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
?>

<section class="site-infos">
    <div class="site-info-content">
        <h2><?php the_field('titre_section'); ?></h2>
        <div class="info-container">
            <div class="tel">
                <h3><?php the_field('phone_label'); ?></h3>
                <a href="tel:<?php echo $tel; ?>"><?php echo $tel_num_dashes; ?></a>
            </div>
            <div class="courriel">
                <h3><?php the_field('email_label'); ?></h3>
                <a href="mailto:<?php the_field('email_address'); ?>"><?php the_field('email_address'); ?></a>
            </div>
            <div class="surveillance">
                <h3><?php the_field('surveillance_label'); ?></h3>
                <p><?php the_field('surveillance_hours'); ?></p>
            </div>
            <div class="adresse">
                <h3><?php the_field('address_label'); ?></h3>
                <p><?php the_field('phys_address'); ?></p>
                <p><?php echo $city_label; ?></p>
            </div>
            <?php if (get_field('traiteur')) { ?>
                <div class="traiteur">
                    <h3><?php the_field('traiteur_label'); ?></h3>
                    <a href="<?php echo get_page_link(490); ?>"><?php the_field('traiteur_link_label'); ?></a>
                </div>
            <?php } ?>
            <div class="dates_camp">
                <h3><?php the_field('dates_camp_label'); ?></h3>
                <p><?php the_field('dates_camp'); ?></p>
            </div>
        </div>
    </div>
</section>