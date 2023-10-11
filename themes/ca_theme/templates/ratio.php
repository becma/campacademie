<?php
    $image = get_field('ratios_img');
?>

<section class="ratios">
    <div class="ratios-content">
        <h2><?php the_field('titre_section-table'); ?></h2>
        <div class="ratios-content-infos">
            <div class="ratios-content-image">
                <img src="<?php echo esc_url($image['url']); ?>" alt="">
            </div>
            <div class="ratios-content-table-container">
                <table>
                    <tr>
                        <th><?php the_field('rangee1_tableau-title'); ?></th>
                        <td><?php the_field('rangee1_tableau-value'); ?></td>
                    </tr>
                    <tr>
                        <th><?php the_field('rangee2_tableau-title'); ?></th>
                        <td><?php the_field('rangee2_tableau-value'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>