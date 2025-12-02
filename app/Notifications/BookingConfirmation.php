<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;

class BookingConfirmation extends Notification
{
    use Queueable;

    protected Booking $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $b = $this->booking;

        // Prefer persisted fields if available (safer for audit/consistency)
        $basePrice = $b->base_price ?? null;
        $adjust = $b->length_adjustment ?? null;

        // If persisted basePrice missing, try service lookup
        if (is_null($basePrice)) {
            try {
                $serviceModel = \App\Models\Service::where('slug', $b->service)->orWhere('name', $b->service)->first();
                if ($serviceModel) {
                    $basePrice = (float) $serviceModel->base_price;
                }
            } catch (\Exception $e) {
                $serviceModel = null;
            }
        }

        // If persisted adjustment missing, compute using two-step rule
        if (is_null($adjust) && $b->length) {
            $ordered = ['neck','shoulder','armpit','bra_strap','mid_back','waist','hip','tailbone','classic'];
            $midIndex = array_search('mid_back', $ordered, true);
            $idx = array_search($b->length, $ordered, true);
            if ($idx !== false && $midIndex !== false) {
                $d = $idx - $midIndex;
                // Per-step rule: each single step away from mid_back changes price by $20
                $adjust = ($d * 20.00);
            }
        }

        // Use a styled blade view for confirmation emails so we can show base/adjustment/total
        $subject = __('emails.confirmation.subject') ?: 'Booking Confirmation';

        // Try extract selector payload from notes (if stored there)
        $selector = null;
        if(!empty($b->notes) && preg_match('/Selector:\s*(\{.*\})/s', $b->notes, $m)){
            try{ $selector = json_decode($m[1], true); }catch(\Exception $e){ $selector = null; }
        }

        // Compute authoritative kids total if this is a kids booking or selector exists
        $computedTotal = null;
        try{
            $serviceType = strtolower((string) ($b->service_type ?? $b->service ?? ''));
            if($serviceType === 'kids-braids' || stripos($b->service ?? '', 'kids') !== false || $selector){
                $baseConfigured = (float) (config('service_prices.kids_braids', 80));
                // adjustments maps
                $typeAdj = ['protective'=>-20,'cornrows'=>-40,'knotless_small'=>20,'knotless_med'=>0,'box_small'=>10,'box_med'=>0,'stitch'=>20];
                $lengthAdj = ['shoulder'=>0,'armpit'=>10,'mid_back'=>20,'waist'=>30];
                $finishAdj = ['curled'=>-10,'plain'=>0];

                $sel = $selector ?: [];
                $adjustments = 0; $addons = 0;
                $bt = $sel['braid_type'] ?? $b->kb_braid_type ?? null;
                $ln = $sel['length'] ?? $b->length ?? null;
                $fi = $sel['finish'] ?? $b->kb_finish ?? null;
                $ex = $sel['extras'] ?? $b->kb_extras ?? null;

                if($bt && isset($typeAdj[$bt])) $adjustments += $typeAdj[$bt];
                if($ln && isset($lengthAdj[$ln])) $adjustments += $lengthAdj[$ln];
                if($fi && isset($finishAdj[$fi])) $adjustments += $finishAdj[$fi];

                // parse extras: either CSV of ids or comma of values
                if($ex){
                    // known addon mapping
                    $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
                    if(is_string($ex) && strpos($ex,'kb_add_')!==false){
                        foreach(explode(',', $ex) as $it){ $it = trim($it); if(isset($addonMap[$it])) $addons += $addonMap[$it]; }
                    } else if(is_string($ex) && preg_match('/^\d+(?:\.\d+)?(,\d+(?:\.\d+)?)*$/', $ex)){
                        foreach(explode(',', $ex) as $n){ $addons += floatval($n); }
                    }
                }

                $computedTotal = round($baseConfigured + $adjustments + $addons, 2);
                // if booking has final_price and looks authoritative, prefer it
                if(!empty($b->final_price) && is_numeric($b->final_price)){
                    // trust stored final_price if it equals computedTotal or is present
                    // but show computedTotal as canonical
                }
            }
        }catch(\Exception $e){ /* noop */ }

