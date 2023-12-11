<?php
/*
Template Name: Emploi
*/
?>

<?php get_header(); ?>

<main>
    <?php get_template_part('/templates/page-title'); ?>
    <?php get_template_part('/templates/emploi-card'); ?>
    <?php get_template_part('/templates/emploi-videos-block'); ?>
    <?php get_template_part('/templates/emploi-passions-block'); ?>
    <?php get_template_part('/templates/emploi-formulaire'); ?>
</main>

<script src="<?php bloginfo('template_url'); ?>/src/js/emploi.js"></script>
<?php get_footer() ?>