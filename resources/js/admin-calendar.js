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
    
    // Helper function to get CSRF token
    const getCsrfToken = () => {
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        return metaTag ? metaTag.getAttribute('content') : null;
    };
    
    // Helper function to refresh CSRF token
    const refreshCsrfToken = async () => {
        try {
            const response = await fetch('/csrf-token', {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            if (response.ok) {
                const data = await response.json();
                const metaTag = document.querySelector('meta[name="csrf-token"]');
                if (metaTag && data.token) {
                    metaTag.setAttribute('content', data.token);
                    return data.token;
                }
            }
        } catch (err) {
            console.error('Failed to refresh CSRF token:', err);
        }
        return null;
    };
    
    let csrf = getCsrfToken();
    // When set, the "Block Dates" modal acts as an edit form instead of create.
    // This stores the original Schedule model id (not the expanded per-day event id).
    window._editingBlockId = null;

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
        timeZone: 'UTC', // Use UTC to avoid timezone conversion issues with blocked dates
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
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
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
                        headers: { 'X-CSRF-TOKEN': getCsrfToken() }
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
                // Reset edit mode
                window._editingBlockId = null;
                window._blockSelectedDates = [];

                // Reset form
                const blockTitle = document.getElementById('blockTitle');
                const blockStart = document.getElementById('blockStart');
                const blockEnd = document.getElementById('blockEnd');
                const blockAllDay = document.getElementById('blockAllDay');
                const blockPreview = document.getElementById('blockPreview');
                const editingNotice = document.getElementById('editingBlockNotice');
                const submitBtn = document.getElementById('submitBlock');
                const modeRange = document.getElementById('blockModeRange');
                const modeSelected = document.getElementById('blockModeSelected');
                const selectedDateInput = document.getElementById('blockSelectedDateInput');
                
                if (blockTitle) blockTitle.value = '';
                if (blockStart) blockStart.value = '';
                if (blockEnd) blockEnd.value = '';
                if (blockAllDay) blockAllDay.checked = true;
                if (blockPreview) blockPreview.style.display = 'none';
                if (editingNotice) editingNotice.style.display = 'none';
                if (submitBtn) submitBtn.innerHTML = '<i class="bi bi-slash-circle me-2"></i>Create Block';
                if (modeRange) { modeRange.checked = true; modeRange.disabled = false; }
                if (modeSelected) { modeSelected.checked = false; modeSelected.disabled = false; }
                if (selectedDateInput) selectedDateInput.value = '';
                
                // Initialize mode
                updateBlockMode();
                try { if (typeof window.__renderBlockSelectedDates === 'function') window.__renderBlockSelectedDates(); } catch (e) {}
                
                // store instance so we can reliably hide it later
                window._blockModalInstance = new bootstrap.Modal(modalEl);
                window._blockModalInstance.show();
            }
        });
    }

    const pad2 = (n) => String(n).padStart(2, '0');

    // Format an ISO string as a datetime-local value using UTC components
    // (we treat the admin inputs as "UTC clock time" to match the existing create logic).
    const isoToDateTimeLocalUTC = (iso) => {
        const d = new Date(iso);
        return `${d.getUTCFullYear()}-${pad2(d.getUTCMonth() + 1)}-${pad2(d.getUTCDate())}T${pad2(d.getUTCHours())}:${pad2(d.getUTCMinutes())}`;
    };

    const isoToDateTimeLocalUTCOnDate = (dateObjUTC, hh = 0, mm = 0) => {
        const yyyy = dateObjUTC.getUTCFullYear();
        const mo = pad2(dateObjUTC.getUTCMonth() + 1);
        const dd = pad2(dateObjUTC.getUTCDate());
        return `${yyyy}-${mo}-${dd}T${pad2(hh)}:${pad2(mm)}`;
    };

    const looksAllDayUTC = (startIso, endIso) => {
        try {
            const s = new Date(startIso);
            const e = new Date(endIso);
            return (
                s.getUTCHours() === 0 && s.getUTCMinutes() === 0 &&
                e.getUTCHours() === 0 && e.getUTCMinutes() === 0
            );
        } catch (e) {
            return false;
        }
    };

    const extractOrigScheduleId = (rawId, extendedProps) => {
        if (extendedProps && (extendedProps.orig_slot_id || extendedProps.orig_slot_id === 0)) {
            return String(extendedProps.orig_slot_id);
        }
        const idStr = String(rawId || '');
        if (idStr.startsWith('slot-')) {
            const parts = idStr.split('-');
            if (parts.length >= 2 && parts[1]) return String(parts[1]);
        }
        return null;
    };

    const getOrigRange = (slotObj) => {
        const ext = slotObj && slotObj.extendedProps ? slotObj.extendedProps : {};
        const startIso = (ext && ext.orig_start) ? ext.orig_start : slotObj.start;
        const endIso = (ext && ext.orig_end) ? ext.orig_end : slotObj.end;
        return { startIso, endIso };
    };

    const openEditBlockInModal = (slotObj) => {
        const modalEl = document.getElementById('blockModal');
        if (!modalEl) return;

        const { startIso, endIso } = getOrigRange(slotObj);
        const origId = extractOrigScheduleId(slotObj.id, slotObj.extendedProps);
        if (!origId || !startIso || !endIso) {
            alert('❌ Unable to edit this block (missing block id or dates).');
            return;
        }

        window._editingBlockId = origId;
        window._blockSelectedDates = [];

        const blockTitle = document.getElementById('blockTitle');
        const blockStart = document.getElementById('blockStart');
        const blockEnd = document.getElementById('blockEnd');
        const blockAllDay = document.getElementById('blockAllDay');
        const editingNotice = document.getElementById('editingBlockNotice');
        const submitBtn = document.getElementById('submitBlock');
        const blockPreview = document.getElementById('blockPreview');
        const modeRange = document.getElementById('blockModeRange');
        const modeSelected = document.getElementById('blockModeSelected');

        if (blockPreview) blockPreview.style.display = 'none';

        const isAllDay = looksAllDayUTC(startIso, endIso);
        if (blockAllDay) blockAllDay.checked = !!isAllDay;

        // Editing supports range blocks only (selected-dates blocks are created as multiple rows)
        if (modeRange) { modeRange.checked = true; modeRange.disabled = true; }
        if (modeSelected) { modeSelected.checked = false; modeSelected.disabled = true; }
        updateBlockMode();

        if (blockTitle) blockTitle.value = slotObj.title || 'Blocked';

        try {
            if (isAllDay) {
                // Stored end is exclusive (00:00 of next day). Show inclusive end date in the input.
                const s = new Date(startIso);
                const e = new Date(endIso);
                const inclusiveEnd = new Date(e.getTime() - 24 * 60 * 60 * 1000);
                if (blockStart) blockStart.value = isoToDateTimeLocalUTCOnDate(s, 0, 0);
                if (blockEnd) blockEnd.value = isoToDateTimeLocalUTCOnDate(inclusiveEnd, 23, 59);
            } else {
                if (blockStart) blockStart.value = isoToDateTimeLocalUTC(startIso);
                if (blockEnd) blockEnd.value = isoToDateTimeLocalUTC(endIso);
            }
        } catch (e) {
            console.error('Failed to prefill edit block fields', e);
        }

        if (editingNotice) editingNotice.style.display = 'flex';
        if (submitBtn) submitBtn.innerHTML = '<i class="bi bi-pencil-square me-2"></i>Update Block';

        // Hide manage modal (if open) then show block modal
        try { window._manageBlocksModalInstance?.hide(); } catch (e) {}
        window._blockModalInstance = new bootstrap.Modal(modalEl);
        window._blockModalInstance.show();

        // Update preview once opened
        try { updateBlockPreview(); } catch (e) {}
    };

    // Selected dates mode (non-continuous all-day blocks)
    window._blockSelectedDates = window._blockSelectedDates || [];
    const __normalizeYmd = (s) => (typeof s === 'string' ? s.trim() : '');
    const __sortYmd = (a, b) => (a < b ? -1 : (a > b ? 1 : 0));

    window.__renderBlockSelectedDates = function () {
        const listEl = document.getElementById('selectedDatesList');
        const emptyEl = document.getElementById('selectedDatesEmpty');
        if (!listEl || !emptyEl) return;

        const dates = (window._blockSelectedDates || []).slice().map(__normalizeYmd).filter(Boolean).sort(__sortYmd);
        window._blockSelectedDates = dates;

        listEl.innerHTML = '';
        emptyEl.style.display = dates.length ? 'none' : 'block';

        dates.forEach((ymd) => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-calendar2-check text-danger"></i>
                    <span>${ymd}</span>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-remove-date="${ymd}" title="Remove">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            listEl.appendChild(li);
        });
    };

    window.__addBlockSelectedDate = function (ymdRaw) {
        const ymd = __normalizeYmd(ymdRaw);
        if (!ymd) return false;
        if (!/^\d{4}-\d{2}-\d{2}$/.test(ymd)) return false;
        const set = new Set(window._blockSelectedDates || []);
        set.add(ymd);
        window._blockSelectedDates = Array.from(set).sort(__sortYmd);
        window.__renderBlockSelectedDates();
        try { updateBlockPreview(); } catch (e) {}
        return true;
    };

    window.__removeBlockSelectedDate = function (ymdRaw) {
        const ymd = __normalizeYmd(ymdRaw);
        window._blockSelectedDates = (window._blockSelectedDates || []).filter(d => d !== ymd);
        window.__renderBlockSelectedDates();
        try { updateBlockPreview(); } catch (e) {}
    };

    // Wire selected dates controls
    try {
        const addBtn = document.getElementById('addSelectedDateBtn');
        const clearBtn = document.getElementById('clearSelectedDatesBtn');
        const dateInput = document.getElementById('blockSelectedDateInput');
        const listEl = document.getElementById('selectedDatesList');
        const modeRange = document.getElementById('blockModeRange');
        const modeSelected = document.getElementById('blockModeSelected');

        const onAdd = () => {
            const v = dateInput?.value || '';
            if (!window.__addBlockSelectedDate(v)) {
                alert('⚠️ Please choose a valid date to add.');
                return;
            }
            if (dateInput) dateInput.value = '';
        };

        if (addBtn && !addBtn.dataset.bound) {
            addBtn.dataset.bound = '1';
            addBtn.addEventListener('click', onAdd);
        }
        if (dateInput && !dateInput.dataset.bound) {
            dateInput.dataset.bound = '1';
            dateInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') { e.preventDefault(); onAdd(); }
            });
        }
        if (clearBtn && !clearBtn.dataset.bound) {
            clearBtn.dataset.bound = '1';
            clearBtn.addEventListener('click', () => {
                window._blockSelectedDates = [];
                window.__renderBlockSelectedDates();
                try { updateBlockPreview(); } catch (e) {}
            });
        }
        if (listEl && !listEl.dataset.bound) {
            listEl.dataset.bound = '1';
            listEl.addEventListener('click', (e) => {
                const btn = e.target && (e.target.closest ? e.target.closest('[data-remove-date]') : null);
                if (!btn) return;
                const ymd = btn.getAttribute('data-remove-date');
                window.__removeBlockSelectedDate(ymd);
            });
        }
        if (modeRange && !modeRange.dataset.bound) {
            modeRange.dataset.bound = '1';
            modeRange.addEventListener('change', () => { updateBlockMode(); try { updateBlockPreview(); } catch (e) {} });
        }
        if (modeSelected && !modeSelected.dataset.bound) {
            modeSelected.dataset.bound = '1';
            modeSelected.addEventListener('change', () => {
                // selected mode forces all-day
                const allDayCheck = document.getElementById('blockAllDay');
                if (allDayCheck) { allDayCheck.checked = true; }
                updateBlockMode();
                window.__renderBlockSelectedDates();
                try { updateBlockPreview(); } catch (e) {}
            });
        }
    } catch (e) {}

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
        const modeSelected = document.getElementById('blockModeSelected');
        const isSelectedMode = !!(modeSelected && modeSelected.checked);

        if (isSelectedMode) {
            const dates = (window._blockSelectedDates || []).slice().map(__normalizeYmd).filter(Boolean).sort(__sortYmd);
            if (!dates.length) {
                previewDiv.style.display = 'none';
                return;
            }

            const chips = dates.slice(0, 8).map(d => `<span class="badge bg-light text-dark border me-1 mb-1">${d}</span>`).join('');
            const more = dates.length > 8 ? `<div class="text-muted small mt-2">+ ${dates.length - 8} more</div>` : '';
            previewContent.innerHTML = `
                <div class="mb-2">
                    <strong class="text-dark" style="font-size: 1.05rem;">${titleVal}</strong>
                </div>
                <div class="mb-2 text-muted small">
                    <i class="bi bi-calendar2-check me-1"></i>${dates.length} selected date(s) (full-day)
                </div>
                <div class="d-flex flex-wrap">${chips}</div>
                ${more}
            `;
            previewDiv.style.display = 'block';
            previewDiv.style.borderColor = '#ff6600';
            previewDiv.style.borderLeftColor = '#ff6600';
            return;
        }

        if (startVal && endVal) {
            try {
                const start = new Date(startVal);
                const end = new Date(endVal);
                
                if (end <= start) {
                    previewContent.innerHTML = '<div class="alert alert-danger mb-0"><i class="bi bi-exclamation-triangle me-2"></i><strong>Error:</strong> End date must be after start date</div>';
                    previewDiv.style.display = 'block';
                    previewDiv.style.borderColor = '#dc3545';
                    previewDiv.style.borderLeftColor = '#dc3545';
                    return;
                }

                // Format dates
                const startFormatted = start.toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric',
                    ...(allDay ? {} : { hour: '2-digit', minute: '2-digit', hour12: true })
                });
                const endFormatted = end.toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric',
                    ...(allDay ? {} : { hour: '2-digit', minute: '2-digit', hour12: true })
                });

                // Calculate duration
                const daysDiff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                const hoursDiff = Math.ceil((end - start) / (1000 * 60 * 60));
                const daysText = daysDiff === 1 ? '1 day' : `${daysDiff} days`;
                const hoursText = hoursDiff < 24 ? `${hoursDiff} hours` : daysText;

                // Default available time slots
                const defaultSlots = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'];
                
                let previewHTML = `
                    <div class="mb-3">
                        <strong class="text-dark" style="font-size: 1.05rem;">${titleVal}</strong>
                    </div>
                    <div class="mb-3 p-3 rounded" style="background: white; border: 1px solid #dee2e6;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-calendar3 me-2 text-primary"></i>
                            <strong>Period:</strong>
                        </div>
                        <div class="ms-4">
                            <div><strong>Start:</strong> ${startFormatted}</div>
                            <div class="mt-1"><strong>End:</strong> ${endFormatted}</div>
                            <div class="mt-2 text-muted"><i class="bi bi-clock me-1"></i>Duration: ${allDay ? daysText : hoursText}</div>
                        </div>
                    </div>
                `;

                // Add time slot analysis for time-specific blocks
                if (!allDay) {
                    const startHour = start.getHours();
                    const startMin = start.getMinutes();
                    const endHour = end.getHours();
                    const endMin = end.getMinutes();
                    
                    // Check if block is on the same day
                    const startDate = start.toDateString();
                    const endDate = end.toDateString();
                    const isSameDay = startDate === endDate;
                    
                    // Determine which slots will be blocked
                    const blockedSlots = [];
                    const availableSlots = [];
                    
                    if (isSameDay) {
                        // For same-day blocks, check each slot
                        defaultSlots.forEach(slot => {
                            const [slotHour, slotMin] = slot.split(':').map(Number);
                            const slotTime = slotHour * 60 + slotMin;
                            const blockStartTime = startHour * 60 + startMin;
                            const blockEndTime = endHour * 60 + endMin;
                            
                            // Check if slot falls within block range (slot time is at the start of the hour)
                            if (slotTime >= blockStartTime && slotTime < blockEndTime) {
                                blockedSlots.push(slot);
                            } else {
                                availableSlots.push(slot);
                            }
                        });
                    } else {
                        // For multi-day time blocks, all slots on affected days would be blocked
                        // This is a simplified view - in reality, it depends on the specific days
                        defaultSlots.forEach(slot => {
                            blockedSlots.push(slot);
                        });
                    }
                    
                    previewHTML += `
                        <div class="p-3 rounded" style="background: white; border: 1px solid #dee2e6;">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-clock-history me-2" style="color: #dc3545;"></i>
                                <strong>Time Slot Impact:</strong>
                            </div>
                            <div class="ms-4">
                                ${blockedSlots.length > 0 ? `
                                    <div class="mb-2">
                                        <span class="badge bg-danger me-1"><i class="bi bi-x-circle me-1"></i>Blocked Slots (${blockedSlots.length}):</span>
                                        <span class="text-muted">${blockedSlots.map(s => {
                                            const [h, m] = s.split(':');
                                            const hour12 = h == 0 ? 12 : (h > 12 ? h - 12 : h);
                                            const ampm = h < 12 ? 'AM' : 'PM';
                                            return `${hour12}:${m} ${ampm}`;
                                        }).join(', ')}</span>
                                    </div>
                                ` : ''}
                                ${availableSlots.length > 0 ? `
                                    <div>
                                        <span class="badge bg-success me-1"><i class="bi bi-check-circle me-1"></i>Available Slots (${availableSlots.length}):</span>
                                        <span class="text-muted">${availableSlots.map(s => {
                                            const [h, m] = s.split(':');
                                            const hour12 = h == 0 ? 12 : (h > 12 ? h - 12 : h);
                                            const ampm = h < 12 ? 'AM' : 'PM';
                                            return `${hour12}:${m} ${ampm}`;
                                        }).join(', ')}</span>
                                    </div>
                                ` : '<div class="text-warning"><i class="bi bi-exclamation-triangle me-1"></i>All time slots will be blocked</div>'}
                            </div>
                        </div>
                    `;
                } else {
                    previewHTML += `
                        <div class="p-3 rounded" style="background: white; border: 1px solid #dee2e6;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-lock-fill me-2" style="color: #dc3545;"></i>
                                <strong>All time slots will be blocked for the selected day(s)</strong>
                            </div>
                        </div>
                    `;
                }

                previewContent.innerHTML = previewHTML;
                previewDiv.style.display = 'block';
                previewDiv.style.borderColor = '#ff6600';
                previewDiv.style.borderLeftColor = '#ff6600';
            } catch (e) {
                previewDiv.style.display = 'none';
            }
        } else {
            previewDiv.style.display = 'none';
        }
    };

    // Update label and help text based on all-day toggle
    const updateBlockMode = () => {
        const allDayCheck = document.getElementById('blockAllDay');
        const startLabel = document.getElementById('startLabel');
        const endLabel = document.getElementById('endLabel');
        const startHelpText = document.getElementById('startHelpText');
        const endHelpText = document.getElementById('endHelpText');
        const allDayHelpText = document.getElementById('allDayHelpText');
        const timeSpecificHelpText = document.getElementById('timeSpecificHelpText');
        const blockStart = document.getElementById('blockStart');
        const blockEnd = document.getElementById('blockEnd');
        const modeSelected = document.getElementById('blockModeSelected');
        const rangeWrap = document.getElementById('blockRangeWrap');
        const selectedWrap = document.getElementById('blockSelectedDatesWrap');
        const modeHelp = document.getElementById('blockModeHelpText');

        if (!allDayCheck) return;

        const isSelectedMode = !!(modeSelected && modeSelected.checked);
        if (rangeWrap) rangeWrap.style.display = isSelectedMode ? 'none' : '';
        if (selectedWrap) selectedWrap.style.display = isSelectedMode ? '' : 'none';

        // Selected-dates mode always creates all-day blocks
        if (isSelectedMode) {
            allDayCheck.checked = true;
            allDayCheck.disabled = true;
            if (modeHelp) modeHelp.innerHTML = 'Selected dates are blocked as <strong>full‑day</strong> blocks. Add multiple non‑continuous dates.';
            if (allDayHelpText) allDayHelpText.style.display = 'block';
            if (timeSpecificHelpText) timeSpecificHelpText.style.display = 'none';
            if (blockStart) blockStart.required = false;
            if (blockEnd) blockEnd.required = false;
            // Labels/help are irrelevant when range inputs are hidden
            if (startLabel) startLabel.textContent = 'Start Date';
            if (endLabel) endLabel.textContent = 'End Date';
            if (startHelpText) startHelpText.textContent = 'Not used in Selected dates mode';
            if (endHelpText) endHelpText.textContent = 'Not used in Selected dates mode';
            return;
        } else {
            allDayCheck.disabled = false;
            if (modeHelp) modeHelp.innerHTML = 'Use <strong>Date range</strong> for continuous blocks (e.g., vacation). Use <strong>Selected dates</strong> for non‑continuous days (e.g., every Saturday).';
            if (blockStart) blockStart.required = true;
            if (blockEnd) blockEnd.required = true;
        }

        const isAllDay = allDayCheck.checked;

        // Toggle help text visibility
        if (allDayHelpText) allDayHelpText.style.display = isAllDay ? 'block' : 'none';
        if (timeSpecificHelpText) timeSpecificHelpText.style.display = isAllDay ? 'none' : 'block';

        // Update labels
        if (startLabel) startLabel.textContent = isAllDay ? 'Start Date' : 'Start Date & Time';
        if (endLabel) endLabel.textContent = isAllDay ? 'End Date' : 'End Date & Time';

        // Update help text
        if (startHelpText) startHelpText.textContent = isAllDay 
            ? 'Select the first day to block' 
            : 'Select the date and time when blocking begins';
        if (endHelpText) endHelpText.textContent = isAllDay 
            ? 'Select the last day to block (inclusive)' 
            : 'Select the date and time when blocking ends';

        // Update input type hint (datetime-local already supports both, but we can update placeholder)
        if (blockStart && blockEnd) {
            // Trigger preview update
            updateBlockPreview();
        }
    };

    // Attach preview updates to inputs
    ['blockStart', 'blockEnd', 'blockTitle', 'blockAllDay'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', updateBlockPreview);
            el.addEventListener('change', () => {
                if (id === 'blockAllDay') {
                    updateBlockMode();
                }
                updateBlockPreview();
            });
        }
    });

    // Initialize block mode on page load
    updateBlockMode();

    const submitBlockBtn = document.getElementById('submitBlock');
    if (submitBlockBtn) {
        submitBlockBtn.addEventListener('click', async () => {
            const title = document.getElementById('blockTitle').value || 'Blocked';
            const allDay = document.getElementById('blockAllDay').checked;
            const startInput = document.getElementById('blockStart').value;
            const endInput = document.getElementById('blockEnd').value;
            const isSelectedMode = !!document.getElementById('blockModeSelected')?.checked;
            const selectedDates = (window._blockSelectedDates || []).slice().map(__normalizeYmd).filter(Boolean).sort(__sortYmd);

            if (isSelectedMode) {
                if (!selectedDates.length) {
                    alert('⚠️ Please add at least one date to block.');
                    return;
                }
            } else {
                if (!startInput || !endInput) { 
                    alert('⚠️ Please provide both start and end date/time'); 
                    return; 
                }
            }

            // Parse datetime-local input directly to avoid timezone conversion issues
            // datetime-local format: "YYYY-MM-DDTHH:mm" (no timezone, local time)
            let start, end;
            
            if (!isSelectedMode && allDay) {
                // For all-day blocks, parse the date part directly from the input string
                // Format: "YYYY-MM-DDTHH:mm" - we only care about the date part
                const startMatch = startInput.match(/^(\d{4})-(\d{2})-(\d{2})/);
                const endMatch = endInput.match(/^(\d{4})-(\d{2})-(\d{2})/);
                
                if (!startMatch || !endMatch) {
                    alert('⚠️ Invalid date format. Please select valid dates.');
                    return;
                }
                
                // Extract date components directly from the string (no timezone conversion)
                const startYear = parseInt(startMatch[1], 10);
                const startMonth = parseInt(startMatch[2], 10) - 1; // JavaScript months are 0-indexed
                const startDate = parseInt(startMatch[3], 10);
                
                const endYear = parseInt(endMatch[1], 10);
                const endMonth = parseInt(endMatch[2], 10) - 1; // JavaScript months are 0-indexed
                const endDate = parseInt(endMatch[3], 10);
                
                // Check if same date selected (single day block)
                const isSameDate = startYear === endYear && 
                                   startMonth === endMonth && 
                                   startDate === endDate;
                
                if (isSameDate) {
                    // Single date: start at 00:00 UTC of selected date, end at 00:00 UTC of next day
                    start = new Date(Date.UTC(startYear, startMonth, startDate, 0, 0, 0, 0));
                    end = new Date(Date.UTC(startYear, startMonth, startDate + 1, 0, 0, 0, 0));
                } else {
                    // Date range: start at 00:00 UTC of start date, end at 00:00 UTC of day after end date
                    // End date is exclusive, so we add 1 day to include the end date itself
                    start = new Date(Date.UTC(startYear, startMonth, startDate, 0, 0, 0, 0));
                    end = new Date(Date.UTC(endYear, endMonth, endDate + 1, 0, 0, 0, 0));
                }
                
                console.log('All-day block dates:', {
                    input: { start: startInput, end: endInput },
                    parsed: { 
                        start: `${startYear}-${String(startMonth + 1).padStart(2, '0')}-${String(startDate).padStart(2, '0')}`,
                        end: `${endYear}-${String(endMonth + 1).padStart(2, '0')}-${String(endDate).padStart(2, '0')}`
                    },
                    utc: { start: start.toISOString(), end: end.toISOString() }
                });
            } else if (!isSelectedMode) {
                // For time-specific blocks, parse the datetime-local input
                // datetime-local format: "YYYY-MM-DDTHH:mm" (local time, no timezone)
                // We need to extract the date and time components and construct UTC dates
                // that represent the same local time
                console.log('TIME-SPECIFIC BLOCK - Input values:', { startInput, endInput, allDay });
                
                const startMatch = startInput.match(/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})/);
                const endMatch = endInput.match(/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})/);
                
                if (!startMatch || !endMatch) {
                    console.error('Regex match failed:', { startMatch, endMatch });
                    alert('⚠️ Please enter valid dates and times');
                    return;
                }
                
                // Extract components (1-indexed: year, month, day, hour, minute)
                const startYear = parseInt(startMatch[1], 10);
                const startMonth = parseInt(startMatch[2], 10) - 1; // JavaScript months are 0-indexed
                const startDay = parseInt(startMatch[3], 10);
                const startHour = parseInt(startMatch[4], 10);
                const startMin = parseInt(startMatch[5], 10);
                
                const endYear = parseInt(endMatch[1], 10);
                const endMonth = parseInt(endMatch[2], 10) - 1;
                const endDay = parseInt(endMatch[3], 10);
                const endHour = parseInt(endMatch[4], 10);
                const endMin = parseInt(endMatch[5], 10);
                
                console.log('Extracted components:', {
                    start: { year: startYear, month: startMonth, day: startDay, hour: startHour, min: startMin },
                    end: { year: endYear, month: endMonth, day: endDay, hour: endHour, min: endMin }
                });
                
                // Create UTC dates from the local time components
                // This preserves the local time values as UTC (no timezone conversion)
                start = new Date(Date.UTC(startYear, startMonth, startDay, startHour, startMin, 0, 0));
                end = new Date(Date.UTC(endYear, endMonth, endDay, endHour, endMin, 0, 0));
                
                console.log('Created UTC dates:', {
                    start: start.toISOString(),
                    end: end.toISOString(),
                    startUTC: `${startHour}:${String(startMin).padStart(2, '0')} UTC`,
                    endUTC: `${endHour}:${String(endMin).padStart(2, '0')} UTC`
                });
                
                if (isNaN(start.getTime()) || isNaN(end.getTime())) {
                    alert('⚠️ Please enter valid dates and times');
                    return;
                }
                
                if (end <= start) {
                    alert('⚠️ End date/time must be after start date/time');
                    return;
                }
            }

            // Disable button during submission
            submitBlockBtn.disabled = true;
            const isEditing = !!window._editingBlockId;
            submitBlockBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>${isEditing ? 'Updating...' : 'Creating...'}`;

            // Build request URL (create vs update)
            // Use the current page origin/protocol. Only upgrade http -> https when the page itself is https
            // to avoid mixed-content errors in production while keeping localhost/dev working.
            const normalizeUrl = (url) => {
                try {
                    const absolute = new URL(url, window.location.origin);
                    if (window.location.protocol === 'https:' && absolute.protocol === 'http:') {
                        absolute.protocol = 'https:';
                    }
                    return absolute.toString();
                } catch (e) {
                    // Fallback: best-effort, keep as-is
                    return url;
                }
            };
            const fullStoreUrl = normalizeUrl(storeUrl);
            const updatePath = window._editingBlockId ? (`/admin/schedules/${window._editingBlockId}`) : null;
            const fullUpdateUrl = updatePath ? normalizeUrl(updatePath) : null;
            const requestUrl = isEditing ? fullUpdateUrl : fullStoreUrl;
            const requestMethod = isEditing ? 'PUT' : 'POST';

            try {
                console.log(isEditing ? 'Updating blocked range:' : 'Creating blocked range:', {
                    editingId: window._editingBlockId || null,
                    title,
                    allDay,
                    input: { start: startInput, end: endInput },
                    parsed: { start: start.toISOString(), end: end.toISOString() },
                    url: requestUrl,
                    method: requestMethod,
                    csrf: csrf ? 'present' : 'missing'
                });
                
                // Get fresh CSRF token
                csrf = getCsrfToken();
                if (!csrf) {
                    alert('❌ CSRF token not found. Please refresh the page and try again.');
                    submitBlockBtn.disabled = false;
                    submitBlockBtn.innerHTML = isEditing ? '<i class="bi bi-pencil-square me-2"></i>Update Block' : '<i class="bi bi-slash-circle me-2"></i>Create Block';
                    return;
                }
                
                const res = await fetch(requestUrl, {
                    method: requestMethod,
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(
                        isSelectedMode
                            ? { title, type: 'blocked', selected_dates: selectedDates }
                            : { title, start: start.toISOString(), end: end.toISOString(), type: 'blocked' }
                    )
                });
                
                console.log('Response status:', res.status, res.statusText);
                console.log('Response headers:', Object.fromEntries(res.headers.entries()));
                
                // Check if response is ok
                if (!res.ok) {
                    const errorText = await res.text();
                    console.error('Server error response:', errorText);
                    
                    // Check if it's a CSRF token mismatch error (419 status code)
                    if (res.status === 419 || errorText.includes('CSRF token mismatch') || errorText.includes('csrf')) {
                        console.log('CSRF token mismatch detected, refreshing token...');
                        const newToken = await refreshCsrfToken();
                        if (newToken) {
                            csrf = newToken;
                            console.log('CSRF token refreshed, retrying request...');
                            // Retry the request with the new token
                            const retryRes = await fetch(requestUrl, {
                                method: requestMethod,
                                headers: { 
                                    'Content-Type': 'application/json', 
                                    'X-CSRF-TOKEN': csrf,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(
                                    isSelectedMode
                                        ? { title, type: 'blocked', selected_dates: selectedDates }
                                        : { title, start: start.toISOString(), end: end.toISOString(), type: 'blocked' }
                                )
                            });
                            
                            if (!retryRes.ok) {
                                const retryErrorText = await retryRes.text();
                                let retryErrorMessage = 'Failed to create blocked range after token refresh';
                                try {
                                    const retryErrorData = JSON.parse(retryErrorText);
                                    retryErrorMessage = retryErrorData.message || retryErrorData.error || retryErrorMessage;
                                } catch (e) {
                                    retryErrorMessage += ` (${retryRes.status} ${retryRes.statusText})`;
                                }
                                alert('❌ ' + retryErrorMessage + '\n\nPlease refresh the page and try again.');
                                return;
                            }
                            
                            // Success on retry - continue with normal success flow
                            const retryData = await retryRes.json();
                            if (retryData.success) {
                                try { window._blockModalInstance?.hide(); } catch (e) {}
                                calendar.refetchEvents();
                                try {
                                    const jumpTo = isSelectedMode ? (selectedDates[0] || null) : start;
                                    if (jumpTo) calendar.gotoDate(jumpTo);
                                } catch (e) {}
                                window._editingBlockId = null;
                                
                                const alertDiv = document.createElement('div');
                                alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                                alertDiv.style.zIndex = '9999';
                                alertDiv.innerHTML = `
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <strong>Success!</strong> Blocked range "${title}" has been ${isEditing ? 'updated' : 'created'}.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                `;
                                document.body.appendChild(alertDiv);
                                setTimeout(() => alertDiv.remove(), 5000);
                                return;
                            } else {
                                alert('❌ Failed to create block: ' + (retryData.message || 'Unknown error'));
                                return;
                            }
                        } else {
                            alert('❌ Session expired. Please refresh the page and try again.');
                            return;
                        }
                    }
                    
                    let errorMessage = 'Failed to create blocked range';
                    try {
                        const errorData = JSON.parse(errorText);
                        errorMessage = errorData.message || errorData.error || errorMessage;
                        if (errorData.conflicts && Array.isArray(errorData.conflicts)) {
                            errorMessage += '\n\nConflicts with existing bookings:\n' + 
                                errorData.conflicts.map(c => `- ${c.name} on ${c.date} at ${c.time}`).join('\n');
                        }
                        if (errorData.booking_conflicts && Array.isArray(errorData.booking_conflicts) && errorData.booking_conflicts.length) {
                            errorMessage += '\n\nThese dates already have bookings:\n' + errorData.booking_conflicts.map(d => `- ${d}`).join('\n');
                        }
                        if (errorData.already_blocked && Array.isArray(errorData.already_blocked) && errorData.already_blocked.length) {
                            errorMessage += '\n\nThese dates are already blocked:\n' + errorData.already_blocked.map(d => `- ${d}`).join('\n');
                        }
                    } catch (e) {
                        errorMessage += ` (${res.status} ${res.statusText})`;
                    }
                    alert('❌ ' + errorMessage);
                    return;
                }
                
                const data = await res.json();
                console.log('Block created response:', data);
                
                if (data.success) {
                    // close modal
                    try { window._blockModalInstance?.hide(); } catch (e) {}
                    // refresh calendar and jump to the start of the block to make it visible
                    calendar.refetchEvents();
                    try {
                        const jumpTo = isSelectedMode ? (selectedDates[0] || null) : start;
                        if (jumpTo) calendar.gotoDate(jumpTo);
                    } catch (e) {}
                    window._editingBlockId = null;
                    
                    // Show success message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                    alertDiv.style.zIndex = '9999';
                    alertDiv.innerHTML = `
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Success!</strong> Blocked range "${title}" has been ${isEditing ? 'updated' : 'created'}.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(alertDiv);
                    setTimeout(() => alertDiv.remove(), 5000);
                } else {
                    console.warn('Failed to create block:', data);
                    let errorMessage = data.message || 'Unknown error';
                    if (data.conflicts && Array.isArray(data.conflicts)) {
                        errorMessage += '\n\nConflicts with existing bookings:\n' + 
                            data.conflicts.map(c => `- ${c.name} on ${c.date} at ${c.time}`).join('\n');
                    }
                    if (data.booking_conflicts && Array.isArray(data.booking_conflicts) && data.booking_conflicts.length) {
                        errorMessage += '\n\nThese dates already have bookings:\n' + data.booking_conflicts.map(d => `- ${d}`).join('\n');
                    }
                    if (data.already_blocked && Array.isArray(data.already_blocked) && data.already_blocked.length) {
                        errorMessage += '\n\nThese dates are already blocked:\n' + data.already_blocked.map(d => `- ${d}`).join('\n');
                    }
                    alert(`❌ Failed to ${isEditing ? 'update' : 'create'} block: ` + errorMessage);
                }
            } catch (err) {
                console.error('Block create error:', err);
                console.error('Error details:', {
                    message: err.message,
                    stack: err.stack,
                    storeUrl,
                    csrf: csrf ? 'present' : 'missing'
                });
                alert(`❌ Error ${isEditing ? 'updating' : 'creating'} blocked range: ` + (err.message || 'Network or server error. Please check the console for details.'));
            } finally {
                submitBlockBtn.disabled = false;
                submitBlockBtn.innerHTML = isEditing ? '<i class="bi bi-pencil-square me-2"></i>Update Block' : '<i class="bi bi-slash-circle me-2"></i>Create Block';
            }
        });
    }

    // Quick example fillers
    window.fillBlockExample = function(exampleType) {
        const allDayCheck = document.getElementById('blockAllDay');
        const blockStart = document.getElementById('blockStart');
        const blockEnd = document.getElementById('blockEnd');
        const blockTitle = document.getElementById('blockTitle');

        if (!blockStart || !blockEnd) return;

        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        const nextWeek = new Date(today);
        nextWeek.setDate(nextWeek.getDate() + 7);

        // Helper to format datetime-local value
        const formatDateTimeLocal = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        };

        switch(exampleType) {
            case 'fullday-single':
                if (allDayCheck) allDayCheck.checked = true;
                updateBlockMode();
                blockStart.value = formatDateTimeLocal(new Date(today.getFullYear(), today.getMonth(), today.getDate(), 0, 0));
                blockEnd.value = formatDateTimeLocal(new Date(today.getFullYear(), today.getMonth(), today.getDate(), 23, 59));
                if (blockTitle) blockTitle.value = 'Holiday - Closed';
                break;

            case 'fullday-range':
                if (allDayCheck) allDayCheck.checked = true;
                updateBlockMode();
                blockStart.value = formatDateTimeLocal(new Date(today.getFullYear(), today.getMonth(), today.getDate(), 0, 0));
                blockEnd.value = formatDateTimeLocal(new Date(tomorrow.getFullYear(), tomorrow.getMonth(), tomorrow.getDate(), 23, 59));
                if (blockTitle) blockTitle.value = 'Weekend Closure';
                break;

            case 'time-morning':
                if (allDayCheck) allDayCheck.checked = false;
                updateBlockMode();
                // Set start date to today at 00:00, end date to next week at 14:00
                // The backend will apply this time block (00:00 to 14:00) to each day in the range
                // For intermediate days, it will block the full day (00:00 to 23:59) since the block spans them
                // For the last day, it will block from 00:00 to 14:00
                blockStart.value = formatDateTimeLocal(new Date(today.getFullYear(), today.getMonth(), today.getDate(), 0, 0));
                blockEnd.value = formatDateTimeLocal(new Date(nextWeek.getFullYear(), nextWeek.getMonth(), nextWeek.getDate(), 14, 0));
                if (blockTitle) blockTitle.value = 'Morning Blocked - Open from 3 PM';
                break;

            case 'time-afternoon':
                if (allDayCheck) allDayCheck.checked = false;
                updateBlockMode();
                // Set start date to today at 14:00, end date to next week at 23:59
                // The backend will apply this time block (14:00 to 23:59) to each day in the range
                // For intermediate days, it will block the full day (00:00 to 23:59) since the block spans them
                // For the last day, it will block from 14:00 to 23:59
                blockStart.value = formatDateTimeLocal(new Date(today.getFullYear(), today.getMonth(), today.getDate(), 14, 0));
                blockEnd.value = formatDateTimeLocal(new Date(nextWeek.getFullYear(), nextWeek.getMonth(), nextWeek.getDate(), 23, 59));
                if (blockTitle) blockTitle.value = 'Afternoon Blocked - Open till 1 PM';
                break;

            case 'time-lunch':
                if (allDayCheck) allDayCheck.checked = false;
                updateBlockMode();
                blockStart.value = formatDateTimeLocal(new Date(today.getFullYear(), today.getMonth(), today.getDate(), 12, 0));
                blockEnd.value = formatDateTimeLocal(new Date(today.getFullYear(), today.getMonth(), today.getDate(), 13, 0));
                if (blockTitle) blockTitle.value = 'Lunch Break';
                break;
        }

        updateBlockPreview();
    };

        // Manage blocks modal - list and unblock
        const openManageBtn = document.getElementById('openManageBlocks');
        if (openManageBtn) {
            openManageBtn.addEventListener('click', async () => {
                const modalEl = document.getElementById('manageBlocksModal');
                if (!modalEl) return;
                // show modal
                const modal = new bootstrap.Modal(modalEl);
                window._manageBlocksModalInstance = modal;
                modal.show();

                const listEl = document.getElementById('blocksList');
                listEl.innerHTML = '<div class="text-center text-muted py-4"><div class="spinner-border spinner-border-sm me-2" role="status"></div>Loading blocked ranges...</div>';

                // Filter controls (client-side): search + from/to date range
                const searchEl = document.getElementById('manageBlocksSearch');
                const fromEl = document.getElementById('manageBlocksFrom');
                const toEl = document.getElementById('manageBlocksTo');
                const applyBtn = document.getElementById('manageBlocksApplyBtn');
                const clearBtn = document.getElementById('manageBlocksClearBtn');

                const parseYmd = (s) => {
                    try { return s ? new Date(s + 'T00:00:00') : null; } catch (e) { return null; }
                };

                const applyManageBlocksFilter = () => {
                    try{
                        const q = (searchEl && searchEl.value ? searchEl.value.trim().toLowerCase() : '');
                        const fromD = parseYmd(fromEl ? fromEl.value : '');
                        const toD = parseYmd(toEl ? toEl.value : '');

                        const rows = Array.from(listEl.querySelectorAll('[data-block-row="1"]'));
                        let anyVisible = false;

                        rows.forEach(row => {
                            const title = (row.dataset.title || '').toLowerCase();
                            const fullText = (row.textContent || '').toLowerCase();
                            const sYmd = row.dataset.startYmd || '';
                            const eYmd = row.dataset.endYmd || '';
                            const sD = parseYmd(sYmd);
                            const eD = parseYmd(eYmd);

                            let ok = true;
                            if (q) ok = ok && (title.includes(q) || fullText.includes(q));

                            // Date range overlap check: block [sD,eD] overlaps filter [fromD,toD]
                            if (fromD || toD) {
                                if (!sD || !eD) {
                                    ok = false;
                                } else {
                                    if (fromD && eD && eD < fromD) ok = false;
                                    if (toD && sD && sD > toD) ok = false;
                                }
                            }

                            row.style.display = ok ? '' : 'none';
                            if (ok) anyVisible = true;
                        });

                        // filtered empty state (only when there are rows)
                        let empty = listEl.querySelector('[data-block-empty="1"]');
                        if (!anyVisible && rows.length) {
                            if (!empty) {
                                empty = document.createElement('div');
                                empty.dataset.blockEmpty = '1';
                                empty.className = 'text-center py-4 text-muted';
                                empty.innerHTML = '<i class="bi bi-search" style="font-size:1.6rem;opacity:0.6;"></i><div class="mt-2">No blocked ranges match your filter.</div>';
                                listEl.appendChild(empty);
                            }
                        } else if (empty) {
                            empty.remove();
                        }
                    }catch(e){}
                };

                // expose so removal actions can re-apply after DOM changes
                window.__applyManageBlocksFilter = applyManageBlocksFilter;

                if (searchEl && !searchEl.dataset.bound) {
                    searchEl.dataset.bound = '1';
                    searchEl.addEventListener('input', applyManageBlocksFilter);
                }
                if (applyBtn && !applyBtn.dataset.bound) {
                    applyBtn.dataset.bound = '1';
                    applyBtn.addEventListener('click', applyManageBlocksFilter);
                }
                if (fromEl && !fromEl.dataset.bound) {
                    fromEl.dataset.bound = '1';
                    fromEl.addEventListener('change', applyManageBlocksFilter);
                }
                if (toEl && !toEl.dataset.bound) {
                    toEl.dataset.bound = '1';
                    toEl.addEventListener('change', applyManageBlocksFilter);
                }
                if (clearBtn && !clearBtn.dataset.bound) {
                    clearBtn.dataset.bound = '1';
                    clearBtn.addEventListener('click', () => {
                        if (searchEl) searchEl.value = '';
                        if (fromEl) fromEl.value = '';
                        if (toEl) toEl.value = '';
                        applyManageBlocksFilter();
                    });
                }

                try {
                    const resp = await fetch(eventsUrl);
                    const items = await resp.json();
                    // filter blocked slots
                    const blocked = items.filter(i => i.extendedProps && i.extendedProps.type === 'blocked');
                    // Deduplicate expanded all-day blocked events (one entry per original schedule slot)
                    const byOrigId = {};
                    blocked.forEach(b => {
                        const origId = extractOrigScheduleId(b.id, b.extendedProps);
                        if (!origId) return;
                        // Prefer an entry that includes orig_start/orig_end if available
                        const hasOrig = b.extendedProps && b.extendedProps.orig_start && b.extendedProps.orig_end;
                        if (!byOrigId[origId] || (hasOrig && !(byOrigId[origId].extendedProps && byOrigId[origId].extendedProps.orig_start))) {
                            byOrigId[origId] = b;
                        }
                    });
                    const uniqueBlocked = Object.keys(byOrigId).map(k => byOrigId[k]);
                    
                    listEl.innerHTML = '';
                    
                    if (!uniqueBlocked.length) {
                        listEl.innerHTML = `
                            <div class="text-center py-5">
                                <i class="bi bi-calendar-check" style="font-size: 3rem; color: #6c757d; opacity: 0.5;"></i>
                                <p class="text-muted mt-3 mb-0">No blocked date ranges found.</p>
                                <small class="text-muted">All dates are available for booking.</small>
                            </div>
                        `;
                        return;
                    }

                    uniqueBlocked.forEach((slot) => {
                        const { startIso, endIso } = getOrigRange(slot);
                        const startDate = new Date(startIso);
                        const endDate = new Date(endIso);
                        const isAllDay = looksAllDayUTC(startIso, endIso);
                        const durationDays = Math.max(1, Math.round((endDate - startDate) / (1000 * 60 * 60 * 24)));
                        const inclusiveEnd = isAllDay ? new Date(endDate.getTime() - 24 * 60 * 60 * 1000) : endDate;
                        const startYmd = startIso ? String(startIso).slice(0, 10) : '';
                        // inclusiveEnd -> y-m-d in local time
                        const endYmd = inclusiveEnd ? new Date(inclusiveEnd.getTime() - inclusiveEnd.getTimezoneOffset() * 60000).toISOString().slice(0,10) : '';
                        
                        const li = document.createElement('div');
                        li.className = 'list-group-item';
                        li.style.cssText = 'border-left: 4px solid #dc3545; margin-bottom: 12px; border-radius: 8px; padding: 16px; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);';
                        li.dataset.blockRow = '1';
                        li.dataset.title = (slot.title || 'Blocked');
                        li.dataset.startYmd = startYmd;
                        li.dataset.endYmd = endYmd;
                        
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
                                <strong>Start:</strong> ${startDate.toLocaleDateString('en-US', isAllDay ? { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' } : { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}
                            </div>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-calendar-x me-1"></i>
                                <strong>End:</strong> ${inclusiveEnd.toLocaleDateString('en-US', isAllDay ? { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' } : { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}
                            </div>
                            <div class="badge bg-warning text-dark mt-2">
                                <i class="bi bi-clock me-1"></i>${isAllDay ? `${durationDays} ${durationDays === 1 ? 'day' : 'days'} (all day)` : 'Time-specific'}
                            </div>
                        `;
                        
                        const actions = document.createElement('div');
                        actions.style.cssText = 'white-space: nowrap; margin-left: 16px; display:flex; flex-direction:column; gap:8px;';

                        const editBtn = document.createElement('button');
                        editBtn.className = 'btn btn-outline-primary btn-sm';
                        editBtn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Edit';
                        editBtn.addEventListener('click', () => openEditBlockInModal(slot));

                        const removeBtn = document.createElement('button');
                        removeBtn.className = 'btn btn-outline-danger btn-sm';
                        removeBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                        removeBtn.addEventListener('click', async () => {
                            if (!confirm(`Are you sure you want to remove the blocked range "${slot.title || 'Blocked'}"?`)) return;
                            
                            removeBtn.disabled = true;
                            editBtn.disabled = true;
                            removeBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Removing...';
                            
                            try {
                                // slot.id might be slot-<origId>-YYYYMMDD; extract the original slot id
                                const raw = ('' + slot.id);
                                const parts = raw.split('-');
                                const origId = parts.length > 1 ? parts[1] : raw.replace('slot-', '');
                                const delResp = await fetch(`/admin/schedules/${origId}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': getCsrfToken() } });
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
                                        try { window.__applyManageBlocksFilter && window.__applyManageBlocksFilter(); } catch(e){}
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
                                    removeBtn.disabled = false;
                                    editBtn.disabled = false;
                                    removeBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                                }
                            } catch (err) {
                                console.error('Unblock error', err);
                                alert('❌ Error removing block. Please check the console for details.');
                                removeBtn.disabled = false;
                                editBtn.disabled = false;
                                removeBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                            }
                        });

                        card.appendChild(left);
                        actions.appendChild(editBtn);
                        actions.appendChild(removeBtn);
                        card.appendChild(actions);
                        li.appendChild(card);
                        listEl.appendChild(li);
                    });

                    // Apply current filter after rendering
                    try { applyManageBlocksFilter(); } catch (e) {}
                } catch (err) {
                    console.error('Failed to load blocked ranges', err);
                    listEl.innerHTML = '<div class="text-danger">Failed to load blocked ranges.</div>';
                }
            });
        }
});
