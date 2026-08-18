<li class="nav-item d-flex align-items-center locale-switcher px-2" role="group" aria-label="{{ __('nav.language') }}">
    <a class="nav-link px-2{{ app()->getLocale() === 'en' ? ' fw-bold' : '' }}"
       href="{{ route('locale.switch', 'en') }}"
       lang="en"
       hreflang="en"
       @if (app()->getLocale() === 'en') aria-current="true" @endif
       style="{{ app()->getLocale() === 'en' ? 'color:#ff6600;' : 'opacity:0.7;' }}">EN</a>
    <span class="text-muted px-1" aria-hidden="true">|</span>
    <a class="nav-link px-2{{ app()->getLocale() === 'fr' ? ' fw-bold' : '' }}"
       href="{{ route('locale.switch', 'fr') }}"
       lang="fr"
       hreflang="fr"
       @if (app()->getLocale() === 'fr') aria-current="true" @endif
       style="{{ app()->getLocale() === 'fr' ? 'color:#ff6600;' : 'opacity:0.7;' }}">FR</a>
</li>
