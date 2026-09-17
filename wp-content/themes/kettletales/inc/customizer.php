<?php
/**
 * Customizer Settings - All Homepage Sections
 *
 * @package KettleTales
 */

function kettletales_customize_register( $wp_customize ) {

    /* ================================================================
       HERO BANNER
       ================================================================ */
    $wp_customize->add_section( 'kettletales_hero', array(
        'title'    => __( 'Hero Banner', 'kettletales' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'hero_bg_video', array(
        'default'           => KETTLETALES_URI . '/assets/images/Tea.mp4',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'hero_bg_video', array(
        'label'       => __( 'Background Video URL (MP4)', 'kettletales' ),
        'description' => __( 'Paste full URL. Leave empty for no video.', 'kettletales' ),
        'section'     => 'kettletales_hero',
        'type'        => 'url',
    ) );

    $wp_customize->add_setting( 'hero_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_bg_image', array(
        'label'       => __( 'Background Image (fallback)', 'kettletales' ),
        'section'     => 'kettletales_hero',
    ) ) );

    $wp_customize->add_setting( 'hero_title', array(
        'default'           => __( 'Every cup has a tale!', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_title', array(
        'label'   => __( 'Title', 'kettletales' ),
        'section' => 'kettletales_hero',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'hero_desc', array(
        'default'           => __( 'Premium Himalayan Teas from Dooars, Darjeeling and Assam sourced from small growers, packed fresh and delivered across India.', 'kettletales' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'hero_desc', array(
        'label'   => __( 'Description', 'kettletales' ),
        'section' => 'kettletales_hero',
        'type'    => 'textarea',
    ) );

    for ( $i = 1; $i <= 5; $i++ ) {
        $defaults = array(
            1 => __( 'Wellness & Lifestyle Products', 'kettletales' ),
            2 => __( 'Artisanal Gift Hampers', 'kettletales' ),
            3 => __( 'Small Farm Sourced', 'kettletales' ),
            4 => __( 'Freshly Packed', 'kettletales' ),
            5 => __( 'Quality Tested', 'kettletales' ),
        );
        $wp_customize->add_setting( "hero_badge_{$i}", array(
            'default'           => $defaults[ $i ],
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "hero_badge_{$i}", array(
            'label'       => sprintf( __( 'Badge %d', 'kettletales' ), $i ),
            'description' => __( 'Leave empty to hide.', 'kettletales' ),
            'section'     => 'kettletales_hero',
            'type'        => 'text',
        ) );
    }

    $wp_customize->add_setting( 'hero_btn_text', array(
        'default'           => __( 'Explore & Shop Teas', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_btn_text', array(
        'label'   => __( 'Button Text', 'kettletales' ),
        'section' => 'kettletales_hero',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'hero_btn_link', array(
        'default'           => '#collections',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'hero_btn_link', array(
        'label'   => __( 'Button Link', 'kettletales' ),
        'section' => 'kettletales_hero',
        'type'    => 'url',
    ) );

    /* ================================================================
       HIMALAYAN COLLECTION
       ================================================================ */
    $wp_customize->add_section( 'kettletales_himalayan', array(
        'title'    => __( 'Himalayan Collection', 'kettletales' ),
        'priority' => 31,
    ) );

    $wp_customize->add_setting( 'himalayan_subtitle', array(
        'default'           => __( 'Collection', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'himalayan_subtitle', array(
        'label'   => __( 'Subtitle', 'kettletales' ),
        'section' => 'kettletales_himalayan',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'himalayan_heading', array(
        'default'           => __( 'Elegant teas shaped by mountain air, rich soil, love and generations of craftsmanship.', 'kettletales' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'himalayan_heading', array(
        'label'   => __( 'Heading', 'kettletales' ),
        'section' => 'kettletales_himalayan',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'himalayan_text', array(
        'default'           => __( 'Handpicked from select Himalayan tea gardens known for their distinctive terroir, this collection showcases the region\'s finest expressions—from delicate first flushes to rich muscatel and roasted varieties. Carefully sourced and packed fresh, each tea captures the character and purity of the mountains.', 'kettletales' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'himalayan_text', array(
        'label'   => __( 'Description', 'kettletales' ),
        'section' => 'kettletales_himalayan',
        'type'    => 'textarea',
    ) );

    /* ================================================================
       SIGNATURE COLLECTION
       ================================================================ */
    $wp_customize->add_section( 'kettletales_signature', array(
        'title'    => __( 'Signature Collection', 'kettletales' ),
        'priority' => 32,
    ) );

    $wp_customize->add_setting( 'signature_subtitle', array(
        'default'           => __( 'Collection', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'signature_subtitle', array(
        'label'   => __( 'Subtitle', 'kettletales' ),
        'section' => 'kettletales_signature',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'signature_heading', array(
        'default'           => __( 'Bold, malty and full-bodied teas from the small tea-growers primarily of Assam.', 'kettletales' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'signature_heading', array(
        'label'   => __( 'Heading', 'kettletales' ),
        'section' => 'kettletales_signature',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'signature_image', array(
        'default'           => KETTLETALES_URI . '/assets/images/img1.jpg',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'signature_image', array(
        'label'   => __( 'Image', 'kettletales' ),
        'section' => 'kettletales_signature',
    ) ) );

    $wp_customize->add_setting( 'signature_text', array(
        'default'           => __( 'Sourced from renowned Assam tea-growing regions, these teas are chosen for their depth, strength and signature malty richness. Whether enjoyed as a robust morning brew or a comforting cup throughout the day, every selection reflects the authentic character of Assam.', 'kettletales' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'signature_text', array(
        'label'   => __( 'Description', 'kettletales' ),
        'section' => 'kettletales_signature',
        'type'    => 'textarea',
    ) );

    /* ================================================================
       WELLNESS COLLECTION
       ================================================================ */
    $wp_customize->add_section( 'kettletales_wellness', array(
        'title'    => __( 'Wellness Collection', 'kettletales' ),
        'priority' => 33,
    ) );

    $wp_customize->add_setting( 'wellness_subtitle', array(
        'default'           => __( 'Collection', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'wellness_subtitle', array(
        'label'   => __( 'Subtitle', 'kettletales' ),
        'section' => 'kettletales_wellness',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'wellness_heading', array(
        'default'           => __( 'Thoughtfully crafted teas for everyday balance and wellbeing.', 'kettletales' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'wellness_heading', array(
        'label'   => __( 'Heading', 'kettletales' ),
        'section' => 'kettletales_wellness',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'wellness_text', array(
        'default'           => __( 'Created for modern lifestyles, this collection features blends designed to support wellness goals—from calming chamomile or Tulsi-Lemon Green Tea and refreshing mint to antioxidant-rich green teas. Each blend combines carefully selected ingredients to create delicious, functional teas that can be enjoyed throughout the day.', 'kettletales' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'wellness_text', array(
        'label'   => __( 'Description', 'kettletales' ),
        'section' => 'kettletales_wellness',
        'type'    => 'textarea',
    ) );

    /* ================================================================
       STORY
       ================================================================ */
    $wp_customize->add_section( 'kettletales_story', array(
        'title'    => __( 'Our Story', 'kettletales' ),
        'priority' => 34,
    ) );

    $wp_customize->add_setting( 'story_image', array(
        'default'           => KETTLETALES_URI . '/assets/images/parallax_1.jpeg',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'story_image', array(
        'label'   => __( 'Background Image', 'kettletales' ),
        'section' => 'kettletales_story',
    ) ) );

    $wp_customize->add_setting( 'story_subtitle', array(
        'default'           => __( 'The Story', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'story_subtitle', array(
        'label'   => __( 'Subtitle', 'kettletales' ),
        'section' => 'kettletales_story',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'story_heading', array(
        'default'           => __( 'Behind Every Brew!', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'story_heading', array(
        'label'   => __( 'Heading', 'kettletales' ),
        'section' => 'kettletales_story',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'story_text_1', array(
        'default'           => __( 'From mist-covered tea gardens to your cup, every leaf is carefully selected and packed. Every harvest reflects generations of craftsmanship and dedication to quality.', 'kettletales' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'story_text_1', array(
        'label'   => __( 'Paragraph 1', 'kettletales' ),
        'section' => 'kettletales_story',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'story_text_2', array(
        'default'           => __( 'We believe that great tea starts with the finest ingredients and the most careful preparation.', 'kettletales' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'story_text_2', array(
        'label'   => __( 'Paragraph 2', 'kettletales' ),
        'section' => 'kettletales_story',
        'type'    => 'textarea',
    ) );

    /* ================================================================
       QUALITY & SOURCING
       ================================================================ */
    $wp_customize->add_section( 'kettletales_quality', array(
        'title'    => __( 'Quality & Sourcing', 'kettletales' ),
        'priority' => 35,
    ) );

    $wp_customize->add_setting( 'quality_image', array(
        'default'           => KETTLETALES_URI . '/assets/images/cup.png',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'quality_image', array(
        'label'   => __( 'Cup Image', 'kettletales' ),
        'section' => 'kettletales_quality',
    ) ) );

    $wp_customize->add_setting( 'quality_subtitle', array(
        'default'           => __( 'QUALITY & SOURCING', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'quality_subtitle', array(
        'label'   => __( 'Subtitle', 'kettletales' ),
        'section' => 'kettletales_quality',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'quality_heading', array(
        'default'           => __( 'From small farms to your cup!', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'quality_heading', array(
        'label'   => __( 'Heading', 'kettletales' ),
        'section' => 'kettletales_quality',
        'type'    => 'text',
    ) );

    for ( $i = 1; $i <= 5; $i++ ) {
        $icons = array(
            KETTLETALES_URI . '/assets/images/icon1.png',
            KETTLETALES_URI . '/assets/images/icon2.png',
            KETTLETALES_URI . '/assets/images/icon3-1.png',
            KETTLETALES_URI . '/assets/images/icon4.png',
            KETTLETALES_URI . '/assets/images/icon5.png',
        );
        $labels = array(
            1 => __( 'Sourced from small holder tea farmers', 'kettletales' ),
            2 => __( 'Eco-friendly growing practices', 'kettletales' ),
            3 => __( 'Limited-batch harvesting', 'kettletales' ),
            4 => __( 'Freshly packed for maximum aroma', 'kettletales' ),
            5 => __( 'Selected batches quality-tested by accredited laboratories', 'kettletales' ),
        );
        $wp_customize->add_setting( "quality_icon_{$i}", array(
            'default'           => $icons[ $i - 1 ],
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "quality_icon_{$i}", array(
            'label'   => sprintf( __( 'Feature %d Icon', 'kettletales' ), $i ),
            'section' => 'kettletales_quality',
        ) ) );

        $wp_customize->add_setting( "quality_feature_{$i}", array(
            'default'           => $labels[ $i ],
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "quality_feature_{$i}", array(
            'label'       => sprintf( __( 'Feature %d Text', 'kettletales' ), $i ),
            'description' => __( 'Leave empty to hide.', 'kettletales' ),
            'section'     => 'kettletales_quality',
            'type'        => 'text',
        ) );
    }

    /* ================================================================
       FOOTER
       ================================================================ */
    $wp_customize->add_section( 'kettletales_footer', array(
        'title'    => __( 'Footer', 'kettletales' ),
        'priority' => 40,
    ) );

    $wp_customize->add_setting( 'footer_logo', array(
        'default'           => KETTLETALES_URI . '/assets/images/TeaLabel_2.png',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_logo', array(
        'label'   => __( 'Footer Logo', 'kettletales' ),
        'section' => 'kettletales_footer',
    ) ) );

    $wp_customize->add_setting( 'footer_about_heading', array(
        'default'           => __( 'KettleTales tea presented by Craft&Weft', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_about_heading', array(
        'label'   => __( 'About Heading', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'footer_about_text', array(
        'default'           => __( 'KettleTales is a premium tea initiative by Craft&Weft, bringing together carefully sourced teas, responsible farming practices and authentic regional flavours.', 'kettletales' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'footer_about_text', array(
        'label'   => __( 'About Text', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'footer_gst', array(
        'default'           => __( 'GST #19BGBPP6543H2Z4', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_gst', array(
        'label'   => __( 'GST Number', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'footer_fssai_logo', array(
        'default'           => KETTLETALES_URI . '/assets/images/fssai-logo.png',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_fssai_logo', array(
        'label'   => __( 'FSSAI Logo', 'kettletales' ),
        'section' => 'kettletales_footer',
    ) ) );

    $wp_customize->add_setting( 'footer_fssai_number', array(
        'default'           => __( 'Licence #12824013000639', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_fssai_number', array(
        'label'   => __( 'FSSAI License Number', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'footer_phone_heading', array(
        'default'           => __( 'To order call us at', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_phone_heading', array(
        'label'   => __( 'Phone Heading', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'footer_phone_1', array(
        'default'           => '+918100219450',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_phone_1', array(
        'label'   => __( 'Phone 1', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'footer_phone_2', array(
        'default'           => '+917003678472',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_phone_2', array(
        'label'   => __( 'Phone 2', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'footer_email_1', array(
        'default'           => 'kettletales2026@gmail.com',
        'sanitize_callback' => 'sanitize_email',
    ) );
    $wp_customize->add_control( 'footer_email_1', array(
        'label'   => __( 'Email 1', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'email',
    ) );

    $wp_customize->add_setting( 'footer_email_2', array(
        'default'           => 'craftnweft@gmail.com',
        'sanitize_callback' => 'sanitize_email',
    ) );
    $wp_customize->add_control( 'footer_email_2', array(
        'label'   => __( 'Email 2', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'email',
    ) );

    $wp_customize->add_setting( 'footer_facebook', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'footer_facebook', array(
        'label'   => __( 'Facebook URL', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'url',
    ) );

    $wp_customize->add_setting( 'footer_instagram', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'footer_instagram', array(
        'label'   => __( 'Instagram URL', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'url',
    ) );

    $wp_customize->add_setting( 'footer_youtube', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'footer_youtube', array(
        'label'   => __( 'YouTube URL', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'url',
    ) );

    $wp_customize->add_setting( 'footer_delivery_text', array(
        'default'           => __( 'Complimentary Delivery Within Kolkata and nearby | Subject to conditions', 'kettletales' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_delivery_text', array(
        'label'   => __( 'Delivery Text', 'kettletales' ),
        'section' => 'kettletales_footer',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'kettletales_customize_register' );
