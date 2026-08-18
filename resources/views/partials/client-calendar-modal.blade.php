<div class="modal fade" id="calendarModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); color: white;">
                <h5 class="modal-title">{{ __('booking.select_datetime') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center mb-3">
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-primary" onclick="previousMonth()">{{ __('booking.previous') }}</button>
                    </div>
                    <div class="col-4 text-center">
                        <h5 id="calendarMonth" class="mb-0"></h5>
                    </div>
                    <div class="col-4 text-end">
                        <button type="button" class="btn btn-outline-primary" onclick="nextMonth()">{{ __('booking.next') }}</button>
                    </div>
                </div>
                <div class="calendar-grid mb-3">
                    <div class="row">
                        <div class="col text-center fw-bold">{{ __('booking.sun') }}</div>
                        <div class="col text-center fw-bold">{{ __('booking.mon') }}</div>
                        <div class="col text-center fw-bold">{{ __('booking.tue') }}</div>
                        <div class="col text-center fw-bold">{{ __('booking.wed') }}</div>
                        <div class="col text-center fw-bold">{{ __('booking.thu') }}</div>
                        <div class="col text-center fw-bold">{{ __('booking.fri') }}</div>
                        <div class="col text-center fw-bold">{{ __('booking.sat') }}</div>
                    </div>
                    <div id="calendarDays" class="row mt-2"></div>
                </div>
                <div id="timeSlotsContainer" style="display: none;">
                    <h6 class="mb-3" style="font-weight: 600; color: #0b3a66;">{{ __('booking.slots_for') }} <span id="selectedDateText"></span></h6>
                    <div id="timeSlotsInstruction" class="alert alert-info mb-3" style="display: none;">{{ __('booking.click_slot') }}</div>
                    <div id="timeSlots" class="row g-2"></div>
                </div>
                <div id="calendarLoading" class="text-center" style="display: none;">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">{{ __('booking.loading_slots') }}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('booking.cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="confirmDateTime()" id="confirmDateTimeBtn" disabled>{{ __('booking.confirm_selection') }}</button>
            </div>
        </div>
    </div>
</div>
