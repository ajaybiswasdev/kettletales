(function ($) {
$(document).ready(function () {
  $(".btn-shop").click(function (e) {
    e.preventDefault();

    $("html, body").animate(
      {
        scrollTop: $(".himalayan-section").first().offset().top,
      },
      800,
    );
  });
});
$(document).ready(function () {
  function closeMenu() {
    $(".side-menu, .menu-overlay").removeClass("active");
    $("body").css("overflow", "");
  }

  $(".menu-toggle").click(function () {
    $(".side-menu, .menu-overlay").toggleClass("active");
    $("body").css(
      "overflow",
      $(".side-menu").hasClass("active") ? "hidden" : "",
    );
  });

  $(".menu-overlay, .side-menu a").click(function () {
    closeMenu();
  });
});
$(document).ready(function () {
  $(".tea-carousel").slick({
    slidesToShow: 6,
    slidesToScroll: 1,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 2500,
    arrows: true,
    dots: false,
    speed: 600,

    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 5,
        },
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 400,
        settings: {
          slidesToShow: 1,
          arrows: false,
        },
      },
    ],
  });

  $(".tea-carousel").on("click", ".tea-item a.tea-item-link", function (e) {
    e.preventDefault();
    var productUrl = $(this).attr("href");
    if (productUrl) {
      window.location.href = productUrl;
    }
  });
});
 

var sections = $("section");

$(window).on("scroll", function () {
  var current = "";

  sections.each(function () {
    var top = $(this).offset().top - 150;
    var bottom = top + $(this).outerHeight();

    if ($(window).scrollTop() >= top && $(window).scrollTop() < bottom) {
      current = $(this).attr("id");
    }
  });

  $(".side-menu a").removeClass("active");

  $('.side-menu a[href="#' + current + '"]').addClass("active");
});

$(document).ready(function () {
  jarallax(document.querySelectorAll(".jarallax"));
  gsap.registerPlugin(ScrollTrigger);

  /* Product Floating */
  var floatingPack = document.querySelector(".floating-pack");
  if (floatingPack) {
    gsap.to(".floating-pack", {
      y: -50,
      repeat: -1,
      yoyo: true,
      duration: 3,
      ease: "power1.inOut",
    });
  }

  /* Fade Up */
  gsap.utils.toArray(".fade-up").forEach(function (item) {
    gsap.from(item, {
      y: 80,
      opacity: 0,
      duration: 1,
      scrollTrigger: {
        trigger: item,
        start: "top 85%",
      },
    });
  });

  /* Fade Left */
  gsap.utils.toArray(".fade-left").forEach(function (item) {
    gsap.from(item, {
      x: -100,
      opacity: 0,
      duration: 1,
      scrollTrigger: {
        trigger: item,
        start: "top 85%",
      },
    });
  });

  /* Fade Right */
  gsap.utils.toArray(".fade-right").forEach(function (item) {
    gsap.from(item, {
      x: 100,
      opacity: 0,
      duration: 1,
      scrollTrigger: {
        trigger: item,
        start: "top 85%",
      },
    });
  });
});

/* Product Tabs */
$(document).ready(function() {
    $('.kt-tabs').on('click', '.kt-tab-btn', function() {
        var tab = $(this).data('tab');
        $(this).closest('.kt-tabs').find('.kt-tab-btn').removeClass('active');
        $(this).closest('.kt-tabs').find('.kt-tab-panel').removeClass('active');
        $(this).addClass('active');
        $(this).closest('.kt-tabs').find('#' + tab).addClass('active');
    });
});

/* Product Image Gallery Thumbnail Switching */
$(document).ready(function() {
    var $mainImg = $(".woocommerce-product-gallery__image.main-product-image img");
    var $mainLink = $(".woocommerce-product-gallery__image.main-product-image a");
    var $thumbs = $(".product-thumbnails .thumbnail");

    $thumbs.on("click", function() {
        var $thumb = $(this);
        var newSrc = $thumb.data("full") || $thumb.find("img").attr("src");

        $thumbs.removeClass("active");
        $thumb.addClass("active");

        if ($mainImg.length && newSrc) {
            $mainImg.attr("src", newSrc);
        }
        if ($mainLink.length && newSrc) {
            $mainLink.attr("href", newSrc);
        }
    });
});

