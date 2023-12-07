<?php
/*
    Template Name: Page de site
    Template Post Type: sites
*/
?>

<?php get_header(); ?>

<main class="camp-page">
    <?php get_template_part('/templates/page-title'); ?>
    <?php get_template_part('/templates/camps-info'); ?>
    <?php get_template_part('/templates/couts_camp'); ?>
    <?php get_template_part('/templates/sacs'); ?>
    <?php get_template_part('/templates/faq'); ?>
    <?php get_template_part('/templates/contact'); ?>
</main>

<?php get_footer(); ?>