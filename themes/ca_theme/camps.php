<?php
/*
Template Name: Camps
*/
?>

<?php get_header(); ?>

<main>
    <?php get_template_part('/templates/page-title'); ?>
    <?php get_template_part('/templates/camps-filtres') ?>
    <?php get_template_part('/templates/camps-list'); ?>
</main>

<?php get_footer(); ?>