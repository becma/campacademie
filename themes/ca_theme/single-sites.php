<?php
/*
Template Name: Page de site
Template Post Type: sites
*/
?>

<?php get_header(); ?>

<main class="site-page">
    <?php get_template_part('/templates/page-title'); ?>
    <?php 
    $img = get_field('list_img');
    $img_url = esc_url($img['url']);
    get_template_part('/templates/fullscreen-hero', null, array ('img' => $img_url)); 
    ?>
    <?php get_template_part('/templates/site_info'); ?>
</main>

<?php get_footer(); ?>