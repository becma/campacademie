<section class="fullscreen-hero">
    <div class="fullscreen-hero-container">
        <div class="img-container">    
            <?php 
            $image = get_field('imagefs');
            $boxposition = get_field('boxpositionfs');
            ?>

            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php the_field('altfs'); ?>">
        </div>
        <div class="text-box <?php echo $boxposition; ?>">
            <h2><?php the_field('titlefs'); ?></h2>
            <p><?php the_field('soustextefs'); ?></p>
        </div>
    </div>
</section>