        // Build friendly labels for selector values so emails show readable text
        $selector_friendly = null;
        try{
            $friendlyBraid = [
                'protective' => 'Protective style',
                'cornrows' => 'Cornrows',
                'knotless_small' => 'Knotless (small)',
                'knotless_med' => 'Knotless (medium)',
                'box_small' => 'Box (small)',
                'box_med' => 'Box (medium)',
                'stitch' => 'Stitch',
            ];
            $friendlyFinish = [
                'none' => '—',
                'sleek' => 'Sleek finish',
                'natural' => 'Natural finish',
                'curled' => 'With curl',
                'plain' => 'Without curl',
            ];
            $friendlyLength = [
                'short' => 'Short',
                'neck' => 'Neck',
                'mid_back' => 'Mid Back',
                'waist' => 'Waist',
                'long' => 'Long',
            ];
            $addonMap = ['kb_add_detangle' => 'Detangle', 'kb_add_beads' => 'Beads', 'kb_add_beads_full' => 'Beads (full)', 'kb_add_extension' => 'Extension', 'kb_add_rest' => 'Restyle'];

            $sel = $selector ?: [];
            $bt = $sel['braid_type'] ?? $b->kb_braid_type ?? null;
            $fi = $sel['finish'] ?? $b->kb_finish ?? null;
            $ln = $sel['length'] ?? $b->kb_length ?? $b->length ?? null;
            $ex = $sel['extras'] ?? $b->kb_extras ?? null;

            $extrasList = [];
            if($ex){
                if(is_array($ex)){
                    foreach($ex as $it){ $it = trim($it); if($it==='') continue; $extrasList[] = $addonMap[$it] ?? ucwords(str_replace(['_','-'], ' ', $it)); }
                } else {
                    // comma separated or CSV of numeric prices
                    foreach(explode(',', (string)$ex) as $it){ $it = trim($it); if($it==='') continue; $extrasList[] = $addonMap[$it] ?? ucwords(str_replace(['_','-'], ' ', $it)); }
                }
            }

            $selector_friendly = [
                'braid_type' => $bt ? ($friendlyBraid[$bt] ?? ucwords(str_replace(['_','-'], ' ', $bt))) : null,
                'finish' => $fi ? ($friendlyFinish[$fi] ?? ucwords(str_replace(['_','-'], ' ', $fi))) : null,
                'length' => $ln ? ($friendlyLength[$ln] ?? ucwords(str_replace(['_','-'], ' ', $ln))) : null,
                'extras' => $extrasList,
            ];
        }catch(\Exception $e){ $selector_friendly = null; }

        // Normalize breakdown values so templates receive a consistent payload
        $addonsTotal = 0;
        $lengthAdjust = 0;

        // Prefer selector-level kids adjustments when present
        if (isset($adjustments) && is_numeric($adjustments)) {
            $lengthAdjust = (float) $adjustments;
        } elseif (!is_null($adjust) && is_numeric($adjust)) {
            $lengthAdjust = (float) $adjust;
        }

        if (isset($addons) && is_numeric($addons)) {
            $addonsTotal = (float) $addons;
        }

        // If $addons isn't numeric but $selector contains extras ids or CSV, attempt to parse it
        if ($addonsTotal === 0 && !empty($selector['extras'])) {
            $ex = $selector['extras'];
            if (is_array($ex)) {
                // mapping from ids
                $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
                foreach ($ex as $it) { if (isset($addonMap[$it])) $addonsTotal += $addonMap[$it]; }
            } elseif (is_string($ex)) {
                if (preg_match('/^\d+(?:\.\d+)?(,\d+(?:\.\d+)?)*$/', $ex)) {
                    foreach (explode(',', $ex) as $n) { $addonsTotal += floatval($n); }
                } else {
                    // maybe comma-separated ids
                    $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
                    foreach (explode(',', $ex) as $it) { $it = trim($it); if (isset($addonMap[$it])) $addonsTotal += $addonMap[$it]; }
                }
            }
        }

        // Compute canonical computed total for selector-based bookings
        $computed_total_final = null;
        if (!is_null($computedTotal)) {
            $computed_total_final = (float) $computedTotal;
        }

