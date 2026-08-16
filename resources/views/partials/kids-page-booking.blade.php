@php
    $kidsBookingOrigin = 'kids-selector';
@endphp
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
.calendar-day {
    border: 1px solid #e9ecef;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    min-height: 48px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.calendar-day.selected { background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); color: #fff; }
.calendar-day.available { background: #d4edda; }
.calendar-day.booked, .calendar-day.past, .calendar-day.blocked-range { background: #f8d7da; cursor: not-allowed; }
.calendar-day.other-month { opacity: .35; }
.time-slot-btn.available { border-color: #17a2b8; }
#kidsBookingModal .dbt-terms-consent { display: flex; gap: 8px; align-items: flex-start; }
</style>

@include('partials.kids-booking-modal')
@include('partials.client-calendar-modal')

<div id="termsPreviewOverlay" style="display:none; position:fixed; inset:0; z-index:20000; background:rgba(3,15,104,0.55); align-items:center; justify-content:center; padding:16px;">
    <div style="background:#fff; max-width:720px; width:100%; max-height:90vh; display:flex; flex-direction:column; border-radius:18px; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #030f68 0%, #4a8bc2 100%); color:#fff; padding:16px 20px; display:flex; justify-content:space-between;">
            <strong>Terms &amp; Conditions</strong>
            <button type="button" data-terms-close="1" style="background:transparent; border:0; color:#fff; font-size:1.6rem; cursor:pointer;" aria-label="Close">&times;</button>
        </div>
        <div id="termsPreviewOverlayBody" style="overflow:auto; padding:20px; background:#f8f9fa; flex:1;">
            <p>A {{ \App\Support\InteracDeposit::amountLabel() }} Interac deposit holds your appointment. Style changes are not taken on the day. You can cancel or reschedule from your confirmation email. Full terms are also on the homepage.</p>
        </div>
        <div style="padding:14px 20px; text-align:right; background:#fff;">
            <button type="button" data-terms-close="1" class="btn btn-primary" style="background:#030f68; border:none; font-weight:700;">Back to booking</button>
        </div>
    </div>
</div>

<script>
(function () {
    if (window.__kidsPageBookingReady) return;
    window.__kidsPageBookingReady = true;

    let calendarCurrentDate = new Date();
    let selectedCalendarDate = null;
    let selectedCalendarTime = null;
    let bookedDatesCache = [];
    let blockedDatesCache = [];

    function formatYMD(d) {
        if (!(d instanceof Date) || isNaN(d.getTime())) return '';
        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return y + '-' + m + '-' + day;
    }

    window.openCalendarModal = function () {
        const modalEl = document.getElementById('calendarModal');
        if (!modalEl) return;
        if (modalEl.parentNode !== document.body) {
            try { document.body.appendChild(modalEl); } catch (e) {}
        }
        modalEl.style.zIndex = '2050';
        const calendarModal = new bootstrap.Modal(modalEl);
        calendarModal.show();
        calendarCurrentDate = new Date();
        fetchCalendarData();
        setTimeout(renderCalendarModal, 80);
        setTimeout(function () {
            const backs = document.querySelectorAll('.modal-backdrop');
            if (backs.length) backs[backs.length - 1].style.zIndex = '2045';
        }, 50);
    };

    function fetchCalendarData() {
        const year = calendarCurrentDate.getFullYear();
        const month = calendarCurrentDate.getMonth() + 1;
        const bookedPromise = fetch('/api/booked-dates').then(function (r) { return r.json(); }).catch(function () { return null; });
        const blockedPromise = fetch('/schedules/blocked-dates?year=' + year + '&month=' + month).then(function (r) { return r.json(); }).catch(function () { return null; });
        Promise.all([bookedPromise, blockedPromise]).then(function (pair) {
            const bookedResp = pair[0], blockedResp = pair[1];
            if (bookedResp && bookedResp.success) {
                bookedDatesCache = (bookedResp.booked_dates || []).filter(function (b) { return b.disabled; }).map(function (b) { return b.date; });
            }
            if (blockedResp && blockedResp.success) {
                blockedDatesCache = blockedResp.blocked_dates || [];
            }
            renderCalendarModal();
        });
    }

    function renderCalendarModal() {
        const monthEl = document.getElementById('calendarMonth');
        const calendarDays = document.getElementById('calendarDays');
        if (!monthEl || !calendarDays) return;
        const year = calendarCurrentDate.getFullYear();
        const month = calendarCurrentDate.getMonth();
        monthEl.textContent = new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        const firstDay = new Date(year, month, 1);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());
        calendarDays.innerHTML = '';
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const blockedIndex = {};
        (blockedDatesCache || []).forEach(function (b) {
            if (b && b.date) blockedIndex[b.date] = b;
        });
        for (let i = 0; i < 42; i++) {
            const date = new Date(startDate);
            date.setDate(startDate.getDate() + i);
            const dateString = formatYMD(date);
            const dayDiv = document.createElement('div');
            dayDiv.className = 'col calendar-day';
            dayDiv.textContent = String(date.getDate());
            if (date.getMonth() !== month) {
                dayDiv.classList.add('other-month');
            } else if (date < today) {
                dayDiv.classList.add('past');
            } else if (bookedDatesCache.indexOf(dateString) !== -1) {
                dayDiv.classList.add('booked');
                dayDiv.title = 'Fully booked';
            } else if (blockedIndex[dateString] && (blockedIndex[dateString].full_day === true || blockedIndex[dateString].full_day === 1)) {
                dayDiv.classList.add('blocked-range');
                dayDiv.title = blockedIndex[dateString].title || 'Blocked';
            } else {
                dayDiv.classList.add('available');
                dayDiv.addEventListener('click', function (ev) { selectCalendarDate(date, ev); });
            }
            calendarDays.appendChild(dayDiv);
        }
    }

    function selectCalendarDate(date, ev) {
        selectedCalendarDate = date;
        window.selectedCalendarDate = date;
        document.querySelectorAll('#calendarModal .calendar-day').forEach(function (day) { day.classList.remove('selected'); });
        if (ev && ev.currentTarget) ev.currentTarget.classList.add('selected');
        loadTimeSlotsForDate(date);
    }

    function loadTimeSlotsForDate(date) {
        const loading = document.getElementById('calendarLoading');
        const timeSlotsContainer = document.getElementById('timeSlotsContainer');
        const timeSlots = document.getElementById('timeSlots');
        const selectedDateText = document.getElementById('selectedDateText');
        if (loading) loading.style.display = 'block';
        if (timeSlotsContainer) timeSlotsContainer.style.display = 'none';
        if (selectedDateText) selectedDateText.textContent = date.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        fetch('/bookings/slots?date=' + formatYMD(date))
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (loading) loading.style.display = 'none';
                if (timeSlotsContainer) timeSlotsContainer.style.display = 'block';
                const slots = (data && data.slots) ? data.slots : [];
                renderTimeSlots(slots);
            })
            .catch(function () {
                if (loading) loading.style.display = 'none';
                if (timeSlotsContainer) timeSlotsContainer.style.display = 'block';
                if (timeSlots) timeSlots.innerHTML = '<div class="alert alert-warning">Could not load times. Try again.</div>';
            });
    }

    function renderTimeSlots(slots) {
        const timeSlots = document.getElementById('timeSlots');
        const confirmBtn = document.getElementById('confirmDateTimeBtn');
        if (!timeSlots) return;
        timeSlots.innerHTML = '';
        selectedCalendarTime = null;
        if (confirmBtn) confirmBtn.disabled = true;
        const open = slots.filter(function (s) { return s.available; });
        if (!open.length) {
            timeSlots.innerHTML = '<div class="alert alert-warning">No remaining times for this date.</div>';
            return;
        }
        slots.forEach(function (slot) {
            const wrap = document.createElement('div');
            wrap.className = 'col-6 col-md-4 col-lg-3';
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-outline-primary w-100 time-slot-btn ' + (slot.available ? 'available' : 'booked');
            btn.disabled = !slot.available;
            btn.textContent = slot.formatted_time || slot.time;
            if (slot.available) {
                btn.addEventListener('click', function () {
                    selectedCalendarTime = { time: slot.time, formattedTime: slot.formatted_time || slot.time };
                    document.querySelectorAll('.time-slot-btn').forEach(function (b) {
                        b.classList.remove('btn-primary');
                        b.classList.add('btn-outline-primary');
                    });
                    btn.classList.remove('btn-outline-primary');
                    btn.classList.add('btn-primary');
                    if (confirmBtn) confirmBtn.disabled = false;
                });
            }
            wrap.appendChild(btn);
            timeSlots.appendChild(wrap);
        });
    }

    window.previousMonth = function () {
        calendarCurrentDate.setMonth(calendarCurrentDate.getMonth() - 1);
        fetchCalendarData();
    };
    window.nextMonth = function () {
        calendarCurrentDate.setMonth(calendarCurrentDate.getMonth() + 1);
        fetchCalendarData();
    };

    window.confirmDateTime = function () {
        if (!selectedCalendarDate || !selectedCalendarTime) return;
        const formattedDate = selectedCalendarDate.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        const dateYmd = formatYMD(selectedCalendarDate);
        const dateInput = document.getElementById('kidsBookingDate');
        const timeInput = document.getElementById('kidsBookingTime');
        const dateLabel = document.getElementById('kidsSelectedDateLabel');
        const timeLabel = document.getElementById('kidsSelectedTimeLabel');
        if (dateInput) dateInput.value = formattedDate;
        if (timeInput) timeInput.value = selectedCalendarTime.formattedTime;
        if (dateLabel) dateLabel.textContent = formattedDate;
        if (timeLabel) timeLabel.textContent = selectedCalendarTime.formattedTime;
        const kidsForm = document.getElementById('kidsBookingForm');
        if (kidsForm) {
            const hd = kidsForm.querySelector('input[name="appointment_date"]');
            const ht = kidsForm.querySelector('input[name="appointment_time"]');
            if (hd) hd.value = dateYmd;
            if (ht) ht.value = selectedCalendarTime.time;
        }
        [dateInput, timeInput].forEach(function (el) {
            if (!el) return;
            try { el.dispatchEvent(new Event('input', { bubbles: true })); } catch (e) {}
            try { el.dispatchEvent(new Event('change', { bubbles: true })); } catch (e) {}
        });
        const cal = bootstrap.Modal.getInstance(document.getElementById('calendarModal'));
        if (cal) cal.hide();
        setTimeout(function () {
            const kidsModalEl = document.getElementById('kidsBookingModal');
            if (kidsModalEl && !kidsModalEl.classList.contains('show')) {
                try { new bootstrap.Modal(kidsModalEl).show(); } catch (e) {}
            }
            const nameField = document.getElementById('kids_name');
            if (nameField) nameField.focus();
            try { if (typeof window.updateKidsConfirmState === 'function') window.updateKidsConfirmState(); } catch (e) {}
        }, 160);
    };

    function fillKidsStyleRecap(sel) {
        try {
            var payload = Object.assign({}, sel || window.__kidsSelectorData || {});
            try {
                var raw = localStorage.getItem('kb_selector');
                if (raw) {
                    var parsed = JSON.parse(raw);
                    if (parsed && typeof parsed === 'object') {
                        Object.keys(parsed).forEach(function (key) {
                            if (payload[key] == null || payload[key] === '') payload[key] = parsed[key];
                        });
                    }
                }
            } catch (e) {}
            var type = payload.kb_braid_type || payload.braid_type || '';
            var meta = (window.__kidsStyleMeta && window.__kidsStyleMeta[type]) || {};
            var name = payload.style_label || meta.label || 'Kids Braids';
            var image = payload.style_image || meta.image || '';
            var duration = payload.style_duration || meta.duration || '';
            var disableSteps = !!meta.disable_steps;
            var finishMap = { plain: 'Without curl', curled: 'With curled tip' };
            var lengthMap = { shoulder: 'Shoulder', armpit: 'Armpit', mid_back: 'Mid back', waist: 'Waist' };
            var addonMap = { kb_add_detangle: 'Detangle / Blowdry', kb_add_beads: 'Tiny beading', kb_add_beads_full: 'Big eye beading', kb_add_extension: 'Hair Extension', kb_add_rest: '15-min break' };
            var finish = payload.finish_label || finishMap[payload.kb_finish || payload.finish] || '';
            var length = payload.length_label || lengthMap[payload.kb_length || payload.hair_length || payload.length] || '';
            var extras = [];
            String(payload.extras_labels || payload.kb_extras || payload.extras || '').split(',').forEach(function (token) {
                token = String(token || '').trim();
                if (!token) return;
                extras.push(addonMap[token] || token);
            });
            var details = [];
            if (!disableSteps) {
                if (finish) details.push(finish);
                if (length) details.push(length);
            }
            extras.forEach(function (item) { if (item) details.push(item); });
            var nameEl = document.getElementById('kidsRecapName');
            var detailsEl = document.getElementById('kidsRecapDetails');
            var timeEl = document.getElementById('kidsRecapTime');
            var imgEl = document.getElementById('kidsRecapImage');
            if (nameEl) nameEl.textContent = name;
            if (detailsEl) detailsEl.textContent = details.join(' · ');
            if (timeEl) timeEl.textContent = duration ? ('About ' + duration) : '';
            if (imgEl) {
                if (image) { imgEl.src = image; imgEl.alt = name; imgEl.style.display = ''; }
                else { imgEl.removeAttribute('src'); imgEl.style.display = 'none'; }
            }
            var colorEl = document.getElementById('kids_hair_color');
            if (colorEl && payload.hair_color) colorEl.value = payload.hair_color;
            var commentsEl = document.getElementById('kids_comments_input');
            if (commentsEl && payload.comments) commentsEl.value = payload.comments;
        } catch (e) {}
    }
    window.fillKidsStyleRecap = fillKidsStyleRecap;

    window.openKidsBookingModal = function (serviceName, serviceType) {
        try {
            const svc = document.getElementById('kids_service_input'); if (svc) svc.value = serviceName || 'Kids Braids';
            const st = document.getElementById('kids_service_type_input'); if (st) st.value = serviceType || 'kids-braids';
            const sel = window.__kidsSelectorData || {};
            const ibt = document.getElementById('kids_braid_type_input'); if (ibt) ibt.value = sel.kb_braid_type || sel.braid_type || '';
            const ifin = document.getElementById('kids_finish_input'); if (ifin) ifin.value = sel.kb_finish || sel.finish || '';
            const iln = document.getElementById('kids_length_input'); if (iln) iln.value = (sel.kb_length || sel.hair_length || '').toString().replace(/-/g, '_');
            const iex = document.getElementById('kids_extras_input'); if (iex) iex.value = sel.kb_extras || sel.extras || '';
            const kp = document.getElementById('kids_price_input'); if (kp) kp.value = sel.price || '';
            const kf = document.getElementById('kids_final_price_input'); if (kf) kf.value = sel.price || '';
            const kt = document.getElementById('kidsModal_total'); if (kt) kt.textContent = sel.price ? ('$' + Number(sel.price).toFixed(2)) : '$--';
            const kb = document.getElementById('kidsModal_base'); if (kb && sel.price) kb.textContent = '$' + Number(sel.price).toFixed(2);
            fillKidsStyleRecap(sel);
            const modalEl = document.getElementById('kidsBookingModal');
            if (modalEl) new bootstrap.Modal(modalEl).show();
            if (typeof toggleAddressFieldKids === 'function') toggleAddressFieldKids();
            try { if (typeof window.updateKidsConfirmState === 'function') window.updateKidsConfirmState(); } catch (e) {}
        } catch (e) { console.warn('openKidsBookingModal failed', e); }
    };

    window.backToKidsSelector = function () {
        try {
            const inst = bootstrap.Modal.getInstance(document.getElementById('kidsBookingModal'));
            if (inst) inst.hide();
            const box = document.querySelector('.kb-selector-container');
            if (box) box.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } catch (e) {}
    };

    window.toggleAddressFieldKids = function () {
        const mobileRadio = document.getElementById('appointment_type_mobile_kids');
        const addressContainer = document.getElementById('addressFieldContainerKids');
        const addressInput = document.getElementById('kids_address');
        const parkingContainer = document.getElementById('parkingFieldContainerKids');
        const parkingInputs = document.querySelectorAll('#kidsBookingForm input[name="parking_type"]');
        const isMobile = !!(mobileRadio && mobileRadio.checked);
        if (addressContainer) addressContainer.classList.toggle('d-none', !isMobile);
        if (parkingContainer) parkingContainer.classList.toggle('d-none', !isMobile);
        if (addressInput) addressInput.required = isMobile;
        parkingInputs.forEach(function (input) { input.required = isMobile; if (!isMobile) input.checked = false; });
        try { if (typeof window.updateKidsConfirmState === 'function') window.updateKidsConfirmState(); } catch (e) {}
    };

    document.addEventListener('DOMContentLoaded', function () {
        const kidsIn = document.getElementById('appointment_type_in_studio_kids');
        const kidsMob = document.getElementById('appointment_type_mobile_kids');
        if (kidsIn) kidsIn.addEventListener('change', toggleAddressFieldKids);
        if (kidsMob) kidsMob.addEventListener('change', toggleAddressFieldKids);
        toggleAddressFieldKids();

        document.querySelectorAll('.js-terms-popup').forEach(function (a) {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                const overlay = document.getElementById('termsPreviewOverlay');
                if (overlay) overlay.style.display = 'flex';
            });
        });
        document.querySelectorAll('[data-terms-close]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const overlay = document.getElementById('termsPreviewOverlay');
                if (overlay) overlay.style.display = 'none';
            });
        });

        const form = document.getElementById('kidsBookingForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                const sel = window.__kidsSelectorData || {};
                const ibt = document.getElementById('kids_braid_type_input'); if (ibt && !ibt.value) ibt.value = sel.kb_braid_type || '';
                const commentsSel = document.getElementById('kb_comments');
                const commentsHid = document.getElementById('kids_comments_input');
                if (commentsHid && commentsSel) commentsHid.value = commentsSel.value || sel.comments || '';
                const colorSel = document.getElementById('kb_hair_color');
                const colorMod = document.getElementById('kids_hair_color');
                if (colorMod && !colorMod.value && colorSel) colorMod.value = colorSel.value;
                const name = (document.getElementById('kids_name') || {}).value || '';
                const parent = (document.getElementById('kids_parent_name') || {}).value || '';
                const age = (document.getElementById('kids_age') || {}).value || '';
                const email = (document.getElementById('kids_email') || {}).value || '';
                const phone = (document.getElementById('kids_phone') || {}).value || '';
                const date = (document.getElementById('kidsBookingDate') || {}).value || '';
                const terms = document.getElementById('termsAcceptedKids');
                if (!name || !parent || !age || !email || !phone || !date || !(terms && terms.checked)) {
                    e.preventDefault();
                    alert('Please fill in the child and parent details, pick a date, and accept the terms.');
                    return false;
                }
            });
        }
    });
})();
</script>
