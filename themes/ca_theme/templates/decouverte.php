<?php
    $cta1_label = get_field('decouverte_lien-1_label');
    $cta1_url = get_field('decouverte_lien-1_url');
    $cta1_color = get_field('decouverte_lien-1_color');
    $cta2_label = get_field('decouverte_lien-2_label');
    $cta2_url = get_field('decouverte_lien-2_url');
    $cta2_color = get_field('decouverte_lien-2_color');
    $cta3_label = get_field('decouverte_lien-3_label');
    $cta3_url = get_field('decouverte_lien-3_url');
    $cta3_color = get_field('decouverte_lien-3_color');
?>

<section class="decouverte">
    <div class="decouverte-content">
        <h2><?php the_field('decouverte_title'); ?></h2>
        <div class="decouverte-content-ctas">
            <div class="decouverte-content-ctas-cta1">
                <a href="<?php echo esc_url($cta1_url['url']); ?>" class="<?php echo $cta1_color ?> cta decouverte-cta">
                    <?php echo $cta1_label ?>
                </a>
            </div>
            <div class="decouverte-content-ctas-cta2">
                <a href="<?php echo esc_url($cta2_url['url']); ?>" class="<?php echo $cta2_color ?> cta decouverte-cta">
                    <?php echo $cta2_label ?>
                </a>
            </div>
            <div class="decouverte-content-ctas-cta3">
                <a href="<?php echo esc_url($cta3_url['url']); ?>" class="<?php echo $cta3_color ?> cta decouverte-cta">
                    <?php echo $cta3_label ?>
                </a>
            </div>
        </div>
    </div>
</section>