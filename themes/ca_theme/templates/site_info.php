<?php
$tel = get_field('phone_number');
$city = get_field_object('site_city');
$ville = $city['value'];
$city_label = esc_html($city['choices'][ $ville ]);

if(ctype_digit($tel)) {
    $tel_num_dashes = substr($tel, 0, 3) .'-'.
                substr($tel, 3, 3) .'-'.
                substr($tel, 6);
}

$courriel = get_field('email_address');
$surveillance = get_field('surveillance_hours');
$adresse = get_field('phys_address');
$dates_camp = get_field('dates_camp');

?>


<section class="site-infos">
    <div class="site-info-content">
        <h2><?php the_field('titre_section'); ?></h2>
        <div class="info-container">
            <?php if (isset($tel_num_dashes)) : ?>
                <div class="tel">
                    <h3>Téléphone</h3>
                    <a href="tel:<?php echo $tel; ?>"><?php echo $tel_num_dashes; ?></a>
                </div>
            <?php endif ?>
            <?php if ($courriel != "") : ?>
                <div class="courriel">
                    <h3>Courriel</h3>
                    <a href="mailto:<?php echo $courriel ?>"><?php echo $courriel ?></a>
                </div>
            <?php endif ?>
            <?php if ($surveillance != "") : ?>
                <div class="surveillance">
                    <h3>Service de surveillance</h3>
                    <p><?php echo $surveillance; ?></p>
                </div>
            <?php endif ?>
            <?php if ($adresse != "") : ?>
                <div class="adresse">
                    <h3>Adresse</h3>
                    <p><?php echo $adresse; ?></p>
                    <p><?php echo $city_label; ?></p>
                </div>
            <?php endif ?>
            <?php if (get_field('traiteur')) { ?>
                <div class="traiteur">
                    <h3>Traiteur Offert</h3>
                    <a href="<?php echo get_page_link(490); ?>"><?php the_field('traiteur_link_label'); ?></a>
                </div>
            <?php } ?>
            <?php if ($dates_camp != "") : ?>
                <div class="dates_camp">
                    <h3>Dates de camp</h3>
                    <p><?php echo $dates_camp?></p>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>