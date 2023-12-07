<?php include get_template_directory() . '/global-info.php' ?>

<?php
    $greySection = !empty(get_field('couts_camps_grey')) ? get_field('couts_camps_grey') : get_field('couts_camps_grey', $camps_global); 
    $title = !empty(get_field('cost_title')) ? get_field('cost_title') : get_field('cost_title', $camps_global);
    $desc = !empty(get_field('cost_desc')) ? get_field('cost_desc') : get_field('cost_desc', $camps_global);

    $coutTitre = !empty(get_field('tableau')['colonnes']['cout']['titre']) ? get_field('tableau')['colonnes']['cout']['titre'] : get_field('tableau', $camps_global)['colonnes']['cout']['titre'];

    $realCost = !empty(get_field('real_cost')) ? get_field('real_cost') : get_field('real_cost', $camps_global);

    if ($realCost === true) {
        $coutPrix = get_field('camp_prix');
    } else {
        $coutPrix = !empty(get_field('tableau')['colonnes']['cout']['base_price']) ? get_field('tableau')['colonnes']['cout']['base_price'] : get_field('tableau', $camps_global)['colonnes']['cout']['base_price'];
    }

    $revenuTitre = !empty(get_field('tableau')['colonnes']['revenu']['titre']) ? get_field('tableau')['colonnes']['revenu']['titre'] : get_field('tableau', $camps_global)['colonnes']['revenu']['titre'];
    $revenu1 = !empty(get_field('tableau')['colonnes']['revenu']['revenu1']) ? get_field('tableau')['colonnes']['revenu']['revenu1'] : get_field('tableau', $camps_global)['colonnes']['revenu']['revenu1'];
    $revenu2 = !empty(get_field('tableau')['colonnes']['revenu']['revenu2']) ? get_field('tableau')['colonnes']['revenu']['revenu2'] : get_field('tableau', $camps_global)['colonnes']['revenu']['revenu2'];
    $revenu3 = !empty(get_field('tableau')['colonnes']['revenu']['revenu3']) ? get_field('tableau')['colonnes']['revenu']['revenu3'] : get_field('tableau', $camps_global)['colonnes']['revenu']['revenu3'];

    $provincialTitre = !empty(get_field('tableau')['colonnes']['provincial']['titre']) ? get_field('tableau')['colonnes']['provincial']['titre'] : get_field('tableau', $camps_global)['colonnes']['provincial']['titre'];
    $creditP1 = !empty(get_field('tableau')['colonnes']['provincial']['credit1']) ? get_field('tableau')['colonnes']['provincial']['credit1'] : get_field('tableau', $camps_global)['colonnes']['provincial']['credit1'];
    $creditP2 = !empty(get_field('tableau')['colonnes']['provincial']['credit2']) ? get_field('tableau')['colonnes']['provincial']['credit2'] : get_field('tableau', $camps_global)['colonnes']['provincial']['credit2'];
    $creditP3 = !empty(get_field('tableau')['colonnes']['provincial']['credit3']) ? get_field('tableau')['colonnes']['provincial']['credit3'] : get_field('tableau', $camps_global)['colonnes']['provincial']['credit3'];

    $montantP1 = number_format((float)($coutPrix * ($creditP1 / 100) ), 2, '.', ''); 
    $montantP2 = number_format((float)($coutPrix * ($creditP2 / 100) ), 2, '.', ''); 
    $montantP3 = number_format((float)($coutPrix * ($creditP3 / 100) ), 2, '.', ''); 

    $federalTitre = !empty(get_field('tableau')['colonnes']['federal']['titre']) ? get_field('tableau')['colonnes']['federal']['titre'] : get_field('tableau', $camps_global)['colonnes']['federal']['titre'];
    $creditF1 = !empty(get_field('tableau')['colonnes']['federal']['deductible1']) ? get_field('tableau')['colonnes']['federal']['deductible1'] : get_field('tableau', $camps_global)['colonnes']['federal']['deductible1'];
    $creditF2 = !empty(get_field('tableau')['colonnes']['federal']['deductible2']) ? get_field('tableau')['colonnes']['federal']['deductible2'] : get_field('tableau', $camps_global)['colonnes']['federal']['deductible2'];
    $creditF3 = !empty(get_field('tableau')['colonnes']['federal']['deductible3']) ? get_field('tableau')['colonnes']['federal']['deductible3'] : get_field('tableau', $camps_global)['colonnes']['federal']['deductible3'];

    $montantF1 = number_format((float)($coutPrix * ($creditF1 / 100) ), 2, '.', '');
    $montantF2 = number_format((float)($coutPrix * ($creditF2 / 100) ), 2, '.', '');
    $montantF3 = number_format((float)($coutPrix * ($creditF3 / 100) ), 2, '.', '');

    $economieTitre = !empty(get_field('tableau')['colonnes']['economie']['titre']) ? get_field('tableau')['colonnes']['economie']['titre'] : get_field('tableau', $camps_global)['colonnes']['economie']['titre'];
    $economie1 = $montantP1 + $montantF1;
    $economie2 = $montantP2 + $montantF2;
    $economie3 = $montantP3 + $montantF3;

    $reelTitre = !empty(get_field('tableau')['colonnes']['reel']['titre']) ? get_field('tableau')['colonnes']['reel']['titre'] : get_field('tableau', $camps_global)['colonnes']['reel']['titre'];
    $reel1 = $coutPrix - $economie1;
    $reel2 = $coutPrix - $economie2;
    $reel3 = $coutPrix - $economie3;



?>

<section class="couts-camp <?php if ($greySection === true) {echo ' -grey-section'; } ?>">
    <div class="couts-camp-content">
        <h2><?php echo $title ?></h2>
        <div class="couts-camp-content-desc"><?php echo $desc; ?></div>
        <div class="couts-camp-content-table">
            <table>
                <tr>
                    <th><?php echo $coutTitre; ?></th>
                    <th><?php echo $revenuTitre; ?></th>
                    <th><?php echo $provincialTitre; ?></th>
                    <th><?php echo $federalTitre ?></th>
                    <th><?php echo $economieTitre ?></th>
                    <th><?php echo $reelTitre ?></th>
                </tr>
                <tr>
                    <td rowspan="3"><?php echo $coutPrix . "$"; ?></td>
                    <td><?php echo $revenu1; ?></td>
                    <td><?php echo $creditP1 . "% (". $montantP1 ."$)"; ?></td>
                    <td><?php echo $creditF1 . "% (". $montantF1 ."$)"; ?></td>
                    <td><?php echo $economie1 . "$"; ?></td>
                    <td><?php echo $reel1 . "$"; ?></td>
                </tr>
                <tr>
                    <td><?php echo $revenu2; ?></td>
                    <td><?php echo $creditP2 . "% (". $montantP2 ."$)"; ?></td>
                    <td><?php echo $creditF2 . "% (". $montantF2 ."$)"; ?></td>
                    <td><?php echo $economie2 . "$"; ?></td>
                    <td><?php echo $reel2 . "$"; ?></td>
                </tr>
                <tr>
                    <td><?php echo $revenu3; ?></td>
                    <td><?php echo $creditP3 . "% (". $montantP3 ."$)"; ?></td>
                    <td><?php echo $creditF3 . "% (". $montantF3 ."$)"; ?></td>
                    <td><?php echo $economie3 . "$"; ?></td>
                    <td><?php echo $reel3 . "$"; ?></td>
                </tr>
            </table>
        </div>
    </div>
</section>