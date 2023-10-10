<?php
    $args = wp_parse_args(
        $args,
        array(
            'img' => '',
            'brochure' => '',
            'brochure_label' => ''
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
                <div class="ctas-holder">
                    <a class="fs_link cta green" href="<?php echo $args['brochure'] ?>">
                        <?php echo $args['brochure_label']; ?>
                    </a>
                    <a class="fs_link cta yellow" href="">
                        <?php the_field('texte_lien'); ?>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>