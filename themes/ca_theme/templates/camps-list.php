<?php include get_template_directory() . '/global-info.php' ?>

<section class="liste-camps">
    <div class="liste-camps-content">
        <?php   
            $camp = get_posts(array(
                'post_type' => 'camps',
                'numberposts' => -1,
                'orderby' => 'title',
                'order' => 'ASC'
            )) ;
        ?>

        <?php foreach ($camp as $camp) {
            $nom = !empty(get_field('camp_modified_name', $camp)) ? get_field('camp_modified_name', $camp) : get_the_title($camp->ID);
            $duree = !empty(get_field('duration', $camp)) ? get_field('duration', $camp) : 1; 
            $categories = get_field('camp_categories', $camp);
            $description = get_field('camp_description', $camp);
            $age_label = !empty(get_field('age_label')) ? get_field('age_label') : get_field('age_label', $camps_global);
            $agemin = get_field('camp_age', $camp)['minimum'];
            $agemax = get_field('camp_age', $camp)['maximum'];
            $price_label = !empty(get_field('price_label')) ? get_field('price_label') : get_field('price_label', $camps_global);
            $price = get_field('camp_prix', $camp);
            $sites = get_field('sites_dispo', $camp);

            $nouveau = get_field('nouveau_camp', $camp);
            $ado_miniclub = get_field_object('miniclub_ado', $camp)['value'];
            $ado_miniclub_labels = get_field_object('miniclub_ado', $camp)['choices'];
            $ado_miniclub_label = $ado_miniclub_labels[$ado_miniclub];

            $collabo = get_field('sponsor_name', $camp);
            $collabo_url = get_field('sponsor_website', $camp);

            $permalink = get_permalink($camp->ID);

            get_template_part("/templates/camp_card", null, 
            array (
                'nom' => $nom,
                'duree' => $duree,
                'categories' => $categories,
                'description' => $description,
                'age_label' => $age_label,
                'agemin' => $agemin,
                'agemax' => $agemax,
                'price_label' => $price_label,
                'price' => $price,
                'sites' => $sites,
                'nouveau' => $nouveau,
                'ado_miniclub' => $ado_miniclub,
                'ado_miniclub_label' => $ado_miniclub_label,
                'collabo' => $collabo,
                'collabo_url' => $collabo_url,
                'permalink' => $permalink
            ));
        }
        ?>
    </div>
</section>