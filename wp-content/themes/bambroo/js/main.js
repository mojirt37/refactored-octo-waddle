/**
 * Bambroo Theme Main JavaScript File
 * Description: اسکریپت‌های اصلی برای تم بامبرو
 */

jQuery(document).ready(function($) {
    // Display WooCommerce messages as alerts
    if ($('.woocommerce-message, .woocommerce-error, .woocommerce-info').length) {
        $('.woocommerce-message, .woocommerce-error, .woocommerce-info').each(function() {
            var message = $(this).text().trim();
            if (message) {
                alert(message);
            }
        });
    }

    // Add active class to current menu item
    $('.main-navigation a').each(function() {
        if ($(this).attr('href') === window.location.href) {
            $(this).addClass('active');
        }
    });

    // Mobile menu toggle
    $('.mobile-menu-toggle').on('click', function() {
        $('.main-navigation').toggleClass('mobile-active');
    });

    // Close mobile menu when clicking on a link
    $('.main-navigation a').on('click', function() {
        if ($(window).width() < 768) {
            $('.main-navigation').removeClass('mobile-active');
        }
    });

    // Scroll to top button
    $('.scroll-to-top').on('click', function() {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
    });

    // Show/hide scroll to top button
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });

    // Add scroll to top button to the page
    if (!$('.scroll-to-top').length) {
        $('body').append('<a href="#" class="scroll-to-top" style="display: none; position: fixed; bottom: 20px; right: 20px; background-color: #4caf50; color: white; padding: 10px; border-radius: 50%; text-decoration: none; font-size: 20px; z-index: 999;">↑</a>');
    }

    // Display product color code visually
    $('.product-color-code span').each(function() {
        var colorCode = $(this).text();
        $(this).css('background-color', colorCode);
        $(this).css('color', getContrastColor(colorCode));
        $(this).css('padding', '0.25rem 0.5rem');
        $(this).css('border-radius', '3px');
    });

    // Calculate contrast color for better readability
    function getContrastColor(hexColor) {
        var r = parseInt(hexColor.substr(1, 2), 16);
        var g = parseInt(hexColor.substr(3, 2), 16);
        var b = parseInt(hexColor.substr(5, 2), 16);
        var brightness = (r * 299 + g * 587 + b * 114) / 1000;
        return brightness > 128 ? '#000000' : '#FFFFFF';
    }

    // Show success message after adding to cart
    $(document.body).on('added_to_cart', function() {
        alert('محصول با موفقیت به سبد خرید اضافه شد!');
    });

    // Update cart fragments via AJAX
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

    // Image preview modal
    $('.product-card img').on('click', function() {
        var imageUrl = $(this).attr('src');
        $('#image-preview').attr('src', imageUrl);
        $('#image-preview-modal').fadeIn();
    });

    // Close image preview modal
    $('#image-preview-modal, #close-preview').on('click', function() {
        $('#image-preview-modal').fadeOut();
    });

    // Prevent closing modal when clicking on the image
    $('#image-preview').on('click', function(e) {
        e.stopPropagation();
    });

    // Add image preview modal to the page
    if (!$('#image-preview-modal').length) {
        $('body').append('\n' +
            '<div id="image-preview-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 9999; justify-content: center; align-items: center;">\n' +
            '    <span id="close-preview" style="position: absolute; top: 20px; right: 20px; color: white; font-size: 30px; cursor: pointer;">&times;</span>\n' +
            '    <img id="image-preview" style="max-width: 90%; max-height: 90%;" src="" alt="پیش‌نمایش">\n' +
            '</div>\n' +
            '');
    }

    // Read more/less functionality
    $('.product-description').each(function() {
        var fullText = $(this).text();
        if (fullText.length > 200) {
            var shortText = fullText.substr(0, 200) + '...';
            $(this).html(shortText + '<a href="#" class="read-more">بیشتر بخوانید</a>');
            $(this).append('<span class="full-text" style="display: none;">' + fullText + '</span>');
        }
    });

    // Read more link click
    $(document).on('click', '.read-more', function(e) {
        e.preventDefault();
        var fullText = $(this).siblings('.full-text').text();
        $(this).parent().html(fullText + '<a href="#" class="read-less">کمتر بخوانید</a>');
    });

    // Read less link click
    $(document).on('click', '.read-less', function(e) {
        e.preventDefault();
        var fullText = $(this).parent().text().replace('کمتر بخوانید', '').trim();
        var shortText = fullText.substr(0, 200) + '...';
        $(this).parent().html(shortText + '<a href="#" class="read-more">بیشتر بخوانید</a>');
        $(this).parent().append('<span class="full-text" style="display: none;">' + fullText + '</span>');
    });
});