        // Resolve base price fallback
        $resolvedBase = null;
        if (!is_null($basePrice) && is_numeric($basePrice)) {
            $resolvedBase = (float) $basePrice;
        } elseif (isset($baseConfigured) && is_numeric($baseConfigured)) {
            $resolvedBase = (float) $baseConfigured;
        } else {
            $resolvedBase = 0.0;
        }

        // Determine final_price to pass: prefer computed_total_final, then booking final_price, else compute from components
        if (!is_null($computed_total_final)) {
            $final_price_to_pass = $computed_total_final;
        } elseif (!empty($b->final_price) && is_numeric($b->final_price)) {
            $final_price_to_pass = (float) $b->final_price;
        } else {
            $final_price_to_pass = round($resolvedBase + $lengthAdjust + $addonsTotal, 2);
        }

        // Also compute an adjustments total (lengthAdjust + addonsTotal) for clarity in templates
        $adjustmentsTotal = round($lengthAdjust, 2);
        $addonsTotal = round($addonsTotal, 2);
        $computed_total_final = $computed_total_final ?? $final_price_to_pass;

        // Compute hideLengthFinish once and pass to views so templates don't duplicate logic
        $rawBraid = strtolower((string)($selector['braid_type'] ?? $b->kb_braid_type ?? $b->service ?? ''));
        $hideLengthFinish = (
            stripos($rawBraid, 'protect') !== false ||
            stripos($rawBraid, 'cornrow') !== false ||
            preg_match('/protective|cornrows|cornrow/i', $rawBraid)
        );

        // Log computed breakdown for observability (temporary)
        try{
            Log::info('BookingConfirmation breakdown', [
                'booking_id' => $b->id,
                'resolved_base' => $resolvedBase,
                'length_adjust' => $lengthAdjust,
                'addons_total' => $addonsTotal,
                'adjustments_total' => $adjustmentsTotal,
                'computed_total' => $computed_total_final,
                'final_price' => $final_price_to_pass,
                'kb_length' => $b->kb_length ?? null,
                'kb_braid_type' => $b->kb_braid_type ?? null,
                'kb_extras' => $b->kb_extras ?? null,
            ]);
        } catch (\Exception $logEx) {}

        // Determine recipient email when possible so templates can adapt (admin vs customer)
        $recipientEmail = null;
        try{
            if (is_object($notifiable) && method_exists($notifiable, 'routeNotificationFor')) {
                $recipientEmail = $notifiable->routeNotificationFor('mail');
            } elseif (is_object($notifiable) && property_exists($notifiable, 'email')) {
                $recipientEmail = $notifiable->email;
            }
        }catch(\Exception $e){ $recipientEmail = null; }

        $isRecipientOwner = false;
        if ($recipientEmail && !empty($b->email)) {
            try{ $isRecipientOwner = (strtolower(trim($recipientEmail)) === strtolower(trim($b->email))); }catch(\Exception $e){ $isRecipientOwner = false; }
        }

        // Prepare confirmation number (prefer explicit confirmation_code if set)
        $confirmationNumber = $b->confirmation_code ?? ('BK' . str_pad($b->id ?? 0, 6, '0', STR_PAD_LEFT));

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.booking_confirmation', [
                'booking' => $b,
                'basePrice' => $resolvedBase,
                'length_adjust' => $lengthAdjust,
                'addons_total' => $addonsTotal,
                'adjustments_total' => $adjustmentsTotal,
                'selector' => $selector,
                'computedTotal' => $computed_total_final,
                'final_price' => $final_price_to_pass,
                'selector_base' => $baseConfigured ?? null,
                'selector_adjust' => $adjustments ?? null,
                'selector_addons' => $addons ?? null,
                'selector_friendly' => $selector_friendly,
                'hideLengthFinish' => $hideLengthFinish,
                // View-level flags
                'recipient_email' => $recipientEmail,
                'is_recipient_owner' => $isRecipientOwner,
                'showContactInfo' => !$isRecipientOwner, // show name/email/phone when recipient is *not* the booking owner (admin)
                'showHeader' => !$isRecipientOwner, // show the small "Booking Confirmation" header for admin emails only
                'confirmation_number' => $confirmationNumber,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
