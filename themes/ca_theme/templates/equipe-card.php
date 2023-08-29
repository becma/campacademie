<?php
    $args = wp_parse_args(
        $args,
        array(
            'nom' => '',
            'position' => '',
            'photo' => '',
            'alt' => ''
        )
    );
?>

<div class="equipe-card">
    <img src="<?php echo $args['photo'] ?>" alt="<?php $args['alt'] ?>">
    <div class="card-content">
        <h3><?php echo $args['nom']; ?></h3>
        <p><?php echo $args['position']; ?></p>
    </div>
</div>