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

    const submitBlockBtn = document.getElementById('submitBlock');
    if (submitBlockBtn) {
        submitBlockBtn.addEventListener('click', async () => {
            const title = document.getElementById('blockTitle').value || 'Blocked';
            const allDay = document.getElementById('blockAllDay').checked;
            const startInput = document.getElementById('blockStart').value;
            const endInput = document.getElementById('blockEnd').value;

            if (!startInput || !endInput) { alert('Please provide start and end'); return; }

            let start = new Date(startInput);
            let end = new Date(endInput);
            if (allDay) {
                // normalize to full days: start at 00:00, end = next day 00:00
                start = new Date(start.getFullYear(), start.getMonth(), start.getDate());
                end = new Date(end.getFullYear(), end.getMonth(), end.getDate() + 1);
            }

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
                    alert('Blocked range created');
                } else {
                    console.warn('Failed to create block:', data);
                    alert('Failed to create block: ' + (data.message || 'Unknown'));
                }
            } catch (err) {
                console.error('Block create error', err);
                alert('Error creating blocked range. See console for details.');
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
                listEl.innerHTML = '<div class="text-muted">Loading blocked ranges...</div>';

                try {
                    const resp = await fetch(eventsUrl);
                    const items = await resp.json();
                    // filter blocked slots
                    const blocked = items.filter(i => i.extendedProps && i.extendedProps.type === 'blocked');
                    if (!blocked.length) {
                        listEl.innerHTML = '<div class="text-muted">No blocked ranges found.</div>';
                        return;
                    }

                    listEl.innerHTML = '';
                    blocked.forEach(slot => {
                        const li = document.createElement('div');
                        li.className = 'list-group-item d-flex justify-content-between align-items-start';
                        const left = document.createElement('div');
                        left.innerHTML = `<div><strong>${slot.title || 'Blocked'}</strong></div><div class="text-muted">${new Date(slot.start).toLocaleString()} — ${new Date(slot.end).toLocaleString()}</div>`;
                        const btn = document.createElement('button');
                        btn.className = 'btn btn-sm btn-outline-danger';
                        btn.textContent = 'Unblock';
                        btn.addEventListener('click', async () => {
                            if (!confirm('Remove this blocked range?')) return;
                            try {
                                // slot.id might be slot-<origId>-YYYYMMDD; extract the original slot id
                                const raw = ('' + slot.id);
                                const parts = raw.split('-');
                                const origId = parts.length > 1 ? parts[1] : raw.replace('slot-', '');
                                const delResp = await fetch(`/admin/schedules/${origId}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrf } });
                                const delData = await delResp.json();
                                if (delData.success) {
                                    // remove from UI and refresh calendar
                                    li.remove();
                                    calendar.refetchEvents();
                                } else {
                                    alert('Failed to remove block');
                                }
                            } catch (err) {
                                console.error('Unblock error', err);
                                alert('Error removing block');
                            }
                        });

                        li.appendChild(left);
                        const right = document.createElement('div');
                        right.appendChild(btn);
                        li.appendChild(right);
                        listEl.appendChild(li);
                    });
                } catch (err) {
                    console.error('Failed to load blocked ranges', err);
                    listEl.innerHTML = '<div class="text-danger">Failed to load blocked ranges.</div>';
                }
            });
        }
});
