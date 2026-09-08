<?php
/**
 * Template Name: Contact
 * Description: صفحه تماس سفارشی برای تم بامبرو
 */

get_header();
?>

<main id="main-content" class="rtl">
    <div class="contact-header">
        <h1>تماس با ما</h1>
        <p>برای ارتباط با بامبرو، فرم زیر را تکمیل کنید یا از اطلاعات تماس استفاده نمایید.</p>
    </div>

    <div class="contact-container">
        <div class="contact-info">
            <h2>اطلاعات تماس</h2>
            <ul>
                <li><strong>آدرس:</strong> تهران، خیابان ولیعصر، پلاک ۱۲۳۴</li>
                <li><strong>تلفن:</strong> ۰۲۱-۱۲۳۴۵۶۷۸</li>
                <li><strong>ایمیل:</strong> info@bambroo.ir</li>
                <li><strong>ساعات کاری:</strong> شنبه تا چهارشنبه: ۸ صبح تا ۵ عصر | پنجشنبه: ۸ صبح تا ۲ ظهر</li>
            </ul>

            <div class="social-media">
                <h3>ما را در شبکه‌های اجتماعی دنبال کنید:</h3>
                <a href="#" class="social-link">اینستاگرام</a>
                <a href="#" class="social-link">تلگرام</a>
                <a href="#" class="social-link">واتساپ</a>
            </div>
        </div>

        <div class="contact-form">
            <h2>فرم تماس</h2>
            <?php
            // نمایش فرم تماس با استفاده از Contact Form 7 یا فرم سفارشی
            if (function_exists('do_shortcode')) {
                echo do_shortcode('[contact-form-7 id="1" title="فرم تماس بامبرو"]');
            } else {
                // فرم سفارشی در صورت عدم نصب Contact Form 7
                echo '<form id="custom-contact-form" method="post" action="">';
                echo '<label for="name">نام و نام خانوادگی:</label>';
                echo '<input type="text" id="name" name="name" required>';

                echo '<label for="email">ایمیل:</label>';
                echo '<input type="email" id="email" name="email" required>';

                echo '<label for="phone">تلفن:</label>';
                echo '<input type="tel" id="phone" name="phone">';

                echo '<label for="subject">موضوع:</label>';
                echo '<input type="text" id="subject" name="subject" required>';

                echo '<label for="message">پیام:</label>';
                echo '<textarea id="message" name="message" required></textarea>';

                echo '<input type="submit" value="ارسال پیام">';
                echo '</form>';
            }
            ?>
        </div>
    </div>

    <div class="contact-map">
        <h2>موقعیت ما روی نقشه</h2>
        <div class="map-placeholder">
            <p>نقشه گوگل یا نقشه سفارشی در اینجا قرار می‌گیرد.</p>
            <!-- می‌توانید از کد زیر برای اضافه کردن نقشه گوگل استفاده کنید -->
            <!-- <iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
        </div>
    </div>
</main>

<?php
get_footer();
?>