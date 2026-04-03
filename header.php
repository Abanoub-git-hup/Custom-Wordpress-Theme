<?php
/**
 * The header for the theme
 *
 * @package Abanoub_Portfolio
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="main-header" id="navbar">
    <nav class="nav-container container">
        
        <!-- الشعار (Logo) -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-link">
            <!-- يمكنك تغيير مسار الصورة مباشرة هنا -->
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="logo-img"> 
        </a>

        <!-- القائمة (Menu) - ثابتة -->
        <ul class="nav-menu">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">Skills</a></li>
            <li><a href="#portfolio">Portfolio</a></li>
            <li><a href="#resume">Resume</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>

        <!-- روابط التواصل (Social Links) - ثابتة -->
        <div class="social-links">
            <a href="https://wa.me/201127515638" target="_blank" aria-label="WhatsApp" class="social-icon">
                <i class="fa-brands fa-whatsapp"></i>
            </a>
            <a href="mailto:abanoubmorise3200@gmail.com" aria-label="Gmail" class="social-icon">
                <i class="fa-solid fa-envelope"></i>
            </a>
            <a href="https://www.linkedin.com/in/abanoub-s-maurice-8b3a32137/" target="_blank" aria-label="LinkedIn" class="social-icon">
                <i class="fa-brands fa-linkedin-in"></i>
            </a>
        </div>
        
    </nav>
</header>