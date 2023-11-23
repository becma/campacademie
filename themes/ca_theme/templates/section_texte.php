<?php
    $args = wp_parse_args(
        $args,
        array(
            'titre' => '',
            'texte' => ''
        )
    );
?>

<section class="texte-simple">
    <div class="texte-simple-content">
        <h3><?php echo $args['titre']; ?></h3>
        <div><?php echo $args['texte']; ?></div>
    </div>

</section>