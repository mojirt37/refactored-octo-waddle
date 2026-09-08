<?php
/**
 * Template Name: Bambroo Homepage
 * Description: صفحه اصلی تم بامبرو
 */

get_header();
?>

<main id="main-content" class="rtl">
    <section class="hero">
        <h1>به فروشگاه بامبرو خوش آمدید</h1>
        <p>مرجع رنگ و محصولات ساختمانی در ایران</p>
    </section>

    <section class="products">
        <h2>محصولات پرفروش</h2>
        <?php
        // نمایش محصولات پرفروش
        echo do_shortcode('[products limit="4" columns="4" orderby="popularity"]');
        ?>
    </section>

    <section class="about">
        <h2>درباره بامبرو</h2>
        <p>بامبرو با سال‌ها تجربه در زمینه فروش رنگ و محصولات ساختمانی، آماده ارائه بهترین خدمات به شما مشتریان عزیز است.</p>
    </section>
</main>

<?php
get_footer();
?>