<?php
/*
Template Name: Page de site
Template Post Type: sites
*/
?>
<?php include get_template_directory() . '/global-info.php' ?>

<?php get_header(); ?>

<main class="site-page">
    <?php get_template_part('/templates/page-title'); ?>
    <?php 
    $img = get_field('list_img');
    $img_url = esc_url($img['url']);
    if (get_field('brochure_label')) {
        $brochure_label = get_field('brochure_label');
    } else {
        $brochure_label = get_field('default_brochure_label', $sites_global);
    }
    if ($brochure_file = get_field('brochure_file')) {
        $brochure_file = get_field('brochure_file');
        $brochure_file_url = $brochure_file['url'];
    } else {
        $brochure_file_url = '';
    }
    
    get_template_part('/templates/fullscreen-hero', 
    null, 
    array (
        'img' => $img_url, 
        'brochure' => $brochure_file_url,
        'brochure_label' => $brochure_label)); 
    ?>
    <?php get_template_part('/templates/site_info'); ?>
    <?php get_template_part('/templates/infos_importantes'); ?>
    <?php get_template_part('/templates/equipe'); ?>
    <?php get_template_part('/templates/sacs'); ?>
    <?php get_template_part('/templates/faq'); ?>
</main>

<?php get_footer(); ?>