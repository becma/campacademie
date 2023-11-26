<?php include get_template_directory() . '/global-info.php' ?>

<?php
    $grey_section = get_field('faq_gris') ;
    $faq_title = !empty(get_field('faq_title')) ? get_field('faq_title') : get_field('faq_title', $sites_global);
?>

<?php 
    function createFaqBlock($faq_name) {
        global $sites_global;
        $faq = get_field($faq_name);
        $faq_global = get_field($faq_name, $sites_global);
        $question = !empty($faq['question']) ? $faq['question'] : $faq_global['question'] ;
        $reponse = !empty($faq['reponse']) ? $faq['reponse'] : $faq_global['reponse'] ;

        if (!empty($question) && !empty($reponse)) {
            get_template_part('/templates/faq_block',
            null,
            array(
                'question' => $question,
                'reponse' => $reponse,
            ));
        }
    }
?>

<section class="faq <?php if ($grey_section === true) {echo ' -grey-section'; } ?>">
    <div class="faq-content">
        <h2><?php echo $faq_title; ?></h2>
        <?php createFaqBlock('question1');?>
        <?php createFaqBlock('question2');?>
        <?php createFaqBlock('question3');?>
        <?php createFaqBlock('question4');?>
        <?php createFaqBlock('question5');?>
        <?php createFaqBlock('question6');?>
        <?php createFaqBlock('question7');?>
        <?php createFaqBlock('question8');?>
        <?php createFaqBlock('question9');?>
        <?php createFaqBlock('question10');?>
    </div>
</section>