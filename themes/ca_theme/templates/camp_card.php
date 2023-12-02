<?php 
    $args = wp_parse_args(
        $args,
        array (
            'nom' => '',
            'duree' => '',
            'description' => '',
            'categories' => '',
            'age_label' => '',
            'agemin' => '',
            'price_label' => '',
            'price' => '',
            'site' => '',
            'nouveau' => '',
            'ado_miniclub' => '',
            'ado_miniclub_label' => '',
            'collabo' => '',
            'collabo_url' => '',
            'permalink' => ''
        )
    );
?>

<?php
    $categoriesArray = [];
    foreach($args['categories'] as $category) {
        array_push($categoriesArray, $category->ID);
    }
?>
<?php
    $sitesArray = [];
    if (!empty($args['sites'])) {
        foreach($args['sites'] as $site) {
            array_push($sitesArray, $site->ID);
        }
    }
?>
<?php
    $hasCollabo = false;
    if (!empty($collabo)) {
        $hasCollabo = true;
    }
?>

<div class="carte-camp" 
     data-age="<?php echo implode(",", range($args['agemin'], $args['agemax'])); ?>" 
     data-categories="<?php echo implode(",", $categoriesArray); ?>"
     data-sites="<?php echo implode(",", $sitesArray); ?>"
     data-ado-miniclub="<?php echo $args['ado_miniclub'];?>" 
     data-new="<?php echo $args['nouveau']; ?>"
     <?php if (!empty($args['collabo'])) { echo "data-collabo";} ?>>
    <?php if ($args['ado_miniclub'] !== 'none'): ?>
        <div class="pastille-<?php echo $args['ado_miniclub']; ?>">
        <?php 
            echo esc_html($args['ado_miniclub_label']);
        ?>
        </div>
    <?php endif ?>
    <?php if ($args['nouveau'] === true): ?>
        <div class="pastille-nouveau">
            Nouveau!
        </div>
    <?php endif ?>
    <div class="intro">
        <h2><?php echo $args['nom'] ?></h3>
        <p><?php echo $args['duree'] . " semaine"; if ($args['duree'] > 1) { echo "s"; }?></p>
        <?php 
        if ($args['categories']) {
            foreach ($args['categories'] as $post) {
                $nom = get_field('nom_officiel', $post->ID);
                echo "<p class=\"categorie\">" . $nom . "</p>";
            }
        }
        
        ?>
        <?php if (!empty($args['collabo'])) {
            echo "<p class=\"collabo\">Collaborateur - ";
            if (!empty($args['collabo_url'])) { echo "<a href=\"" . $args['collabo_url'] . "\">" ;}
            echo $args['collabo'];
            if (!empty($args['collabo_url'])) { echo "</a>"; }
            echo "</p>";
        } ?>
    </div>
    <div class="desc"><?php echo $args['description']; ?></div>
    <div class="table-holder">
        <table>
            <tr>
                <th><?php echo $args['age_label'] ?></th>
                <th><?php echo $args['price_label'] ?></th>
            </tr>
            <tr>
                <td><?php echo $args['agemin'] . "-" . $args['agemax'] . " ans"; ?></td>
                <td><?php echo $args['price'] . "$"; ?></td>
            </tr>
        </table>
    </div>
    <div class="lien-camp">
        <a class="cta yellow" href="<?php echo $args['permalink']; ?>">PLUS D'INFORMATIONS</a>
    </div>
</div>