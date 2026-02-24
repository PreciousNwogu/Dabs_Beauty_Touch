<!-- Kids Selector Form Partial -->
<style>
    .kb-selector-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .kb-header {
        text-align: center;
        padding: 40px 20px 30px;
        background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
        border-radius: 16px 16px 0 0;
        color: white;
        margin-bottom: 0;
    }

    .kb-header h1 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 10px;
        color: white;
    }

    .kb-header p {
        font-size: 1.1rem;
        margin-bottom: 0;
        opacity: 0.95;
        color: white;
    }

    .kb-progress {
        display: flex;
        justify-content: space-between;
        padding: 20px;
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        gap: 10px;
        flex-wrap: wrap;
    }

    .kb-progress-step {
        flex: 1;
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.3s ease;
        min-width: 120px;
    }

    .kb-progress-step.active {
        background: #fff3e0;
        border: 2px solid #ff6600;
    }

    .kb-progress-step .step-number {
        display: inline-block;
        width: 32px;
        height: 32px;
        line-height: 32px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .kb-progress-step.active .step-number {
        background: #ff6600;
        color: white;
    }

    .kb-progress-step .step-label {
        display: block;
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 600;
    }

    .kb-progress-step.active .step-label {
        color: #ff6600;
    }

    .kb-content {
        padding: 30px 20px;
        background: white;
    }

    .kb-section {
        margin-bottom: 40px;
    }

    .kb-section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #030f68;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .kb-section-subtitle {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .kb-braid-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .kb-braid-card {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        position: relative;
    }

    .kb-braid-card:hover {
        border-color: #ff6600;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 102, 0, 0.15);
    }

    .kb-braid-card input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .kb-braid-card input[type="radio"]:checked + .kb-braid-content {
        border-left: 4px solid #ff6600;
        padding-left: 12px;
    }

    .kb-braid-card input[type="radio"]:checked ~ .kb-checkmark {
        opacity: 1;
    }

    .kb-braid-card.selected {
        border-color: #ff6600;
        background: #fff8f0;
        box-shadow: 0 4px 12px rgba(255, 102, 0, 0.2);
    }

    .kb-braid-content {
        transition: all 0.3s ease;
    }

    .kb-braid-name {
        font-size: 1.05rem;
        font-weight: 600;
        color: #030f68;
        margin-bottom: 4px;
    }

    .kb-braid-price {
        font-size: 1.3rem;
        font-weight: 800;
        color: #ff6600;
    }

    .kb-checkmark {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 28px;
        height: 28px;
        background: #ff6600;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .kb-option-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .kb-option-btn {
        flex: 1;
        min-width: 140px;
        padding: 14px 20px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .kb-option-btn:hover {
        border-color: #ff6600;
        background: #fff8f0;
    }

    .kb-option-btn input[type="radio"] {
        display: none;
    }

    .kb-option-btn input[type="radio"]:checked + .kb-option-label {
        color: #ff6600;
        font-weight: 700;
    }

    .kb-option-btn.selected {
        border-color: #ff6600;
        background: #fff8f0;
        box-shadow: 0 2px 8px rgba(255, 102, 0, 0.15);
    }

    .kb-option-label {
        font-size: 1rem;
        font-weight: 600;
        color: #030f68;
        transition: all 0.3s ease;
    }

    .kb-option-price {
        display: block;
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 4px;
    }

    .kb-addon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 12px;
    }

    .kb-addon-card {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 14px 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .kb-addon-card:hover {
        border-color: #ff6600;
        background: #fff8f0;
    }

    .kb-addon-card input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        flex-shrink: 0;
    }

    .kb-addon-card.checked {
        border-color: #ff6600;
        background: #fff8f0;
    }

    .kb-addon-label {
        flex: 1;
        font-weight: 600;
        color: #030f68;
    }

    .kb-addon-price {
        font-weight: 700;
        color: #ff6600;
    }

    .kb-price-summary {
        position: sticky;
        top: 20px;
        background: white;
        border: 3px solid #ff6600;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 8px 24px rgba(255, 102, 0, 0.15);
    }

    .kb-price-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #030f68;
        margin-bottom: 16px;
        text-align: center;
    }

    .kb-price-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .kb-price-item:last-of-type {
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 12px;
    }

    .kb-price-total {
        display: flex;
        justify-content: space-between;
        padding: 16px 0;
        font-size: 1.4rem;
        font-weight: 800;
        color: #030f68;
    }

    .kb-price-total-amount {
        color: #ff6600;
        font-size: 1.8rem;
    }

    .kb-action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 20px;
    }

    .kb-btn-continue {
        background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
        color: white;
        border: none;
        padding: 16px 32px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(255, 102, 0, 0.3);
    }

    .kb-btn-continue:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 102, 0, 0.4);
    }

    .kb-btn-cancel {
        color: #6c757d;
        background: white;
        border: 2px solid #e9ecef;
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        text-align: center;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .kb-btn-cancel:hover {
        border-color: #6c757d;
        color: #495057;
    }

    @media (max-width: 768px) {
        .kb-header h1 { font-size: 1.5rem; }
        .kb-progress { padding: 15px 10px; }
        .kb-progress-step { min-width: 80px; padding: 8px; }
        .kb-braid-grid { grid-template-columns: 1fr; }
        .kb-addon-grid { grid-template-columns: 1fr; }
        .kb-price-summary { position: static; margin-top: 30px; }
    }
</style>

<div class="kb-selector-container">
    <div class="card shadow-lg" style="border: none; border-radius: 16px; overflow: hidden;">
        <!-- Header -->
        <div class="kb-header">
            <h1>👧🏾 Kids Braids Selector</h1>
            <p>Professional braiding for ages 3–8 • Customize your child's perfect style</p>
        </div>

        <!-- Progress Indicator -->
        <div class="kb-progress">
            <div class="kb-progress-step active" data-step="1">
                <span class="step-number">1</span>
                <span class="step-label">Braid Type</span>
            </div>
            <div class="kb-progress-step" data-step="2">
                <span class="step-number">2</span>
                <span class="step-label">Finish</span>
            </div>
            <div class="kb-progress-step" data-step="3">
                <span class="step-number">3</span>
                <span class="step-label">Length</span>
            </div>
            <div class="kb-progress-step" data-step="4">
                <span class="step-number">4</span>
                <span class="step-label">Add-Ons</span>
            </div>
        </div>

        <div class="row g-0">
            <!-- Left Column: Form -->
            <div class="col-lg-8 kb-content">
                <form id="kidsSelectorForm" method="POST" action="{{ route('kids.selector.submit') }}">
                    @csrf

                    <!-- Step 1: Braid Type -->
                    <div class="kb-section" data-step="1">
                        <h2 class="kb-section-title">
                            <span style="color: #ff6600;">✨</span> Choose Braid Type
                        </h2>
                        <p class="kb-section-subtitle">Select the perfect style for your child</p>

                        <div class="kb-braid-grid" id="kb-braid-types">
                            <label class="kb-braid-card" for="kb_type_protective">
                                <input type="radio" name="kb_braid_type" id="kb_type_protective" value="protective" checked>
                                <div class="kb-braid-content">
                                    <div class="kb-braid-name">Natural Hair Twist</div>
                                    <div class="kb-braid-price">$60</div>
                                </div>
                                <span class="kb-checkmark">✓</span>
                            </label>

                            <label class="kb-braid-card" for="kb_type_cornrows">
                                <input type="radio" name="kb_braid_type" id="kb_type_cornrows" value="cornrows">
                                <div class="kb-braid-content">
                                    <div class="kb-braid-name">Cornrow (without extension)</div>
                                    <div class="kb-braid-price">$40</div>
                                </div>
                                <span class="kb-checkmark">✓</span>
                            </label>

                            <label class="kb-braid-card" for="kb_type_cornrow_weave">
                                <input type="radio" name="kb_braid_type" id="kb_type_cornrow_weave" value="cornrow_weave">
                                <div class="kb-braid-content">
                                    <div class="kb-braid-name">Cornrow weave (with extension)</div>
                                    <div class="kb-braid-price">From $80</div>
                                </div>
                                <span class="kb-checkmark">✓</span>
                            </label>

                            <label class="kb-braid-card" for="kb_type_knotless_small">
                                <input type="radio" name="kb_braid_type" id="kb_type_knotless_small" value="knotless_small">
                                <div class="kb-braid-content">
                                    <div class="kb-braid-name">Knotless Small</div>
                                    <div class="kb-braid-price">$100</div>
                                </div>
                                <span class="kb-checkmark">✓</span>
                            </label>

                            <label class="kb-braid-card" for="kb_type_knotless_med">
                                <input type="radio" name="kb_braid_type" id="kb_type_knotless_med" value="knotless_med">
                                <div class="kb-braid-content">
                                    <div class="kb-braid-name">Knotless Medium</div>
                                    <div class="kb-braid-price">$80</div>
                                </div>
                                <span class="kb-checkmark">✓</span>
                            </label>

                            <label class="kb-braid-card" for="kb_type_box_small">
                                <input type="radio" name="kb_braid_type" id="kb_type_box_small" value="box_small">
                                <div class="kb-braid-content">
                                    <div class="kb-braid-name">Box Braids Small</div>
                                    <div class="kb-braid-price">$90</div>
                                </div>
                                <span class="kb-checkmark">✓</span>
                            </label>

                            <label class="kb-braid-card" for="kb_type_box_med">
                                <input type="radio" name="kb_braid_type" id="kb_type_box_med" value="box_med">
                                <div class="kb-braid-content">
                                    <div class="kb-braid-name">Box Braids Medium</div>
                                    <div class="kb-braid-price">$80</div>
                                </div>
                                <span class="kb-checkmark">✓</span>
                            </label>

                            <label class="kb-braid-card" for="kb_type_stitch">
                                <input type="radio" name="kb_braid_type" id="kb_type_stitch" value="stitch">
                                <div class="kb-braid-content">
                                    <div class="kb-braid-name">Stitch Braids</div>
                                    <div class="kb-braid-price">$100</div>
                                </div>
                                <span class="kb-checkmark">✓</span>
                            </label>

                            {{-- CMS-managed kids braid types --}}
                            @foreach($cmsKidsServices ?? [] as $cksvc)
                                @php $cksSlug = 'cms_' . $cksvc->id; $cksPrice = (int) $cksvc->effective_price; @endphp
                                <label class="kb-braid-card" for="kb_type_{{ $cksSlug }}">
                                    <input type="radio" name="kb_braid_type" id="kb_type_{{ $cksSlug }}" value="{{ $cksSlug }}">
                                    <div class="kb-braid-content">
                                        <div class="kb-braid-name">{{ $cksvc->name }}</div>
                                        <div class="kb-braid-price">${{ $cksPrice }}</div>
                                    </div>
                                    <span class="kb-checkmark">✓</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Step 2: Finish -->
                    <div class="kb-section" id="kb-finish-section" data-step="2">
                        <h2 class="kb-section-title" id="kb-finish-header">
                            <span style="color: #ff6600;">💫</span> Choose Finish
                        </h2>
                        <p class="kb-section-subtitle">How would you like the ends styled?</p>

                        <div class="kb-option-group" id="kb-finish-block">
                            <label class="kb-option-btn" for="kb_finish_plain">
                                <input type="radio" name="kb_finish" id="kb_finish_plain" value="plain" checked>
                                <div class="kb-option-label">
                                    Without Curl
                                </div>
                            </label>

                            <label class="kb-option-btn" for="kb_finish_curled">
                                <input type="radio" name="kb_finish" id="kb_finish_curled" value="curled">
                                <div class="kb-option-label">
                                    With curled tip
                                    <span class="kb-option-price">-$10</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Step 3: Hair Length -->
                    <div class="kb-section" id="kb-length-section" data-step="3">
                        <h2 class="kb-section-title" id="kb-length-header">
                            <span style="color: #ff6600;">📏</span> Choose Hair Length
                        </h2>
                        <p class="kb-section-subtitle">Select the desired braid length</p>

                        <div class="kb-option-group" id="kb-lengths">
                            <label class="kb-option-btn" for="kb_len_shoulder">
                                <input type="radio" name="kb_length" id="kb_len_shoulder" value="shoulder" checked>
                                <div class="kb-option-label">
                                    Shoulder
                                </div>
                            </label>

                            <label class="kb-option-btn" for="kb_len_armpit">
                                <input type="radio" name="kb_length" id="kb_len_armpit" value="armpit">
                                <div class="kb-option-label">
                                    Armpit
                                    <span class="kb-option-price">+$10</span>
                                </div>
                            </label>

                            <label class="kb-option-btn" for="kb_len_midback">
                                <input type="radio" name="kb_length" id="kb_len_midback" value="mid_back">
                                <div class="kb-option-label">
                                    Mid Back
                                    <span class="kb-option-price">+$20</span>
                                </div>
                            </label>

                            <label class="kb-option-btn" for="kb_len_waist">
                                <input type="radio" name="kb_length" id="kb_len_waist" value="waist">
                                <div class="kb-option-label">
                                    Waist
                                    <span class="kb-option-price">+$30</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Step 4: Add-Ons -->
                    <div class="kb-section" data-step="4">
                        <h2 class="kb-section-title">
                            <span style="color: #ff6600;">🎀</span> Add Extra Services
                        </h2>
                        <p class="kb-section-subtitle">Optional enhancements (select all that apply)</p>

                        <div class="kb-addon-grid" id="kb-addons">
                            <label class="kb-addon-card" for="kb_add_detangle">
                                <input type="checkbox" id="kb_add_detangle" value="15">
                                <span class="kb-addon-label">Detangle / Blowdry</span>
                                <span class="kb-addon-price">+$15</span>
                            </label>

                            <label class="kb-addon-card" for="kb_add_beads">
                                <input type="checkbox" id="kb_add_beads" value="15">
                                <span class="kb-addon-label">Tiny beading</span>
                                <span class="kb-addon-price">+$15</span>
                            </label>

                            <label class="kb-addon-card" for="kb_add_beads_full">
                                <input type="checkbox" id="kb_add_beads_full" value="10">
                                <span class="kb-addon-label">Big eye beading</span>
                                <span class="kb-addon-price">+$10</span>
                            </label>

                            <label class="kb-addon-card" for="kb_add_extension">
                                <input type="checkbox" id="kb_add_extension" value="20">
                                <span class="kb-addon-label">Hair Extension</span>
                                <span class="kb-addon-price">+$20</span>
                            </label>

                            <label class="kb-addon-card" for="kb_add_rest">
                                <input type="checkbox" id="kb_add_rest" value="5">
                                <span class="kb-addon-label">Resting Break</span>
                                <span class="kb-addon-price">+$5</span>
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="price" id="kb_price_input" value="">
                    <input type="hidden" name="kb_extras" id="kb_extras_input" value="">
                    <!-- Hidden mirrors so disabled radios still submit values -->
                    <input type="hidden" name="kb_length" id="kb_length_hidden" value="">
                    <input type="hidden" name="kb_finish" id="kb_finish_hidden" value="">
                </form>
            </div>

            <!-- Right Column: Price Summary -->
            <div class="col-lg-4" style="background: #f8f9fa; padding: 30px 20px;">
                <div class="kb-price-summary">
                    <h3 class="kb-price-title">💰 Price Summary</h3>

                    @php
                        $kidsBaseServer = (int) config('service_prices.kids_braids', 80);
                        $kidsOrigServer = (int) config('service_prices_original.kids_braids', $kidsBaseServer);
                    @endphp

                    <div id="kb_itemized_pricing">
                        <!-- Braid Type Adjustment -->
                        <div class="kb-price-item" id="kb_braid_type_line" style="display: none;">
                            <span id="kb_braid_type_name">• Adjustment</span>
                            <strong id="kb_braid_type_price">$0</strong>
                        </div>

                        <!-- Finish Adjustment -->
                        <div class="kb-price-item" id="kb_finish_line" style="display: none;">
                            <span id="kb_finish_name">• Finish</span>
                            <strong id="kb_finish_price">$0</strong>
                        </div>

                        <!-- Length Adjustment -->
                        <div class="kb-price-item" id="kb_length_line" style="display: none;">
                            <span id="kb_length_name">• Length</span>
                            <strong id="kb_length_price">$0</strong>
                        </div>

                        <!-- Add-ons -->
                        <div id="kb_addons_lines"></div>
                    </div>

                    <!-- Original (strikethrough) — shown by JS only for discounted braid types -->
                    <div id="kb_original_price_row" style="display:none;justify-content:space-between;align-items:center;margin-bottom:6px;padding-bottom:6px;border-bottom:1px solid #e3e3e0;">
                        <span style="font-size:0.85rem;color:#999;">Original price:</span>
                        <span id="kb_original_price_val" style="font-size:0.85rem;color:#999;text-decoration:line-through;">${{ $kidsOrigServer }}</span>
                    </div>

                    <!-- Total -->
                    <div class="kb-price-total">
                        <span>Total <span id="kb_discount_badge" style="background:#ff6600;color:#fff;font-size:0.65rem;font-weight:700;padding:2px 6px;border-radius:4px;margin-left:4px;vertical-align:middle;display:none;">DISCOUNTED</span></span>
                        <span class="kb-price-total-amount" id="kb_total_price">${{ $kidsBaseServer }}</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="kb-action-buttons">
                        <button id="kb_proceed_btn" class="kb-btn-continue" type="submit" form="kidsSelectorForm">
                            <i class="bi bi-arrow-right-circle me-2"></i>Continue to Booking
                        </button>
                        <a href="{{ route('home') }}" class="kb-btn-cancel">
                            <i class="bi bi-x-circle me-1"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Enhanced UI Interaction Script -->
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Handle braid card selections
    document.querySelectorAll('.kb-braid-card').forEach(function(card){
        card.addEventListener('click', function(){
            document.querySelectorAll('.kb-braid-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
        });
    });

    // Handle option button selections
    document.querySelectorAll('.kb-option-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            const input = this.querySelector('input[type="radio"]');
            if(input){
                document.querySelectorAll(`input[name="${input.name}"]`).forEach(function(radio){
                    radio.closest('.kb-option-btn').classList.remove('selected');
                });
                this.classList.add('selected');
            }
        });
    });

    // Handle addon card selections
    document.querySelectorAll('.kb-addon-card').forEach(function(card){
        const checkbox = card.querySelector('input[type="checkbox"]');
        if(checkbox){
            checkbox.addEventListener('change', function(){
                if(this.checked){
                    card.classList.add('checked');
                } else {
                    card.classList.remove('checked');
                }
            });
        }
    });

    // Update progress indicators
    function updateProgress(){
        try{
            const braidType = document.querySelector('input[name="kb_braid_type"]:checked');
            const braidTypeValue = braidType ? braidType.value : '';
            let disabledTypes = ['protective', 'cornrows'];
            @foreach($cmsKidsServices ?? [] as $cksvc)
            disabledTypes.push('cms_{{ $cksvc->id }}');
            @endforeach
            const shouldHideFinishLength = disabledTypes.includes(braidTypeValue);

            // Update step indicators
            const steps = document.querySelectorAll('.kb-progress-step');
            steps.forEach(step => step.classList.remove('active'));

            // Always show step 1 (Braid Type) as active
            const step1 = document.querySelector('.kb-progress-step[data-step="1"]');
            if(step1) step1.classList.add('active');

            // Show/hide steps 2 and 3 based on braid type
            const step2 = document.querySelector('.kb-progress-step[data-step="2"]');
            const step3 = document.querySelector('.kb-progress-step[data-step="3"]');
            if(!shouldHideFinishLength){
                if(step2) step2.classList.add('active');
                if(step3) step3.classList.add('active');
            }

            // Always show step 4 (Add-Ons)
            const step4 = document.querySelector('.kb-progress-step[data-step="4"]');
            if(step4) step4.classList.add('active');

        }catch(e){
            console.warn('updateProgress error:', e);
        }
    }

    // Listen for braid type changes
    document.querySelectorAll('input[name="kb_braid_type"]').forEach(function(radio){
        radio.addEventListener('change', updateProgress);
    });

    // Initial setup
    updateProgress();

    // Set initial selected state for pre-checked options
    document.querySelectorAll('input[type="radio"]:checked').forEach(function(radio){
        const card = radio.closest('.kb-braid-card');
        if(card) card.classList.add('selected');

        const btn = radio.closest('.kb-option-btn');
        if(btn) btn.classList.add('selected');
    });
});
</script>

