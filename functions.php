<?php
/**
 * Abanoub Portfolio - Static Theme Functions
 *
 * @package Abanoub_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // منع الوصول المباشر للملف
}

// تعريف إصدار الثيم لمكافحة الكاش
define( 'ABANOUB_VERSION', '1.0.2' );

/**
 * Theme Setup
 */
function abanoub_theme_setup() {
    load_theme_textdomain( 'abanoub-portfolio', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 100,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'abanoub-portfolio' ),
    ) );
}
add_action( 'after_setup_theme', 'abanoub_theme_setup' );

/**
 * Enqueue Scripts and Styles
 */
function abanoub_scripts() {
    // 1. الخطوط والأيقونات الخارجية
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap', array(), null );
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0' );

    // 2. ملف الستايل الرئيسي
    wp_enqueue_style( 'abanoub-style', get_stylesheet_uri(), array(), ABANOUB_VERSION );
// 3. ملفات CSS المجزأة مع تحديث تلقائي للـ Version
$css_files = array('main', 'header', 'hero', 'skills', 'portfolio', 'resume', 'contact', 'footer');

foreach ( $css_files as $file ) {
    $file_path = get_template_directory() . '/assets/css/' . $file . '.css';
    
    // بنجيب وقت تعديل الملف لو موجود، لو مش موجود بنستخدم الإصدار العام
    $version = file_exists( $file_path ) ? filemtime( $file_path ) : ABANOUB_VERSION;

    wp_enqueue_style( 
        'abanoub-' . $file, 
        get_template_directory_uri() . '/assets/css/' . $file . '.css', 
        array('abanoub-style'), 
        $version 
    );
}

    // 4. استدعاء مكتبات GSAP من الـ CDN
    wp_enqueue_script('gsap-js', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), '3.12.2', true);
    wp_enqueue_script('gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', array('gsap-js'), '3.12.2', true);

  
    // 5. استدعاء ملف الجافا سكريبت الموحد (يعتمد على GSAP و ScrollTrigger)
// لاحظ أننا أضفنا 'gsap-scroll-trigger' داخل المصفوفة لضمان تحميله أولاً
wp_enqueue_script('abanoub-main', get_template_directory_uri() . '/assets/js/main.js', array('gsap-js', 'gsap-scroll-trigger'), ABANOUB_VERSION, true);

    // 6. تمرير البيانات لملف الـ main (لنصوص الكتابة المتحركة)
    wp_localize_script( 'abanoub-main', 'abanoubData', array(
        'typingWords' => get_theme_mod( 'typing_words', 'Front-End Developer,WordPress Developer' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'abanoub_scripts' );

/**
 * Customizer Settings
 */
function abanoub_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'abanoub_hero', array(
        'title'    => __( 'Hero & Basic Info', 'abanoub-portfolio' ),
        'priority' => 30,
    ) );

    $settings = array(
        'hero_name'        => 'Abanoub Maurice',
        'hero_welcome'     => 'Hi i am',
        'hero_description' => 'I weave magic into digital interfaces...',
        'typing_words'     => 'Front-End Developer,WordPress Developer',
        'phone_number'     => '+201127515638',
        'email_address'    => 'abanoubmorise3200@gmail.com',
        'whatsapp_link'    => 'https://wa.me/201127515638',
        'linkedin_link'    => 'https://www.linkedin.com/in/abanoub-s-maurice-8b3a32137/',
        'github_link'      => 'https://github.com/Abanoub-git-hup',
    );

    foreach ( $settings as $key => $default ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $default,
            'sanitize_callback' => ( strpos( $key, 'link' ) !== false ) ? 'esc_url_raw' : 'sanitize_text_field',
        ) );
        
        $wp_customize->add_control( $key, array(
            'label'   => ucfirst( str_replace( '_', ' ', $key ) ),
            'section' => 'abanoub_hero',
            'type'    => ( strpos( $key, 'description' ) !== false || strpos( $key, 'words' ) !== false ) ? 'textarea' : 'text',
        ) );
    }
}
add_action( 'customize_register', 'abanoub_customize_register' );







