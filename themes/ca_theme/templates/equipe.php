<?php
    $section_grey = get_field('equipe-gris');

    $nom1 = get_field('equipe_nom_1');
    $position1 = get_field('equipe_position_1');
    $photoArray1 = get_field('equipe_photo_1');
    $photo1 = esc_url($photoArray1['url']);
    $alt1 = get_field('equipe_alt_1');

    $nom2 = get_field('equipe_nom_2');
    $position2 = get_field('equipe_position_2');
    $photoArray2 = get_field('equipe_photo_2');
    $photo2 = esc_url($photoArray2['url']);
    $alt2 = get_field('equipe_alt_2');

    $nom3 = get_field('equipe_nom_3');
    $position3 = get_field('equipe_position_3');
    $photoArray3 = get_field('equipe_photo_3');
    $photo3 = esc_url($photoArray3['url']);
    $alt3 = get_field('equipe_alt_3');

    $nom4 = get_field('equipe_nom_4');
    $position4 = get_field('equipe_position_4');
    $photoArray4 = get_field('equipe_photo_4');
    $photo4 = esc_url($photoArray4['url']);
    $alt4 = get_field('equipe_alt_4');

    $nom5 = get_field('equipe_nom_5');
    $position5 = get_field('equipe_position_5');
    $photoArray5 = get_field('equipe_photo_5');
    $photo5 = esc_url($photoArray5['url']);
    $alt5 = get_field('equipe_alt_5');

    $nom6 = get_field('equipe_nom_6');
    $position6 = get_field('equipe_position_6');
    $photoArray6 = get_field('equipe_photo_6');
    $photo6 = esc_url($photoArray6['url']);
    $alt6 = get_field('equipe_alt_6');
?>

<section class="equipe <?php if ($section_grey = true) {echo "-grey-section";} ?>">
    <div class="equipe-content">
        <h2><?php the_field('equipe_title'); ?></h2>
        <div class="cards-container">
            <?php get_template_part(
                'templates/equipe-card', 
                null, 
                array(
                    'nom' => $nom1,
                    'position' => $position1,
                    'photo' => $photo1,
                    'alt' => $alt1)
                ); 
            ?>
            <?php get_template_part(
                'templates/equipe-card', 
                null, 
                array(
                    'nom' => $nom2,
                    'position' => $position2,
                    'photo' => $photo2,
                    'alt' => $alt2)
                ); 
            ?>
            <?php get_template_part(
                'templates/equipe-card', 
                null, 
                array(
                    'nom' => $nom3,
                    'position' => $position3,
                    'photo' => $photo3,
                    'alt' => $alt3)
                ); 
            ?>
            <?php get_template_part(
                'templates/equipe-card', 
                null, 
                array(
                    'nom' => $nom4,
                    'position' => $position4,
                    'photo' => $photo4,
                    'alt' => $alt4)
                ); 
            ?>
            <?php get_template_part(
                'templates/equipe-card', 
                null, 
                array(
                    'nom' => $nom5,
                    'position' => $position5,
                    'photo' => $photo5,
                    'alt' => $alt5)
                ); 
            ?>
            <?php get_template_part(
                'templates/equipe-card', 
                null, 
                array(
                    'nom' => $nom6,
                    'position' => $position6,
                    'photo' => $photo6,
                    'alt' => $alt6)
                ); 
            ?>
        </div>
    </div>
</section>