<!-- Inline helper: hide finish and length when braid types do not require them -->
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Pricing map for explicit prices
    const braidTypePrices = {
        'protective': 60,
        'cornrows': 40,
        'knotless_small': 100,
        'knotless_med': 80,
        'box_small': 90,
        'box_med': 80,
        'stitch': 100
    };

    function setFinishAndLengthDisabled(disabled, braidTypeValue){
        console.log('setFinishAndLengthDisabled called with disabled:', disabled, 'braidType:', braidTypeValue);

        // HIDE/SHOW FINISH SECTION
        const finishSection = document.getElementById('kb-finish-section');
        if(finishSection) {
            finishSection.style.display = disabled ? 'none' : '';
        }

        // Disable/enable finish radio buttons
        document.querySelectorAll('input[name="kb_finish"]').forEach(function(i){
            i.disabled = disabled;
        });

        // Reset to default when hiding
        if(disabled){
            const plain = document.getElementById('kb_finish_plain');
            if(plain) plain.checked = true;
        }

        // HIDE/SHOW LENGTH SECTION
        const lengthSection = document.getElementById('kb-length-section');
        if(lengthSection) {
            lengthSection.style.display = disabled ? 'none' : '';
        }

        // Disable/enable length radio buttons
        document.querySelectorAll('input[name="kb_length"]').forEach(function(i){
            i.disabled = disabled;
        });

        // Reset to default when hiding
        if(disabled){
            const shoulder = document.getElementById('kb_len_shoulder');
            if(shoulder) shoulder.checked = true;
        }

        // RENUMBER STEPS DYNAMICALLY
        renumberSteps(disabled);

        // UPDATE PRICING TO SHOW EXPLICIT PRICE
        updatePricingDisplay(braidTypeValue);
    }

    function renumberSteps(finishLengthHidden){
        try{
            // Get all step numbers
            const steps = document.querySelectorAll('.kb-step-number');
            let currentStep = 1;

            steps.forEach(function(stepEl){
                const originalStep = parseInt(stepEl.getAttribute('data-step'));

                // Skip steps 2 and 3 if they're hidden (finish/length)
                if(finishLengthHidden && (originalStep === 2 || originalStep === 3)){
                    return; // Don't renumber these, they're hidden
                }

                stepEl.textContent = currentStep + ')';
                currentStep++;
            });
        }catch(e){
            console.error('renumberSteps error:', e);
        }
    }

    function updatePricingDisplay(braidTypeValue){
        try{
            const basePrice = {{ (int) config('service_prices.kids_braids', 80) }}; // Kids Braids base price (from CMS/config)
            const kidsOriginalBase = {{ (int) config('service_prices_original.kids_braids', config('service_prices.kids_braids', 80)) }}; // Original before discount
            // Braid types that have the CMS discount applied
            const discountedBraidTypes = ['cornrow_weave', 'knotless_small', 'knotless_med', 'box_small', 'box_med', 'stitch'];

            // Braid type names and adjustments
            const braidTypeNames = {
                'protective': 'Natural hair twist',
                'cornrows': 'Cornrow (without extension)',
                'cornrow_weave': 'Cornrow weave (with extension)',
                'knotless_small': 'Knotless (Small)',
                'knotless_med': 'Knotless (Medium)',
                'box_small': 'Box Braids (Small)',
                'box_med': 'Box Braids (Medium)',
                'stitch': 'Stitch Braids'
            };

            const braidTypeAdjustments = {
                'protective': -20,
                'cornrows': -40,
                'knotless_small': 20,
                'knotless_med': 0,
                'box_small': 10,
                'box_med': 0,
                'stitch': 20,
                'cornrow_weave': 0
            };

            @php $kidsOriginalConfigBase = (int) config('service_prices_original.kids_braids', config('service_prices.kids_braids', 80)); @endphp
            const cmsKidsFixedPrices = {};
            @foreach($cmsKidsServices ?? [] as $cksvc)
                @php $cksSlug = 'cms_' . $cksvc->id; @endphp
                braidTypeNames['{{ $cksSlug }}'] = '{{ addslashes($cksvc->name) }}';
                braidTypeAdjustments['{{ $cksSlug }}'] = {{ (int) $cksvc->effective_price - $kidsOriginalConfigBase }};
                cmsKidsFixedPrices['{{ $cksSlug }}'] = {{ (int) $cksvc->effective_price }};
            @endforeach

            const braidTypeName = braidTypeNames[braidTypeValue] || 'Unknown';
            const braidTypeAdj = braidTypeAdjustments[braidTypeValue] !== undefined ? braidTypeAdjustments[braidTypeValue] : 0;

            // protective and cornrows always use the original (non-discounted) base — their prices are fixed
            let fixedPriceTypes = ['protective', 'cornrows'];
            @foreach($cmsKidsServices ?? [] as $cksvc)
            fixedPriceTypes.push('cms_{{ $cksvc->id }}');
            @endforeach
            const effectiveBase = fixedPriceTypes.indexOf(braidTypeValue) !== -1 ? kidsOriginalBase : basePrice;

            // Show/hide and populate braid type line
            const braidTypeLine = document.getElementById('kb_braid_type_line');
            const braidTypeNameEl = document.getElementById('kb_braid_type_name');
            const braidTypePriceEl = document.getElementById('kb_braid_type_price');

            if(braidTypeAdj !== 0) {
                if(braidTypeLine) braidTypeLine.style.display = '';
                if(braidTypeNameEl) braidTypeNameEl.textContent = braidTypeName;
                if(braidTypePriceEl) braidTypePriceEl.textContent = (braidTypeAdj >= 0 ? '+' : '') + '$' + Math.abs(braidTypeAdj);
            } else {
                if(braidTypeLine) braidTypeLine.style.display = 'none';
            }

            // For protective/cornrows, hide finish and length
            let disabledTypes = ['protective', 'cornrows'];
            @foreach($cmsKidsServices ?? [] as $cksvc)
            disabledTypes.push('cms_{{ $cksvc->id }}');
            @endforeach
            const shouldDisable = disabledTypes.indexOf(braidTypeValue) !== -1;

            // Finish adjustment
            let finishAdj = 0;
            const finishLine = document.getElementById('kb_finish_line');
            const finishNameEl = document.getElementById('kb_finish_name');
            const finishPriceEl = document.getElementById('kb_finish_price');

            if(!shouldDisable) {
                const finishEl = document.querySelector('input[name="kb_finish"]:checked');
                const finishVal = finishEl ? finishEl.value : 'plain';
                finishAdj = (finishVal === 'curled') ? -10 : 0;

                if(finishAdj !== 0) {
                    if(finishLine) finishLine.style.display = '';
                    if(finishNameEl) finishNameEl.textContent = 'With curled tip';
                    if(finishPriceEl) finishPriceEl.textContent = '-$10';
                } else {
                    if(finishLine) finishLine.style.display = 'none';
                }
            } else {
                if(finishLine) finishLine.style.display = 'none';
            }

            // Length adjustment
            let lengthAdj = 0;
            const lengthLine = document.getElementById('kb_length_line');
            const lengthNameEl = document.getElementById('kb_length_name');
            const lengthPriceEl = document.getElementById('kb_length_price');

            if(!shouldDisable) {
                const lengthEl = document.querySelector('input[name="kb_length"]:checked');
                const lengthVal = lengthEl ? lengthEl.value : 'shoulder';
                const lengthNames = { 'shoulder': 'Shoulder length', 'armpit': 'Armpit length', 'mid_back': 'Mid back length', 'waist': 'Waist length' };
                const lengthAdjMap = { 'shoulder': 0, 'armpit': 10, 'mid_back': 20, 'waist': 30 };
                lengthAdj = lengthAdjMap[lengthVal] || 0;

                if(lengthAdj !== 0) {
                    if(lengthLine) lengthLine.style.display = '';
                    if(lengthNameEl) lengthNameEl.textContent = lengthNames[lengthVal] || lengthVal;
                    if(lengthPriceEl) lengthPriceEl.textContent = '+$' + lengthAdj;
                } else {
                    if(lengthLine) lengthLine.style.display = 'none';
                }
            } else {
                if(lengthLine) lengthLine.style.display = 'none';
            }

            // Add-ons - show each one individually
            const addonsContainer = document.getElementById('kb_addons_lines');
            const addonNames = {
                'kb_add_detangle': 'Detangle / Blowdry',
                'kb_add_beads': 'Tiny beading',
                'kb_add_beads_full': 'Big eye beading',
                'kb_add_extension': 'Hair Extension',
                'kb_add_rest': 'Resting Break'
            };

            let addonsHTML = '';
            let addonsTotal = 0;
            document.querySelectorAll('#kb-addons input[type="checkbox"]:checked').forEach(function(cb){
                const addonValue = Number(cb.value) || 0;
                const addonName = addonNames[cb.id] || cb.id;
                addonsTotal += addonValue;
                addonsHTML += '<div>• ' + addonName + ': <strong>+$' + addonValue + '</strong></div>';
            });

            if(addonsContainer) addonsContainer.innerHTML = addonsHTML;

            // Calculate total — CMS kids services use their exact DB price, not base+adj
            const isCmsType = braidTypeValue.startsWith('cms_');
            const totalPrice = (isCmsType && cmsKidsFixedPrices[braidTypeValue] !== undefined)
                ? cmsKidsFixedPrices[braidTypeValue] + addonsTotal
                : effectiveBase + braidTypeAdj + finishAdj + lengthAdj + addonsTotal;

            // Update total display
            const totalPriceEl = document.getElementById('kb_total_price');
            if(totalPriceEl) totalPriceEl.textContent = '$' + totalPrice;

            // Discount display: show only for selected discounted braid types
            const showDiscount = kidsOriginalBase > basePrice && discountedBraidTypes.indexOf(braidTypeValue) !== -1;
            const origRow = document.getElementById('kb_original_price_row');
            const discBadge = document.getElementById('kb_discount_badge');
            const origVal = document.getElementById('kb_original_price_val');
            if(origRow)  { origRow.style.display  = showDiscount ? 'flex' : 'none'; }
            if(discBadge){ discBadge.style.display = showDiscount ? 'inline' : 'none'; }
            if(origVal && showDiscount){ origVal.textContent = '$' + kidsOriginalBase; }
            if(totalPriceEl){ totalPriceEl.style.color = showDiscount ? '#ff6600' : ''; }

            // Update hidden price input
            const priceInput = document.getElementById('kb_price_input');
            if(priceInput) priceInput.value = totalPrice;

            // Backwards compatibility for old elements
            const kbBaseEl = document.getElementById('kb_base_price');
            const kbAdjustEl = document.getElementById('kb_adjustments');
            const kbTotalEl2 = document.getElementById('kb_total_price');
            if(kbBaseEl) kbBaseEl.textContent = '$' + effectiveBase;
            if(kbAdjustEl) kbAdjustEl.textContent = (braidTypeAdj + finishAdj + lengthAdj + addonsTotal >= 0 ? '+' : '') + '$' + Math.abs(braidTypeAdj + finishAdj + lengthAdj + addonsTotal);

        }catch(e){
            console.error('updatePricingDisplay error:', e);
        }
    }

    function evaluateBraidType(){
        try{
            const cur = document.querySelector('input[name="kb_braid_type"]:checked');
            const val = cur ? cur.value : 'protective';
            console.log('evaluateBraidType called, selected value:', val);
            // Hide finish & length for specific braid types
            let disabledTypes = ['protective', 'cornrows'];
            @foreach($cmsKidsServices ?? [] as $cksvc)
            disabledTypes.push('cms_{{ $cksvc->id }}');
            @endforeach
            const shouldDisable = disabledTypes.indexOf(val) !== -1;
            console.log('shouldDisable:', shouldDisable);
            setFinishAndLengthDisabled(shouldDisable, val);

            // Ensure hidden mirror fields reflect any default selections immediately
            try{ if(typeof syncHiddenMirrors === 'function') syncHiddenMirrors(); }catch(e){}
        }catch(e){
            console.error('evaluateBraidType error:', e);
        }
    }

    // Evaluate on page load to set initial state
    try{
        // Small delay to ensure DOM is fully ready
        setTimeout(function(){ evaluateBraidType(); }, 100);
    }catch(e){
        console.error('Failed to evaluate braid type on load:', e);
    }

    // attach listeners to braid type radios (listen for both change and click for instant response)
    const braidRadios = document.querySelectorAll('input[name="kb_braid_type"]');
    console.log('Found braid radios:', braidRadios.length);
    braidRadios.forEach(function(r){
        r.addEventListener('change', function(e){
            console.log('Braid type changed to:', e.target.value);
            evaluateBraidType();
        });
        r.addEventListener('click', function(e){
            console.log('Braid type clicked:', e.target.value);
            // Small delay to ensure radio is checked before evaluation
            setTimeout(function(){ evaluateBraidType(); }, 10);
        });
    });
    // also attach a container click handler as a fallback
    const braidContainer = document.getElementById('kb-braid-types');
    if(braidContainer) {
        braidContainer.addEventListener('click', function(e){
            try{
                // Wait a bit for the radio to be checked
                setTimeout(function(){ evaluateBraidType(); }, 50);
            }catch(e){
                console.error('Container click handler error:', e);
            }
        });
    }

    // keep hidden mirrors in sync so server receives values even when radios are disabled
    function syncHiddenMirrors(){
        try{
            const selLen = document.querySelector('input[name="kb_length"]:checked');
            const selFin = document.querySelector('input[name="kb_finish"]:checked');
            const lenHidden = document.getElementById('kb_length_hidden');
            const finHidden = document.getElementById('kb_finish_hidden');
            if(lenHidden) lenHidden.value = selLen ? selLen.value : (document.getElementById('kb_len_shoulder') ? document.getElementById('kb_len_shoulder').value : 'shoulder');
            if(finHidden) finHidden.value = selFin ? selFin.value : (document.getElementById('kb_finish_plain') ? document.getElementById('kb_finish_plain').value : 'plain');
        }catch(e){ console.warn('syncHiddenMirrors error', e); }
    }

    // attach listeners to finish/length to keep hidden mirrors updated
    document.querySelectorAll('input[name="kb_length"]').forEach(function(r){ r.addEventListener('change', syncHiddenMirrors); });
    document.querySelectorAll('input[name="kb_finish"]').forEach(function(r){ r.addEventListener('change', syncHiddenMirrors); });

    // ensure mirrors are synced before form submit
    const form = document.getElementById('kidsSelectorForm');
    if(form){
        form.addEventListener('submit', function(e){
            // Always sync mirrors
            syncHiddenMirrors();

            // If the selector is embedded inside the kids booking modal, intercept submit
            // and open the kids booking modal with the selector payload instead of posting.
            if(document.getElementById('kidsBookingModal')){
                e.preventDefault();

                try{
                    const sel = {};
                    sel.kb_braid_type = document.querySelector('input[name="kb_braid_type"]:checked') ? document.querySelector('input[name="kb_braid_type"]:checked').value : '';
                    sel.kb_finish = document.querySelector('input[name="kb_finish"]:checked') ? document.querySelector('input[name="kb_finish"]:checked').value : '';
                    sel.kb_length = document.querySelector('input[name="kb_length"]:checked') ? document.querySelector('input[name="kb_length"]:checked').value : '';

                    // collect add-ons values (sum when numeric), also keep list
                    const addons = [];
                    let addonsSum = 0;
                    document.querySelectorAll('#kb-addons input[type="checkbox"]:checked').forEach(function(cb){
                        addons.push(cb.id || cb.value || cb.name);
                        const n = Number(cb.value);
                        if(!isNaN(n)) addonsSum += n;
                    });
                    sel.extras = addons.length ? addons.join(',') : '';
                    // price: try use kb_price_input if present, else leave blank
                    const kbPrice = document.getElementById('kb_price_input');
                    sel.price = kbPrice ? (Number(kbPrice.value) || addonsSum) : addonsSum;

                    // expose globally for the kids modal opener
                    try{ window.__kidsSelectorData = sel; }catch(e){ /* noop */ }

                    // If a function to show the booking panel inside the modal exists, use it.
                    if(typeof window.showKidsBookingPanel === 'function'){
                        try{ window.showKidsBookingPanel(sel); }catch(e){ console.warn('showKidsBookingPanel failed', e); }
                    } else if(typeof openKidsBookingModal === 'function'){
                        // fallback to existing opener which will populate preview and open modal
                        openKidsBookingModal('Kids Braids','kids-braids');
                    }
                }catch(err){
                    console.warn('Failed to open kids modal from selector submit', err);
                }
            }
        });
    }

    // Attach listeners to finish/length/addons for real-time price updates
    document.querySelectorAll('input[name="kb_finish"]').forEach(function(r){
        r.addEventListener('change', function(){
            const braidType = document.querySelector('input[name="kb_braid_type"]:checked');
            const val = braidType ? braidType.value : 'protective';
            updatePricingDisplay(val);
        });
    });

    document.querySelectorAll('input[name="kb_length"]').forEach(function(r){
        r.addEventListener('change', function(){
            const braidType = document.querySelector('input[name="kb_braid_type"]:checked');
            const val = braidType ? braidType.value : 'protective';
            updatePricingDisplay(val);
        });
    });

    document.querySelectorAll('#kb-addons input[type="checkbox"]').forEach(function(cb){
        cb.addEventListener('change', function(){
            const braidType = document.querySelector('input[name="kb_braid_type"]:checked');
            const val = braidType ? braidType.value : 'protective';
            updatePricingDisplay(val);
        });
    });

    // run initial evaluation
    evaluateBraidType();

    // Ensure hidden kb_price_input is seeded with server base if not provided (keeps production/client in sync)
    try{
        const kbPriceInput = document.getElementById('kb_price_input');
        const kbBaseEl = document.getElementById('kb_base_price');
        if(kbPriceInput && kbBaseEl){
            const m = (kbBaseEl.textContent||kbBaseEl.innerText||'').match(/\$?\s*([0-9,\.]+)/);
            if(m && (!kbPriceInput.value || Number(kbPriceInput.value) === 0)){
                kbPriceInput.value = Number(m[1].replace(/,/g,''));
            }
        }
    }catch(e){}

    // If user came from kids modal Back button, restore selector state from localStorage
    try{
        const stored = localStorage.getItem('kb_selector');
        if(stored){
            const parsed = JSON.parse(stored);
            if(parsed){
                // restore braid type
                if(parsed.kb_braid_type){
                    const rb = document.querySelector('input[name="kb_braid_type"][value="'+parsed.kb_braid_type+'"]'); if(rb) rb.checked = true;
                }
                // restore finish
                if(parsed.kb_finish){
                    const rf = document.querySelector('input[name="kb_finish"][value="'+parsed.kb_finish+'"]'); if(rf) rf.checked = true;
                }
                // restore length
                if(parsed.kb_length){
                    const rl = document.querySelector('input[name="kb_length"][value="'+parsed.kb_length+'"]'); if(rl) rl.checked = true;
                }
                // restore addons (comma list of ids)
                if(parsed.kb_extras){
                    const parts = (parsed.kb_extras||'').toString().split(',').map(s=>s.trim()).filter(Boolean);
                    parts.forEach(function(it){ try{ const cb = document.getElementById(it); if(cb && cb.type==='checkbox') cb.checked = true; }catch(e){} });
                }
                // restore price input if present
                try{ const kp = document.getElementById('kb_price_input'); if(kp && parsed.price) kp.value = parsed.price; }catch(e){}

                // update mirrors and price summary
                try{ syncHiddenMirrors(); }catch(e){}
                // ensure global service info reflects kids flow so recomputeGlobal uses kids exceptions
                try{ window.currentServiceInfo = window.currentServiceInfo || {}; window.currentServiceInfo.serviceType = 'kids-braids'; if(parsed.price) window.currentServiceInfo.basePrice = Number(parsed.price); }catch(e){}
                try{ if(typeof recomputeGlobal === 'function') recomputeGlobal(); }catch(e){}
                try{ if(typeof compute === 'function') compute(); }catch(e){}

                // Ensure finish/length hide/show state matches restored braid type
                // This must be called after all selections are restored
                try{
                    if(typeof evaluateBraidType === 'function') {
                        // Small delay to ensure DOM is ready
                        setTimeout(function(){ evaluateBraidType(); }, 50);
                    }
                }catch(e){}

                // keep a global snapshot so other code can pick it up
                try{ window.__kidsSelectorData = { kb_braid_type: parsed.kb_braid_type, kb_finish: parsed.kb_finish, kb_length: parsed.kb_length, extras: parsed.kb_extras, price: parsed.price }; }catch(e){}

                // clear stored value after restore so it doesn't stale next time
                try{ localStorage.removeItem('kb_selector'); }catch(e){}
            }
        }
    }catch(e){ console.warn('Failed to restore kb_selector from localStorage', e); }
});

