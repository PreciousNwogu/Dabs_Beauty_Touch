<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleSwitchTest extends TestCase
{
    public function test_switching_to_french_translates_nav_and_cookie_banner(): void
    {
        $this->from(route('login'))
            ->get(route('locale.switch', 'fr'))
            ->assertRedirect(route('login'))
            ->assertSessionHas('locale', 'fr')
            ->assertCookie('locale', 'fr');

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('<html lang="fr"', false)
            ->assertSee('content="fr_CA"', false)
            ->assertSee('Accueil')
            ->assertSee('Prendre rendez-vous')
            ->assertSee('Nous utilisons des témoins pour améliorer votre expérience.')
            ->assertSee('En savoir plus')
            ->assertSee('Tous droits réservés.');
    }

    public function test_french_locale_translates_terms_and_homepage_copy(): void
    {
        $this->from(route('login'))->get(route('locale.switch', 'fr'));

        $this->get(route('login'))
            ->assertSee('Conditions');

        app()->setLocale('fr');
        $terms = view('partials.terms-content')->render();
        $this->assertStringContainsString('Conditions générales', $terms);
        $this->assertStringContainsString('Dépôt et paiement', $terms);
        $this->assertSame('Pourquoi DBT', __('home.why.title'));
        $this->assertSame('Nos services', __('home.services.title'));
        $this->assertSame('Questions fréquentes', __('home.faq.title'));
        $this->assertSame('Réservez votre rendez-vous', __('booking.page_title'));
        $this->assertSame('Sélecteur de tresses enfants', __('kids.heading'));
        $this->assertSame('Avant de venir', __('kids.prep.title'));
        $this->assertSame('Veuillez choisir un type de tresses avant de continuer.', __('kids.js.choose_braid'));
        $this->assertSame('Style protecteur sur cheveux naturels. Sans extensions.', __('kids.cards.protective'));
        $this->assertSame('Styles de tresses doux et amusants pour enfants — knotless, cornrows et plus.', __('home.services.kids_desc'));
    }

    public function test_french_locale_translates_kids_selector_page(): void
    {
        $this->from(route('kids.selector'))->get(route('locale.switch', 'fr'));

        $this->get(route('kids.selector'))
            ->assertOk()
            ->assertSee('<html lang="fr"', false)
            ->assertSee('Sélecteur de tresses enfants')
            ->assertSee('Avant de venir')
            ->assertSee('Choisir le type de tresses')
            ->assertSee('Continuer vers la réservation')
            ->assertSee('Réservation enfants')
            ->assertSee('Prénom de l’enfant')
            ->assertSee('Style protecteur sur cheveux naturels. Sans extensions.');
    }

    public function test_switching_back_to_english_restores_nav_copy(): void
    {
        $this->from(route('login'))->get(route('locale.switch', 'fr'));
        $this->from(route('login'))->get(route('locale.switch', 'en'))
            ->assertSessionHas('locale', 'en');

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('<html lang="en"', false)
            ->assertSee('content="en_CA"', false)
            ->assertSee('>Home</a>', false)
            ->assertSee('Book Appointment')
            ->assertDontSee('Accueil');
    }

    public function test_unsupported_locale_is_not_found(): void
    {
        $this->get(route('locale.switch', 'de'))->assertNotFound();
    }
}
