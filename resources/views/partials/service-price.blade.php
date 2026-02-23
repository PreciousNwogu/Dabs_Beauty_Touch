@php
    $eff = (int) config('service_prices.' . $priceKey, $priceDefault ?? 0);
    $ori = (int) config('service_prices_original.' . $priceKey, $eff);
@endphp
<p class="price">
    @if($eff < $ori)
        <strong style="color:#ff6600">From ${{ number_format($eff, 0) }}</strong>&nbsp;<del class="text-muted" style="font-weight:600;font-size:.88em">${{ number_format($ori, 0) }}</del>&nbsp;<span class="badge bg-danger" style="font-size:.65rem;vertical-align:middle;padding:3px 6px;border-radius:6px">SALE</span>
    @else
        <strong>From ${{ number_format($eff, 0) }}</strong>
    @endif
    <small class="text-muted">{{ $priceLabel ?? '' }}</small>
</p>
