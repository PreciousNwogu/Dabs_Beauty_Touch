<!-- Cookie Consent Banner -->
<div id="cookieConsentBanner" class="cookie-consent-banner" style="display: none;">
    <div class="cookie-consent-container">
        <div class="cookie-consent-content">
            <div class="cookie-consent-icon">
                <i class="bi bi-cookie" style="font-size: 1rem; color: #ff6600;"></i>
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
                <button type="button" class="btn btn-warning btn-sm cookie-consent-accept" id="cookieAcceptBtn">
                    Accept
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.cookie-consent-banner {
    position: fixed;
    bottom: 16px;
    left: 16px;
    right: auto;
    max-width: 420px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    color: #333;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    z-index: 9999;
    padding: 10px 12px;
    transform: translateX(-120%);
    transition: transform 0.35s ease-in-out;
    border: 1px solid rgba(0, 0, 0, 0.06);
    border-radius: 8px;
}

.cookie-consent-banner.show {
    transform: translateX(0);
    display: block !important;
}

.cookie-consent-container {
    max-width: 100%;
    margin: 0 auto;
}

.cookie-consent-content {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: nowrap;
}

.cookie-consent-icon {
    flex-shrink: 0;
}

.cookie-consent-text {
    flex: 1;
    min-width: 0;
}

.cookie-consent-message {
    margin: 0;
    font-size: 0.8rem;
    line-height: 1.3;
    color: #555;
}

.cookie-consent-link {
    color: #030f68;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
    border-bottom: 1px solid #030f68;
}

.cookie-consent-link:hover {
    color: #ff6600;
    border-bottom-color: #ff6600;
}

.cookie-consent-buttons {
    display: flex;
    gap: 6px;
    flex-shrink: 0;
}

.cookie-consent-buttons .btn {
    padding: 5px 10px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    transition: all 0.2s;
    white-space: nowrap;
}

.cookie-consent-buttons .btn:hover {
    transform: none;
    box-shadow: none;
}

.cookie-consent-decline {
    border-color: #d0d0d0;
    color: #666;
    background: transparent;
}

.cookie-consent-decline:hover {
    background: #f5f5f5;
    border-color: #999;
    color: #333;
}

.cookie-consent-accept {
    background: #ff6600 !important;
    border: none !important;
    color: white !important;
}

.cookie-consent-accept:hover {
    background: #ff7722 !important;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .cookie-consent-banner {
        padding: 8px 10px;
        bottom: 12px;
        left: 12px;
        right: 12px;
        max-width: none;
    }
    
    .cookie-consent-content {
        flex-wrap: wrap;
        gap: 6px;
    }
    
    .cookie-consent-icon {
        display: none;
    }
    
    .cookie-consent-text {
        width: 100%;
        margin-bottom: 4px;
    }
    
    .cookie-consent-buttons {
        width: 100%;
        justify-content: flex-end;
    }
    
    .cookie-consent-buttons .btn {
        font-size: 0.75rem;
        padding: 4px 9px;
    }
    
    .cookie-consent-message {
        font-size: 0.75rem;
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

