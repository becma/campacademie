<?php 
    function cleanString($string) {
        $string = str_replace(' ', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    $choix = get_field('poste_choix');
    $choixTitre = $choix['poste_titre'];
    $premierChoix = $choix['poste_premier_choix'];
    $premierChoixNoChar = cleanString($premierChoix);
    $deuxiemeChoix = $choix['poste_deuxieme_choix'];
    $deuxiemeChoixNoChar = cleanString($deuxiemeChoix);
    $troisiemeChoix = $choix['poste_troisieme_choix'];
    $troisiemeChoixNoChar = cleanString($troisiemeChoix);
    $quatriemeChoix = $choix['poste_quatrieme_choix'];
    $quatriemeChoixNoChar = cleanString($quatriemeChoix);

    $sites = get_posts(array(
        'post_type' => 'sites',
        'numberposts' => -1
    )) ;
?>

<section class="emploi-formulaire">
    <div class="emploi-formulaire-content">
        <form action="">
            <fieldset class="emploi-formulaire-content-poste">
                <legend><?php echo the_field('premiere_section_titre'); ?></legend>
                <div class="emploi-formulaire-content-poste-input-group">
                    <input type="checkbox" name="<?php echo $premierChoixNoChar; ?>">
                    <label for="<?php echo $premierChoixNoChar; ?>"><?php echo $premierChoix; ?></label>
                </div>
                <div class="emploi-formulaire-content-poste-input-group">
                    <input type="checkbox" name="<?php echo $deuxiemeChoixNoChar; ?>">
                    <label for="<?php echo $deuxiemeChoixNoChar; ?>"><?php echo $deuxiemeChoix; ?></label>
                </div>
                <div class="emploi-formulaire-content-poste-input-group">
                    <input type="checkbox" name="<?php echo $troisiemeChoixNoChar; ?>">
                    <label for="<?php echo $troisiemeChoixNoChar; ?>"><?php echo $troisiemeChoix; ?></label>
                </div>
                <div class="emploi-formulaire-content-poste-input-group">
                    <input type="checkbox" name="<?php echo $quatriemeChoixNoChar; ?>">
                    <label for="<?php echo $quatriemeChoixNoChar; ?>"><?php echo $quatriemeChoix; ?></label>
                </div>
            </fieldset>
            <fieldset>
                <legend><?php echo the_field('sites_titre'); ?></legend>
                <?php foreach ($sites as $site): ?>
                    <?php
                        $site_name = get_the_title($site->ID);
                        $site_city = get_field_object('site_city', $site->ID);
                        $city_value = $site_city['value'];
                        $city_label = esc_html($site_city['choices'][ $city_value ]);
                    ?>
                    <div class="emploi-formulaire-content-sites-input-group">
                        <input type="checkbox" name="<?php echo cleanString($site_name); ?>">
                        <label for="<?php echo cleanString($site_name); ?>"><?php echo $site_name." (".$city_label.")" ?></label>
                    </div>
                <?php endforeach ?>
            </fieldset>
            <fieldset>
                <legend></legend>
                <div class="emploi-formulaire-content-infos-input-group">
                    <label for=""></label>
                    <input type="text">
                </div>
                <div class="emploi-formulaire-content-infos-input-group">
                    <label for=""></label>
                    <input type="email">
                </div>
                <div class="emploi-formulaire-content-infos-input-group">
                    <label for=""></label>
                    <input type="file">
                </div>
                <div class="emploi-formulaire-content-infos-input-group">
                    <label for=""></label>
                    <input type="textarea">
                </div>
            </fieldset>
        </form>
    </div>
</section>