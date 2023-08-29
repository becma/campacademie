<?php $grey = get_field('rabais-grey') ?>

<section class="rabais <?php if ($grey = true) {echo '-grey-section';} ?>">
    <div class="rabais-container">
        <div class="rabais-container-infos">
            <h2><?php the_field('rabais_title'); ?></h2>
            <p><?php the_field('rabais_texte'); ?></p>
        </div>
        <div class="rabais-container-rabais">
            <div class="rabais-container-rabais-1">
                <div class="rabais-num-1">
                    <?php the_field('rabais_1'); ?>
                </div>
                <p><?php the_field('rabais_1_libelle'); ?></p>
            </div>
            <div class="rabais-container-rabais-2">
                <div class="rabais-num-2">
                    <?php the_field('rabais_2'); ?>
                </div>
                <p><?php the_field('rabais_2_libelle'); ?></p>
            </div>
        </div>
    </div>
</section>