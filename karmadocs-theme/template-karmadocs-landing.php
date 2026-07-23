<?php
/**
 * Template Name: KarmaDocs Landing
 * Description: Full-width landing page with video hero, stats, consultation form, and FAQ section.
 */

// Inject Meta Pixel into wp_head
add_action('wp_head', function () {
    echo '<!-- Meta Pixel Code -->';
    ?>
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return; n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
            n.queue = []; t = b.createElement(e); t.async = !0;
            t.src = v; s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1943390473007545');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1943390473007545&ev=PageView&noscript=1" /></noscript>
    <?php
    echo '<!-- End Meta Pixel Code -->';
});

get_header();
?>

<!-- HERO -->
<section class="hero">
    <video autoplay muted loop playsinline preload="auto">
        <source src="https://karmadocs.com/wp-content/themes/karmadocs-theme/assets/hero-video.mp4" type="video/mp4">
    </video>

    <div class="hero-inner">
        <div class="hero-grid">
            <!-- Left -->
            <div class="hero-left">
                <div class="badge">
                    <span class="badge-dot"></span>
                    Comprehensive Psychiatric Services
                </div>
                <h1>Compassionate Mental Health <em>Care That Works</em></h1>
                <p class="sub">From advanced TMS therapy and medication management to individual counseling, we
                    offer a full spectrum of psychiatric services tailored to your unique needs. Begin your healing
                    journey today.</p>
                <div class="stats">
                    <div class="st"><span class="st-num">85%</span><span class="st-label">Success Rate</span></div>
                    <div class="st"><span class="st-num">10K+</span><span class="st-label">Patients</span></div>
                    <div class="st"><span class="st-num">4.9</span><span class="st-label">Rating</span></div>
                    <div class="st"><span class="st-num">5+</span><span class="st-label">Services</span></div>
                </div>
            </div>

            <!-- Right: Form -->
            <div class="card" style="margin-top:40px;">
                <h2>Schedule a Consultation</h2>
                <p class="card-sub">We'll reach out within one business day</p>

                <form id="karmadocs-form" accept-charset="UTF-8" data-action="submit_consultation">
                    <div class="fld">
                        <label>Full Name <span class="r">*</span></label>
                        <input type="text" name="name" required placeholder="Your full name">
                    </div>
                    <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div class="fld">
                            <label>Phone Number <span class="r">*</span></label>
                            <input type="tel" name="phone" required placeholder="(555) 000-0000">
                        </div>
                        <div class="fld">
                            <label>Email Address <span class="r">*</span></label>
                            <input type="email" name="email" required placeholder="you@email.com">
                        </div>
                    </div>
                    <div class="fld">
                        <label>What are you seeking help for? <span class="r">*</span></label>
                        <select name="condition" required>
                            <option value="" disabled selected>Select a condition</option>
                            <option value="Depression">Depression</option>
                            <option value="Anxiety">Anxiety Disorders</option>
                            <option value="PTSD">PTSD & Trauma</option>
                            <option value="OCD">OCD</option>
                            <option value="Womens Mood Disorders">Women's Mood Disorders</option>
                            <option value="Stress & Adjustment">Stress & Adjustment</option>
                            <option value="ADHD">ADHD</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="fld">
                        <label>Preferred Location <span class="r">*</span></label>
                        <select name="location" required>
                            <option value="" disabled selected>Choose a clinic</option>
                            <option value="Palm Springs">Palm Springs, CA 92264</option>
                            <option value="Rancho Mirage">Rancho Mirage, CA 92270</option>
                            <option value="Twentynine Palms">Twentynine Palms, CA 92277</option>
                        </select>
                    </div>
                    <div class="fld">
                        <label>Anything else you'd like us to know?</label>
                        <textarea name="message" rows="2"
                            placeholder="Optional — tell us about your situation..."></textarea>
                    </div>

                    <input type="hidden" name="nonce" id="karmadocs-nonce">

                    <button type="submit" class="btn-submit">Get My Free Consultation</button>
                    <p class="trust">No spam. Your information is safe with us.</p>
                </form>

                <div id="formSuccess" style="display:none;text-align:center;padding:40px 0;">
                    <div
                        style="width:48px;height:48px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                        <svg style="width:24px;height:24px;color:#22c55e;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M5 13l4 4L19 7" />
                            </svg>
                    </div>
                    <h3 style="font-size:18px;font-weight:700;color:#1a2b4a;margin-bottom:4px;">Thank You!</h3>
                    <p style="font-size:14px;color:#6b7280;">We'll be in touch shortly.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="faq-section" id="faq-section">
    <div class="faq-wrap">
        <div class="faq-title">
            <h2>Common Questions</h2>
            <p>Everything you need to know about our psychiatric services</p>
        </div>

        <div class="faq-item">
            <button class="faq-q" onclick="toggleFaq(this)">
                <div class="icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg></div>
                <span>What services does KarmaDocs offer?</span>
                <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-a">
                <p>KarmaDocs provides a full spectrum of psychiatric care including TMS therapy, medication
                    management, and individual talk therapy. We treat depression, anxiety disorders, PTSD, OCD,
                    women's mood disorders, stress & adjustment disorders, and ADHD with evidence-based,
                    personalized treatment plans.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" onclick="toggleFaq(this)">
                <div class="icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg></div>
                <span>Does insurance cover your services?</span>
                <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-a">
                <p>Yes. We work with most major insurance providers including Medicare, IEHP, Tricare, Blue Cross
                    Blue Shield, Aetna, and Cigna. Our team handles all benefit verification and pre-authorization
                    for TMS, medication management, and therapy services.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" onclick="toggleFaq(this)">
                <div class="icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg></div>
                <span>What can I expect from my first visit?</span>
                <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-a">
                <p>Your first visit is a comprehensive psychiatric evaluation. Our clinician will review your
                    medical history, current symptoms, and treatment goals to create a personalized care plan —
                    whether that involves therapy, medication, TMS, or a combination.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" onclick="toggleFaq(this)">
                <div class="icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg></div>
                <span>How does medication management work?</span>
                <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-a">
                <p>Our board-certified providers prescribe and monitor psychiatric medications as part of a broader
                    treatment plan. We focus on finding the right medication and dosage with minimal side effects,
                    checking in regularly to ensure your care stays aligned with your goals.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" onclick="toggleFaq(this)">
                <div class="icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg></div>
                <span>When should I seek psychiatric care?</span>
                <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-a">
                <p>You don't have to wait until things feel unmanageable. If you're struggling with persistent
                    sadness, anxiety, racing thoughts, difficulty sleeping, trauma symptoms, or any mental health
                    concern — we're here to help. Early intervention leads to better outcomes.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" onclick="toggleFaq(this)">
                <div class="icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg></div>
                <span>What conditions do you treat?</span>
                <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-a">
                <p>KarmaDocs treats depression, anxiety disorders, PTSD, OCD, women's mood disorders, stress &
                    adjustment disorders, and ADHD. We believe every individual's experience is unique and tailor
                    every treatment plan accordingly.</p>
            </div>
        </div>
    </div>
</section>

<!-- Add this script at the bottom before the closing script tag -->
<script>
    // Set nonce value on page load
    document.getElementById('karmadocs-nonce').value = '<?php echo wp_create_nonce("karmadocs_nonce"); ?>';

    // Handle form submission
    document.getElementById('karmadocs-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('action', 'submit_consultation');
        formData.append('nonce', document.getElementById('karmadocs-nonce').value);

        // Get Facebook cookies
        const getCookie = n => (document.cookie.match(new RegExp('(^| )' + n + '=([^;]+)')) || [])[2] || '';
        formData.append('_meta_fbp', getCookie('_fbp'));
        formData.append('_meta_fbc', getCookie('_fbc'));

        fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.style.display = 'none';
                    document.getElementById('formSuccess').style.display = 'block';
                    // Track Facebook Lead event on client side
                    if (typeof fbq === 'function') {
                        fbq('track', 'Lead', { content_name: 'Consultation Request', content_category: 'Mental Health' });
                    }
                } else {
                    alert(data.data.message || 'Something went wrong. Please try again.');
                }
            })
            .catch(error => {
                alert('Something went wrong. Please try again.');
                console.error('Error:', error);
            });
    });
</script>