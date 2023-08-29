<?php $image = get_field('passions_image'); ?>

<section class="emploi-passions-block">
    <div class="emploi-passions-block-content">
        <div class="emploi-passions-block-content-text">
            <h2><?php echo the_field('passions_titre'); ?></h2>
            <div><?php echo the_field('passions_texte'); ?></div>
            <ul>
                <li><?php echo the_field('passion_1'); ?></li>
                <li><?php echo the_field('passion_2'); ?></li>
                <li><?php echo the_field('passion_3'); ?></li>
                <li><?php echo the_field('passion_4'); ?></li>
                <li><?php echo the_field('passion_5'); ?></li>
                <li><?php echo the_field('passion_6'); ?></li>
                <li><?php echo the_field('passion_7'); ?></li>
                <li><?php echo the_field('passions_fin-liste'); ?></li>
            </ul>
        </div>
        <div class="emploi-passions-block-content-img">
            <img src="<?php echo esc_url($image['url']); ?>" alt="">
        </div>
    </div>
</section>