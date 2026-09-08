<?php
/**
 * Footer Template
 *
 * @package Bambroo
 */
?>

        </main>
        <footer id="site-footer" class="rtl">
            <div class="container">
                <?php
                // نمایش منوی پاورقی
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'container' => 'nav',
                    'container_class' => 'footer-navigation',
                    'fallback_cb' => false,
                ));
                ?>
                <div class="copyright">
                    <p>&copy; <?php echo date('Y'); ?> فروشگاه بامبرو. تمام حقوق محفوظ است.</p>
                </div>
            </div>
        </footer>
        <?php wp_footer(); ?>
    </body>
</html>