/* Single Product — pill-size selection syncs to hidden <select> */
$(document).on("click", ".kt-pill", function(e) {
    e.preventDefault();
    var $pill = $(this);
    var $group = $pill.closest(".kt-pill-group");
    var selectName = $group.data("attribute");
    var val = $pill.data("value");

    $group.find(".kt-pill").removeClass("active");
    $pill.addClass("active");

    var $form = $pill.closest(".variations_form");
    var $select = $form.find('select[name="' + selectName + '"]');
    $select.val(val).trigger("change");
    $form.trigger("woocommerce_variation_select_change");
    $form.trigger("check_variations");
});

/* Single Product — clear pills on Reset click */
$(document).on("click", ".reset_variations", function(e) {
    e.preventDefault();
    var $form = $(this).closest(".variations_form");
    $form.find(".kt-pill").removeClass("active");
    $form.find(".variations select").val("").trigger("change");
    $form.trigger("woocommerce_variation_select_change");
    $form.trigger("check_variations");
});

/* Quick Add to Cart — pill-size selection on homepage products */
$(document).on("click", ".kt-size-pill", function(e) {
    e.preventDefault();
    var $pill = $(this);
    var $add = $pill.closest(".kt-quick-add");

    $add.find(".kt-size-pill").removeClass("active");
    $pill.addClass("active");

    $add.find(".kt-quick-add-btn").prop("disabled", false);
});

$(document).on("click", ".kt-quick-add-btn", function(e) {
    e.preventDefault();
    var $btn = $(this);
    if ($btn.hasClass("kt-quick-added") || $btn.prop("disabled")) return;

    var $add = $btn.closest(".kt-quick-add");
    var $activePill = $add.find(".kt-size-pill.active");

    /* Variable path: pill buttons present */
    if ($activePill.length) {
        var variationId = $activePill.data("variation-id");

        $btn.addClass("loading").html('<i class="fas fa-spinner fa-spin"></i>');

        var ajaxUrl = (typeof kt_ajax !== "undefined" && kt_ajax.ajax_url) ? kt_ajax.ajax_url : "/kettletales/wp-admin/admin-ajax.php";

        $.ajax({
            url: ajaxUrl,
            type: "POST",
            dataType: "json",
            data: {
                action: "kt_add_variation_to_cart",
                variation_id: variationId
            },
            success: function(response) {
                if (response.success) {
                    $btn.removeClass("loading").addClass("kt-quick-added").html('<i class="fas fa-check"></i> Added!');
                    if (response.data && response.data.fragments) {
                        $.each(response.data.fragments, function(sel, html) {
                            $(sel).replaceWith(html);
                        });
                    }
                    setTimeout(function() {
                        $btn.removeClass("kt-quick-added").html('<i class="fas fa-shopping-bag"></i> Add to Cart');
                        $add.find(".kt-size-pill").removeClass("active");
                        $btn.prop("disabled", true);
                    }, 2000);
                } else {
                    alert(response.data && response.data.message ? response.data.message : "Could not add to cart.");
                    $btn.removeClass("loading").html('<i class="fas fa-shopping-bag"></i> Add to Cart');
                }
            },
            error: function() {
                alert("Something went wrong. Please try again.");
                $btn.removeClass("loading").html('<i class="fas fa-shopping-bag"></i> Add to Cart');
            }
        });

    /* Simple path: no pills — the button itself is an <a> with href */
    } else {
        if ($btn.attr("href")) {
            window.location.href = $btn.attr("href");
        }
    }
});

/* Force cart count refresh after any WooCommerce cart update */
$(document.body).on("updated_wc_div", function() {
    $(document.body).trigger("wc_fragment_refresh");
});

$(document.body).on("added_to_cart removed_from_cart", function() {
    $(document.body).trigger("wc_fragment_refresh");
});

/* Shop Header Mobile Menu Toggle */
$(document).ready(function() {
    $('.shop-menu-toggle').on('click', function() {
        $('.shop-mobile-menu').toggleClass('active');
        var $icon = $(this).find('i');
        $icon.toggleClass('fa-bars fa-times');
    });
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.shop-header').length) {
            $('.shop-mobile-menu').removeClass('active');
            $('.shop-menu-toggle i').removeClass('fa-times').addClass('fa-bars');
        }
    });
});

})(jQuery);
