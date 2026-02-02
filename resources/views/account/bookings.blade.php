@extends('layouts.app')

@section('title', 'My Bookings - Dab\'s Beauty Touch')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="mb-1" style="font-weight:900;color:#0b3a66;">My Bookings</h3>
            <div class="text-muted">Your recent appointments.</div>
        </div>
        <a href="{{ route('home') }}#services" class="btn btn-outline-primary" style="border-radius:12px;font-weight:700;">Book again</a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:16px;">
        <div class="card-body">
            @if($bookings->count() === 0)
                <div class="alert alert-info mb-0">
                    You don’t have any bookings yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $b)
                                <tr>
                                    <td>{{ optional($b->appointment_date)->format('M j, Y') }}</td>
                                    <td>
                                        @php
                                            $t = $b->appointment_time;
                                            try { $t = $t ? \Carbon\Carbon::parse($t)->format('g:i A') : '—'; } catch(\Throwable $e) {}
                                        @endphp
                                        {{ $t ?: '—' }}
                                    </td>
                                    <td>{{ $b->service ?? '—' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $b->status_badge }}">{{ ucfirst($b->status ?? 'pending') }}</span>
                                    </td>
                                    <td class="text-end">
                                        @if(!empty($b->confirmation_code))
                                            <a class="btn btn-sm btn-primary"
                                               style="border-radius:10px;font-weight:700;"
                                               href="{{ route('account.bookings.show', ['booking' => $b->id]) }}">
                                                View
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

