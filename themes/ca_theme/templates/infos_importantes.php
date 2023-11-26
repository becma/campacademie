<?php include get_template_directory() . '/global-info.php' ?>

<?php
    $absence_memo = !empty(get_field('absence_memo')) ? get_field('absence_memo') : get_field("absence_memo", $sites_global) ; 
    $questions_memo = !empty(get_field('questions_memo')) ? get_field('questions_memo') : get_field("questions_memo", $sites_global) ; 

?>

<section class="infos-importantes">
    <div class="infos-importantes-content">
        <?php get_template_part('/templates/avertissement', 
                null, 
                array('class' => 'infos-importantes-content-absence',
                      'content' => $absence_memo )
              )
        ?>
        <?php get_template_part('/templates/avertissement', 
                null, 
                array('class' => 'infos-importantes-content-questions',
                      'content' => $questions_memo )
              )
        ?>
    </div>
</section>