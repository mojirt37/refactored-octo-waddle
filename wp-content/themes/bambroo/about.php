<?php
/**
 * Template Name: About
 * Description: صفحه درباره ما سفارشی برای تم بامبرو
 */

get_header();
?>

<main id="main-content" class="rtl">
    <div class="about-header">
        <h1>درباره بامبرو</h1>
        <p>مرجع رنگ و محصولات ساختمانی در ایران</p>
    </div>

    <div class="about-container">
        <div class="about-content">
            <h2>داستان ما</h2>
            <p>
                بامبرو با سال‌ها تجربه در زمینه فروش رنگ و محصولات ساختمانی، در سال ۱۳۸۵ تأسیس شد. 
                ما با هدف ارائه بهترین محصولات و خدمات به مشتریان عزیز، همواره در حال بهبود و نوآوری بوده‌ایم. 
                امروزه، بامبرو به عنوان یکی از معتبرترین فروشگاه‌های اینترنتی در حوزه رنگ و محصولات ساختمانی شناخته می‌شود.
            </p>

            <h2>مأموریت ما</h2>
            <p>
                مأموریت ما در بامبرو، ارائه محصولات با کیفیت بالا و خدمات استثنایی به مشتریان است. 
                ما معتقدیم که رنگ و محصولات ساختمانی نقش مهمی در زیبایی و دوام ساختمان‌ها ایفا می‌کنند، 
                و به همین دلیل، همواره در تلاش هستیم تا بهترین محصولات را با مناسب‌ترین قیمت‌ها به شما ارائه دهیم.
            </p>

            <h2>چرا بامبرو؟</h2>
            <ul class="about-features">
                <li><strong>کیفیت بالا:</strong> تمام محصولات ما از برندهای معتبر و با کیفیت بالا هستند.</li>
                <li><strong>قیمت مناسب:</strong> ما همواره سعی می‌کنیم بهترین قیمت‌ها را به شما ارائه دهیم.</li>
                <li><strong>تحویل سریع:</strong> سفارشات شما در سریع‌ترین زمان ممکن تحویل داده می‌شوند.</li>
                <li><strong>مشاوره رایگان:</strong> تیم ما آماده ارائه مشاوره رایگان در مورد انتخاب رنگ و محصولات است.</li>
                <li><strong>پشتیبانی ۲۴/۷:</strong> ما در تمام ساعات شبانه‌روز آماده پاسخگویی به سوالات شما هستیم.</li>
            </ul>
        </div>

        <div class="about-images">
            <div class="about-image">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/about-1.jpg'); ?>" alt="تیم بامبرو">
                <p>تیم حرفه‌ای بامبرو</p>
            </div>
            <div class="about-image">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/about-2.jpg'); ?>" alt="محصولات بامبرو">
                <p>محصولات با کیفیت</p>
            </div>
            <div class="about-image">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/about-3.jpg'); ?>" alt="انبار بامبرو">
                <p>انبار مدرن</p>
            </div>
        </div>
    </div>

    <div class="about-team">
        <h2>تیم ما</h2>
        <div class="team-members">
            <div class="team-member">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/team-1.jpg'); ?>" alt="مدیر عامل">
                <h3>مدیر عامل</h3>
                <p>فرشاد کرمی</p>
            </div>
            <div class="team-member">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/team-2.jpg'); ?>" alt="مدیر فروش">
                <h3>مدیر فروش</h3>
                <p>مهدی محمدی</p>
            </div>
            <div class="team-member">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/team-3.jpg'); ?>" alt="کارشناس فنی">
                <h3>کارشناس فنی</h3>
                <p>رضا کریمی</p>
            </div>
        </div>
    </div>

    <div class="about-partners">
        <h2>همکاران ما</h2>
        <div class="partners-logos">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/partner-1.png'); ?>" alt="همکار ۱">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/partner-2.png'); ?>" alt="همکار ۲">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/partner-3.png'); ?>" alt="همکار ۳">
        </div>
    </div>
</main>

<?php
get_footer();
?>