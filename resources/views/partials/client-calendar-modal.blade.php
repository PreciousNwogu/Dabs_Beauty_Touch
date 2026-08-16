<div class="modal fade" id="calendarModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); color: white;">
                <h5 class="modal-title">Select Date &amp; Time</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center mb-3">
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-primary" onclick="previousMonth()">Previous</button>
                    </div>
                    <div class="col-4 text-center">
                        <h5 id="calendarMonth" class="mb-0"></h5>
                    </div>
                    <div class="col-4 text-end">
                        <button type="button" class="btn btn-outline-primary" onclick="nextMonth()">Next</button>
                    </div>
                </div>
                <div class="calendar-grid mb-3">
                    <div class="row">
                        <div class="col text-center fw-bold">Sun</div>
                        <div class="col text-center fw-bold">Mon</div>
                        <div class="col text-center fw-bold">Tue</div>
                        <div class="col text-center fw-bold">Wed</div>
                        <div class="col text-center fw-bold">Thu</div>
                        <div class="col text-center fw-bold">Fri</div>
                        <div class="col text-center fw-bold">Sat</div>
                    </div>
                    <div id="calendarDays" class="row mt-2"></div>
                </div>
                <div id="timeSlotsContainer" style="display: none;">
                    <h6 class="mb-3" style="font-weight: 600; color: #0b3a66;">Available Time Slots for <span id="selectedDateText"></span></h6>
                    <div id="timeSlotsInstruction" class="alert alert-info mb-3" style="display: none;">Click a time slot to select it.</div>
                    <div id="timeSlots" class="row g-2"></div>
                </div>
                <div id="calendarLoading" class="text-center" style="display: none;">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Loading available slots...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="confirmDateTime()" id="confirmDateTimeBtn" disabled>Confirm selection</button>
            </div>
        </div>
    </div>
</div>
