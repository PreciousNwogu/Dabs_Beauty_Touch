@extends('layouts.app')

@section('title', "Kids Braids Selector - Dab's Beauty Touch")
@section('meta_title', "Kids Braids Selector - Dab's Beauty Touch | Customize Your Child's Braids")
@section('meta_description', "Customize your child's braiding service with our interactive kids braids selector. Choose braid type, length, finish, and extras. Professional, gentle braiding services for children in Ottawa.")
@section('meta_keywords', 'kids braids, children braiding, kids hair braiding Ottawa, customize braids, kids hair styles')
@section('canonical', url('/kids-selector'))
@section('og_url', url('/kids-selector'))
@section('og_title', "Kids Braids Selector - Dab's Beauty Touch")
@section('og_description', "Customize your child's braiding service with our interactive kids braids selector. Professional, gentle braiding services for children.")
@section('twitter_url', url('/kids-selector'))
@section('twitter_title', "Kids Braids Selector - Dab's Beauty Touch")
@section('twitter_description', "Customize your child's braiding service with our interactive kids braids selector.")

@push('styles')
<style>
    .selector-card { max-width: 920px; margin: 28px auto; }
    .price-box { background: #fff; border-left: 6px solid #ff6600; padding: 16px; border-radius:8px; }
    .selector-card .card-title { color: #030f68; }
    .price-box .btn-primary { background: #ff6600; border-color: #ff6600; }
    .price-box .btn-primary:hover { background: #e55a00; border-color: #e55a00; }
</style>
@endpush

@section('content')
    <div class="container mt-4">
        @if(session('booking_error') || $errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                <strong>Booking Error:</strong>
                {{ session('error_message') ?: $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @include('partials.kids-selector-form')
        @include('partials.kids-page-booking')
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const priceMap = {!! json_encode($servicePrices ?? config('service_prices', [])) !!} || { 'kids_braids': 80 };
    const baseKey = 'kids_braids';
    const base = (priceMap[baseKey] !== undefined) ? Number(priceMap[baseKey]) : 80;

    // Function to hide/show Finish and Length sections based on braid type
    function toggleFinishAndLength(){
        const typeEl = document.querySelector('input[name="kb_braid_type"]:checked');
        const type = typeEl ? typeEl.value : '';
        
        // Hide for protective, cornrows, and any CMS-managed braid types (data-disable-steps attr)
        const shouldHide = (type === 'protective' || type === 'cornrows') || (typeEl && typeEl.dataset.disableSteps === '1');
        
        console.log('toggleFinishAndLength - type:', type, 'shouldHide:', shouldHide);
        
        // Hide/Show Finish section
        const finishHeader = document.getElementById('kb-finish-header');
        const finishBlock = document.getElementById('kb-finish-block');
        if(finishHeader) finishHeader.style.display = shouldHide ? 'none' : '';
        if(finishBlock) finishBlock.style.display = shouldHide ? 'none' : '';
        
        // Hide/Show Length section
        const lengthHeader = document.getElementById('kb-length-header');
        const lengthBlock = document.getElementById('kb-lengths');
        if(lengthHeader) lengthHeader.style.display = shouldHide ? 'none' : '';
        if(lengthBlock) lengthBlock.style.display = shouldHide ? 'none' : '';
        
        // Show/hide note
        const note = document.getElementById('kb_disabled_note');
        if(note) note.style.display = shouldHide ? 'block' : 'none';
    }

    function compute(){
        const typeEl = document.querySelector('input[name="kb_braid_type"]:checked');
        const type = typeEl ? typeEl.value : '';
        const shouldHide = (type === 'protective' || type === 'cornrows') || (typeEl && typeEl.dataset.disableSteps === '1');
        // data-price is the CMS-derived starting price for the selected style
        const startPrice = (typeEl && typeEl.dataset.price !== undefined && typeEl.dataset.price !== '')
            ? Number(typeEl.dataset.price)
            : base;

        let adj = 0;
        if(!shouldHide){
            const finishEl = document.querySelector('input[name="kb_finish"]:checked');
            if(finishEl && finishEl.value==='curled') adj -= 10;

            const lengthEl = document.querySelector('input[name="kb_length"]:checked');
            const length = lengthEl ? lengthEl.value : '';
            if(length==='armpit') adj += 10;
            if(length==='mid_back') adj += 20;
            if(length==='waist') adj += 30;
        }

        ['kb_add_detangle','kb_add_beads','kb_add_beads_full','kb_add_extension','kb_add_rest'].forEach(id=>{
            const el = document.getElementById(id);
            if(el && el.checked) adj += Number(el.value||0);
        });

        const total = startPrice + adj;
        const baseEl = document.getElementById('kb_base_price'); if(baseEl) baseEl.textContent = '$' + Number(startPrice).toFixed(0);
        const adjEl = document.getElementById('kb_adjustments'); if(adjEl) adjEl.textContent = '$' + Number(adj).toFixed(0);
        const totEl = document.getElementById('kb_total_price'); if(totEl) totEl.textContent = '$' + Number(total).toFixed(0);
        return { total, base: startPrice, adj };
    }

    document.querySelectorAll('#kidsSelectorForm input').forEach(i=> i.addEventListener('change', function(){
        toggleFinishAndLength();
        compute();
    }));
    
    // Initial setup on page load
    toggleFinishAndLength();
    compute();

    const proceedBtn = document.getElementById('kb_proceed_btn');
        if(proceedBtn){
            proceedBtn.addEventListener('click', function(e){
                // Prevent normal form submit; instead navigate to home with selector parameters so
                // the booking modal on the home page can open directly.
                e.preventDefault();
                const res = compute();
                const extras = [];
                ['kb_add_detangle','kb_add_beads','kb_add_beads_full','kb_add_extension','kb_add_rest'].forEach(id=>{
                    const el = document.getElementById(id);
                    if(el && el.checked) extras.push(id);
                });
                const extrasInput = document.getElementById('kb_extras_input');
                const priceInput = document.getElementById('kb_price_input');
                if(extrasInput) extrasInput.value = extras.join(',');
                if(priceInput) priceInput.value = res.total;

                // mirror disabled radio values into hidden inputs
                try{
                    const lengthEl = document.querySelector('input[name="kb_length"]:checked');
                    const finishEl = document.querySelector('input[name="kb_finish"]:checked');
                    const hiddenLen = document.getElementById('kb_length_hidden');
                    const hiddenFin = document.getElementById('kb_finish_hidden');
                    if(hiddenLen) hiddenLen.value = lengthEl ? lengthEl.value : '';
                    if(hiddenFin) hiddenFin.value = finishEl ? finishEl.value : '';
                }catch(err){ console.warn('Failed to set hidden length/finish', err); }

                // Build query string and redirect to home which will open the booking modal
                try{
                    let braidType = (document.querySelector('input[name="kb_braid_type"]:checked')||{}).value || '';
                    const finish = (document.querySelector('input[name="kb_finish"]:checked')||{}).value || '';
                    const length = (document.querySelector('input[name="kb_length"]:checked')||{}).value || '';

                    // Defensive fallback: ensure one braid type is always selected before continuing.
                    if(!braidType){
                        const defaultBraid = document.getElementById('kb_type_protective');
                        if(defaultBraid){
                            defaultBraid.checked = true;
                            braidType = defaultBraid.value || '';
                        }
                    }
                    if(!braidType){
                        alert('Please choose a braid type before continuing.');
                        return;
                    }

                    const radio = document.querySelector('input[name="kb_braid_type"]:checked');
                    const commentsEl = document.getElementById('kb_comments');
                    const colorEl = document.getElementById('kb_hair_color');
                    const selectorSnapshot = {
                        kb_braid_type: braidType,
                        kb_finish: finish,
                        kb_length: length,
                        kb_extras: extras.join(','),
                        price: String(res.total),
                        style_label: (radio && radio.dataset && radio.dataset.label) || '',
                        style_image: (radio && radio.dataset && radio.dataset.image) || '',
                        style_duration: (radio && radio.dataset && radio.dataset.duration) || '',
                        finish_label: finish === 'curled' ? 'With curled tip' : (finish ? 'Without curl' : ''),
                        length_label: ({shoulder:'Shoulder',armpit:'Armpit',mid_back:'Mid back',waist:'Waist'})[length] || length,
                        extras_labels: extras.map(function(id){
                            return ({kb_add_detangle:'Detangle / Blowdry',kb_add_beads:'Tiny beading',kb_add_beads_full:'Big eye beading',kb_add_extension:'Hair Extension',kb_add_rest:'15-min break'})[id] || id;
                        }).filter(Boolean).join(', '),
                        comments: commentsEl ? commentsEl.value : '',
                        hair_color: colorEl ? colorEl.value : ''
                    };
                    try { localStorage.setItem('kb_selector', JSON.stringify(selectorSnapshot)); } catch (storageErr) { console.warn('Failed to persist kb_selector snapshot', storageErr); }
                    try { window.__kidsSelectorData = selectorSnapshot; } catch (stateErr) { console.warn('Failed to set in-memory selector snapshot', stateErr); }

                    if (typeof openKidsBookingModal === 'function' && document.getElementById('kidsBookingModal')) {
                        openKidsBookingModal('Kids Braids', 'kids-braids');
                        return;
                    }

                    const qs = new URLSearchParams();
                    qs.set('ks', '1');
                    qs.set('service', 'Kids Braids');
                    qs.set('service_type', 'kids-braids');
                    qs.set('price', String(res.total));
                    qs.set('braid_type', braidType);
                    qs.set('finish', finish);
                    qs.set('hair_length', length);
                    if(extras.length) qs.set('extras', extras.join(','));

                    window.location.href = '{{ route('home') }}' + '?' + qs.toString();
                }catch(err){
                    console.warn('Redirect to home failed, submitting form as fallback', err);
                    // fallback to form submit
                    document.getElementById('kidsSelectorForm').submit();
                }
            });
        }
});
</script>
@endpush
