<?php   
    $sites = get_posts(array(
        'post_type' => 'sites',
        'numberposts' => -1
    ));

    $categories = get_posts(array(
        'post_type' => 'categories',
        'numberposts' => -1,
        'post_status' => array('publish', 'private')
    ));

    $ouvrir_label = get_field('menu_labels')['open'];
    $fermer_label = get_field('menu_labels')['close'];
    $nouveau_label = get_field('special-camps_labels')['nouveau'];
    $collabo_label = get_field('special-camps_labels')['collabo'];
    $sites_label = get_field('filters_labels')['sites'];
    $categories_label = get_field('filters_labels')['categories'];
    $ages_label = get_field('filters_labels')['ages'];
?>

<section class="filtres-camps">
    <div class="filtres-camps-content">
        <div class="filtres-camps-content-header">
            <button id="campsFiltersHandler" aria-expanded="false" aria-controls="campsFilters" data-open-label="<?php echo $ouvrir_label; ?>" data-close-label="<?php echo $fermer_label; ?>">
                <h2><?php echo $ouvrir_label; ?></h2>
            </button>
        </div>
        <div class="filtres-camps-content-filters" id="campsFilters">
            <form action="">
                <fieldset class="filtres-camps-content-filters-bases">
                    <label>
                        <span><?php echo $nouveau_label; ?></span>
                        <input type="checkbox" id="nouveauCamp" class="sr-only">
                    </label>
                    <label >
                        <span><?php echo $collabo_label; ?></span>
                        <input type="checkbox" id="collaboCamp" class="sr-only">
                    </label>
                </fieldset>
                <fieldset class="filtres-camps-content-filters-sites">
                    <legend><?php echo $sites_label; ?></legend>
                    <?php foreach ($sites as $site):
                        $nameSite = get_the_title($site->ID); ?>
                        <label>
                            <span><?php echo $nameSite; ?></span>
                            <input class="sr-only" type="checkbox" value="<?php echo $site->ID; ?>">
                        </label>
                    <?php endforeach ?>
                </fieldset>
                <fieldset class="filtres-camps-content-filters-categories">
                    <legend><?php echo $categories_label ?></legend>
                    <?php foreach ($categories as $category) :
                        $nameCategory = get_field('nom_officiel', $category->ID); ?>
                        <label>
                            <span><?php echo $nameCategory; ?></span>
                            <input class="sr-only" type="checkbox" value="<?php echo $category->ID; ?>">
                        </label>
                    <?php endforeach ?>
                </fieldset>
                <fieldset class="filtres-camps-content-filters-ages">
                    <legend><?php echo $ages_label; ?></legend>
                    <?php foreach (range(4,15) as $age) : ?>
                        <label>
                            <span><?php echo $age . " ans"; ?></span>
                            <input class="sr-only" type="checkbox" value=<?php echo $age; ?>>
                        </label>
                    <?php endforeach ?>
                </fieldset>
            </form>
        </div>
    </div>
</section>