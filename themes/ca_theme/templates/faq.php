<?php include get_template_directory() . '/global-info.php' ?>

<?php

    $grey_section = get_field('faq_gris') ;

    $faq_title = !empty(get_field('faq_title')) ? get_field('faq_title') : get_field('faq_title', $sites_global);

    $faq1 = get_field('question1');
    $faq1_global = get_field('question1', $sites_global);
    $faq1_question = !empty($faq1['question']) ? $faq1['question'] : $faq1_global['question'];
    $faq1_reponse = !empty($faq1['reponse']) ? $faq1['reponse'] : $faq1_global['reponse'];
   
    $faq2 = get_field('question2');
    $faq2_global = get_field('question2', $sites_global);
    $faq2_question = !empty($faq2['question']) ? $faq2['question'] : $faq2_global['question'];
    $faq2_reponse = !empty($faq2['reponse']) ? $faq2['reponse'] : $faq2_global['reponse'];
   
    $faq3 = get_field('question3');
    $faq3_global = get_field('question3', $sites_global);
    $faq3_question = !empty($faq3['question']) ? $faq3['question'] : $faq3_global['question'];
    $faq3_reponse = !empty($faq3['reponse']) ? $faq3['reponse'] : $faq3_global['reponse'];
    
    $faq4 = get_field('question4');
    $faq4_global = get_field('question4', $sites_global);
    $faq4_question = !empty($faq4['question']) ? $faq4['question'] : $faq4_global['question'];
    $faq4_reponse = !empty($faq4['reponse']) ? $faq4['reponse'] : $faq4_global['reponse'];
    
    $faq5 = get_field('question5');
    $faq5_global = get_field('question5', $sites_global);
    $faq5_question = !empty($faq5['question']) ? $faq5['question'] : $faq5_global['question'];
    $faq5_reponse = !empty($faq5['reponse']) ? $faq5['reponse'] : $faq5_global['reponse'];
    
    $faq6 = get_field('question6');
    $faq6_global = get_field('question6', $sites_global);
    $faq6_question = !empty($faq6['question']) ? $faq6['question'] : $faq6_global['question'];
    $faq6_reponse = !empty($faq6['reponse']) ? $faq6['reponse'] : $faq6_global['reponse'];
    
    $faq7 = get_field('question7');
    $faq7_global = get_field('question7', $sites_global);
    $faq7_question = !empty($faq7['question']) ? $faq7['question'] : $faq7_global['question'];
    $faq7_reponse = !empty($faq7['reponse']) ? $faq7['reponse'] : $faq4_global['reponse'];
    
    $faq8 = get_field('question8');
    $faq8_global = get_field('question8', $sites_global);
    $faq8_question = !empty($faq8['question']) ? $faq8['question'] : $faq8_global['question'];
    $faq8_reponse = !empty($faq8['reponse']) ? $faq8['reponse'] : $faq8_global['reponse'];
    
    $faq9 = get_field('question9');
    $faq9_global = get_field('question9', $sites_global);
    $faq9_question = !empty($faq9['question']) ? $faq9['question'] : $faq9_global['question'];
    $faq9_reponse = !empty($faq9['reponse']) ? $faq9['reponse'] : $faq9_global['reponse'];
    
    $faq10 = get_field('question10');
    $faq10_global = get_field('question10', $sites_global);
    $faq10_question = !empty($faq10['question']) ? $faq10['question'] : $faq10_global['question'];
    $faq10_reponse = !empty($faq10['reponse']) ? $faq10['reponse'] : $faq10_global['reponse'];

?>

<section class="faq <?php if ($grey_section === true) {echo ' -grey-section'; } ?>">
    <div class="faq-content">
        <h2><?php echo $faq_title; ?></h2>
        <?php 
        if (!empty($faq1_question) && !empty($faq1_reponse)) {
            get_template_part('/templates/faq_block',
            null,
            array(
                'question' => $faq1_question,
                'reponse' => $faq1_reponse,
            ));
        }
        ?>
        <?php 
        if (!empty($faq2_question) && !empty($faq2_reponse)) {
            get_template_part('/templates/faq_block',
            null,
            array(
                'question' => $faq2_question,
                'reponse' => $faq2_reponse,
            ));
        }
        ?>
        <?php 
        if (!empty($faq3_question) && !empty($faq3_reponse)) {
            get_template_part('/templates/faq_block',
            null,
            array(
                'question' => $faq3_question,
                'reponse' => $faq3_reponse,
            ));
        }
        ?>
        <?php 
        if (!empty($faq4_question) && !empty($faq4_reponse)) {
            get_template_part('/templates/faq_block',
            null,
            array(
                'question' => $faq4_question,
                'reponse' => $faq4_reponse,
            ));
        }
        ?>
        <?php 
        if (!empty($faq5_question) && !empty($faq5_reponse)) {
            get_template_part('/templates/faq_block',
            null,
            array(
                'question' => $faq5_question,
                'reponse' => $faq5_reponse,
            ));
        }
        ?>
        <?php 
        if (!empty($faq6_question) && !empty($faq6_reponse)) {
            get_template_part('/templates/faq_block',
            null,
            array(
                'question' => $faq6_question,
                'reponse' => $faq6_reponse,
            ));
        }
        ?>
        <?php 
        if (!empty($faq7_question) && !empty($faq7_reponse)) {
            get_template_part('/templates/faq_block',
            null,
            array(
                'question' => $faq7_question,
                'reponse' => $faq7_reponse,
            ));
        }
        ?>
        <?php 
        if (!empty($faq8_question) && !empty($faq8_reponse)) {
            get_template_part('/templates/faq_block',
            null,
            array(
                'question' => $faq8_question,
                'reponse' => $faq8_reponse,
            ));
        }
        ?>
        <?php 
        if (!empty($faq9_question) && !empty($faq9_reponse)) {
            get_template_part('/templates/faq_block',
            null,
            array(
                'question' => $faq9_question,
                'reponse' => $faq9_reponse,
            ));
        }
        ?>
        <?php 
        if (!empty($faq10_question) && !empty($faq10_reponse)) {
            get_template_part('/templates/faq_block',
            null,
            array(
                'question' => $faq10_question,
                'reponse' => $faq10_reponse,
            ));
        }
        ?>
    </div>
</section>