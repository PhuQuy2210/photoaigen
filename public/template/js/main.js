/*  ---------------------------------------------------
    Template Name: Phozogy
    Description:  Phozogy photography HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    // Search model
    $('.search-switch').on('click', function () {
        $('.search-model').fadeIn(400);
    });

    $('.search-close-switch').on('click', function () {
        $('.search-model').fadeOut(400, function () {
            $('#search-input').val('');
        });
    });

    // Isotppe Filter
    // $(".filter-controls li").on('click', function() {
    //     var filterData = $(this).attr("data-filter");

    //     $(".portfolio-filter, .gallery-filter").isotope({
    //         filter: filterData,
    //     });

    //     $(".filter-controls li").removeClass('active');
    //     $(this).addClass('active');
    // });

    $(".portfolio-filter, .gallery-filter").isotope({
        itemSelector: '.pf-item, .gf-item',
        percentPosition: true,
        masonry: {
            // use element for option
            columnWidth: '.pf-item, .gf-item',
            horizontalOrder: true,
        }
    });

    //Masonary
    $('.portfolio-details-pic').masonry({
        itemSelector: '.pdp-item',
        columnWidth: '.pdp-item'
    });

    /*------------------
        Navigation
    --------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
        Carousel Slider
    --------------------*/
    var hero_s = $(".hs-slider");
    hero_s.owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        items: 1,
        dots: false,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ['<span class="arrow_carrot-left"></span>', '<span class="arrow_carrot-right"></span>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*------------------
        Team Slider
    --------------------*/
    $(".categories-slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 3,
        dots: false,
        nav: true,
        navText: ['<span class="arrow_carrot-left"></span>', '<span class="arrow_carrot-right"></span>'],
        stagePadding: 120,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
                stagePadding: 0
            },
            768: {
                items: 2,
                stagePadding: 0
            },
            992: {
                items: 2
            },
            1200: {
                items: 3
            }
        }
    });

    // $('.image-popup').magnificPopup({
    //     type: 'image'
    // });
    /*------------------
        Image Popup
    --------------------*/

    // $(document).ready(function () {
    //     $('.image-popup').magnificPopup({
    //         type: 'image',
    //         gallery: {
    //             enabled: true, // Bật tính năng chuyển ảnh
    //         },
    //         callbacks: {
    //             markupParse: function (template, values, item) {
    //                 // Lấy dữ liệu bổ sung từ phần tử HTML
    //                 var $imageElement = $(item.el).closest('.item_image');
    //                 var imageId = $imageElement.data('id');
    //                 var viewCount = $imageElement.find('.view-icon span').text();
    //                 var likeCount = $imageElement.find('.like-icon span').text();
    //                 var category = $imageElement.find('.pf-text h4').text();

    //                 // Thêm nút tải ảnh và thông tin chi tiết
    //                 values.title = `
    //                     <a href="${item.src}" download class="mfp-download"><i class="bi bi-download"></i></a>
    //                     <div class="popup-info">
    //                         <p><strong><i class="bi bi-tags"></i></strong> ${category}</p>
    //                         <p><strong><i class="bi bi-eye"></i></strong> ${viewCount}</p>
    //                         <p><strong><i class="bi bi-heart-fill"></i></strong> ${likeCount}</p>
    //                     </div>
    //                 `;
    //             }
    //         }
    //     });
    // });

    // cộng gấp đôi

    // $(document).ready(function () {
    //     $('.image-popup').magnificPopup({
    //         type: 'image',
    //         gallery: {
    //             enabled: true, // Bật tính năng chuyển ảnh
    //         },
    //         callbacks: {
    //             markupParse: function (template, values, item) {
    //                 var $imageElement = $(item.el).closest('.item_image');
    //                 var imageId = $imageElement.data('id');
    //                 var viewCount = $imageElement.find('.view-icon span').text();
    //                 var likeCount = $imageElement.find('.like-icon span').text();
    //                 var category = $imageElement.find('.pf-text h4').text();

    //                 // Thêm nút tải ảnh và thông tin chi tiết
    //                 values.title = `
    //                     <a href="${item.src}" download class="mfp-download"><i class="bi bi-download"></i></a>
    //                     <div class="popup-info">
    //                         <p><strong><i class="bi bi-tags"></i></strong> ${category}</p>
    //                         <p class="view-count"><strong><i class="bi bi-eye"></i></strong> ${viewCount}</p>
    //                         <p><strong><i class="bi bi-heart-fill"></i></strong> ${likeCount}</p>
    //                     </div>
    //                 `;
    //             },
    //             open: function () {
    //                 this.currItem.el.data('viewed', false); // Đánh dấu ảnh chưa được xem
    //             },
    //             change: function () {
    //                 var $imageElement = $(this.currItem.el).closest('.item_image');
    //                 var imageId = $imageElement.data('id');

    //                 if (imageId && !this.currItem.el.data('viewed')) {
    //                     updateViewCount(imageId);
    //                     this.currItem.el.data('viewed', true); // Đánh dấu ảnh đã được xem
    //                 }
    //             }
    //         }
    //     });

    //     function updateViewCount(imageId) {
    //         $.ajax({
    //             url: '/update-view/' + imageId,
    //             method: 'POST',
    //             data: {
    //                 _token: $('meta[name="csrf-token"]').attr('content')
    //             },
    //             success: function (response) {
    //                 if (response.success) {
    //                     $('.view-count').html(`<strong><i class="bi bi-eye"></i></strong> ${response.view}`);
    //                 }
    //             }
    //         });
    //     }
    // });

    function formatViews(views) {
        if (views >= 1000) {
            return (views / 1000).toFixed(1).replace(/\.0$/, '') + 'k';
        }
        return views.toLocaleString('de-DE');
    }
    
    $(document).ready(function () {
        $('.image-popup').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true, // Bật tính năng chuyển ảnh
            },
            callbacks: {
                markupParse: function (template, values, item) {
                    var $imageElement = $(item.el).closest('.item_image');
                    var imageId = $imageElement.data('id');
                    var viewCount = parseInt($imageElement.find('.view-icon span').text().replace(/\./g, '')) || 0;
                    var likeCount = parseInt($imageElement.find('.like-icon span').text().replace(/\./g, '')) || 0;
                    var category = $imageElement.find('.pf-text h4').text();

                    var downloadUrl = `/download?url=${encodeURIComponent(item.src)}`;

                    values.title = `
                        <a href="${downloadUrl}" class="mfp-download btn btn-sm btn-primary" title="Tải ảnh">
                            <i class="bi bi-download"></i>
                        </a>
                        <div class="popup-info">
                            <p><strong><i class="bi bi-tags"></i></strong>${category}</p>
                            <p class="view-count"><strong><i class="bi bi-eye"></i></strong> ${viewCount.toLocaleString('de-DE')}</p>
                            <p><strong><i class="bi bi-heart-fill"></i></strong> ${likeCount.toLocaleString('de-DE')}</p>
                        </div>
                    `;
                },
                open: function () {
                    $(this.currItem.el).data('viewed', false); // Đánh dấu ảnh chưa được xem
                },
                change: function () {
                    var $imageElement = $(this.currItem.el).closest('.item_image');
                    var imageId = $imageElement.data('id');

                    if (imageId && !$(this.currItem.el).data('viewed')) {
                        updateViewCount(imageId, $imageElement);
                        $(this.currItem.el).data('viewed', true); // Đánh dấu ảnh đã được xem
                    }
                }
            }
        });

        function updateViewCount(imageId, $imageElement) {
            $.ajax({
                url: '/update-view/' + imageId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        $imageElement.find('.view-icon span').text(formatViews(response.view));
                    }
                }
            });
        }
    });


    /*------------------
        Video Popup
    --------------------*/
    $('.video-popup').magnificPopup({
        type: 'iframe'
    });

    function toggleDropdown(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của thẻ <a>
        const dropdown = event.target.nextElementSibling;

        // Kiểm tra trạng thái hiện tại và chuyển đổi
        if (dropdown.style.display === "none" || dropdown.style.display === "") {
            dropdown.style.display = "block !important";
        } else {
            dropdown.style.display = "none !important";
        }
    }

})(jQuery);