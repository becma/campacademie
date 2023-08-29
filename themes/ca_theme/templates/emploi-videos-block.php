<?php
    $image = get_field('emploi_video_image');
    $idVideo1 = get_field('emploi_video1_id');
    $idVideo2 = get_field('emploi_video2_id');
?>

<section class="emploi-videos-block -grey-section">
    <div class="emploi-videos-block-content">
        <div class="emploi-videos-block-content-img">
            <img src="<?php echo esc_url($image['url']); ?>" alt="" />
        </div>
        <div class="emploi-videos-block-content-videos">
            <div class="emploi-videos-block-content-videos-video1">
                <h2><?php echo the_field('emploi_video1_title'); ?></h2>
                <?php echo "<iframe width='400' height='225' src='https://www.youtube.com/embed/$idVideo1' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>"; ?>
            </div>
            <div class="emploi-videos-block-content-videos-video2">
                <h2><?php echo the_field('emploi_video2_title'); ?></h2>
                <?php echo "<iframe width='400' height='225' src='https://www.youtube.com/embed/$idVideo2' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>"; ?>
            </div>
        </div>
    </div>
</section>