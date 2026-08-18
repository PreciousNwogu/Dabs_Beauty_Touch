<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="text-center mb-5">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #030f68;">{{ __('terms.title') }}</h2>
            <div style="display:inline-block; max-width:820px; margin-top:18px; text-align:left;">
                <div style="background: linear-gradient(90deg, rgba(255,102,0,0.06), rgba(3,15,104,0.03)); border-left: 6px solid #ff6600; padding: 18px 20px; border-radius: 12px; box-shadow: 0 6px 18px rgba(3,15,104,0.06);">
                    <div style="display:flex; align-items:flex-start; gap:12px;">
                        <div style="font-size:1.6rem; color:#ff6600; line-height:1; margin-top:2px;"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div>
                            <div style="font-size:1.05rem; color:#03253f; font-weight:700; margin-bottom:6px;">{{ __('terms.before') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(255, 152, 0, 0.1)); border-left: 6px solid #ff6600; border-top: 2px solid rgba(255, 102, 0, 0.3); padding: 20px 24px; border-radius: 12px; box-shadow: 0 4px 12px rgba(255, 102, 0, 0.1);">
                    <p style="margin: 0; color: #ff6600; font-size: 1.1rem; line-height: 1.6;">
                        <strong style="font-weight: 700;">{{ __('terms.important') }}</strong> {{ __('terms.washed') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card h-100 shadow-lg border-0" style="border-radius: 20px; background: #fff;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-credit-card" style="font-size: 3rem; color: #ff6600;"></i>
                        </div>
                        <h4 style="color: #030f68; font-weight: 700; text-align: center; margin-bottom: 20px;">{{ __('terms.deposit_title') }}</h4>
                        <ul class="list-unstyled" style="font-size: 1rem; line-height: 1.8;">
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <strong>{{ __('terms.deposit_required') }}</strong> {{ __('terms.deposit_required_body') }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <strong>{{ __('terms.payment_methods') }}</strong> {{ __('terms.payment_methods_body') }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <strong>{{ __('terms.balance') }}</strong> {{ __('terms.balance_body') }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                                <strong>{{ __('terms.no_refunds') }}</strong> {{ __('terms.no_refunds_body') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100 shadow-lg border-0" style="border-radius: 20px; background: #fff;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ff6600;"></i>
                        </div>
                        <h4 style="color: #030f68; font-weight: 700; text-align: center; margin-bottom: 20px;">{{ __('terms.cancel_title') }}</h4>
                        <ul class="list-unstyled" style="font-size: 1rem; line-height: 1.8;">
                            <li class="mb-3">
                                <i class="bi bi-clock-fill text-info me-2"></i>
                                <strong>{{ __('terms.notice') }}</strong> {{ __('terms.notice_body') }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                <strong>{{ __('terms.no_show') }}</strong> {{ __('terms.no_show_body') }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-arrow-clockwise text-success me-2"></i>
                                <strong>{{ __('terms.reschedule') }}</strong> {{ __('terms.reschedule_body') }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-calendar2-week-fill text-primary me-2"></i>
                                <strong>{{ __('terms.window') }}</strong> {{ __('terms.window_body') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100 shadow-lg border-0" style="border-radius: 20px; background: #fff;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-house-heart" style="font-size: 3rem; color: #ff6600;"></i>
                        </div>
                        <h4 style="color: #030f68; font-weight: 700; text-align: center; margin-bottom: 20px;">{{ __('terms.home_title') }}</h4>
                        <ul class="list-unstyled" style="font-size: 1rem; line-height: 1.8;">
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <strong>{{ __('terms.no_extra') }}</strong> {{ __('terms.no_extra_body') }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-car-front-fill text-info me-2"></i>
                                <strong>{{ __('terms.transport') }}</strong> {{ __('terms.transport_body') }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-p-circle-fill text-warning me-2"></i>
                                <strong>{{ __('terms.paid_parking') }}</strong> {{ __('terms.paid_parking_body') }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                                <strong>{{ __('terms.area') }}</strong> {{ __('terms.area_body') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100 shadow-lg border-0" style="border-radius: 20px; background: linear-gradient(135deg, #030f68 0%, #05137c 100%); color: white;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-telephone-fill" style="font-size: 3rem; color: #ff6600;"></i>
                        </div>
                        <h4 style="color: #fff; font-weight: 700; text-align: center; margin-bottom: 20px;">{{ __('terms.contact_title') }}</h4>
                        <div class="contact-info" style="font-size: 1rem; line-height: 1.8;">
                            <div class="mb-3">
                                <i class="bi bi-telephone-fill text-warning me-2"></i>
                                <strong>{{ __('terms.phone') }}</strong>
                                <a href="tel:+13432458848" style="color: #ff6600; text-decoration: none;">(+1)343-245-8848</a>
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-envelope-fill text-warning me-2"></i>
                                <strong>{{ __('terms.email') }}</strong>
                                <a href="mailto:info@dabsbeautytouch.com" style="color: #ff6600; text-decoration: none;">info@dabsbeautytouch.com</a>
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-clock-fill text-warning me-2"></i>
                                <strong>{{ __('terms.response') }}</strong> {{ __('terms.response_body') }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-chat-dots-fill text-warning me-2"></i>
                                <strong>{{ __('terms.consult') }}</strong> {{ __('terms.consult_body') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-lg border-0" style="border-radius: 20px; background: #fff;">
                    <div class="card-body p-4">
                        <h4 style="color: #030f68; font-weight: 700; text-align: center; margin-bottom: 30px;">
                            <i class="bi bi-file-text me-2" style="color: #ff6600;"></i>
                            {{ __('terms.additional') }}
                        </h4>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled" style="font-size: 1rem; line-height: 1.8;">
                                    <li class="mb-3">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <strong>{{ __('terms.prep') }}</strong> {{ __('terms.prep_body') }}
                                    </li>
                                    <li class="mb-3">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <strong>{{ __('terms.extensions') }}</strong> {{ __('terms.extensions_body') }}
                                    </li>
                                    <li class="mb-3">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <strong>{{ __('terms.duration') }}</strong> {{ __('terms.duration_body') }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled" style="font-size: 1rem; line-height: 1.8;">
                                    <li class="mb-3">
                                        <i class="bi bi-exclamation-circle-fill text-warning me-2"></i>
                                        <strong>{{ __('terms.style_changes') }}</strong> {{ __('terms.style_changes_body') }}
                                    </li>
                                    <li class="mb-3">
                                        <i class="bi bi-calendar-check-fill text-info me-2"></i>
                                        <strong>{{ __('terms.reservation') }}</strong> {{ __('terms.reservation_body') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
