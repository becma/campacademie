<section class="card-group">
    <?php
    $card1_image = get_field('card1-image');
    $card1_alt = get_field('card1-alt');
    $card1_title = get_field('card1-title');
    $card1_from = get_field('card1-from');
    $card1_text = get_field('card1-text');
    $card1_ctaLabel = get_field('card1-ctalabel');
    $card1_ctaLink = get_field('card1-ctalink');
    $card1_ctaColor = get_field('card1-ctaColor');

    $card2_image = get_field('card2-image');
    $card2_alt = get_field('card2-alt');
    $card2_title = get_field('card2-title');
    $card2_from = get_field('card2-from');
    $card2_text = get_field('card2-text');
    $card2_ctaLabel = get_field('card2-ctalabel');
    $card2_ctaLink = get_field('card2-ctalink');
    $card2_ctaColor = get_field('card2-ctaColor');
    ?>

    <h2 class="visuallyhidden">Nos camps</h2>

    <div class="card-group-container"> 
        <div class="card">
            <div class="img-container">
                <img src="<?php echo esc_url($card1_image['url']); ?>" alt="<?php echo $card1_alt ?>">
                <div class="filtre-img"></div>
            </div>
            <div class="text-content">
                <h3><?php echo $card1_title ?></h3>
                <p class="from"><?php echo $card1_from ?></p>
                <p><?php echo $card1_text ?></p>
            </div>
            <div class="cta-holder cta-1">
                <a href="<?php echo esc_url($card1_ctaLink['url']); ?>" class="cta <?php echo $card1_ctaColor ?>"><?php echo $card1_ctaLabel ?></a>
            </div>
        </div>

        <div class="card">
            <div class="img-container">
                <img src="<?php echo esc_url($card2_image['url']); ?>'" alt="<?php echo $card2_alt ?>">
                <div class="filtre-img"></div>
            </div>
            <div class="text-content">
                <h3><?php echo $card2_title ?></h3>
                <p class="from"><?php echo $card2_from ?></p>
                <p><?php echo $card2_text ?></p>
            </div>
            <div class="cta-holder cta-2">
                <a href="<?php echo esc_url($card2_ctaLink['url']); ?>" class="cta <?php echo $card2_ctaColor ?>"><?php echo $card2_ctaLabel?></a>
            </div>
        </div>
 
        <?php /*(!empty($card2_title)) {*/
        //     echo '<div class="card">
        //             <div class="img-container">
        //                 <img src="'.esc_url($card2_image['url']);.'" alt="'.$card2_alt.'">
        //                 <div class="filtre-img"></div>
        //             </div>
        //             <div class="text-content">
        //                 <h3>'.$card2_title.'</h3>
        //                 <p class="from">'.$card2_from.'</p>
        //                 <p>'.$card2_text.'</p>
        //             </div>
        //             <div class="cta cta-2">
        //                 <a href="'.esc_url($card2_ctaLink['url']);.'">'.$card2_ctaLabel.'</a>
        //             </div>
        //         </div>';
        // } 
        ?>
        
    </div>
</section>