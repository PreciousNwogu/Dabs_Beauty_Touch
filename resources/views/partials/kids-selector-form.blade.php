<!-- Kids Selector Form Partial -->
<div class="selector-card card shadow-sm">
    <div class="card-body">
        <h3 class="card-title">Kids Braids (3–8 yrs) — Choose options</h3>
        <p class="text-muted">Follow the steps below to select braid type, length and add-ons. Price updates automatically.</p>

        <div class="row">
            <div class="col-md-8">
                <form id="kidsSelectorForm" method="POST" action="{{ route('kids.selector.submit') }}">
                    @csrf
                    <h6 class="mt-3">1) Braid Type</h6>
                    <div id="kb-braid-types" class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kb_braid_type" id="kb_type_protective" value="protective" checked>
                            <label class="form-check-label" for="kb_type_protective">Protective style (natural hair) (-$20)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kb_braid_type" id="kb_type_cornrows" value="cornrows">
                            <label class="form-check-label" for="kb_type_cornrows">Cornrows with natural hair (-$40)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kb_braid_type" id="kb_type_knotless_small" value="knotless_small">
                            <label class="form-check-label" for="kb_type_knotless_small">Knotless (Small) (+$20)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kb_braid_type" id="kb_type_knotless_med" value="knotless_med">
                            <label class="form-check-label" for="kb_type_knotless_med">Knotless (Medium)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kb_braid_type" id="kb_type_box_small" value="box_small">
                            <label class="form-check-label" for="kb_type_box_small">Box Braids (Small) (+$10)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kb_braid_type" id="kb_type_box_med" value="box_med">
                            <label class="form-check-label" for="kb_type_box_med">Box Braids (Medium)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kb_braid_type" id="kb_type_stitch" value="stitch">
                            <label class="form-check-label" for="kb_type_stitch">Stitch Braids (&gt;10 rows) (+$20)</label>
                        </div>
                    </div>

                    <h6 class="mt-3">2) Finish</h6>
                    <div class="mb-3" id="kb-finish-block">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kb_finish" id="kb_finish_curled" value="curled">
                            <label class="form-check-label" for="kb_finish_curled">With curled tip (-$10)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kb_finish" id="kb_finish_plain" value="plain" checked>
                            <label class="form-check-label" for="kb_finish_plain">Without curled tip</label>
                        </div>
                    </div>

                    <h6 class="mt-3">3) Hair Length</h6>
                    <div id="kb-lengths" class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kb_length" id="kb_len_shoulder" value="shoulder" checked>
                            <label class="form-check-label" for="kb_len_shoulder">Shoulder (base)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kb_length" id="kb_len_armpit" value="armpit">
                            <label class="form-check-label" for="kb_len_armpit">Armpit (+$10)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kb_length" id="kb_len_midback" value="mid_back">
                            <label class="form-check-label" for="kb_len_midback">Mid Back (+$20)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kb_length" id="kb_len_waist" value="waist">
                            <label class="form-check-label" for="kb_len_waist">Waist (+$30)</label>
                        </div>
                    </div>

                    <h6 class="mt-3">4) Add-Ons</h6>
                    <div id="kb-addons" class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="kb_add_detangle" value="15">
                            <label class="form-check-label" for="kb_add_detangle">Detangle / Blowdry (+$15)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="kb_add_beads" value="10">
                            <label class="form-check-label" for="kb_add_beads">Beads (+$10)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="kb_add_beads_full" value="15">
                            <label class="form-check-label" for="kb_add_beads_full">Small eye beads full (+$15)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="kb_add_extension" value="20">
                            <label class="form-check-label" for="kb_add_extension">Hair Extension (+$20)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="kb_add_rest" value="5">
                            <label class="form-check-label" for="kb_add_rest">Resting Break (+$5)</label>
                        </div>
                    </div>

                    <!-- Helper note shown when finish/length are disabled -->
                    <div id="kb_disabled_note" class="form-text text-muted mt-2" style="display:none">Finish and hair length are disabled for the selected braid type.</div>

                    <input type="hidden" name="price" id="kb_price_input" value="">
                    <input type="hidden" name="extras" id="kb_extras_input" value="">
                    <!-- Hidden mirrors so disabled radios still submit values -->
                    <input type="hidden" name="kb_length" id="kb_length_hidden" value="">
                    <input type="hidden" name="kb_finish" id="kb_finish_hidden" value="">
                </form>
            </div>

            <div class="col-md-4">
                <div class="price-box">
                    <h6>Price Summary</h6>
                    <div class="mb-2">Base: <span id="kb_base_price">$--</span></div>
                    <div class="mb-2">Adjustments: <span id="kb_adjustments">$0</span></div>
                    <div class="mb-3"><strong>Total: <span id="kb_total_price">$--</span></strong></div>
                    <div class="d-grid">
                        <button id="kb_proceed_btn" class="btn btn-primary w-100" type="submit" form="kidsSelectorForm">Continue to Booking</button>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-link w-100 mt-2">Cancel</a>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Inline helper: disable finish and length when braid types do not require them -->
<script>
document.addEventListener('DOMContentLoaded', function(){
    function setFinishAndLengthDisabled(disabled){
        // finish radios
        document.querySelectorAll('input[name="kb_finish"]').forEach(function(i){
            i.disabled = disabled;
        });
        // hide/show finish block wrapper
        try{
            const finishBlock = document.getElementById('kb-finish-block');
            if(finishBlock) finishBlock.style.display = disabled ? 'none' : '';
        }catch(e){ /* noop */ }
        // if disabling, ensure a safe default is selected
        if(disabled){
            const plain = document.getElementById('kb_finish_plain'); if(plain) plain.checked = true;
        }

        // length radios
        document.querySelectorAll('input[name="kb_length"]').forEach(function(i){
            i.disabled = disabled;
        });
        // hide/show length wrapper
        try{
            const lengthBlock = document.getElementById('kb-lengths');
            if(lengthBlock) lengthBlock.style.display = disabled ? 'none' : '';
        }catch(e){ /* noop */ }
        // if disabling, set base shoulder length
        if(disabled){
            const shoulder = document.getElementById('kb_len_shoulder'); if(shoulder) shoulder.checked = true;
        }

        // visually indicate disabled state on labels (dim)
        const lengthLabels = document.querySelectorAll('#kb-lengths .form-check-label');
        const finishLabels = document.querySelectorAll('input[name="kb_finish"]').length ? Array.from(document.querySelectorAll('input[name="kb_finish"]')).map(i=> document.querySelector('label[for="'+i.id+'"]')) : [];
        lengthLabels.forEach(function(l){ if(disabled) l.classList.add('text-muted','opacity-75'); else { l.classList.remove('text-muted','opacity-75'); } });
        finishLabels.forEach(function(l){ if(l){ if(disabled) l.classList.add('text-muted','opacity-75'); else { l.classList.remove('text-muted','opacity-75'); } } });

        // show/hide helper note
        const note = document.getElementById('kb_disabled_note'); if(note) note.style.display = disabled ? 'block' : 'none';
    }

    function evaluateBraidType(){
        const cur = document.querySelector('input[name="kb_braid_type"]:checked');
        const val = cur ? cur.value : '';
        const shouldDisable = (val === 'protective' || val === 'cornrows');
        setFinishAndLengthDisabled(shouldDisable);
    }

    // attach listeners to braid type radios
    document.querySelectorAll('input[name="kb_braid_type"]').forEach(function(r){
        r.addEventListener('change', evaluateBraidType);
    });

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

    // run initial evaluation
    evaluateBraidType();
});
</script>
