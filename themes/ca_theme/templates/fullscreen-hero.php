<?php
    $args = wp_parse_args(
        $args,
        array(
            'img' => '',
        )
    );

    $page = get_page_template_slug();
?>

<section class="fullscreen-hero">
    <div><?php echo $page; ?></div>
    <div class="fullscreen-hero-container">
        <div class="img-container">    
            <?php 
                $boxposition = get_field('boxpositionfs');
            ?>

            <img src="<?php echo $args['img']; ?>" alt="<?php the_field('altfs'); ?>">
        </div>
        <?php if (is_front_page()) { ?>
            <div class="text-box <?php echo $boxposition; ?>">
                <h2><?php the_field('titlefs'); ?></h2>
                <p><?php the_field('soustextefs'); ?></p>
            </div>
        <?php } else { ?>
            <div class="text-box <?php echo $boxposition; ?>">
                <a class="fs_link cta" href="">
                    <?php the_field('texte_lien'); ?>
                </a>
            </div>
        <?php } ?>
    </div>
</section>