// Fallback: ensure `showKidsBookingPanel` exists so Continue opens the kids booking modal
// This does not touch calendar state and only attempts to populate/show the kids modal
if(typeof window.showKidsBookingPanel !== 'function'){
    window.showKidsBookingPanel = function(sel){
        try{
            if(sel) try{ window.__kidsSelectorData = sel; }catch(e){}

            // keep selector hidden mirrors in sync if present
            try{ if(typeof syncHiddenMirrors === 'function') syncHiddenMirrors(); }catch(e){}

            // write back to local selector hidden inputs if available
            try{
                const kbPriceInput = document.getElementById('kb_price_input'); if(kbPriceInput && sel && sel.price) kbPriceInput.value = sel.price;
                const kbExtrasInput = document.getElementById('kb_extras_input'); if(kbExtrasInput && sel && sel.extras) kbExtrasInput.value = sel.extras;
            }catch(e){ /* noop */ }

            const kidsModal = document.getElementById('kidsBookingModal');
            if(!kidsModal) return; // nothing to do if modal markup not present on page

            // Populate modal fields (best-effort) but do NOT call any calendar functions
            try{
                const svc = document.getElementById('kids_service_input'); if(svc) svc.value = 'Kids Braids';
                const st = document.getElementById('kids_service_type_input'); if(st) st.value = 'kids-braids';

                const bt = sel && (sel.kb_braid_type || sel.braid_type) ? (sel.kb_braid_type || sel.braid_type) : '';
                const fin = sel && (sel.kb_finish || sel.finish) ? (sel.kb_finish || sel.finish) : '';
                const ln = sel && (sel.kb_length || sel.length) ? (sel.kb_length || sel.length) : '';

                const ibt = document.getElementById('kids_braid_type_input'); if(ibt) ibt.value = bt;
                const ifin = document.getElementById('kids_finish_input'); if(ifin) ifin.value = fin;
                const iln = document.getElementById('kids_length_input'); if(iln) iln.value = ln;
                const iex = document.getElementById('kids_extras_input'); if(iex) iex.value = sel && sel.extras ? sel.extras : '';

                // Try to populate visible preview pieces in the modal if present
                const kb_total = document.getElementById('kidsModal_total');
                const kb_base = document.getElementById('kidsModal_base');
                const kb_adjust = document.getElementById('kidsModal_adjustments');

                // First, try to copy visible selector summary into modal (keeps selector/modal in sync)
                var copiedFromSelector = false;
                try{
                    var selBaseEl = document.getElementById('kb_base_price');
                    var selAdjustEl = document.getElementById('kb_adjustments');
                    var selTotalEl = document.getElementById('kb_total_price');
                    var kb_base = document.getElementById('kidsModal_base');
                    var kb_adjust = document.getElementById('kidsModal_adjustments');
                    var kb_total = document.getElementById('kidsModal_total');
                    if(selBaseEl && selAdjustEl && selTotalEl && kb_base && kb_adjust && kb_total){
                        // copy inner contents (selector displays simple values)
                        kb_base.innerHTML = 'Base: <strong>' + (selBaseEl.textContent || selBaseEl.innerText || selBaseEl.innerHTML).replace(/^\$/,'') + '</strong>';
                        // selector's adjustments may be plain text like "$75" or include sign; normalize
                        kb_adjust.innerHTML = 'Adjustments: <strong>' + (selAdjustEl.textContent || selAdjustEl.innerText || selAdjustEl.innerHTML) + '</strong>';
                        kb_total.innerHTML = '<strong>Total: ' + (selTotalEl.textContent || selTotalEl.innerText || selTotalEl.innerHTML) + '</strong>';
                        // also write hidden price fields from selector total if possible
                        var priceMatch = (selTotalEl.textContent||selTotalEl.innerText||'').match(/\$\s*([0-9,\.]+)/);
                        if(priceMatch){
                            var p = Number(priceMatch[1].replace(/,/g,''));
                            try{ var kidsPriceInput = document.getElementById('kids_price_input'); if(kidsPriceInput) kidsPriceInput.value = p; }catch(e){}
                            try{ var kidsFinalInput = document.getElementById('kids_final_price_input'); if(kidsFinalInput) kidsFinalInput.value = Number(p).toFixed(2); }catch(e){}
                        }
                        copiedFromSelector = true;
                    }
                }catch(e){ /* ignore copy failure and fall back to computing breakdown */ }

                // Compute breakdown: base, braid-type adj, length adj, finish adj, extras
                try{
                    const priceMapLocal = window.priceMap || {
                        'kids-braids': 80
                    };
                    const base = Number(priceMapLocal['kids-braids'] || 80);
                    // braid type adjustments
                    const typeAdjMap = { 'protective': -20, 'cornrows': -40, 'knotless_small': 20, 'knotless_med': 0, 'box_small': 10, 'box_med': 0, 'stitch': 20 };
                    const lengthAdjMap = { 'shoulder': 0, 'armpit': 10, 'mid_back': 20, 'waist': 30 };
                    const finishAdjMap = { 'curled': -10, 'plain': 0 };

                    const bt = (sel.kb_braid_type || sel.braid_type || '').toString();
                    const ln = (sel.kb_length || sel.length || '').toString();
                    const fi = (sel.kb_finish || sel.finish || '').toString();
                    // Determine extras from selector payload, modal hidden input, or checked addon boxes
                    var exRaw = '';
                    try{
                        if(sel && sel.extras) exRaw = sel.extras;
                        if(!exRaw){
                            var kbExtrasEl = document.getElementById('kids_extras_input') || document.getElementById('kb_extras_input');
                            if(kbExtrasEl && kbExtrasEl.value) exRaw = kbExtrasEl.value;
                        }
                        // As a last resort, build extras from checked addon checkboxes in selector area
                        if(!exRaw){
                            var parts = [];
                            var addonChk = document.querySelectorAll('#kb-addons input[type="checkbox"]');
                            if(addonChk && addonChk.length){
                                addonChk.forEach(function(cb){ if(cb.checked){ parts.push(cb.id || cb.value); } });
                                if(parts.length) exRaw = parts.join(',');
                            }
                        }
                    }catch(e){ exRaw = (sel && sel.extras) ? sel.extras : ''; }

                    const typeAdj = (bt && typeAdjMap[bt]) ? Number(typeAdjMap[bt]) : 0;
                    const lengthAdj = (ln && lengthAdjMap[ln]) ? Number(lengthAdjMap[ln]) : 0;
                    const finishAdj = (fi && finishAdjMap[fi]) ? Number(finishAdjMap[fi]) : 0;

                    // parse extras: either CSV of numeric values or known addon ids
                    let extrasSum = 0;
                    if(exRaw){
                        try{
                            if(typeof exRaw === 'string' && exRaw.match(/^\d+(?:\.\d+)?(?:,\d+(?:\.\d+)?)*$/)){
                                extrasSum = exRaw.split(',').map(x=>Number(x)||0).reduce((a,b)=>a+b,0);
                            } else {
                                const addonMap = {'kb_add_detangle':15,'kb_add_beads':10,'kb_add_beads_full':15,'kb_add_extension':20,'kb_add_rest':5};
                                exRaw.toString().split(',').forEach(function(it){ it = it.trim(); if(addonMap[it]) extrasSum += addonMap[it]; });
                            }
                        }catch(e){ extrasSum = 0; }
                    }

                    const adjustmentsTotal = Number(typeAdj || 0) + Number(lengthAdj || 0) + Number(finishAdj || 0) + Number(extrasSum || 0);
                    const computedTotal = Number(base) + Number(adjustmentsTotal);

                    // Format with 2 decimal places to match email format
                    if(kb_base) kb_base.innerHTML = 'Base: <strong>$' + Number(base).toFixed(2) + '</strong>';
                    if(kb_adjust) kb_adjust.innerHTML = 'Adjustments: <strong>' + (adjustmentsTotal >= 0 ? '+' : '-') + '$' + Math.abs(Number(adjustmentsTotal)).toFixed(2) + '</strong>';
                    if(kb_total) kb_total.innerHTML = '<strong>Total: $' + Number(computedTotal).toFixed(2) + '</strong>';
                }catch(e){
                    // fallback to previous behavior
                    if(kb_total){
                        const total = sel && sel.price ? Number(sel.price).toFixed(0) : (document.getElementById('kb_total_price') ? document.getElementById('kb_total_price').textContent.replace('$','') : '');
                        kb_total.innerHTML = '<strong>Total: $' + (total || '--') + '</strong>';
                    }
                }
            }catch(e){ console.warn('populate kids modal fallback failed', e); }

            // Show modal (Bootstrap if available; fallback otherwise). Don't touch calendar.
                // Before showing modal, request server-side canonical breakdown so modal matches emails
                try{
                    var previewPayload = {
                        service: 'Kids Braids',
                        service_type: 'kids-braids',
                        kb_length: (iln && iln.value) ? iln.value : (ln||''),
                        kb_extras: (iex && iex.value) ? iex.value : (sel && sel.extras ? sel.extras : ''),
                        kb_braid_type: bt || ''
                    };
                    var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
                    fetch('/api/price/preview', {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(previewPayload)
                    }).then(function(res){ return res.json(); }).then(function(json){
                        if(json && json.success && json.breakdown){
                            var b = json.breakdown;
                            // Calculate adjustments total (length adjustments + addons) to match email format
                            var adjustmentsTotal = (Number(b.kb_length_adjustment||0) + Number(b.kb_extras_total||0));
                            try{ if(kb_base) kb_base.innerHTML = 'Base: <strong>$' + (Number(b.kb_base_price || b.base_price || 0)).toFixed(2) + '</strong>'; }catch(e){}
                            try{ if(kb_adjust) kb_adjust.innerHTML = 'Adjustments: <strong>' + (adjustmentsTotal >= 0 ? '+' : '-') + '$' + Math.abs(adjustmentsTotal).toFixed(2) + '</strong>'; }catch(e){}
                            try{ if(kb_total) kb_total.innerHTML = '<strong>Total: $' + (Number(b.kb_final_price || b.final_price || 0)).toFixed(2) + '</strong>'; }catch(e){}
                            // write hidden inputs
                            try{ var kidsPriceInput = document.getElementById('kids_price_input'); if(kidsPriceInput) kidsPriceInput.value = Number(b.kb_final_price || b.final_price || 0).toFixed(2); }catch(e){}
                            try{ var kidsFinalInput = document.getElementById('kids_final_price_input'); if(kidsFinalInput) kidsFinalInput.value = Number(b.kb_final_price || b.final_price || 0).toFixed(2); }catch(e){}
                        }
                    }).catch(function(err){ console.warn('Price preview fetch failed', err); }).finally(function(){
                        try{
                            if(typeof bootstrap !== 'undefined' && bootstrap.Modal){
                                const m = new bootstrap.Modal(kidsModal);
                                m.show();
                            } else {
                                kidsModal.style.display = 'block';
                                kidsModal.classList.add('show');
                                document.body.classList.add('modal-open');
                            }
                        }catch(e){ console.warn('showing kids modal failed', e); }
                    });
                }catch(e){
                    console.warn('server preview attempt failed', e);
                    try{
                        if(typeof bootstrap !== 'undefined' && bootstrap.Modal){
                            const m = new bootstrap.Modal(kidsModal);
                            m.show();
                        } else {
                            kidsModal.style.display = 'block';
                            kidsModal.classList.add('show');
                            document.body.classList.add('modal-open');
                        }
                    }catch(e){ console.warn('showing kids modal failed', e); }
                }
            }catch(e){ console.warn('fallback showKidsBookingPanel error', e); }
        }catch(e){ console.warn('fallback showKidsBookingPanel error', e); }
    };
}

