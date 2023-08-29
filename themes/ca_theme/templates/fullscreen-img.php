<?php
    $image = get_field('fullscreen-img');
?>

<section class="fullscreen-img">
    <div class="fullscreen-img-content">
        <img src="<?php echo esc_url($image['url']); ?>" alt="">
    </div>
</section>