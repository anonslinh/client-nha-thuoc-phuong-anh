<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.classList.add('pa-luxury-reveal-ready');

        const selector = [
            '.lc-gallery-card',
            '.lc-info-card',
            '.lc-detail-card',
            '.lc-related-card-wrap',
            '.wc-hero',
            '.wc-card',
            '.fs-hero',
            '.fs-stat-card',
            '.fs-product-card',
            '.fs-session-tab',
            '.lc-maincat-head',
            '.lc-subcat-card',
            '.lc-product-card',
            '.product-card',
            '[class*="product-card"]',
            '[class*="filter-card"]',
            '[class*="info-card"]',
            '[class*="detail-card"]',
            '.lc-footer-top',
            '.lc-footer-grid > *'
        ].join(',');

        const items = Array.from(document.querySelectorAll(selector));
        if (!items.length) return;

        items.forEach(function (item, index) {
            item.classList.add('pa-luxury-reveal');
            item.style.transitionDelay = Math.min(index % 6, 5) * 45 + 'ms';
        });

        const revealVisibleNow = function () {
            const viewportHeight = window.innerHeight || document.documentElement.clientHeight || 0;

            items.forEach(function (item) {
                if (item.classList.contains('pa-luxury-visible')) return;
                const rect = item.getBoundingClientRect();
                if (rect.top < viewportHeight * 0.96 && rect.bottom > 0) {
                    item.classList.add('pa-luxury-visible');
                }
            });
        };

        if (!('IntersectionObserver' in window)) {
            items.forEach(function (item) {
                item.classList.add('pa-luxury-visible');
            });
            return;
        }

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('pa-luxury-visible');
                observer.unobserve(entry.target);
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -70px 0px'
        });

        items.forEach(function (item) {
            observer.observe(item);
        });

        requestAnimationFrame(revealVisibleNow);
        setTimeout(revealVisibleNow, 300);
        setTimeout(revealVisibleNow, 900);
        window.addEventListener('scroll', revealVisibleNow, { passive: true });
        window.addEventListener('resize', revealVisibleNow, { passive: true });
    });
</script>
