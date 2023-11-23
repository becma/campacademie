<?php
/*
Template Name: Page de texte simple
*/
?>

<?php get_header(); ?>

<?php
$section1 = get_field('section1');
$section2 = get_field('section2');
$section3 = get_field('section3');
$section4 = get_field('section4');
$section5 = get_field('section5');
?>

<?php 
function generateTextBlock($section) {
    if ($section && $section['section_title'] && $section['section_text']) {
        get_template_part('/templates/section_texte',
        null,
        array(
            'titre' => $section['section_title'],
            'texte' => $section['section_text']
        ));
    }
}
?>

<main>
    <?php get_template_part('/templates/page-title'); ?>
    <?php
        generateTextBlock($section1);
        generateTextBlock($section2);
        generateTextBlock($section3);
        generateTextBlock($section4);
        generateTextBlock($section5);
    ?>
</main>

<?php get_footer() ?>