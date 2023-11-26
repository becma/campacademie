<?php
    $args = wp_parse_args(
        $args,
        array(
            'membre' => '',
        )
    );
?>

<?php
    $membre = $args['membre'];
    $membre_nom = $membre['nom'];
    $membre_position = $membre['position'];
    $membre_photo = $membre['photo'];
?>

<div class="equipe-card">
    <img src="<?php echo esc_url($membre['photo']['url']) ?>" alt="<?php echo esc_attr($membre['photo']['alt']) ?>">
    <div class="card-content">
        <h3><?php echo $membre_nom; ?></h3>
        <p><?php echo $membre_position; ?></p>
    </div>
</div>