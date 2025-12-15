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
                            <label class="form-check-label" for="kb_finish_curled">With curl (-$10)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kb_finish" id="kb_finish_plain" value="plain" checked>
                            <label class="form-check-label" for="kb_finish_plain">Without curl</label>
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
                            <label class="form-check-label" for="kb_add_beads">Beading (+$10)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="kb_add_beads_full" value="15">
                            <label class="form-check-label" for="kb_add_beads_full">Small size beads (+$15)</label>
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
                    <input type="hidden" name="kb_extras" id="kb_extras_input" value="">
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
        // Disable finish & length for specific braid types
        const disabledTypes = ['protective', 'cornrows'];
        const shouldDisable = disabledTypes.indexOf(val) !== -1;
        setFinishAndLengthDisabled(shouldDisable);

        // Ensure hidden mirror fields reflect any default selections immediately
        try{ if(typeof syncHiddenMirrors === 'function') syncHiddenMirrors(); }catch(e){}
    }

    // attach listeners to braid type radios (listen for both change and click for instant response)
    const braidRadios = document.querySelectorAll('input[name="kb_braid_type"]');
    braidRadios.forEach(function(r){
        r.addEventListener('change', evaluateBraidType);
        r.addEventListener('click', evaluateBraidType);
    });
    // also attach a container click handler as a fallback
    const braidContainer = document.getElementById('kb-braid-types');
    if(braidContainer) braidContainer.addEventListener('click', function(){ try{ evaluateBraidType(); }catch(e){} });

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
                try{ if(typeof evaluateBraidType === 'function') evaluateBraidType(); }catch(e){}

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

                    if(kb_base) kb_base.innerHTML = 'Base: <strong>$' + Number(base).toFixed(0) + '</strong>';
                    if(kb_adjust) kb_adjust.innerHTML = 'Adjustments: <strong>' + (adjustmentsTotal >= 0 ? '+' : '-') + '$' + Math.abs(Number(adjustmentsTotal)).toFixed(0) + '</strong>';
                    if(kb_total) kb_total.innerHTML = '<strong>Total: $' + Number(computedTotal).toFixed(0) + '</strong>';
                }catch(e){
                    // fallback to previous behavior
                    if(kb_total){
                        const total = sel && sel.price ? Number(sel.price).toFixed(0) : (document.getElementById('kb_total_price') ? document.getElementById('kb_total_price').textContent.replace('$','') : '');
                        kb_total.innerHTML = '<strong>Total: $' + (total || '--') + '</strong>';
                    }
                }
            }catch(e){ console.warn('populate kids modal fallback failed', e); }

            // Show modal (Bootstrap if available; fallback otherwise). Don't touch calendar.
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

        kidsForm.addEventListener('submit', function(){
            try{ populateKidsHiddenFields(); }catch(e){ console.warn('populateKidsHiddenFields failed', e); }
        });
    }catch(e){ console.warn('kidsBookingForm hookup failed', e); }
});
</script>
