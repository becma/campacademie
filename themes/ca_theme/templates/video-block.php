<?php 
    $grey = get_field('videos-grey');
    $ctaLabel = get_field('videos_cta_label');
    $ctaLink = get_field('videos_cta_url');
    $ctaColor = get_field('videos_cta_color');
    $linksArray = [];
    $video_1 = get_field('video_1');
    $video_2 = get_field('video_2');
    $video_3 = get_field('video_3');
    $video_4 = get_field('video_4');
    $video_5 = get_field('video_5');
    $video_6 = get_field('video_6');
    $video_7 = get_field('video_7');
    $video_8 = get_field('video_8');
    $video_9 = get_field('video_9');

    if ( !empty($video_1)) {
        array_push($linksArray, $video_1);
    }
    if ( !empty($video_2)) {
        array_push($linksArray, $video_2);
    }
    if ( !empty($video_3)) {
        array_push($linksArray, $video_3);
    }
    if ( !empty($video_4)) {
        array_push($linksArray, $video_4);
    }
    if ( !empty($video_5)) {
        array_push($linksArray, $video_5);
    }
    if ( !empty($video_6)) {
        array_push($linksArray, $video_6);
    }
    if ( !empty($video_7)) {
        array_push($linksArray, $video_7);
    }
    if ( !empty($video_8)) {
        array_push($linksArray, $video_8);
    }
    if ( !empty($video_9)) {
        array_push($linksArray, $video_9);
    }

    $i = 0;

?>

<section class="videos <?php if ($grey = true) {echo '-grey-section';} ?>">
    <div class="videos-content">
        <h2></h2>
        <div class="videos-content-list">
            <?php
                while ($i < count($linksArray)) {
                    echo "<iframe width='400' height='225' src='https://www.youtube.com/embed/$linksArray[$i]' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
                    $i ++;
                }
            ?>
        </div>
        <div class="cta-holder">
            <a href="<?php echo esc_url($ctaLink['url']); ?>" class="cta <?php echo $ctaColor; ?>" target="_blank">
                <?php echo $ctaLabel; ?>
            </a>
        </div>
    </div>
</section>