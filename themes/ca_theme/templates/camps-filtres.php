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
?>

<section class="filtres-camps">
    <div class="filtres-camps-content">
        <div class="filtres-camps-content-header">
            <button id="campsFiltersHandler" aria-expanded="false" aria-controls="campsFilters"><h2>VOIR LES FILTRES</h2></button>
        </div>
        <div class="filtres-camps-content-filters" id="campsFilters">
            <form action="">
                <fieldset class="filtres-camps-content-filters-bases">
                    <label>
                        Nouveau camp
                        <input type="checkbox" id="nouveauCamp" class="sr-only">
                    </label>
                    <label >
                        Collaborateurs
                        <input type="checkbox" id="collaboCamp" class="sr-only">
                    </label>
                </fieldset>
                <fieldset class="filtres-camps-content-filters-sites">
                    <legend>SITES</legend>
                    <?php foreach ($sites as $site):
                        $nameSite = get_the_title($site->ID); ?>
                        <label>
                            <?php echo $nameSite; ?>
                            <input class="sr-only" type="checkbox" value="<?php echo $site->ID; ?>">
                        </label>
                    <?php endforeach ?>
                </fieldset>
                <fieldset class="filtres-camps-content-filters-categories">
                    <legend>CATÉGORIES</legend>
                    <?php foreach ($categories as $category) :
                        $nameCategory = get_field('nom_officiel', $category->ID); ?>
                        <label> 
                            <?php echo $nameCategory; ?>
                            <input class="sr-only" type="checkbox" value="<?php echo $category->ID; ?>">
                        </label>
                    <?php endforeach ?>
                </fieldset>
                <fieldset class="filtres-camps-content-filters-ages">
                    <legend>ÂGE</legend>
                    <?php foreach (range(4,15) as $age) : ?>
                        <label>
                            <?php echo $age . " ans"; ?>
                            <input class="sr-only" type="checkbox" value=<?php echo $age; ?>>
                        </label>
                    <?php endforeach ?>
                </fieldset>
            </form>
        </div>
    </div>
</section>