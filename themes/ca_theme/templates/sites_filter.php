<div class="sites-filter">
    <?php 
        $sites = get_field('site_city');
        $options = $sites['choices'];

        foreach ($options as $option):
            echo esc_attr($option);
        endforeach;
    ?>

    <div>
        <?php echo $sites; ?>
    </div>
</div>