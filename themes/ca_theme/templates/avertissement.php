<?php
    $args = wp_parse_args(
        $args,
        array(
            'class' => '',
            'content' => '',
        )
    );
?>

<div class="<?php echo $args['class']; ?> avertissement">
    <?php echo $args['content']?>
</div>