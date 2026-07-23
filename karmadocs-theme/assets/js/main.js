/**
 * KarmaDocs Theme JavaScript
 */

(function () {
    'use strict';

    // Nav scroll effect
    const nav = document.getElementById('nav');
    if (nav) {
        window.addEventListener('scroll', function () {
            nav.classList.toggle('scrolled', window.scrollY > 50);
        });
    }

    // FAQ accordion toggle
    window.toggleFaq = function (btn) {
        const item = btn.closest('.faq-item');
        if (!item) return;

        const answer = item.querySelector('.faq-a');
        const chevron = btn.querySelector('.chevron');
        if (!answer || !chevron) return;

        const isOpen = answer.classList.contains('open');

        // Close all
        document.querySelectorAll('.faq-a').forEach(function (el) {
            el.classList.remove('open');
        });
        document.querySelectorAll('.faq-q .chevron').forEach(function (el) {
            el.style.transform = 'rotate(0deg)';
        });

        // Open clicked if it was closed
        if (!isOpen) {
            answer.classList.add('open');
            chevron.style.transform = 'rotate(180deg)';
        }
    };

    // AJAX form submission
    const form = document.getElementById('heroForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            formData.append('action', 'submit_consultation');
            formData.append('nonce', document.getElementById('karmadocs_nonce').value);

            // Facebook cookies for tracking
            const getCookie = function (name) {
                const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
                return match ? match[2] : '';
            };
            formData.append('_meta_fbp', getCookie('_fbp'));
            formData.append('_meta_fbc', getCookie('_fbc'));

            fetch(form.dataset.ajaxUrl || ajaxurl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData,
            })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (data.success) {
                    form.style.display = 'none';
                    const success = document.getElementById('formSuccess');
                    if (success) success.style.display = 'block';

                    // Facebook Lead event
                    if (typeof fbq === 'function') {
                        fbq('track', 'Lead', {
                            content_name: 'Consultation Request',
                            content_category: 'Mental Health',
                        });
                    }
                } else {
                    alert(data.data.message || 'Something went wrong. Please try again.');
                }
            })
            .catch(function () {
                alert('Something went wrong. Please try again.');
            });
        });
    }

    // Set nonce value from PHP
    const nonceField = document.getElementById('karmadocs_nonce');
    if (nonceField) {
        nonceField.value = karmadocs_ajax ? karmadocs_ajax.nonce : '';
    }
})();
