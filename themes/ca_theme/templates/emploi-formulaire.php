<?php $greySection = get_field('emploi_gris'); ?>

<section class="emploi-formulaire<?php if ($greySection) {echo ' -grey-section';} ?>">
    <div class="emploi-formulaire-content">
        <h2><?php the_field('emploi_titre'); ?></h2>
        <?php echo do_shortcode('[contact-form-7 id="451" title="Emploi - Infos" html_id="emploiForm"]'); ?>
    </div>
</section>