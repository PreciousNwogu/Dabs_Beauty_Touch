<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class AdminBookingNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
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
        $formattedId = 'BK' . str_pad($b->id, 6, '0', STR_PAD_LEFT);

        $subject = "New Booking received: {$formattedId}";

        // extract selector and compute kids total if available
        $selector = null;
        if(!empty($b->notes) && preg_match('/Selector:\s*(\{.*\})/s', $b->notes, $m)){
            try{ $selector = json_decode($m[1], true); }catch(\Exception $e){ $selector = null; }
        }

        $computedTotal = null;
        try{
            $serviceType = strtolower((string) ($b->service_type ?? $b->service ?? ''));
            if($serviceType === 'kids-braids' || stripos($b->service ?? '', 'kids') !== false || $selector){
                $baseConfigured = (float) (config('service_prices.kids_braids', 80));
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

                if($ex){
                    $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
                    if(is_string($ex) && strpos($ex,'kb_add_')!==false){
                        foreach(explode(',', $ex) as $it){ $it = trim($it); if(isset($addonMap[$it])) $addons += $addonMap[$it]; }
                    } else if(is_string($ex) && preg_match('/^\d+(?:\.\d+)?(,\d+(?:\.\d+)?)*$/', $ex)){
                        foreach(explode(',', $ex) as $n){ $addons += floatval($n); }
                    }
                }

                $computedTotal = round($baseConfigured + $adjustments + $addons, 2);
            }
        }catch(\Exception $e){ /* noop */ }

        // Build friendly labels for selector values for admin email
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
            $friendlyFinish = ['none' => '—','sleek' => 'Sleek finish','natural' => 'Natural finish','curled' => 'With curl','plain' => 'Without curl'];
            $friendlyLength = ['short' => 'Short','neck' => 'Neck','mid_back' => 'Mid Back','waist' => 'Waist','long' => 'Long'];
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

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.admin_booking_notification', [
                'booking' => $b,
                'formattedId' => $formattedId,
                'selector' => $selector,
                'computedTotal' => $computedTotal,
                'selector_base' => $baseConfigured ?? null,
                'selector_adjust' => $adjustments ?? null,
                'selector_addons' => $addons ?? null,
                'selector_friendly' => $selector_friendly,
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