</script>

<!-- Recompute booking price globally when length or addons change (applies to main booking modal too) -->
<script>
document.addEventListener('DOMContentLoaded', function(){
    function getSelectedLengthGlobal(){
        const byName = document.querySelector('input[name="hair_length"]:checked') || document.querySelector('input[name="length"]:checked');
        if(byName) return byName.value;
        const alt = document.querySelector('input[name="kb_length"]:checked');
        if(alt) return alt.value;
        const any = Array.from(document.querySelectorAll('input[id^="length_"]')).find(i => i.checked);
        return any ? any.value : null;
    }

    function getBaseGlobal(){
        if(window.currentServiceInfo && window.currentServiceInfo.basePrice != null) return Number(window.currentServiceInfo.basePrice);
        const hidden = document.getElementById('selectedPrice'); if(hidden && hidden.value) return Number(hidden.value);
        const kbPrice = document.getElementById('kb_price_input'); if(kbPrice && kbPrice.value) return Number(kbPrice.value);
        // Fallback: parse visible priceDisplay element if present
        const disp = document.getElementById('priceDisplay'); if(disp){ const m = (disp.textContent||'').match(/\$\s*([0-9,.]+)/); if(m) return Number(m[1].replace(/,/g,'')); }
        // Additional fallback: parse selector's base price element (kb_base_price) or kb_base
        const kbBaseEl = document.getElementById('kb_base_price') || document.getElementById('kb_base');
        if(kbBaseEl){ const mm = (kbBaseEl.textContent||kbBaseEl.innerText||'').match(/\$?\s*([0-9,.]+)/); if(mm) return Number(mm[1].replace(/,/g,'')); }
        return null;
    }

    function computeAdjGlobal(length, serviceType){
        let lt = (length||'').toString().toLowerCase().trim();
        lt = lt.replace(/[-\s]+/g, '_');
        if (lt === 'midback') lt = 'mid_back';
        if (lt === 'brastrap') lt = 'bra_strap';
        const exceptions = ['jumbo-knotless','kids-braids'];
        if((lt==='neck' || lt==='shoulder') && (!serviceType || exceptions.indexOf(serviceType)===-1)) return -40;
        if(lt==='armpit') return 10;
        if(lt==='mid_back' || lt==='mid-back' || lt==='mid') return 0;
        if(lt==='waist') return 30;
        if(lt==='tailbone') return 40;
        return 0;
    }

    function sumAddonsGlobal(){
        let s=0; Array.from(document.querySelectorAll('input[type="checkbox"]')).forEach(cb=>{ if(cb.checked && !isNaN(Number(cb.value))) s+=Number(cb.value); }); return s;
    }

    function recomputeGlobal(){
        try{
            const base = getBaseGlobal(); if(base===null) return;
            const len = getSelectedLengthGlobal();
            const st = (window.currentServiceInfo && window.currentServiceInfo.serviceType) ? window.currentServiceInfo.serviceType : (document.getElementById('selectedServiceType')?document.getElementById('selectedServiceType').value:null);
            const adj = computeAdjGlobal(len, st);
            const addons = sumAddonsGlobal();
            const final = Math.max(0, Number(base)+Number(adj)+Number(addons));
            const disp = document.getElementById('priceDisplay'); if(disp) disp.textContent = '$'+Number(final).toFixed(0);
            const sel = document.getElementById('selectedPrice'); if(sel) sel.value = Number(final).toFixed(2);
            const finalInput = (document.querySelector('input[name="final_price"]') || (function(){ const f=document.getElementById('bookingForm')||document.querySelector('form'); if(!f) return null; const i=document.createElement('input'); i.type='hidden'; i.name='final_price'; f.appendChild(i); return i; })());
            if(finalInput) finalInput.value = Number(final).toFixed(2);
            // Also update explicit inputs by id if present so non-dynamic forms get the value
            const finalById = document.getElementById('final_price_input'); if(finalById) finalById.value = Number(final).toFixed(2);
            const kidsFinalById = document.getElementById('kids_final_price_input'); if(kidsFinalById) kidsFinalById.value = Number(final).toFixed(2);
            const kbTotal = document.getElementById('kb_total_price'); if(kbTotal) kbTotal.textContent = '$'+Number(final).toFixed(0);

            // Mirror addon selections into hidden kb_extras_input (send ids) and update kb_price_input so server receives canonical final
            try{
                var kbExtrasMirror = document.getElementById('kb_extras_input');
                if(kbExtrasMirror){
                    var parts = [];
                    document.querySelectorAll('#kb-addons input[type="checkbox"]').forEach(function(cb){ if(cb.checked) parts.push(cb.id || cb.value || ''); });
                    kbExtrasMirror.value = parts.filter(Boolean).join(',');
                }
            }catch(e){ console.warn('kb_extras mirror failed', e); }

            try{
                var kbPriceHidden = document.getElementById('kb_price_input');
                if(kbPriceHidden) kbPriceHidden.value = Number(final).toFixed(2);
            }catch(e){ /* noop */ }
        }catch(e){ console.warn('recomputeGlobal error', e); }
    }

    // attach
    Array.from(document.querySelectorAll('input[name="hair_length"], input[name="length"], input[id^="length_"], input[name="kb_length"]')).forEach(i=>i.addEventListener('change', recomputeGlobal));
    Array.from(document.querySelectorAll('#kb-addons input[type="checkbox"], .price-box input[type="checkbox"], input[type="checkbox"][id^="kb_add_"]')).forEach(c=>c.addEventListener('change', recomputeGlobal));

    // integrate with existing updatePriceDisplay if present
    if(typeof window.updatePriceDisplay === 'function'){
        const prev = window.updatePriceDisplay;
        window.updatePriceDisplay = function(base){ try{ prev(base); }catch(e){} recomputeGlobal(); };
    } else window.updatePriceDisplay = recomputeGlobal;

    // initial run
    setTimeout(recomputeGlobal, 200);
});
</script>

