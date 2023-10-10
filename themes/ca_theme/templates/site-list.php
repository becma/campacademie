<section class="site-list">
    <div class="site-list-content">

        <div class="site-list-content-filter -mobile">
            <select name="" id="">
                <option value="All">Tous nos sites</option>

            <?php 
                $sites = get_field_object('site_city');
                $options = $sites['choices'];

                foreach ($options as $option): ?>
                    <option value="<?php echo esc_attr($option); ?>">
                        <?php echo esc_attr($option); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <i class="fa-solid fa-chevron-down"></i>
        </div>

        <div class="site-list-content-filter -desktop">
            <button class="active" data-city="All">Tous nos sites</button>

        <?php 
            $sites = get_field_object('site_city');
            $options = $sites['choices'];

            foreach ($options as $option): ?>
                <button data-city="<?php echo esc_attr($option); ?>">
                    <?php echo esc_attr($option); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="site-list-content-sites">
            <?php   
                $sites = get_posts(array(
                    'post_type' => 'sites',
                    'numberposts' => -1
                )) ;
            ?>

            <?php foreach ($sites as $site):
                if (get_field('list_img', $site->ID)) {
                    $site_img = get_field('list_img', $site->ID);
                }
                $img_url = esc_url($site_img['url']); 
                if (get_field('override_name', $site->ID)) {
                    $site_name = get_field('override_name', $site->ID);
                } else {
                    $site_name = get_the_title($site->ID);
                }
                $site_city = get_field_object('site_city', $site->ID);
                $city_value = $site_city['value'];
                $city_label = esc_html($site_city['choices'][ $city_value ]);
                if (get_field('cta_label', $site->ID)) {
                    $cta_label = get_field('cta_label', $site->ID);
                } else {
                    $cta_label = get_field('cta_default_label');
                }
                $permalink = get_permalink($site->ID);
                if (get_field('brochure_label', $site->ID)) {
                    $brochure_label = get_field('brochure_label', $site->ID);
                } else {
                    $brochure_label = get_field('default_brochure_label');
                }
                if ($brochure_file = get_field('brochure_file', $site->ID)) {
                    $brochure_file = get_field('brochure_file', $site->ID);
                    $brochure_file_url = $brochure_file['url'];
                } else {
                    $brochure_file_url = '';
                }
                if (get_field('quartier', $site->ID)) {
                    $quartier = get_field('quartier', $site->ID);
                } else {
                    $quartier = '';
                }
            ?>
                <?php get_template_part(
                    'templates/site-card', 
                    null, 
                    array(
                        'img' => $img_url,
                        'nom' => $site_name,
                        'ville' => $city_label,
                        'quartier' => $quartier,
                        'label' => $cta_label,
                        'permalink' => $permalink,
                        'brochure_label' => $brochure_label,
                        'brochure_file' => $brochure_file_url)
                ); 
                ?>
                
            <?php endforeach; ?>
        </div>
    </div>
</section>