<?php include get_template_directory() . '/global-info.php' ?>

<?php
    $tel1_label = get_field('tel1_label', $coordonnees);
    $tel1_num = get_field('tel1_num', $coordonnees);
    $tel2_label = get_field('tel2_label', $coordonnees);
    $tel2_num = get_field('tel2_num', $coordonnees);
    $courriel = get_field('courriel', $coordonnees);
    $horaire_label = get_field('horaire_label', $coordonnees);
    $horaire_heures = get_field('horaire_heures', $coordonnees);

    if(ctype_digit($tel1_num)) {
    $tel1_num_dashes = substr($tel1_num, 0, 3) .'-'.
                substr($tel1_num, 3, 3) .'-'.
                substr($tel1_num, 6);
    }

    if(ctype_digit($tel2_num)) {
    $tel2_num_dashes = substr($tel2_num, 0, 1) .'-'.
                substr($tel2_num, 1, 3) .'-'.
                substr($tel2_num, 4, 3) .'-'.
                substr($tel2_num, 7);
    }
?>

<section class="coordonnees">
    <div class="coordonnees-content">
        <div class="coordonnees-content-tel">
            <i class="fa-solid fa-phone"></i> 
            <div class="coordonnees-content-tel-numbers">
                <div class="tel1">
                    <p><span class="unbr"><?php echo $tel1_label; ?> : </span></p>
                    <a href="tel:<?php echo $tel1_num; ?>"><span class="unbr"><?php echo $tel1_num_dashes; ?></span></a>
                </div>  
                <div class="tel2">
                    <p><span class="unbr"><?php echo $tel2_label; ?> : </span></p>
                    <a href="tel:<?php echo $tel2_num; ?>"><span class="unbr"><?php echo $tel2_num_dashes; ?></span></a>
                </div>
            </div>
        </div>
        <div class="coordonees-content-email">
            <i class="fa-solid fa-envelope"></i>
            <div class="coordonnees-content-email-adress">
                <a href="mailto:<?php echo $courriel; ?>"><?php echo $courriel; ?></a>
            </div>
        </div>
        <div class="coordonnees-content-hours">
            <i class="fa-sharp fa-solid fa-clock"></i>
            <div class="coordonnees-content-hours-infos">
                <p class="coordonnees-content-hours-label"><span class="unbr"><?php echo $horaire_label ?></span></p>
                <p><span class="unbr"><?php echo $horaire_heures ?></span></p>
            </div>
        </div>
    </div>
</section>