<script>
// Ensure kids booking form hidden selector fields are populated before submit
document.addEventListener('DOMContentLoaded', function(){
    try{
        const kidsForm = document.getElementById('kidsBookingForm');
        if(!kidsForm) return;

        function populateKidsHiddenFields(){
            // Prefer global selector payload if present (set by selector submit)
            const sel = window.__kidsSelectorData || {};

            // Fallback to selector hidden mirrors on the page
            const mirrorLen = document.getElementById('kb_length_hidden');
            const mirrorFin = document.getElementById('kb_finish_hidden');
            const extrasMirror = document.getElementById('kb_extras_input');
            const priceMirror = document.getElementById('kb_price_input');

            const btInput = document.getElementById('kids_braid_type_input');
            const finInput = document.getElementById('kids_finish_input');
            const lenInput = document.getElementById('kids_length_input');
            const exInput = document.getElementById('kids_extras_input');
            const priceInput = document.getElementById('kids_price_input');

            // Set braid type
            if(!btInput.value && (sel.kb_braid_type || sel.braid_type)) btInput.value = sel.kb_braid_type || sel.braid_type;
            // Set finish
            if(!finInput.value && (sel.kb_finish || sel.finish)) finInput.value = sel.kb_finish || sel.finish;
            // Set length: priority - sel.kb_length -> mirrorHidden -> sel.length
            if(sel.kb_length){
                lenInput.value = sel.kb_length;
            } else if(mirrorLen && mirrorLen.value){
                lenInput.value = mirrorLen.value;
            } else if(sel.length){
                lenInput.value = sel.length;
            }
            // extras
            if(!exInput.value && (sel.extras || (extrasMirror && extrasMirror.value))){
                exInput.value = sel.extras || (extrasMirror ? extrasMirror.value : '');
            }
            // price
            if(!priceInput.value && (sel.price || (priceMirror && priceMirror.value))){
                priceInput.value = sel.price || (priceMirror ? priceMirror.value : '');
            }

            // Normalize underscores for length (server expects underscores)
            if(lenInput && lenInput.value){ lenInput.value = lenInput.value.replace(/-/g,'_'); }
        }

        // Populate once on page load (in case modal is pre-opened)
        populateKidsHiddenFields();

        // Centralized validation function so other handlers can call it too
        function validateKidsSubmission(evt){
            try{ populateKidsHiddenFields(); }catch(exc){ console.warn('populateKidsHiddenFields failed', exc); }
            var errors = [];
            var nameEl = document.getElementById('kids_name');
                var nameVal = nameEl ? (nameEl.value||'').trim() : '';
                if(!nameVal) errors.push({el: nameEl, msg: "Please enter the child's name."});

                var phoneEl = document.getElementById('kids_phone');
                var phoneVal = phoneEl ? (phoneEl.value||'').trim() : '';
                var phonePattern = null;
                try{ if(phoneEl && phoneEl.getAttribute('pattern')) phonePattern = new RegExp(phoneEl.getAttribute('pattern')); }catch(e){}
                if(!phoneVal || (phonePattern && !phonePattern.test(phoneVal)) ) errors.push({el: phoneEl, msg: 'Please enter a valid parent/guardian phone number.'});

                // appointment date/time hidden inputs or visible labels
                var dateInput = document.querySelector('input[name="appointment_date"]');
                var timeInput = document.querySelector('input[name="appointment_time"]');
                var dateVal = dateInput ? (dateInput.value||'').trim() : (document.getElementById('kidsBookingDate') ? (document.getElementById('kidsBookingDate').value||'').trim() : '');
                var timeVal = timeInput ? (timeInput.value||'').trim() : (document.getElementById('kidsBookingTime') ? (document.getElementById('kidsBookingTime').value||document.getElementById('kidsBookingTime').textContent||'').trim() : '');
                if(!dateVal) errors.push({el: document.getElementById('kidsBookingDate'), msg: 'Please select an appointment date.'});
                if(!timeVal) errors.push({el: document.getElementById('kidsBookingTime'), msg: 'Please select an appointment time.'});

                // Ensure service/selection details are present
                var braidInput = document.getElementById('kids_braid_type_input');
                if(!braidInput || !(braidInput.value||'').trim()){
                    // try to read from selector radios
                    var selectedBraid = (document.querySelector('input[name="kb_braid_type"]:checked')||{}).value || '';
                    if(!selectedBraid) errors.push({el: document.getElementById('kb-braid-types'), msg: 'Please choose a braid type.'});
                }

                // final price must be set and greater than zero
                var finalPriceEl = document.getElementById('kids_final_price_input') || document.getElementById('kids_price_input') || document.getElementById('kb_price_input');
                var finalPriceVal = 0;
                try{ if(finalPriceEl && finalPriceEl.value) finalPriceVal = Number(String(finalPriceEl.value).replace(/[^0-9.\-]+/g,'')) || 0; }catch(e){}
                if(!finalPriceVal || finalPriceVal <= 0) errors.push({el: finalPriceEl || document.getElementById('kb_total_price'), msg: 'Price is not set. Please complete the selector.'});

                if(errors.length){
                    console.log('kidsBookingForm validation failed', errors);
                    try{ if(evt && typeof evt.preventDefault === 'function') evt.preventDefault(); }catch(e){}
                    // mark invalid fields and show a single alert in the modal
                    function clearValidationUI(){
                        try{ ['kids_name','kids_phone'].forEach(function(id){ var el=document.getElementById(id); if(el) el.classList.remove('is-invalid'); }); }catch(e){}
                        try{ var existing = document.getElementById('kidsBookingFormErrors'); if(existing) existing.remove(); }catch(e){}
                    }
                    clearValidationUI();

                    errors.forEach(function(it){
                        try{
                            if(it.el && it.el.classList) it.el.classList.add('is-invalid');
                            // Add or update an invalid-feedback element directly under the field
                            try{
                                if(it.el && it.el.tagName){
                                    var fb = null;
                                    // If the element is a form-control, attach feedback after it
                                    if(it.el.classList && it.el.classList.contains('form-control')){
                                        fb = it.el.nextElementSibling;
                                        if(!fb || !fb.classList || !fb.classList.contains('invalid-feedback')){
                                            fb = document.createElement('div');
                                            fb.className = 'invalid-feedback';
                                            it.el.parentNode.insertBefore(fb, it.el.nextSibling);
                                        }
                                        fb.textContent = it.msg;
                                    } else if(it.el.id && it.el.classList && it.el.classList.contains('form-check')){
                                        // form-check wrapper (radio/checkbox) - attach small help text below the block
                                        fb = it.el.querySelector('.invalid-feedback');
                                        if(!fb){
                                            fb = document.createElement('div'); fb.className = 'invalid-feedback d-block';
                                            it.el.appendChild(fb);
                                        }
                                        fb.textContent = it.msg;
                                    } else if(it.el && it.el.id){
                                        // generic element (e.g. container), ensure an inline message is shown nearby
                                        fb = document.getElementById(it.el.id + '_feedback');
                                        if(!fb){ fb = document.createElement('div'); fb.id = it.el.id + '_feedback'; fb.className = 'invalid-feedback d-block'; it.el.parentNode.insertBefore(fb, it.el.nextSibling); }
                                        fb.textContent = it.msg;
                                    }
                                }
                            }catch(e){ /* ignore feedback attach errors */ }
                        }catch(e){}
                    });

                    var alertContainer = document.getElementById('kidsBookingFormErrors');
                    if(!alertContainer){
                        alertContainer = document.createElement('div');
                        alertContainer.id = 'kidsBookingFormErrors';
                        alertContainer.className = 'alert alert-danger';
                        var modalBody = document.getElementById('kidsBookingModal') ? document.getElementById('kidsBookingModal').querySelector('.modal-body') : null;
                        if(modalBody) modalBody.insertBefore(alertContainer, modalBody.firstChild);
                        else document.body.insertBefore(alertContainer, document.body.firstChild);
                    }
                    alertContainer.innerHTML = '<ul class="mb-0 pl-3">' + errors.map(function(x){ return '<li>'+x.msg+'</li>'; }).join('') + '</ul>';
                    try{ var focusEl = errors[0].el || document.getElementById('kids_name'); if(focusEl && focusEl.focus) focusEl.focus(); }catch(e){}
                    // scroll modal body to top so alert is visible
                    try{ var mb = document.getElementById('kidsBookingModal') ? document.getElementById('kidsBookingModal').querySelector('.modal-body') : null; if(mb) mb.scrollTop = 0; else window.scrollTo(0,0); }catch(e){}
                    return errors;
                }
            }catch(err){ console.warn('kidsBookingForm validation error', err); }
            return errors;
        }

        // Ensure the form submit event also runs validation (covers Enter key submits)
        try{
            kidsForm.addEventListener('submit', function(e){
                try{
                    var errs = validateKidsSubmission(e);
                    if(errs && errs.length){
                        try{ e.preventDefault(); }catch(ex){}
                        return false;
                    }
                }catch(err){ console.warn('submit-handler validation failed', err); }
            });
        }catch(e){ /* noop */ }

        // Utility: check if required fields are present and valid
        function isKidsFormValid(){
            try{
                var nameEl = document.getElementById('kids_name');
                var phoneEl = document.getElementById('kids_phone');
                var dateInput = document.querySelector('input[name="appointment_date"]');
                var timeInput = document.querySelector('input[name="appointment_time"]');
                var finalPriceEl = document.getElementById('kids_final_price_input') || document.getElementById('kids_price_input') || document.getElementById('kb_price_input');
                var braidSelected = (document.querySelector('input[name="kb_braid_type"]:checked')||{}).value || '';

                var nameOk = nameEl && (nameEl.value||'').trim().length > 0;
                var phoneOk = false;
                if(phoneEl){
                    var v = (phoneEl.value||'').trim();
                    if(v.length>6){
                        var patt = null; try{ if(phoneEl.getAttribute('pattern')) patt = new RegExp(phoneEl.getAttribute('pattern')); }catch(e){}
                        phoneOk = patt ? patt.test(v) : true;
                    }
                }
                var dateOk = dateInput && (dateInput.value||'').trim().length>0;
                var timeOk = timeInput && (timeInput.value||'').trim().length>0;
                var priceOk = false; try{ if(finalPriceEl && finalPriceEl.value && Number(String(finalPriceEl.value).replace(/[^0-9.\-]+/g,''))>0) priceOk = true; }catch(e){}
                var braidOk = !!braidSelected;
                return nameOk && phoneOk && dateOk && timeOk && priceOk && braidOk;
            }catch(e){ console.warn('isKidsFormValid error', e); return false; }
        }

        // Enable/disable modal confirm button based on validity
        function updateConfirmState(){
            try{
                var btn = document.querySelector('#kidsBookingModal button[type="submit"]');
                if(!btn){ console.log('updateConfirmState: confirm button not found'); return; }
                var ok = isKidsFormValid();
                console.log('updateConfirmState: form valid=', ok);
                btn.disabled = !ok;
                if(!ok){ btn.classList.add('disabled'); btn.setAttribute('aria-disabled','true'); } else { btn.classList.remove('disabled'); btn.removeAttribute('aria-disabled'); }
            }catch(e){ console.warn('updateConfirmState failed', e); }
        }

        // Wire up listeners to update confirm state when inputs change
        try{
            ['kids_name','kids_phone','kidsBookingDate','kidsBookingTime'].forEach(function(id){ var el=document.getElementById(id); if(el) el.addEventListener('input', updateConfirmState); if(el) el.addEventListener('change', updateConfirmState); });
            document.querySelectorAll('input[name="kb_braid_type"]').forEach(function(r){ r.addEventListener('change', updateConfirmState); });
            var priceEls = [document.getElementById('kids_final_price_input'), document.getElementById('kids_price_input'), document.getElementById('kb_price_input')];
            priceEls.forEach(function(pe){ if(pe) pe.addEventListener('input', updateConfirmState); });
            // addons and length changes affect price -> recompute and update state
            document.querySelectorAll('#kb-addons input[type="checkbox"]').forEach(function(cb){ cb.addEventListener('change', function(){ setTimeout(function(){ try{ recomputeGlobal(); updateConfirmState(); }catch(e){} }, 50); }); });
            document.querySelectorAll('input[name="kb_length"]').forEach(function(r){ r.addEventListener('change', function(){ setTimeout(function(){ try{ recomputeGlobal(); updateConfirmState(); }catch(e){} }, 50); }); });
        }catch(e){ /* noop */ }

        // Also attach to the Confirm Booking button inside the modal to ensure validation runs
        try{
            var confirmBtn = document.querySelector('#kidsBookingModal button[type="submit"]');
            if(confirmBtn){
                // initialize disabled state
                updateConfirmState();
                confirmBtn.addEventListener('click', function(evt){
                    try{ console.log('Confirm Booking clicked'); }catch(e){}
                    try{
                        evt.preventDefault(); evt.stopPropagation();
                        var errs = validateKidsSubmission(evt);
                        if(errs && errs.length){ updateConfirmState(); return false; }

                        // Build preview payload to get server canonical breakdown before final submit
                        var kidsFormEl = document.getElementById('kidsBookingForm');
                        var payload = {
                            service: 'Kids Braids',
                            service_type: 'kids-braids',
                            kb_length: (document.getElementById('kids_length_input') && document.getElementById('kids_length_input').value) ? document.getElementById('kids_length_input').value : (document.querySelector('input[name="kb_length"]:checked') ? document.querySelector('input[name="kb_length"]:checked').value : ''),
                            kb_braid_type: (document.getElementById('kids_braid_type_input') && document.getElementById('kids_braid_type_input').value) ? document.getElementById('kids_braid_type_input').value : (document.querySelector('input[name="kb_braid_type"]:checked') ? document.querySelector('input[name="kb_braid_type"]:checked').value : ''),
                            kb_extras: (document.getElementById('kids_extras_input') && document.getElementById('kids_extras_input').value) ? document.getElementById('kids_extras_input').value : (document.getElementById('kb_extras_input') ? document.getElementById('kb_extras_input').value : '')
                        };
                        var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
                        fetch('/api/price/preview', {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        }).then(function(res){ return res.json(); }).then(function(json){
                            if(json && json.success && json.breakdown){
                                var b = json.breakdown;
                                try{ var kidsPriceInput = document.getElementById('kids_price_input'); if(kidsPriceInput) kidsPriceInput.value = Number(b.kb_final_price || b.final_price || 0).toFixed(2); }catch(e){}
                                try{ var kidsFinalInput = document.getElementById('kids_final_price_input'); if(kidsFinalInput) kidsFinalInput.value = Number(b.kb_final_price || b.final_price || 0).toFixed(2); }catch(e){}
                                try{ var kidsExtras = document.getElementById('kids_extras_input'); if(kidsExtras && (!kidsExtras.value || kidsExtras.value.trim()==='')){ var selparts = []; document.querySelectorAll('#kb-addons input[type="checkbox"]').forEach(function(cb){ if(cb.checked) selparts.push(cb.id || cb.value); }); if(selparts.length) kidsExtras.value = selparts.join(','); } }catch(e){}
                            }
                        }).catch(function(err){ console.warn('Price preview failed before submit', err); }).finally(function(){
                            // submit form after preview attempt (best-effort)
                            try{ if(kidsFormEl) kidsFormEl.submit(); }catch(e){ console.warn('Failed to submit kidsBookingForm programmatically', e); }
                        });
                        return false;
                    }catch(e){ console.warn('confirmBtn validation failed', e); }
                });
            }
        }catch(e){ /* noop */ }

        // Also listen on capture phase for any submit on the kids form to reliably block submission
        document.addEventListener('submit', function(e){
            try{
                var t = e.target || e.srcElement;
                if(t && t.id === 'kidsBookingForm'){
                    console.log('Capture submit for kidsBookingForm');
                    var errs = validateKidsSubmission(e);
                    if(errs && errs.length){
                        try{ e.preventDefault(); e.stopPropagation(); }catch(ex){}
                        updateConfirmState();
                        return false;
                    }
                }
            }catch(er){ console.warn('capture submit handler error', er); }
        }, true);

        // Re-evaluate when modal is shown
        try{
            var kidsModalEl = document.getElementById('kidsBookingModal');
            if(kidsModalEl){
                if(window.bootstrap && bootstrap.Modal){
                    kidsModalEl.addEventListener('shown.bs.modal', function(){ console.log('kids modal shown -> updateConfirmState'); updateConfirmState(); });
                } else {
                    // non-bootstrap fallback
                    kidsModalEl.addEventListener('display', function(){ updateConfirmState(); });
                }
            }
        }catch(e){ /* noop */ }

        // Clear validation UI when user corrects fields
        function _clearKidsErrors(){
            try{ var ex = document.getElementById('kidsBookingFormErrors'); if(ex) ex.remove(); }catch(e){}
            try{ ['kids_name','kids_phone','kidsBookingDate','kidsBookingTime'].forEach(function(id){ var el=document.getElementById(id); if(el && el.classList) el.classList.remove('is-invalid'); }); }catch(e){}
        }
        try{
            var nameFld = document.getElementById('kids_name'); if(nameFld) nameFld.addEventListener('input', _clearKidsErrors);
            var phoneFld = document.getElementById('kids_phone'); if(phoneFld) phoneFld.addEventListener('input', _clearKidsErrors);
            var dateFld = document.getElementById('kidsBookingDate'); if(dateFld) dateFld.addEventListener('change', _clearKidsErrors);
            var timeFld = document.getElementById('kidsBookingTime'); if(timeFld) timeFld.addEventListener('change', _clearKidsErrors);
            // Clear when braid type changes
            document.querySelectorAll('input[name="kb_braid_type"]').forEach(function(r){ r.addEventListener('change', _clearKidsErrors); });
        }catch(e){ /* noop */ }
    }catch(e){ console.warn('kidsBookingForm hookup failed', e); }
});
</script>
