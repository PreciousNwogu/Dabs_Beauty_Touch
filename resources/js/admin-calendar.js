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
                // Reset form
                const blockTitle = document.getElementById('blockTitle');
                const blockStart = document.getElementById('blockStart');
                const blockEnd = document.getElementById('blockEnd');
                const blockAllDay = document.getElementById('blockAllDay');
                const blockPreview = document.getElementById('blockPreview');
                
                if (blockTitle) blockTitle.value = '';
                if (blockStart) blockStart.value = '';
                if (blockEnd) blockEnd.value = '';
                if (blockAllDay) blockAllDay.checked = true;
                if (blockPreview) blockPreview.style.display = 'none';
                
                // Initialize mode
                updateBlockMode();
                
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

        if (!allDayCheck) return;

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

            if (!startInput || !endInput) { 
                alert('⚠️ Please provide both start and end date/time'); 
                return; 
            }

            // Parse datetime-local input directly to avoid timezone conversion issues
            // datetime-local format: "YYYY-MM-DDTHH:mm" (no timezone, local time)
            let start, end;
            
            if (allDay) {
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
            } else {
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
            submitBlockBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';

            try {
                console.log('Creating blocked range:', { 
                    title, 
                    allDay,
                    input: { start: startInput, end: endInput },
                    parsed: { start: start.toISOString(), end: end.toISOString() },
                    storeUrl, 
                    csrf: csrf ? 'present' : 'missing' 
                });
                
                const res = await fetch(storeUrl, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ title, start: start.toISOString(), end: end.toISOString(), type: 'blocked' })
                });
                
                console.log('Response status:', res.status, res.statusText);
                console.log('Response headers:', Object.fromEntries(res.headers.entries()));
                
                // Check if response is ok
                if (!res.ok) {
                    const errorText = await res.text();
                    console.error('Server error response:', errorText);
                    let errorMessage = 'Failed to create blocked range';
                    try {
                        const errorData = JSON.parse(errorText);
                        errorMessage = errorData.message || errorData.error || errorMessage;
                        if (errorData.conflicts && Array.isArray(errorData.conflicts)) {
                            errorMessage += '\n\nConflicts with existing bookings:\n' + 
                                errorData.conflicts.map(c => `- ${c.name} on ${c.date} at ${c.time}`).join('\n');
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
                    let errorMessage = data.message || 'Unknown error';
                    if (data.conflicts && Array.isArray(data.conflicts)) {
                        errorMessage += '\n\nConflicts with existing bookings:\n' + 
                            data.conflicts.map(c => `- ${c.name} on ${c.date} at ${c.time}`).join('\n');
                    }
                    alert('❌ Failed to create block: ' + errorMessage);
                }
            } catch (err) {
                console.error('Block create error:', err);
                console.error('Error details:', {
                    message: err.message,
                    stack: err.stack,
                    storeUrl,
                    csrf: csrf ? 'present' : 'missing'
                });
                alert('❌ Error creating blocked range: ' + (err.message || 'Network or server error. Please check the console for details.'));
            } finally {
                submitBlockBtn.disabled = false;
                submitBlockBtn.innerHTML = '<i class="bi bi-slash-circle me-2"></i>Create Block';
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
