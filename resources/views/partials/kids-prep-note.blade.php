@php
    $depositLabel = \App\Support\InteracDeposit::amountLabel();
@endphp
<div class="kb-prep-note">
    <div class="kb-prep-note-title">Before you come</div>
    <ul class="kb-prep-note-list">
        <li>Hair washed, dried, and detangled if you can. That keeps the visit shorter.</li>
        <li>Kids usually sit about <strong>1–3 hours</strong>, depending on the style. If your child needs a break, add the <strong>15-min break</strong> add-on while booking.</li>
        <li>Style changes are not taken on the day of the appointment.</li>
        <li>A <strong>{{ $depositLabel }} Interac deposit</strong> holds the spot. You can cancel or reschedule from the confirmation email.</li>
    </ul>
</div>
