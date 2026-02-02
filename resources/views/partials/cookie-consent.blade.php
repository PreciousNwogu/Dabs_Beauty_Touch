<!-- Cookie Consent Banner -->
<div id="cookieConsentBanner" class="cookie-consent-banner" style="display: none;">
    <div class="cookie-consent-container">
        <div class="cookie-consent-content">
            <div class="cookie-consent-icon">
                <i class="bi bi-cookie" style="font-size: 1.25rem; color: #ff8533;"></i>
            </div>
            <div class="cookie-consent-text">
                <p class="cookie-consent-message">
                    We use cookies to improve your experience.
                    <a href="{{ route('home') }}#terms" class="cookie-consent-link">Learn more</a>
                </p>
            </div>
            <div class="cookie-consent-buttons">
                <button type="button" class="btn btn-outline-light btn-sm cookie-consent-decline" id="cookieDeclineBtn">
                    Decline
                </button>
                <button type="button" class="btn btn-warning btn-sm cookie-consent-accept" id="cookieAcceptBtn" style="background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%); border: none; color: white; font-weight: 700;">
                    Accept All
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.cookie-consent-banner {
    position: fixed;
    bottom: 12px;
    left: 12px;
    right: 12px;
    margin: 0 auto;
    max-width: 880px;
    background: rgba(3, 15, 104, 0.94);
    backdrop-filter: blur(10px);
    color: white;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
    z-index: 9999;
    padding: 12px 14px;
    transform: translateY(100%);
    transition: transform 0.4s ease-in-out;
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 14px;
}

.cookie-consent-banner.show {
    transform: translateY(0);
    display: block !important;
}

.cookie-consent-container {
    max-width: 1200px;
    margin: 0 auto;
}

.cookie-consent-content {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.cookie-consent-icon {
    flex-shrink: 0;
}

.cookie-consent-text {
    flex: 1;
    min-width: 250px;
}

.cookie-consent-message {
    margin: 0;
    font-size: 0.9rem;
    line-height: 1.35;
    color: rgba(255, 255, 255, 0.88);
}

.cookie-consent-link {
    color: #ff6600;
    text-decoration: underline;
    font-weight: 500;
    transition: color 0.3s;
}

.cookie-consent-link:hover {
    color: #ff8533;
}

.cookie-consent-buttons {
    display: flex;
    gap: 10px;
    flex-shrink: 0;
}

.cookie-consent-buttons .btn {
    padding: 8px 14px;
    border-radius: 10px;
    font-weight: 700;
    transition: all 0.3s;
    white-space: nowrap;
}

.cookie-consent-buttons .btn:hover {
    transform: none;
    box-shadow: none;
}

.cookie-consent-decline {
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
}

.cookie-consent-decline:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.8);
    color: white;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .cookie-consent-banner {
        padding: 10px 12px;
        bottom: 10px;
        left: 10px;
        right: 10px;
    }
    
    .cookie-consent-content {
        flex-direction: row;
        align-items: center;
        gap: 10px;
    }
    
    .cookie-consent-text {
        min-width: 100%;
    }
    
    .cookie-consent-buttons {
        width: 100%;
        flex-direction: row;
        justify-content: flex-end;
    }
    
    .cookie-consent-buttons .btn {
        width: auto;
    }
    
    .cookie-consent-message {
        font-size: 0.85rem;
    }
}

/* Animation for smooth appearance */
@keyframes slideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.cookie-consent-banner.show {
    animation: slideUp 0.4s ease-out;
}
</style>

<script>
(function() {
    'use strict';
    
    // Check if user has already given consent
    function hasConsent() {
        try {
            return localStorage.getItem('cookieConsent') !== null;
        } catch (e) {
            return false;
        }
    }
    
    // Get consent status
    function getConsentStatus() {
        try {
            return localStorage.getItem('cookieConsent');
        } catch (e) {
            return null;
        }
    }
    
    // Set consent status
    function setConsentStatus(status) {
        try {
            localStorage.setItem('cookieConsent', status);
            localStorage.setItem('cookieConsentDate', new Date().toISOString());
        } catch (e) {
            console.warn('Failed to save cookie consent:', e);
        }
    }
    
    // Show banner
    function showBanner() {
        const banner = document.getElementById('cookieConsentBanner');
        if (banner && !hasConsent()) {
            banner.style.display = 'block';
            // Trigger animation after a small delay
            setTimeout(function() {
                banner.classList.add('show');
            }, 10);
        }
    }
    
    // Hide banner
    function hideBanner() {
        const banner = document.getElementById('cookieConsentBanner');
        if (banner) {
            banner.classList.remove('show');
            setTimeout(function() {
                banner.style.display = 'none';
            }, 400);
        }
    }
    
    // Handle accept
    function handleAccept() {
        setConsentStatus('accepted');
        hideBanner();
        // You can trigger analytics or other cookie-dependent scripts here
        console.log('Cookie consent: Accepted');
    }
    
    // Handle decline
    function handleDecline() {
        setConsentStatus('declined');
        hideBanner();
        // You can disable analytics or other cookie-dependent scripts here
        console.log('Cookie consent: Declined');
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        // Only show if consent hasn't been given
        if (!hasConsent()) {
            showBanner();
        }
        
        // Attach event listeners
        const acceptBtn = document.getElementById('cookieAcceptBtn');
        const declineBtn = document.getElementById('cookieDeclineBtn');
        
        if (acceptBtn) {
            acceptBtn.addEventListener('click', handleAccept);
        }
        
        if (declineBtn) {
            declineBtn.addEventListener('click', handleDecline);
        }
    });
})();
</script>

