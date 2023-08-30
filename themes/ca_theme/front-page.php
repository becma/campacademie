<?php 
  get_header();

//   get_template_part('templates/commons/hero');

//   if ( have_posts() ) : while ( have_posts() ) : the_post();
//       //the_title();
//       the_content();
//     endwhile; 
//   endif;
?>

<main>

    <?php
        $image = get_field('imagefs');
        $image_url = esc_url($image['url']);
    ?>

    <?php get_template_part('/templates/fullscreen-hero', null, array( 'img' => $image_url)); ?>
    <?php get_template_part('/templates/cards-group'); ?>
    <?php get_template_part('/templates/ratio'); ?>
    <?php get_template_part('/templates/section-rabais'); ?>
    <?php get_template_part('/templates/decouverte'); ?>
    <?php get_template_part('/templates/video-block') ?>
    <?php get_template_part('/templates/coordonnees'); ?>
    <?php get_template_part('/templates/contact') ?>

</main>
    
<?php get_footer(); ?>