<?php
/**
 * The front page template file
 *
 * @package Abanoub_Portfolio
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <!-- Hero Section -->
    <?php get_template_part( 'template-parts/content', 'hero' ); ?>

    <!-- Skills Section -->
    <div id="custom-skills-section">
        <?php get_template_part( 'template-parts/content', 'skills' ); ?>
    </div>

    <!-- Portfolio Section -->
    <?php get_template_part( 'template-parts/content', 'portfolio' ); ?>

    <!-- Resume Section -->
    <?php get_template_part( 'template-parts/content', 'resume' ); ?>

    <!-- Contact Section -->
    <?php get_template_part( 'template-parts/content', 'contact' ); ?>

</main>

<?php
get_footer();