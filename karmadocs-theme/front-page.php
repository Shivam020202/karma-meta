<?php
/**
 * Front Page Template
 *
 * @package KarmaDocs
 */

get_header(); ?>

<!-- HERO -->
<section class="hero">
    <video autoplay muted loop playsinline preload="auto">
        <source src="<?php echo esc_url(get_theme_mod('karmadocs_hero_video', 'https://karmadocs.com/wp-content/themes/karmadocs-theme/assets/hero-video.mp4')); ?>"
            type="video/mp4">
    </video>

    <div class="hero-inner">
        <div class="hero-grid">
            <!-- Left -->
            <div class="hero-left">
                <div class="badge">
                    <span class="badge-dot"></span>
                    <?php echo esc_html(get_theme_mod('karmadocs_badge_text', 'Comprehensive Psychiatric Services')); ?>
                </div>
                <h1><?php echo wp_kses_post(get_theme_mod('karmadocs_headline', 'Compassionate Mental Health <em>Care That Works</em>')); ?></h1>
                <p class="sub"><?php echo esc_html(get_theme_mod('karmadocs_subheading', 'From advanced TMS therapy and medication management to individual counseling, we offer a full spectrum of psychiatric services tailored to your unique needs. Begin your healing journey today.')); ?></p>
                <div class="stats">
                    <?php
                    $stats = karmadocs_get_stats();
                    ?>
                    <?php foreach ($stats as $stat): ?>
                    <div class="st"><span class="st-num"><?php echo esc_html($stat['value']); ?></span><span class="st-label"><?php echo esc_html($stat['label']); ?></span></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right: Form -->
            <div class="card" style="margin-top:40px;">
                <h2><?php echo esc_html(get_theme_mod('karmadocs_form_title', 'Schedule a Consultation')); ?></h2>
                <p class="card-sub"><?php echo esc_html(get_theme_mod('karmadocs_form_subtitle', 'We\'ll reach out within one business day')); ?></p>

                <form id="heroForm" accept-charset="UTF-8">
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

                    <input type="hidden" name="nonce" id="karmadocs_nonce">

                    <button type="submit" class="btn-submit"><?php echo esc_html(get_theme_mod('karmadocs_form_submit_text', 'Get My Free Consultation')); ?></button>
                    <p class="trust"><?php echo esc_html(get_theme_mod('karmadocs_form_trust_text', 'No spam. Your information is safe with us.')); ?></p>
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
            <h2><?php echo esc_html(get_theme_mod('karmadocs_faq_title', 'Common Questions')); ?></h2>
            <p><?php echo esc_html(get_theme_mod('karmadocs_faq_subtitle', 'Everything you need to know about our psychiatric services')); ?></p>
        </div>

        <?php
        $faqs = karmadocs_get_faqs();

        foreach ($faqs as $index => $faq):
        ?>
        <div class="faq-item">
            <button class="faq-q" onclick="toggleFaq(this)">
                <div class="icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg></div>
                <span><?php echo esc_html($faq['question']); ?></span>
                <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-a">
                <p><?php echo esc_html($faq['answer']); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php get_footer(); ?>
