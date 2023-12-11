<?php include get_template_directory() . '/global-info.php' ?>

<?php
    $sites = get_posts(array(
        'post_type' => 'sites',
        'numberposts' => -1
    )) ;

    $hasVideo = (get_field('camp_hasVideo'));
    $ageLabel = !empty(get_field('age_label')) ? get_field('age_label') : get_field('age_label', $camps_global);
    $priceLabel = !empty(get_field('price_label')) ? get_field('price_label') : get_field('price_label', $camps_global);
    $ageMin = get_field('camp_age')['minimum'];
    $ageMax = get_field('camp_age')['maximum'];
    $prix = get_field('camp_prix');
    $siteCtaLabel = !empty(get_field('site-cta_label')) ? get_field('site-cta_label') : get_field('site-cta_label', $camps_global);
    $disposCtaLabel = !empty(get_field('dispos-cta_label')) ? get_field('dispos-cta_label') : get_field('dispos-cta_label', $camps_global);
    $qidigoCtaLabel = !empty(get_field('qidigo-cta_label')) ? get_field('qidigo-cta_label') : get_field('qidigo-cta_label', $camps_global);

    $grillesObject = [];

    $i = 1;

    while ($i <= 6) {
        $cityArray = [];
        $fieldLabel = "ville$i";
        $villeGrille = get_field($fieldLabel, $grilles_global);
        $ville = $villeGrille['ville']['value'];
        $grille = !empty($villeGrille['grille']) ? $villeGrille['grille'] : false;
        $qidigo = !empty($villeGrille['qidigo']) ? $villeGrille['qidigo'] : false;

        $cityArray['grille'] = $grille;
        $cityArray['qidigo'] = $qidigo;

        $grillesObject[$ville] = $cityArray;
        $i ++;
    }
?>

<section class="camps-infos">
    <div class="camps-infos-content">
        <div class="camps-infos-content-desc">
            <div class="camps-infos-content-desc-text"><?php the_field('camp_description'); ?></div>
            <div class="camps-infos-content-desc-table-holder">
                <table>
                    <tr>
                        <th><span><?php echo $ageLabel; ?></span></th>
                        <th><span><?php echo $priceLabel; ?></span></th>
                    </tr>
                    <tr>
                        <td><span><?php echo "$ageMin-$ageMax ans"; ?></span></td>
                        <td><span><?php echo "$prix$"; ?></span></td>
                    </tr>
                </table>
            </div>
            <div class="camps-infos-content-desc-ctas-holder">
                <div class="select-site-holder">
                    <form method="GET" action="">
                        <select name="selectSite" id="selectSite">
                            <option value="choose"><?php echo $siteCtaLabel; ?></option>
                            <?php foreach ($sites as $site): ?>
                                <option value="<?php echo esc_html(get_field_object('site_city', $site->ID)['value']); ?>">
                                    <?php echo get_the_title($site); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="dispos-cta-holder">
                    <a class="dispos-link hidden" href="" tabindex="-1"><?php echo $disposCtaLabel; ?></a>
                </div>
                <div class="qidigo-cta-holder">
                    <a class="qidigo-link cta yellow hidden" href="" tabindex="-1"><?php echo $qidigoCtaLabel; ?></a>
                </div>
            </div>
        </div>
        <div class="camps-infos-content-media">
            <?php if ($hasVideo) {
                $videoId = get_field('video_id');
                echo "<iframe width='700' height='400' src='https://www.youtube.com/embed/$videoId' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
            } else {
                $imgSrc = get_field('camp_image')['url'];
                echo "<img src=\"$imgSrc\" />";
            }
            ?>
        </div>
    </div>

    <script>
        const grilleVilles = <?php echo json_encode($grillesObject); ?>;
        const selectSite = document.querySelector('#selectSite');
        const disposLink = document.querySelector('.dispos-link');  
        const qidigoLink = document.querySelector('.qidigo-link');

        selectSite.addEventListener('change', () => {
            let value = selectSite.value;

            for (const grilleVille in grilleVilles) {
                if (value === grilleVille) {
                    if (grilleVilles[value]['grille']) {
                        disposLink.setAttribute('href', grilleVilles[value]['grille']);
                        disposLink.classList.remove('hidden');
                        disposLink.setAttribute('tabindex', 0);
                        disposLink.setAttribute('aria-hidden', false);
                    } else {
                        disposLink.setAttribute('href', '');
                        disposLink.classList.add('hidden');
                        disposLink.setAttribute('tabindex', -1);
                        disposLink.setAttribute('aria-hidden', true);
                    }

                    if (grilleVilles[value]['qidigo']) {
                        qidigoLink.setAttribute('href', grilleVilles[value]['qidigo']);
                        qidigoLink.classList.remove('hidden');
                        qidigoLink.setAttribute('tabindex', 0);
                        qidigoLink.setAttribute('aria-hidden', false);
                    } else {
                        qidigoLink.setAttribute('href', '');
                        qidigoLink.classList.add('hidden');
                        qidigoLink.setAttribute('tabindex', -1);
                        qidigoLink.setAttribute('aria-hidden', true);
                    }
                }

            }
        })
    </script>
</section>