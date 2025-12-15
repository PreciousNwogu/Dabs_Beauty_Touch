<?php

namespace App\Helpers;

use Illuminate\Support\HtmlString;

class SocialLinks
{
    /**
     * Render social links with inline SVG icons suitable for emails.
     */
    public static function render(): HtmlString
    {
        $instagramSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0b3a66" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.5" y2="6.5"></line></svg>';

        $whatsappSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0b3a66" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-2.54 5.93L21 21l-3.57-2.33A8.5 8.5 0 1 1 21 11.5z"></path><path d="M17.5 14.5c-.4-.2-2.3-1.1-2.7-1.2-.4-.2-.7-.2-.9.2l-.6 1.1c-.2.4-.6.5-1 .4-1.1-.3-4.1-2.4-4.1-4.5 0-1.2.6-2.1 1.3-2.6.3-.2.6-.2.9-.1.3.1.7.3 1 .6.3.2.6.3.9.1.3-.1.8-.3 1.5-.2.6.1 1.9.7 2.3.8.4.1.7.2.8.4.1.3 0 .6-.2.9-.2.3-.6.8-.8 1-.3.3-.6.5-.4.9.2.4 1.1 1.8 1.3 2 .2.2.3.3.2.6-.1.3-.7.9-1.1 1z"></path></svg>';

        $instaLink = '<a href="https://www.instagram.com/dabs_beauty_touch" target="_blank" rel="noopener noreferrer" style="margin-right:12px;text-decoration:none;">' . $instagramSvg . ' <span style="font-size:13px;color:#0b3a66;vertical-align:middle;margin-left:6px;">Instagram</span></a>';

        $waLink = '<a href="https://wa.me/13432548848" target="_blank" rel="noopener noreferrer" style="text-decoration:none;">' . $whatsappSvg . ' <span style="font-size:13px;color:#0b3a66;vertical-align:middle;margin-left:6px;">WhatsApp</span></a>';

        $html = '<p style="margin:8px 0 0 0;color:#6c757d;">' . $instaLink . $waLink . '</p>';

        return new HtmlString($html);
    }
}
