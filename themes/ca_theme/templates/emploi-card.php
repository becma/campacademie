<?php
    $image_aide = get_field('aide_animateur_image'); 
    $image_animateur = get_field('animateur_image'); 
    $image_directeur = get_field('directeur_image'); 
?>

<section class="emploi-card">
    <div class="emploi-card-content">
        <h2><?php echo get_field('emploi_card_title') ?></h2>
        <div class="emploi-card-content-cards">
            <button class="emploi-card-content-cards-item aide-animateur">
                <div class="emploi-card-content-cards-item-img">
                    <img src="<?php echo esc_url($image_aide['url']); ?>" alt="">
                    <div class="img-background"></div>
                </div>
                <div class="emploi-card-content-cards-item-text">
                    <h3><?php echo get_field('aide_animateur_title') ?></h3>
                    <hr>
                    <p><?php echo get_field('aide_animateur_age'); ?></p>
                </div>
            </button>
            <button class="emploi-card-content-cards-item animateur">
                <div class="emploi-card-content-cards-item-img">
                    <img src="<?php echo esc_url($image_animateur['url']); ?>" alt="">
                    <div class="img-background"></div>
                </div>
                <div class="emploi-card-content-cards-item-text">
                    <h3><?php echo get_field('animateur_title') ?></h3>
                    <hr>
                    <p><?php echo get_field('animateur_age'); ?></p>
                </div>
            </button>
            <button class="emploi-card-content-cards-item directeur">
                <div class="emploi-card-content-cards-item-img">
                    <img src="<?php echo esc_url($image_directeur['url']); ?>" alt="">
                    <div class="img-background"></div>
                </div>
                <div class="emploi-card-content-cards-item-text">
                    <h3><?php echo get_field('directeur_title') ?></h3>
                    <hr>
                    <p><?php echo get_field('directeur_age'); ?></p>
                </div>
            </button>
        </div>
        <div class="emploi-card-content-benevole">
            <h3><?php echo the_field('benevole_titre') ?></h3>
            <div><?php echo the_field('benevole_texte') ?></div>
            <button><?php echo the_field('bouton_texte') ?></button>
        </div>
    </div>
</section>