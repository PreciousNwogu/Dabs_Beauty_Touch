/**
 * Test script to reproduce and diagnose the modal freeze issue
 * Run with: node tools/test_modal_freeze.js
 */

const puppeteer = require('puppeteer');

(async () => {
    console.log('🚀 Starting modal freeze diagnostic test...\n');
    
    const browser = await puppeteer.launch({
        headless: false, // Keep browser visible to see the issue
        devtools: true,  // Open DevTools automatically
        defaultViewport: { width: 1280, height: 800 }
    });

    try {
        const page = await browser.newPage();
        
        // Listen for console messages
        page.on('console', msg => {
            const type = msg.type();
            const text = msg.text();
            console.log(`[Browser ${type}]:`, text);
        });

        // Navigate to local site
        console.log('📍 Navigating to http://127.0.0.1:8000...');
        await page.goto('http://127.0.0.1:8000', { waitUntil: 'networkidle2' });
        console.log('✅ Page loaded\n');

        // Wait a bit for any animations
        await page.waitForTimeout(2000);

        // Find and click a Knotless Braids service card
        console.log('🔍 Looking for Knotless Braids service card...');
        
        // Try multiple selectors to find the service card
        const cardClicked = await page.evaluate(() => {
            // Look for card with "Knotless Braids" text
            const cards = Array.from(document.querySelectorAll('.card, .service-card, [class*="card"]'));
            const knotlessCard = cards.find(card => {
                const text = card.textContent || '';
                return text.toLowerCase().includes('knotless braids') || 
                       text.toLowerCase().includes('knotless');
            });
            
            if (knotlessCard) {
                console.log('Found Knotless Braids card, clicking...');
                knotlessCard.click();
                return true;
            }
            
            // Try finding button/link with onclick or data attributes
            const buttons = Array.from(document.querySelectorAll('button, a, .clickable, [onclick]'));
            const knotlessBtn = buttons.find(btn => {
                const text = btn.textContent || '';
                const onclick = btn.getAttribute('onclick') || '';
                return text.toLowerCase().includes('knotless') || 
                       onclick.toLowerCase().includes('knotless');
            });
            
            if (knotlessBtn) {
                console.log('Found Knotless Braids button, clicking...');
                knotlessBtn.click();
                return true;
            }
            
            return false;
        });

        if (!cardClicked) {
            console.error('❌ Could not find Knotless Braids card');
            await browser.close();
            return;
        }

        console.log('✅ Clicked Knotless Braids card\n');
        
        // Wait for size/length modal to appear
        console.log('⏳ Waiting for size/length modal...');
        await page.waitForSelector('#serviceSizeLengthModal.show', { timeout: 5000 });
        console.log('✅ Size/length modal appeared\n');
        
        await page.waitForTimeout(1000);

        // Select size and length options
        console.log('📝 Selecting size and length options...');
        await page.evaluate(() => {
            // Select first available size option
            const sizeRadios = document.querySelectorAll('#serviceSizeLengthModal input[name*="size"]');
            if (sizeRadios.length > 0) {
                sizeRadios[0].click();
                console.log('Selected size option');
            }

            // Select first available length option
            const lengthRadios = document.querySelectorAll('#serviceSizeLengthModal input[name*="length"]');
            if (lengthRadios.length > 0) {
                lengthRadios[0].click();
                console.log('Selected length option');
            }
        });

        await page.waitForTimeout(500);

        // Capture state BEFORE clicking Continue
        console.log('\n📊 STATE BEFORE "Continue to Booking":\n');
        const stateBefore = await page.evaluate(() => {
            return {
                backdrops: document.querySelectorAll('.modal-backdrop').length,
                visibleModals: Array.from(document.querySelectorAll('.modal.show')).map(m => m.id),
                bodyModalOpen: document.body.classList.contains('modal-open'),
                bodyPaddingRight: document.body.style.paddingRight,
                activeElement: {
                    tag: document.activeElement?.tagName,
                    id: document.activeElement?.id,
                    className: document.activeElement?.className
                }
            };
        });
        console.log(JSON.stringify(stateBefore, null, 2));

        // Click "Continue to Booking" button
        console.log('\n🖱️ Clicking "Continue to Booking" button...');
        await page.click('#continueToBookingBtn');
        
        // Wait a bit for transition
        await page.waitForTimeout(2000);

        // Capture state AFTER clicking Continue
        console.log('\n📊 STATE AFTER "Continue to Booking":\n');
        const stateAfter = await page.evaluate(() => {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            const modals = document.querySelectorAll('.modal.show');
            
            return {
                backdrops: backdrops.length,
                backdropDetails: Array.from(backdrops).map((b, i) => ({
                    index: i,
                    className: b.className,
                    zIndex: window.getComputedStyle(b).zIndex,
                    pointerEvents: window.getComputedStyle(b).pointerEvents
                })),
                visibleModals: Array.from(modals).map(m => ({
                    id: m.id,
                    ariaHidden: m.getAttribute('aria-hidden'),
                    display: window.getComputedStyle(m).display,
                    zIndex: window.getComputedStyle(m).zIndex
                })),
                bodyModalOpen: document.body.classList.contains('modal-open'),
                bodyPaddingRight: document.body.style.paddingRight,
                bodyOverflow: document.body.style.overflow,
                bodyDataBsPaddingRight: document.body.getAttribute('data-bs-padding-right'),
                activeElement: {
                    tag: document.activeElement?.tagName,
                    id: document.activeElement?.id,
                    className: document.activeElement?.className
                },
                bookingModalVisible: document.querySelector('#bookingModal')?.classList.contains('show'),
                sizeModalVisible: document.querySelector('#serviceSizeLengthModal')?.classList.contains('show')
            };
        });
        console.log(JSON.stringify(stateAfter, null, 2));

        // Check for console errors
        console.log('\n🔍 Checking console for errors...');
        
        // Test if UI is frozen by trying to click elements
        console.log('\n🖱️ Testing if clicks are blocked...');
        const clickTest = await page.evaluate(() => {
            let results = [];
            
            // Test clicking body
            try {
                const bodyClickable = window.getComputedStyle(document.body).pointerEvents !== 'none';
                results.push(`Body pointer-events: ${window.getComputedStyle(document.body).pointerEvents}`);
            } catch (e) {
                results.push(`Body click test error: ${e.message}`);
            }

            // Test clicking backdrop
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach((backdrop, i) => {
                const style = window.getComputedStyle(backdrop);
                results.push(`Backdrop ${i} - display: ${style.display}, pointerEvents: ${style.pointerEvents}, zIndex: ${style.zIndex}`);
            });

            // Check if booking modal opened
            const bookingModal = document.getElementById('bookingModal');
            if (bookingModal) {
                results.push(`Booking modal state: show=${bookingModal.classList.contains('show')}, aria-hidden=${bookingModal.getAttribute('aria-hidden')}`);
            }

            return results;
        });
        console.log(clickTest.join('\n'));

        // Get console errors from page
        console.log('\n📋 Console Messages Summary:');
        console.log('(Check browser DevTools for complete stack traces)');

        // Keep browser open for manual inspection
        console.log('\n✨ Test complete! Browser will remain open for 30 seconds for manual inspection...');
        console.log('Press Ctrl+C to close immediately.\n');
        
        await page.waitForTimeout(30000);

    } catch (error) {
        console.error('\n❌ Test failed with error:', error);
    } finally {
        await browser.close();
        console.log('Browser closed.');
    }
})();
