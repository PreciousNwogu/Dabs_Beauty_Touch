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
        @include('partials.kids-selector-form')
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const priceMap = {!! json_encode($servicePrices ?? config('service_prices', [])) !!} || { 'kids_braids': 80 };
    const baseKey = 'kids_braids';
    const base = (priceMap[baseKey] !== undefined) ? Number(priceMap[baseKey]) : 80;

    function compute(){
        let total = base; let adj = 0;
        const typeEl = document.querySelector('input[name="kb_braid_type"]:checked');
        const type = typeEl ? typeEl.value : '';
        if(type==='protective') adj -= 20;
        if(type==='cornrows') adj -= 40;
        if(type==='knotless_small') adj += 20;
        if(type==='box_small') adj += 10;
        if(type==='stitch') adj += 20;

        const finishEl = document.querySelector('input[name="kb_finish"]:checked');
        if(finishEl && finishEl.value==='curled') adj -= 10;

        const lengthEl = document.querySelector('input[name="kb_length"]:checked');
        const length = lengthEl ? lengthEl.value : '';
        if(length==='armpit') adj += 10;
        if(length==='mid_back') adj += 20;
        if(length==='waist') adj += 30;

        ['kb_add_detangle','kb_add_beads','kb_add_beads_full','kb_add_extension','kb_add_rest'].forEach(id=>{
            const el = document.getElementById(id);
            if(el && el.checked) adj += Number(el.value||0);
        });

        total += adj;
        const baseEl = document.getElementById('kb_base_price'); if(baseEl) baseEl.textContent = '$' + Number(base).toFixed(0);
        const adjEl = document.getElementById('kb_adjustments'); if(adjEl) adjEl.textContent = '$' + Number(adj).toFixed(0);
        const totEl = document.getElementById('kb_total_price'); if(totEl) totEl.textContent = '$' + Number(total).toFixed(0);
        return { total, base, adj };
    }

    document.querySelectorAll('#kidsSelectorForm input').forEach(i=> i.addEventListener('change', compute));
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
                    const braidType = (document.querySelector('input[name="kb_braid_type"]:checked')||{}).value || '';
                    const finish = (document.querySelector('input[name="kb_finish"]:checked')||{}).value || '';
                    const length = (document.querySelector('input[name="kb_length"]:checked')||{}).value || '';
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
