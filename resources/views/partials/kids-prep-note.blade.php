@php
    $depositLabel = \App\Support\InteracDeposit::amountLabel();
@endphp
<div class="kb-prep-note">
    <div class="kb-prep-note-title">{{ __('kids.prep.title') }}</div>
    <ul class="kb-prep-note-list">
        <li>{{ __('kids.prep.wash') }}</li>
        <li>{!! __('kids.prep.sit') !!}</li>
        <li>{{ __('kids.prep.no_changes') }}</li>
        <li>{!! __('kids.prep.deposit', ['amount' => $depositLabel]) !!}</li>
    </ul>
</div>
