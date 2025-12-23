import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
// Note: CSS is loaded via CDN in the Blade template to avoid Vite deep-import/export issues

document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('adminCalendar');
    if (!calendarEl) return;

    const eventsUrl = calendarEl.dataset.eventsUrl || '/schedules/events';
    const rescheduleUrl = calendarEl.dataset.rescheduleUrl || '/schedules/reschedule';
    const storeUrl = calendarEl.dataset.storeUrl || '/schedules';
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'timeGridWeek,dayGridMonth'
        },
        nowIndicator: true,
        editable: true,
        selectable: true,
        events: eventsUrl,
        eventDrop: function(info) {
            const id = info.event.id;
            if (!id || !id.startsWith('booking-')) { info.revert(); return; }
            const bookingId = id.replace('booking-', '');
            const start = info.event.start;
            const end = info.event.end || new Date(start.getTime() + 60*60*1000); // default 1 hour

            // Check for blocked overlaps
            const events = calendar.getEvents();
            const overlapsBlocked = events.some(ev => {
                const t = ev.extendedProps && ev.extendedProps.type;
                if (!t || t !== 'blocked') return false;
                const s = ev.start;
                const e = ev.end || new Date(s.getTime() + 24*60*60*1000);
                return (start < e && end > s);
            });

            if (overlapsBlocked) { alert('Cannot move booking into a blocked date/range.'); info.revert(); return; }

            const startIso = start.toISOString();
            const endIso = end ? end.toISOString() : null;

            fetch(rescheduleUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ booking_id: bookingId, start: startIso, end: endIso })
            }).then(r => r.json()).then(data => {
                if (!data.success) { alert('Failed to reschedule booking: ' + (data.message || 'Unknown')); info.revert(); }
            }).catch(err => { console.error('Reschedule error', err); info.revert(); });
        },
        // Log events when calendar receives them and ensure blocked events are visible
        eventsSet: function(events) {
            try {
                const total = events.length;
                const blockedCount = events.filter(ev => ev.extendedProps && ev.extendedProps.type === 'blocked').length;
                console.log('[adminCalendar] events loaded:', { total, blockedCount });
            } catch (e) {
                console.error('eventsSet logging failed', e);
            }
        },
        eventDidMount: function(info) {
            try {
                const isBlocked = info.event.extendedProps && info.event.extendedProps.type === 'blocked';
                if (!isBlocked) return;

                // In month (dayGrid) view FullCalendar may truncate titles; force line-wrap for blocked ranges
                if (info.view && info.view.type && info.view.type.indexOf('dayGrid') === 0) {
                    const main = info.el.querySelector('.fc-event-main');
                    if (main) {
                        main.style.whiteSpace = 'normal';
                        main.style.overflow = 'visible';
                        main.style.textOverflow = 'clip';
                        main.style.lineHeight = '1.1';
                    }
                }
            } catch (e) {
                console.error('eventDidMount error', e);
            }
        },
        eventClick: function(info) {
            const id = info.event.id || '';
            if (id.startsWith('booking-')) {
                const bookingId = id.replace('booking-', '');
                // viewBookingDetails is defined in the Blade page; call it if available
                if (typeof window.viewBookingDetails === 'function') {
                    window.viewBookingDetails(bookingId);
                }
                return;
            }

            // allow admin to delete slot (blocked/availability) by clicking
            if (id.startsWith('slot-')) {
                // ids for expanded blocked-day events are like: slot-<origId>-YYYYMMDD
                const parts = id.split('-');
                const origId = parts.length > 1 ? parts[1] : id.replace('slot-', '');
                if (confirm('Delete this schedule slot / block?')) {
                    fetch('/admin/schedules/' + origId, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': csrf }
                    }).then(r => r.json()).then(data => {
                        if (data.success) {
                            calendar.refetchEvents();
                            alert('Slot deleted');
                        } else {
                            alert('Failed to delete slot');
                        }
                    }).catch(err => { console.error('Delete slot error', err); alert('Error deleting slot'); });
                }
            }
        }
    });

    try {
        calendar.render();
        // expose for other scripts
        window.adminCalendar = calendar;
    } catch (err) {
        console.error('FullCalendar render error:', err);
        calendarEl.innerHTML = '<div class="text-center text-danger p-4">Calendar failed to initialize. See console for details.</div>';
    }

    // Block dates modal wiring
    const openBlockBtn = document.getElementById('openBlockModal');
    if (openBlockBtn) {
        openBlockBtn.addEventListener('click', () => {
            const modalEl = document.getElementById('blockModal');
            if (modalEl) {
                // store instance so we can reliably hide it later
                window._blockModalInstance = new bootstrap.Modal(modalEl);
                window._blockModalInstance.show();
            }
        });
    }

    // Update preview when inputs change
    const updateBlockPreview = () => {
        const startInput = document.getElementById('blockStart');
        const endInput = document.getElementById('blockEnd');
        const titleInput = document.getElementById('blockTitle');
        const allDayCheck = document.getElementById('blockAllDay');
        const previewDiv = document.getElementById('blockPreview');
        const previewContent = document.getElementById('blockPreviewContent');

        if (!startInput || !endInput || !previewDiv || !previewContent) return;

        const startVal = startInput.value;
        const endVal = endInput.value;
        const titleVal = titleInput?.value || 'Blocked';
        const allDay = allDayCheck?.checked ?? true;

        if (startVal && endVal) {
            try {
                const start = new Date(startVal);
                const end = new Date(endVal);
                
                if (end <= start) {
                    previewContent.innerHTML = '<span class="text-danger">⚠️ End date must be after start date</span>';
                    previewDiv.style.display = 'block';
                    previewDiv.style.borderLeftColor = '#dc3545';
                    return;
                }

                const startFormatted = start.toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric',
                    ...(allDay ? {} : { hour: '2-digit', minute: '2-digit' })
                });
                const endFormatted = end.toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric',
                    ...(allDay ? {} : { hour: '2-digit', minute: '2-digit' })
                });

                const daysDiff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                const daysText = daysDiff === 1 ? '1 day' : `${daysDiff} days`;

                previewContent.innerHTML = `
                    <div><strong>${titleVal}</strong></div>
                    <div class="mt-1">📅 ${startFormatted} → ${endFormatted}</div>
                    <div class="mt-1 text-muted">Duration: ${daysText}</div>
                `;
                previewDiv.style.display = 'block';
                previewDiv.style.borderLeftColor = '#ff6600';
            } catch (e) {
                previewDiv.style.display = 'none';
            }
        } else {
            previewDiv.style.display = 'none';
        }
    };

    // Attach preview updates to inputs
    ['blockStart', 'blockEnd', 'blockTitle', 'blockAllDay'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', updateBlockPreview);
            el.addEventListener('change', updateBlockPreview);
        }
    });

    const submitBlockBtn = document.getElementById('submitBlock');
    if (submitBlockBtn) {
        submitBlockBtn.addEventListener('click', async () => {
            const title = document.getElementById('blockTitle').value || 'Blocked';
            const allDay = document.getElementById('blockAllDay').checked;
            const startInput = document.getElementById('blockStart').value;
            const endInput = document.getElementById('blockEnd').value;

            if (!startInput || !endInput) { 
                alert('⚠️ Please provide both start and end date/time'); 
                return; 
            }

            let start = new Date(startInput);
            let end = new Date(endInput);
            
            if (allDay) {
                // For all-day blocks, normalize to full days using local date components
                // This ensures we only block the selected date(s) without timezone issues
                const startYear = start.getFullYear();
                const startMonth = start.getMonth();
                const startDate = start.getDate();
                
                const endYear = end.getFullYear();
                const endMonth = end.getMonth();
                const endDate = end.getDate();
                
                // Check if same date selected (single day block)
                const isSameDate = startYear === endYear && 
                                   startMonth === endMonth && 
                                   startDate === endDate;
                
                if (isSameDate) {
                    // Single date: start at 00:00 of selected date, end at 00:00 of next day
                    start = new Date(startYear, startMonth, startDate, 0, 0, 0, 0);
                    end = new Date(startYear, startMonth, startDate + 1, 0, 0, 0, 0);
                } else {
                    // Date range: start at 00:00 of start date, end at 00:00 of day after end date
                    start = new Date(startYear, startMonth, startDate, 0, 0, 0, 0);
                    end = new Date(endYear, endMonth, endDate + 1, 0, 0, 0, 0);
                }
            } else {
                // For time-specific blocks, ensure end is after start
                if (end <= start) {
                    alert('⚠️ End date must be after start date');
                    return;
                }
            }

            // Disable button during submission
            submitBlockBtn.disabled = true;
            submitBlockBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';

            try {
                const res = await fetch(storeUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ title, start: start.toISOString(), end: end.toISOString(), type: 'blocked' })
                });
                const data = await res.json();
                if (data.success) {
                    console.log('Block created response:', data);
                    // close modal
                    try { window._blockModalInstance?.hide(); } catch (e) {}
                    // refresh calendar and jump to the start of the block to make it visible
                    calendar.refetchEvents();
                    try { calendar.gotoDate(start); } catch (e) {}
                    
                    // Show success message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                    alertDiv.style.zIndex = '9999';
                    alertDiv.innerHTML = `
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Success!</strong> Blocked range "${title}" has been created.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(alertDiv);
                    setTimeout(() => alertDiv.remove(), 5000);
                } else {
                    console.warn('Failed to create block:', data);
                    alert('❌ Failed to create block: ' + (data.message || 'Unknown error'));
                }
            } catch (err) {
                console.error('Block create error', err);
                alert('❌ Error creating blocked range. Please check the console for details.');
            } finally {
                submitBlockBtn.disabled = false;
                submitBlockBtn.innerHTML = '<i class="bi bi-slash-circle me-2"></i>Create Block';
            }
        });
    }

        // Manage blocks modal - list and unblock
        const openManageBtn = document.getElementById('openManageBlocks');
        if (openManageBtn) {
            openManageBtn.addEventListener('click', async () => {
                const modalEl = document.getElementById('manageBlocksModal');
                if (!modalEl) return;
                // show modal
                const modal = new bootstrap.Modal(modalEl);
                modal.show();

                const listEl = document.getElementById('blocksList');
                listEl.innerHTML = '<div class="text-center text-muted py-4"><div class="spinner-border spinner-border-sm me-2" role="status"></div>Loading blocked ranges...</div>';

                try {
                    const resp = await fetch(eventsUrl);
                    const items = await resp.json();
                    // filter blocked slots
                    const blocked = items.filter(i => i.extendedProps && i.extendedProps.type === 'blocked');
                    
                    listEl.innerHTML = '';
                    
                    if (!blocked.length) {
                        listEl.innerHTML = `
                            <div class="text-center py-5">
                                <i class="bi bi-calendar-check" style="font-size: 3rem; color: #6c757d; opacity: 0.5;"></i>
                                <p class="text-muted mt-3 mb-0">No blocked date ranges found.</p>
                                <small class="text-muted">All dates are available for booking.</small>
                            </div>
                        `;
                        return;
                    }

                    blocked.forEach((slot, index) => {
                        const startDate = new Date(slot.start);
                        const endDate = new Date(slot.end);
                        const daysDiff = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                        
                        const li = document.createElement('div');
                        li.className = 'list-group-item';
                        li.style.cssText = 'border-left: 4px solid #dc3545; margin-bottom: 12px; border-radius: 8px; padding: 16px; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);';
                        
                        const card = document.createElement('div');
                        card.className = 'd-flex justify-content-between align-items-start';
                        
                        const left = document.createElement('div');
                        left.style.flex = '1';
                        left.innerHTML = `
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-slash-circle-fill me-2" style="color: #dc3545; font-size: 1.2rem;"></i>
                                <strong style="color: #0b3a66; font-size: 1.1rem;">${slot.title || 'Blocked'}</strong>
                            </div>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-calendar-event me-1"></i>
                                <strong>Start:</strong> ${startDate.toLocaleDateString('en-US', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}
                            </div>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-calendar-x me-1"></i>
                                <strong>End:</strong> ${endDate.toLocaleDateString('en-US', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}
                            </div>
                            <div class="badge bg-warning text-dark mt-2">
                                <i class="bi bi-clock me-1"></i>${daysDiff} ${daysDiff === 1 ? 'day' : 'days'}
                            </div>
                        `;
                        
                        const btn = document.createElement('button');
                        btn.className = 'btn btn-outline-danger btn-sm';
                        btn.style.cssText = 'white-space: nowrap; margin-left: 16px;';
                        btn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                        btn.addEventListener('click', async () => {
                            if (!confirm(`Are you sure you want to remove the blocked range "${slot.title || 'Blocked'}"?`)) return;
                            
                            btn.disabled = true;
                            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Removing...';
                            
                            try {
                                // slot.id might be slot-<origId>-YYYYMMDD; extract the original slot id
                                const raw = ('' + slot.id);
                                const parts = raw.split('-');
                                const origId = parts.length > 1 ? parts[1] : raw.replace('slot-', '');
                                const delResp = await fetch(`/admin/schedules/${origId}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrf } });
                                const delData = await delResp.json();
                                if (delData.success) {
                                    // Check if this is the last item before removal
                                    const isLastItem = listEl.children.length === 1;
                                    
                                    // Animate removal
                                    li.style.transition = 'opacity 0.3s, transform 0.3s';
                                    li.style.opacity = '0';
                                    li.style.transform = 'translateX(-20px)';
                                    setTimeout(() => {
                                        li.remove();
                                        // Refresh calendar
                                        calendar.refetchEvents();
                                        
                                        // Show success message
                                        const alertDiv = document.createElement('div');
                                        alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                                        alertDiv.style.zIndex = '9999';
                                        alertDiv.innerHTML = `
                                            <i class="bi bi-check-circle-fill me-2"></i>
                                            <strong>Success!</strong> Blocked range has been removed.
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        `;
                                        document.body.appendChild(alertDiv);
                                        setTimeout(() => alertDiv.remove(), 5000);
                                        
                                        // If this was the last item, show empty state
                                        if (isLastItem) {
                                            listEl.innerHTML = `
                                                <div class="text-center py-5">
                                                    <i class="bi bi-calendar-check" style="font-size: 3rem; color: #6c757d; opacity: 0.5;"></i>
                                                    <p class="text-muted mt-3 mb-0">No blocked date ranges found.</p>
                                                    <small class="text-muted">All dates are available for booking.</small>
                                                </div>
                                            `;
                                        }
                                    }, 300);
                                } else {
                                    alert('❌ Failed to remove block: ' + (delData.message || 'Unknown error'));
                                    btn.disabled = false;
                                    btn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                                }
                            } catch (err) {
                                console.error('Unblock error', err);
                                alert('❌ Error removing block. Please check the console for details.');
                                btn.disabled = false;
                                btn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                            }
                        });

                        card.appendChild(left);
                        card.appendChild(btn);
                        li.appendChild(card);
                        listEl.appendChild(li);
                    });
                } catch (err) {
                    console.error('Failed to load blocked ranges', err);
                    listEl.innerHTML = '<div class="text-danger">Failed to load blocked ranges.</div>';
                }
            });
        }
});
