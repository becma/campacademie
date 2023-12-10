<?php $videoId = get_field('videoid_site'); ?>

<section class="single-video">
    <div class="single-video-content">
        <div class="single-video-content-iframe-container">
            <?php echo "<iframe src=\"https://www.youtube.com/embed/$videoId\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>"?>
        </div>
    </div>
</section>