<?php include get_template_directory() . '/global-info.php' ?>

<?php 
    $section_grey = get_field('sacs-gris'); 

    $sac = get_field('sac');
    $sac_global = get_field('sac', $sites_global);
    $lunch = get_field('lunch');
    $lunch_global = get_field('lunch', $sites_global);

    if (!empty($sac) || !empty($sac_global)) {
        $sac_titre = !empty($sac['titre']) ? $sac['titre'] : $sac_global['titre'];
        $sac_contenu = !empty($sac['contenu']) ? $sac['contenu'] : $sac_global['contenu'];
    }

    if (!empty($lunch) || !empty($lunch_global)) {
        $lunch_titre = !empty($lunch['titre']) ? $lunch['titre'] : $lunch_global['titre'];
        $lunch_contenu = !empty($lunch['contenu']) ? $lunch['contenu'] : $lunch_global['contenu'];
    }

    $allergie = !empty(get_field('allergies_memo')) ? get_field('allergies_memo') : get_field('allergies_memo', $sites_global);
?>

<?php if (!empty($sac) || !empty($sac_global) || !empty($lunch) || !empty($lunch_global) || !empty($allergie)) : ?>
    <section class="sacs <?php if ($sacs_section_grey === true) {echo "-grey-section";} ?>">
        <div class="sacs-content">
            <div class="sacs-content-dans">
                <?php if (!empty($sac) || !empty($sac_global)) : ?>
                    <div class="sac-a-dos">
                        <h3>
                            <?php if (!empty($sac_titre)) { echo $sac_titre;} ?>
                        </h3>
                        <div>
                            <?php if (!empty($sac_contenu)) { echo $sac_contenu; } ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($lunch) || !empty($lunch_global)) : ?>
                    <div class="boite-a-lunch">
                        <h3>
                            <?php if (!empty($lunch_titre)) { echo $lunch_titre ; } ?>
                        </h3>
                        <div>
                            <?php if (!empty($lunch_contenu)) { echo $lunch_contenu; } ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($allergie)) {
                get_template_part('/templates/avertissement',
                    null,
                    array(
                        'class' => 'sacs-content-allergies',
                        'content' => $allergie,
                    ));
                }
            ?>
        </div>
    </section>
<?php endif; ?>