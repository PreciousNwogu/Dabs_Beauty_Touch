@extends('layouts.app')

@section('title', 'Booking Details - Dab\'s Beauty Touch')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h3 class="mb-1" style="font-weight:900;color:#0b3a66;">Booking Details</h3>
            <div class="text-muted">Review your past booking and rebook in one click.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('account.bookings') }}" class="btn btn-outline-secondary" style="border-radius:12px;font-weight:700;">
                Back
            </a>
            <button id="rebookBtn" type="button" class="btn btn-primary" style="border-radius:12px;font-weight:800;">
                Book again
            </button>
        </div>
    </div>

    <div class="alert alert-info" style="border-radius:12px;">
        <strong>Note:</strong> We’ll autofill your info. You’ll still need to choose a <strong>new date and time</strong>.
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:16px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <tbody>
                        <tr>
                            <td class="text-muted" style="width:220px;">Booking ID</td>
                            <td style="font-weight:800;">{{ 'BK' . str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Confirmation Code</td>
                            <td style="font-weight:800;">{{ $booking->confirmation_code ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Service</td>
                            <td style="font-weight:700;">{{ $booking->service ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Length</td>
                            <td>{{ $booking->length ? ucwords(str_replace(['_','-'], ' ', $booking->length)) : '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Date / Time</td>
                            <td>
                                @php
                                    $d = $booking->appointment_date ? $booking->appointment_date->format('F j, Y') : '—';
                                    $t = $booking->appointment_time;
                                    try { $t = $t ? \Carbon\Carbon::parse($t)->format('g:i A') : null; } catch(\Throwable $e) {}
                                @endphp
                                {{ $d }}{{ $t ? (' at ' . $t) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Final Price</td>
                            <td style="font-weight:800;">{{ $booking->final_price !== null ? ('$' . number_format((float)$booking->final_price, 2)) : '—' }}</td>
                        </tr>
                        @if(!empty($booking->message))
                        <tr>
                            <td class="text-muted">Notes</td>
                            <td>{{ $booking->message }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @php
                $imgUrl = null;
                if (!empty($booking->sample_picture)) {
                    $imgUrl = asset('storage/' . ltrim($booking->sample_picture, '/'));
                }
            @endphp

            @if($imgUrl)
                <hr class="my-4">
                <div>
                    <div style="font-weight:800;color:#0b3a66;" class="mb-2">Reference Image</div>
                    <img src="{{ $imgUrl }}" alt="Reference image" style="max-width:100%;border-radius:14px;border:1px solid #e5e7eb;">
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
    const btn = document.getElementById('rebookBtn');
    if(!btn) return;

    btn.addEventListener('click', function(){
        try{
            const KEY = 'dbt_booking_draft_v1';
            const draft = {
                name: @json($booking->name ?? ''),
                phone: @json($booking->phone ?? ''),
                email: @json($booking->email ?? ''),
                address: @json($booking->address ?? ''),
                message: @json($booking->message ?? '')
            };
            try { sessionStorage.setItem(KEY, JSON.stringify(draft)); } catch(e) {}

            const serviceType = @json($serviceType ?? '');
            const serviceName = @json($serviceName ?? '');
            const url = "{{ route('home') }}" + "?service_type=" + encodeURIComponent(serviceType) + "&service=" + encodeURIComponent(serviceName);
            window.location.href = url;
        }catch(e){
            window.location.href = "{{ route('home') }}#services";
        }
    });
})();
</script>
@endpush
@endsection

