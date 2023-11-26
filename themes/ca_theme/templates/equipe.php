<?php include get_template_directory() . '/global-info.php' ?>

<?php
    $section_grey = get_field('equipe-gris');

    $membre1 = get_field('membre1', $direction);
    $membre2 = get_field('membre2', $direction);
    $membre3 = get_field('membre3', $direction);
    $membre4 = get_field('membre4', $direction);
    $membre5 = get_field('membre5', $direction);
    $membre6 = get_field('membre6', $direction);
?>

<section class="equipe <?php if ($section_grey = true) {echo "-grey-section";} ?>">
    <div class="equipe-content">
        <h2><?php the_field('equipe_title'); ?></h2>
        <div media="(min-width:1201px)" class="cards-container" becma-slider slides-active="3" slides-to-scroll="1" automatic-width breakpoints="{'1201': {'slidesToShow':'2'}, '708': {'slidesToShow': '1'} }">
            <?php 
                if ($membre1 && $membre1['nom']) {
                    get_template_part(
                        'templates/equipe-card', 
                        null, 
                        array('membre' => $membre1)
                    ); 
                }
                if ($membre2 && $membre2['nom']) {
                    get_template_part(
                        'templates/equipe-card', 
                        null, 
                        array('membre' => $membre2)
                    ); 
                }
                if ($membre3 && $membre3['nom']) {
                    get_template_part(
                        'templates/equipe-card', 
                        null, 
                        array('membre' => $membre3)
                    ); 
                }
                if ($membre4 && $membre4['nom']) {
                    get_template_part(
                        'templates/equipe-card', 
                        null, 
                        array('membre' => $membre4)
                    ); 
                }
                if ($membre5 && $membre5['nom']) {
                    get_template_part(
                        'templates/equipe-card', 
                        null, 
                        array('membre' => $membre5)
                    ); 
                }
                if ($membre6 && $membre6['nom']) {
                    get_template_part(
                        'templates/equipe-card', 
                        null, 
                        array('membre' => $membre6)
                    ); 
                }
            ?>
        </div>
    </div>
</section>