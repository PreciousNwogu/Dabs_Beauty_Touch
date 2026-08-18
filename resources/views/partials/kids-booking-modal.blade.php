<style>
.kids-style-recap {
    display: flex;
    gap: 14px;
    align-items: flex-start;
    background: #fff8f0;
    border: 2px solid #ffd4b0;
    border-radius: 12px;
    padding: 14px 16px;
}
.kids-style-recap img {
    width: 88px;
    height: 88px;
    object-fit: contain;
    object-position: center;
    border-radius: 10px;
    flex-shrink: 0;
    background: #f3efe8;
}
.kids-style-recap-name {
    font-weight: 800;
    color: #030f68;
    font-size: 1.12rem;
    line-height: 1.25;
}
.kids-style-recap-details,
.kids-style-recap-time {
    font-size: 0.9rem;
    color: #555;
    margin-top: 2px;
}
.kids-style-recap-change {
    display: inline-block;
    margin-top: 6px;
    color: #ff6600;
    font-weight: 700;
    font-size: 0.88rem;
    background: none;
    border: 0;
    padding: 0;
    text-decoration: none;
    cursor: pointer;
}
.kids-style-recap-change:hover { text-decoration: underline; }
#kidsBookingModal .kb-prep-note { margin: 0 0 16px; }
</style>
<script>window.__kidsStyleMeta = window.__kidsStyleMeta || @json(\App\Support\KidsStyleCatalog::publicMeta());</script>
<div class="modal fade" id="kidsBookingModal" tabindex="-1" aria-labelledby="kidsBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%); color: white; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title" id="kidsBookingModalLabel">{{ __('kids.modal.title') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="{{ __('booking.close') }}"></button>
            </div>
            <div class="modal-body p-4">
                <form id="kidsBookingForm" action="{{ url('/bookings') }}" method="POST" autocomplete="on" novalidate enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="booking_origin" value="{{ $kidsBookingOrigin ?? 'home' }}">
                    <input type="hidden" id="kids_service_input" name="service" value="Kids Braids">
                    <input type="hidden" id="kids_service_type_input" name="service_type" value="kids-braids">
                    <input type="hidden" id="kids_braid_type_input" name="kb_braid_type" value="">
                    <input type="hidden" id="kids_finish_input" name="kb_finish" value="">
                    <input type="hidden" id="kids_length_input" name="kb_length" value="">
                    <input type="hidden" id="kids_extras_input" name="kb_extras" value="">
                    <input type="hidden" id="kids_comments_input" name="comments" value="">
                    <input type="hidden" id="kids_price_input" name="price" value="">
                    <input type="hidden" id="kids_final_price_input" name="final_price" value="">
                    <input type="hidden" id="kids_appointment_date" name="appointment_date" value="">
                    <input type="hidden" id="kids_appointment_time" name="appointment_time" value="">

                    <div id="kidsStyleRecap" class="kids-style-recap mb-3">
                        <img id="kidsRecapImage" alt="" style="display:none;">
                        <div>
                            <div class="small text-muted">{{ __('kids.modal.selected_style') }}</div>
                            <div id="kidsRecapName" class="kids-style-recap-name">{{ __('kids.service_name') }}</div>
                            <div id="kidsRecapDetails" class="kids-style-recap-details"></div>
                            <div id="kidsRecapTime" class="kids-style-recap-time"></div>
                            <button type="button" class="kids-style-recap-change" onclick="backToKidsSelector()">{{ __('kids.modal.change_style') }}</button>
                        </div>
                    </div>

                    @include('partials.kids-prep-note')

                    <div class="row">
                        <div class="col-md-7">
                            <p class="fw-bold mb-2" style="color:#030f68;">{{ __('kids.modal.child') }}</p>
                            <div class="mb-3">
                                <label class="form-label" for="kids_name">{{ __('kids.modal.child_name') }}</label>
                                <input id="kids_name" name="name" type="text" class="form-control" required autocomplete="given-name">
                                <div id="kids_name_error" class="text-danger small mt-1" style="display:none;"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kids_age">{{ __('kids.modal.child_age') }}</label>
                                <select id="kids_age" name="child_age" class="form-select" required>
                                    <option value="">{{ __('kids.modal.select_age') }}</option>
                                    @for ($age = 3; $age <= 8; $age++)
                                        <option value="{{ $age }}">{{ $age }}</option>
                                    @endfor
                                </select>
                                <div id="kids_age_error" class="text-danger small mt-1" style="display:none;"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kids_hair_color">{{ __('kids.modal.hair_color') }}</label>
                                <input id="kids_hair_color" name="hair_color" type="text" class="form-control" maxlength="80" placeholder="{{ __('kids.modal.hair_color_placeholder') }}">
                            </div>

                            <p class="fw-bold mb-2 mt-3" style="color:#030f68;">{{ __('kids.modal.parent') }}</p>
                            <div class="mb-3">
                                <label class="form-label" for="kids_parent_name">{{ __('kids.modal.parent_name') }}</label>
                                <input id="kids_parent_name" name="parent_name" type="text" class="form-control" required autocomplete="name">
                                <div id="kids_parent_name_error" class="text-danger small mt-1" style="display:none;"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kids_email">{{ __('kids.modal.parent_email') }}</label>
                                <input id="kids_email" name="email" type="email" class="form-control" placeholder="you@example.com" required>
                                <div id="kids_email_error" class="text-danger small mt-1" style="display:none;"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kids_phone">{{ __('kids.modal.parent_phone') }}</label>
                                <input id="kids_phone" name="phone" type="tel" class="form-control" required pattern="[0-9+()\s\-]{7,}" placeholder="+1 555 555 5555">
                                <div class="form-text small text-muted">{{ __('kids.modal.phone_help') }} <code>+1</code></div>
                                <div id="kids_phone_error" class="text-danger small mt-1" style="display:none;"></div>
                            </div>

                            <div class="mb-3 d-flex gap-2 align-items-center">
                                <div>
                                    <label class="form-label mb-1">{{ __('kids.modal.selected_date') }}</label>
                                    <div id="kidsSelectedDateLabel" class="form-control-plaintext">--</div>
                                </div>
                                <div>
                                    <label class="form-label mb-1">{{ __('kids.modal.selected_time') }}</label>
                                    <div id="kidsSelectedTimeLabel" class="form-control-plaintext">--</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('kids.modal.date') }}</label>
                                <input id="kidsBookingDate" type="text" class="form-control" readonly onclick="openCalendarModal(); return false;" />
                                <div id="kidsBookingDate_error" class="text-danger small mt-1" style="display:none;"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('kids.modal.time') }}</label>
                                <input id="kidsBookingTime" type="text" class="form-control" readonly />
                                <div id="kidsBookingTime_error" class="text-danger small mt-1" style="display:none;"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('booking.form.type') }}</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="appointment_type" id="appointment_type_in_studio_kids" value="in-studio" checked>
                                        <label class="form-check-label" for="appointment_type_in_studio_kids">{{ __('booking.form.in_studio') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="appointment_type" id="appointment_type_mobile_kids" value="mobile">
                                        <label class="form-check-label" for="appointment_type_mobile_kids">{{ __('booking.form.mobile') }}</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted mt-2">{{ __('booking.form.mobile_help') }}</small>
                            </div>

                            <div class="mb-3 d-none" id="addressFieldContainerKids">
                                <label for="kids_address" class="form-label">{{ __('booking.form.address') }}</label>
                                <input type="text" class="form-control" id="kids_address" name="address" placeholder="{{ __('booking.form.address_placeholder') }}" autocomplete="off" minlength="10">
                                <div class="invalid-feedback">{{ __('booking.form.address_invalid') }}</div>
                            </div>

                            <div class="mb-3 d-none parking-choice-group" id="parkingFieldContainerKids">
                                <label class="form-label">{{ __('booking.form.parking') }}</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input parking-option-kids" type="radio" name="parking_type" id="parking_type_free_kids" value="free">
                                        <label class="form-check-label" for="parking_type_free_kids">{{ __('booking.form.parking_free') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input parking-option-kids" type="radio" name="parking_type" id="parking_type_paid_kids" value="paid">
                                        <label class="form-check-label" for="parking_type_paid_kids">{{ __('booking.form.parking_paid') }}</label>
                                    </div>
                                </div>
                                <div class="alert alert-warning py-2 mt-2 mb-0 paid-parking-note" style="font-size:0.95rem;">
                                    {!! __('booking.form.parking_note') !!}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('kids.modal.sample') }}</label>
                                <input id="kids_sample_picture" name="sample_picture" type="file" accept="image/*" class="form-control">
                                <div id="kids_imagePreview" class="mt-2" style="display:none;">
                                    <img id="kids_previewImg" src="" alt="{{ __('kids.modal.sample_preview') }}" style="max-width:120px; border-radius:8px; display:block;" />
                                    <div id="kids_fileName" class="small text-muted mt-1"></div>
                                    <button type="button" id="kids_removeSampleBtn" class="btn btn-sm btn-outline-secondary mt-2">{{ __('booking.remove') }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div style="background:#ffffff;border-radius:12px;padding:20px;border:2px solid #ff6600;box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                                <h5 style="color:#0b3a66;font-weight:800;margin-bottom:16px;font-size:1.2rem;border-bottom:2px solid #ff6600;padding-bottom:8px;">{{ __('kids.summary.title') }}</h5>
                                <div style="margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid #e3e3e0;">
                                    <div style="display:flex;justify-content:space-between;align-items:center;">
                                        <span style="color:#666;font-size:0.95rem;">{{ __('kids.modal.base') }}</span>
                                        <span>
                                            <span id="kidsModal_base_original" style="font-size:0.85rem;color:#999;text-decoration:line-through;margin-right:4px;display:none;"></span>
                                            <span id="kidsModal_base" style="font-size:1.1rem;font-weight:600;color:#0b3a66;">$--</span>
                                            <span id="kidsModal_discount_badge" style="background:#ff6600;color:#fff;font-size:0.65rem;font-weight:700;padding:2px 6px;border-radius:4px;margin-left:4px;display:none;">{{ __('booking.js.discounted') }}</span>
                                        </span>
                                    </div>
                                </div>
                                <div style="margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid #e3e3e0;">
                                    <div style="display:flex;justify-content:space-between;align-items:center;">
                                        <span style="color:#666;font-size:0.95rem;">{{ __('kids.modal.adjustments') }}</span>
                                        <span id="kidsModal_adjustments" style="font-size:1.1rem;font-weight:600;color:#0b3a66;">+ $0.00</span>
                                    </div>
                                </div>
                                <div style="margin-top:16px;padding-top:16px;border-top:2px solid #ff6600;background:#fff7e0;border-radius:8px;padding:14px;">
                                    <div style="display:flex;justify-content:space-between;align-items:center;">
                                        <span style="color:#0b3a66;font-size:1.1rem;font-weight:700;">{{ __('kids.modal.total') }}</span>
                                        <span id="kidsModal_total" style="font-size:1.5rem;font-weight:800;color:#ff6600;">$--</span>
                                    </div>
                                </div>
                                <div class="small text-muted mt-3">{{ __('kids.modal.deposit', ['amount' => \App\Support\InteracDeposit::amountLabel()]) }}</div>
                            </div>
                            <div class="d-grid mt-3">
                                <input type="hidden" name="terms_accepted" value="0">
                                <div class="dbt-terms-consent mb-2">
                                    <input class="form-check-input" type="checkbox" id="termsAcceptedKids" name="terms_accepted" value="1" required autocomplete="off">
                                    <div>
                                        <label for="termsAcceptedKids" style="font-size:0.95rem;">
                                            {!! __('kids.modal.agree_html') !!}
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="alert alert-warning py-2 mb-0" style="font-size:0.9rem;">
                                        {!! __('booking.form.no_changes') !!}
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" id="kidsBackToSelectorBtn" class="btn btn-secondary" style="font-weight:600;" onclick="backToKidsSelector()">{{ __('kids.modal.back') }}</button>
                                    <button type="submit" class="btn btn-warning" id="kidsBookAppointmentBtn" style="font-weight:600;">{{ __('kids.modal.confirm') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
