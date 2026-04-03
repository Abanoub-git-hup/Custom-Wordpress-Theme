<?php
/**
 * The footer for the theme
 *
 * @package Abanoub_Portfolio
 */
?>
<footer class="simple-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo">
                    <?php 
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else { ?>
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                    <?php } ?>
                </a>
                <p><?php esc_html_e( 'Creating digital experiences with passion.', 'abanoub-portfolio' ); ?></p>
            </div>

            <div class="footer-socials">
                <?php 
                $linkedin = get_theme_mod( 'social_linkedin' ); 
                if ( $linkedin ) : ?>
                    <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" aria-label="LinkedIn" class="social-icon"><i class="fa-brands fa-linkedin-in"></i></a>
                <?php endif; ?>
                
                <?php 
                $github = get_theme_mod( 'social_github' ); 
                if ( $github ) : ?>
                    <a href="<?php echo esc_url( $github ); ?>" target="_blank" aria-label="GitHub" class="social-icon"><i class="fa-brands fa-github"></i></a>
                <?php endif; ?>
                
                <?php 
                $whatsapp = get_theme_mod( 'social_whatsapp' ); 
                if ( $whatsapp ) : ?>
                    <a href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" aria-label="WhatsApp" class="social-icon"><i class="fa-brands fa-whatsapp"></i></a>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date( 'Y' ); ?> <span><?php bloginfo( 'name' ); ?></span>. <?php esc_html_e( 'All Rights Reserved.', 'abanoub-portfolio' ); ?></p>
        </div>
    </div>
</footer>

<!-- WhatsApp Floating Button -->
<?php 
 $whatsapp_link = get_theme_mod( 'social_whatsapp' );
if ( $whatsapp_link ) : ?>
<a href="<?php echo esc_url( $whatsapp_link ); ?>" class="whatsapp-btn" target="_blank" aria-label="Chat on WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
    <span class="tooltip"><?php esc_html_e( 'Chat with me!', 'abanoub-portfolio' ); ?></span>
</a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>