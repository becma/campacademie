<?php
    $args = wp_parse_args(
        $args,
        array(
            'img' => '',
            'nom' => '',
            'ville' => '',
            'quartier' => '',
            'label' => '',
            'permalink' => '',
            'brochure_label' => '',
            'brochure_file' => ''
        )
    );
?>

<div class="site-card" data-city="<?php echo $args['ville'] ?>">
    <div class="site-card_img-container">
        <img src="<?php echo $args['img']; ?>" alt="">
        <div class="shadow"></div>
    </div>
    <div class="site-card_infos">
        <h2><?php echo $args['nom']; ?></h2>
        <div class="site-card_infos-ville-quartier">
            <p class="site-card_infos-ville"><?php echo $args['ville']; ?></p>
            <?php if ($args['quartier'] != ''): ?>
                <p class="site-card_infos-quartier"><?php echo $args['quartier']; ?></p>
            <?php endif ?>
        </div>
        <div class="site-card_infos_cta-group">
            <a class="cta purple" href="<?php echo $args['permalink'] ?>"><?php echo $args['label']; ?></a>
            <a class="cta-2" href="<?php echo $args['brochure_file'] ?>" target="_blank"><?php echo $args['brochure_label']; ?></a>
        </div>
    </div>
</div>