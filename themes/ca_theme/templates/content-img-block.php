<?php
    $image1 = get_field('image_1');
    $image2 = get_field('image_2');
?>

<section class="content-img-block">
    <div class="content-img-block-content">
        <div class="content-img-block-content-1">
            <div class="content-img-block-content-1-img">
                <div class="arrow-left <?php the_field('arrow1_color'); ?>"></div>
                <img src="<?php echo esc_url($image1['url']); ?>" alt="">
            </div>
            <div class="content-img-block-content-1-text">
                <h2><?php the_field('title_1'); ?></h2>
                <div><?php the_field('texte_1'); ?></div>
            </div>
        </div>
    </div>
    <div class="content-img-block-content">
        <div class="content-img-block-content-2">
            <div class="content-img-block-content-2-img">
                <img src="<?php echo esc_url($image2['url']); ?>" alt="">
                <div class="arrow-right <?php the_field('arrow2_color'); ?>"></div>
            </div>
            <div class="content-img-block-content-2-text">
                <h2><?php the_field('title_2'); ?></h2>
                <div><?php the_field('texte_2'); ?></div>
            </div>
        </div>
    </div>
</section>