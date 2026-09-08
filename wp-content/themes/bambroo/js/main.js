/**
 * Bambroo Theme Main JavaScript File
 * Description: اسکریپت‌های اصلی برای تم بامبرو
 */

// منتظر لود کامل صفحه
jQuery(document).ready(function($) {
    
    // نمایش پیام‌های WooCommerce به صورت مودال
    if ($('.woocommerce-message, .woocommerce-error, .woocommerce-info').length) {
        $('.woocommerce-message, .woocommerce-error, .woocommerce-info').each(function() {
            var message = $(this).text();
            alert(message);
        });
    }

    // افزودن کلاس active به منوی جاری
    $('.main-navigation a').each(function() {
        if ($(this).attr('href') === window.location.href) {
            $(this).addClass('active');
        }
    });

    // اسلایدر برای محصولات پرفروش
    if ($('.products-slider').length) {
        $('.products-slider').slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 4,
            slidesToScroll: 1,
            rtl: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                }
            ]
        });
    }

    // نمایش/مخفی کردن فیلترهای صفحه فروشگاه
    $('.filter-toggle').on('click', function() {
        $('.shop-sidebar').toggleClass('active');
    });

    // تغییر تعداد محصولات نمایش داده شده
    $('.products-per-page select').on('change', function() {
        var value = $(this).val();
        window.location.href = window.location.href.split('?')[0] + '?products_per_page=' + value;
    });

    // اعتبارسنجی فرم تماس
    $('#custom-contact-form').on('submit', function(e) {
        e.preventDefault();
        
        var name = $('#name').val();
        var email = $('#email').val();
        var subject = $('#subject').val();
        var message = $('#message').val();

        if (!name || !email || !subject || !message) {
            alert('لطفاً تمام فیلدهای اجباری را پر کنید.');
            return;
        }

        if (!validateEmail(email)) {
            alert('لطفاً یک آدرس ایمیل معتبر وارد کنید.');
            return;
        }

        // ارسال فرم (در اینجا می‌توانید از AJAX استفاده کنید)
        alert('پیام شما با موفقیت ارسال شد!');
        $(this)[0].reset();
    });

    // اعتبارسنجی ایمیل
    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // نمایش کد رنگ به صورت بصری
    $('.product-color-code span').each(function() {
        var colorCode = $(this).text();
        $(this).css('background-color', colorCode);
        $(this).css('color', getContrastColor(colorCode));
        $(this).css('padding', '0.25rem 0.5rem');
        $(this).css('border-radius', '3px');
    });

    // محاسبه رنگ متضاد برای خوانایی بهتر
    function getContrastColor(hexColor) {
        // تبدیل کد رنگ هگزا به RGB
        var r = parseInt(hexColor.substr(1, 2), 16);
        var g = parseInt(hexColor.substr(3, 2), 16);
        var b = parseInt(hexColor.substr(5, 2), 16);

        // محاسبه درخشندگی
        var brightness = (r * 299 + g * 587 + b * 114) / 1000;

        // بازگشت رنگ متضاد
        return brightness > 128 ? '#000000' : '#FFFFFF';
    }

    // نمایش توضیحات بیشتر/کمتر
    $('.product-description').each(function() {
        var fullText = $(this).text();
        if (fullText.length > 200) {
            var shortText = fullText.substr(0, 200) + '...';
            $(this).html(shortText + '<a href="#" class="read-more">بیشتر بخوانید</a>');
            $(this).append('<span class="full-text" style="display: none;">' + fullText + '</span>');
        }
    });

    // کلیک روی لینک بیشتر بخوانید
    $(document).on('click', '.read-more', function(e) {
        e.preventDefault();
        var fullText = $(this).siblings('.full-text').text();
        $(this).parent().html(fullText + '<a href="#" class="read-less">کمتر بخوانید</a>');
    });

    // کلیک روی لینک کمتر بخوانید
    $(document).on('click', '.read-less', function(e) {
        e.preventDefault();
        var fullText = $(this).parent().text().replace('کمتر بخوانید', '').trim();
        var shortText = fullText.substr(0, 200) + '...';
        $(this).parent().html(shortText + '<a href="#" class="read-more">بیشتر بخوانید</a>');
        $(this).parent().append('<span class="full-text" style="display: none;">' + fullText + '</span>');
    });

    // نمایش پیش‌نمایش تصویر محصول
    $('.product-card img').on('click', function() {
        var imageUrl = $(this).attr('src');
        $('#image-preview').attr('src', imageUrl);
        $('#image-preview-modal').fadeIn();
    });

    // بستن مودال پیش‌نمایش تصویر
    $('#image-preview-modal, #close-preview').on('click', function() {
        $('#image-preview-modal').fadeOut();
    });

    // جلوگیری از بستن مودال با کلیک روی تصویر
    $('#image-preview').on('click', function(e) {
        e.stopPropagation();
    });

    // افزودن مودال پیش‌نمایش تصویر به صفحه
    if (!$('#image-preview-modal').length) {
        $('body').append('\n' +
            '<div id="image-preview-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 9999; justify-content: center; align-items: center;">\n' +
            '    <span id="close-preview" style="position: absolute; top: 20px; right: 20px; color: white; font-size: 30px; cursor: pointer;">&times;</span>\n' +
            '    <img id="image-preview" style="max-width: 90%; max-height: 90%;" src="" alt="پیش‌نمایش">\n' +
            '</div>\n' +
            '');
    }

    // نمایش پیام موفقیت پس از افزودن به سبد خرید
    $(document.body).on('added_to_cart', function() {
        alert('محصول با موفقیت به سبد خرید اضافه شد!');
    });

    // به‌روزرسانی سبد خرید به صورت AJAX
    $(document.body).on('added_to_cart', function() {
        var fragments = {
            'div.widget_shopping_cart_content': 1
        };
        
        $.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: 'woocommerce_get_refreshed_fragments',
                fragments: fragments
            },
            success: function(response) {
                if (response.fragments) {
                    $.each(response.fragments, function(key, value) {
                        $(key).replaceWith(value);
                    });
                }
            }
        });
    });

    // نمایش/مخفی کردن منوی موبایل
    $('.mobile-menu-toggle').on('click', function() {
        $('.main-navigation').toggleClass('mobile-active');
    });

    // بستن منوی موبایل با کلیک روی لینک‌ها
    $('.main-navigation a').on('click', function() {
        if ($(window).width() < 768) {
            $('.main-navigation').removeClass('mobile-active');
        }
    });

    // اسکرول به بالای صفحه
    $('.scroll-to-top').on('click', function() {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
    });

    // نمایش/مخفی کردن دکمه اسکرول به بالا
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });

    // افزودن دکمه اسکرول به بالا به صفحه
    if (!$('.scroll-to-top').length) {
        $('body').append('<a href="#" class="scroll-to-top" style="display: none; position: fixed; bottom: 20px; right: 20px; background-color: #4caf50; color: white; padding: 10px; border-radius: 50%; text-decoration: none; font-size: 20px; z-index: 999;">↑</a>');
    }
});
