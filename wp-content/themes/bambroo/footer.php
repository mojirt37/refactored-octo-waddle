<?php
/**
 * Footer Template for Bambroo Theme
 *
 * @package Bambroo
 */

// Get social media links from theme mods
$facebook_url = get_theme_mod('bambroo_facebook_url', '#');
$instagram_url = get_theme_mod('bambroo_instagram_url', '#');
$telegram_url = get_theme_mod('bambroo_telegram_url', '#');
$whatsapp_number = get_theme_mod('bambroo_whatsapp_number', '989123456789');
$phone_number = get_theme_mod('bambroo_phone_number', '۰۲۱-۱۲۳۴۵۶۷۸');
$email_address = get_theme_mod('bambroo_email_address', 'info@bambroo.ir');
$address = get_theme_mod('bambroo_address', 'تهران، خیابان ولیعصر، پلاک ۱۲۳۴');

?>

        </main>
        
        <!-- Newsletter Section -->
        <section class="newsletter-section" aria-label="خبرنامه">
            <div class="container">
                <div class="newsletter-content">
                    <h2><?php echo esc_html__('برای دریافت آخرین اخبار و تخفیف‌ها، در خبرنامه ما عضو شوید', 'bambroo'); ?></h2>
                    <form class="newsletter-form" method="post" action="">
                        <div class="newsletter-form-group">
                            <label for="newsletter-email" class="sr-only">ایمیل</label>
                            <input type="email" id="newsletter-email" name="email" placeholder="<?php echo esc_attr__('آدرس ایمیل خود را وارد کنید', 'bambroo'); ?>" required aria-required="true" />
                            <button type="submit" class="button">
                                <i class="fas fa-paper-plane"></i> <?php echo esc_html__('عضویت', 'bambroo'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <footer id="site-footer" class="rtl" aria-label="پاورقی">
            <div class="container">
                <!-- Footer Widgets -->
                <div class="footer-widgets">
                    <!-- About Widget -->
                    <div class="footer-widget footer-about">
                        <div class="footer-logo">
                            <?php
                            if (has_custom_logo()) {
                                the_custom_logo();
                            } else {
                                echo '<h3 class="footer-site-title">' . esc_html(get_bloginfo('name')) . '</h3>';
                            }
                            ?>
                        </div>
                        <p><?php echo esc_html__('بامبرو با سال‌ها تجربه در زمینه فروش رنگ و محصولات ساختمانی، آماده ارائه بهترین خدمات به شما مشتریان عزیز است.', 'bambroo'); ?></p>
                        <div class="footer-social">
                            <a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="اینستاگرام">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="<?php echo esc_url($telegram_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="تلگرام">
                                <i class="fab fa-telegram"></i>
                            </a>
                            <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="فیسبوک">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links Widget -->
                    <div class="footer-widget footer-links">
                        <h3><?php echo esc_html__('لینک‌های سریع', 'bambroo'); ?></h3>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html__('خانه', 'bambroo'); ?></a></li>
                            <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php echo esc_html__('فروشگاه', 'bambroo'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>"><?php echo esc_html__('درباره ما', 'bambroo'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>"><?php echo esc_html__('تماس با ما', 'bambroo'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('consultation'))); ?>"><?php echo esc_html__('مشاوره رنگ', 'bambroo'); ?></a></li>
                        </ul>
                    </div>

                    <!-- Customer Service Widget -->
                    <div class="footer-widget footer-service">
                        <h3><?php echo esc_html__('خدمات مشتریان', 'bambroo'); ?></h3>
                        <ul>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span><?php echo esc_html__('تلفن:', 'bambroo'); ?> <?php echo esc_html($phone_number); ?></span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span><?php echo esc_html__('ایمیل:', 'bambroo'); ?> <?php echo esc_html($email_address); ?></span>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo esc_html__('آدرس:', 'bambroo'); ?> <?php echo esc_html($address); ?></span>
                            </li>
                        </ul>
                        <div class="footer-working-hours">
                            <i class="fas fa-clock"></i>
                            <span><?php echo esc_html__('ساعات کاری: شنبه تا چهارشنبه ۸ صبح تا ۵ عصر', 'bambroo'); ?></span>
                        </div>
                    </div>

                    <!-- My Account Widget -->
                    <div class="footer-widget footer-account">
                        <h3><?php echo esc_html__('حساب کاربری', 'bambroo'); ?></h3>
                        <ul>
                            <?php if (is_user_logged_in()) : ?>
                                <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"><?php echo esc_html__('داشبورد', 'bambroo'); ?></a></li>
                                <li><a href="<?php echo esc_url(wc_get_page_permalink('edit-account')); ?>"><?php echo esc_html__('ویرایش حساب', 'bambroo'); ?></a></li>
                                <li><a href="<?php echo esc_url(wc_get_page_permalink('orders')); ?>"><?php echo esc_html__('سفارش‌ها', 'bambroo'); ?></a></li>
                                <li><a href="<?php echo esc_url(wc_get_page_permalink('customer-logout')); ?>"><?php echo esc_html__('خروج', 'bambroo'); ?></a></li>
                            <?php else : ?>
                                <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"><?php echo esc_html__('ورود / ثبت‌نام', 'bambroo'); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <!-- Footer Bottom -->
                <div class="footer-bottom">
                    <div class="footer-copyright">
                        <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. <?php echo esc_html__('تمام حقوق محفوظ است.', 'bambroo'); ?></p>
                    </div>
                    <div class="footer-payment-methods">
                        <span><?php echo esc_html__('روش‌های پرداخت:', 'bambroo'); ?></span>
                        <div class="payment-methods">
                            <img src="<?php echo esc_url(BAMBROO_THEME_DIR . '/images/payment-zarinpal.png'); ?>" alt="زرین‌پال" />
                            <img src="<?php echo esc_url(BAMBROO_THEME_DIR . '/images/payment-bank.png'); ?>" alt="پرداخت آنلاین" />
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        
        <!-- Floating WhatsApp Button -->
        <a href="https://wa.me/<?php echo esc_attr($whatsapp_number); ?>" class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="تماس با واتساپ">
            <i class="fab fa-whatsapp"></i>
        </a>
        
        <!-- Scroll to Top Button -->
        <a href="#" class="scroll-to-top" aria-label="برو به بالای صفحه">
            <i class="fas fa-chevron-up"></i>
        </a>

        <?php wp_footer(); ?>
    </body>
</html>