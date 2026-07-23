<!-- FOOTER -->
<footer class="footer">
    <div class="footer-inner">
        <img src="<?php echo esc_url(get_theme_mod('karmadocs_logo', 'https://res.cloudinary.com/de4kw1t2i/image/upload/v1766060387/Karma-Docs-Logo-Horizental_w48ja1.webp')); ?>"
            alt="<?php bloginfo('name'); ?>" style="height:64px;">
        <p><?php echo esc_html(get_theme_mod('karmadocs_footer_text', 'Comprehensive psychiatric care in Palm Springs, CA — from TMS therapy and medication management to talk therapy for depression, anxiety, and more.')); ?></p>
        <span class="copy">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</span>
    </div>
</footer>

<?php wp_footer(); ?>

<script>
    const nav = document.getElementById('nav');
    window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 50));

    function toggleFaq(btn) {
        const a = btn.closest('.faq-item').querySelector('.faq-a');
        const ch = btn.querySelector('.chevron');
        const open = a.classList.contains('open');
        document.querySelectorAll('.faq-a').forEach(x => x.classList.remove('open'));
        document.querySelectorAll('.faq-q .chevron').forEach(x => x.style.transform = 'rotate(0deg)');
        if (!open) { a.classList.add('open'); ch.style.transform = 'rotate(180deg)'; }
    }

    // AJAX Form submission
    document.getElementById('heroForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('action', 'submit_consultation');
        formData.append('nonce', document.getElementById('karmadocs_nonce').value);

        // Handle Facebook cookies
        const gc = n => (document.cookie.match(new RegExp('(^| )' + n + '=([^;]+)')) || [])[2] || '';
        formData.append('_meta_fbp', gc('_fbp'));
        formData.append('_meta_fbc', gc('_fbc'));

        fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('heroForm').style.display = 'none';
                document.getElementById('formSuccess').style.display = 'block';
            } else {
                alert(data.data.message || 'Something went wrong. Please try again.');
            }
        })
        .catch(error => {
            alert('Something went wrong. Please try again.');
            console.error('Error:', error);
        });
    });

    // Set nonce value on page load
    document.getElementById('karmadocs_nonce').value = '<?php echo wp_create_nonce("karmadocs_nonce"); ?>';
</script>
</body>

</html>
