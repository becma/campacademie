<?php include get_template_directory() . '/global-info.php' ?>

<?php
    $postType = get_post_type();
    $grey_section = !empty(get_field('faq_gris')) ? get_field('faq_gris') : ($postType === "camps" ? get_field('faq_gris', $camps_global) : get_field('faq_gris', $sites_global));
    $faq_title = !empty(get_field('faq_title')) ? get_field('faq_title') : ($postType === "camps" ? get_field('faq_title', $camps_global) : get_field('faq_title', $sites_global));
?>

<?php 
    function createFaqBlock($faq_name, $camps_global, $sites_global, $postType) {
        $faq = get_field($faq_name);
        $faq_global = $postType === "camps" ? get_field($faq_name, $camps_global) : get_field($faq_name, $sites_global);
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
        <?php createFaqBlock('question1', $camps_global, $sites_global, $postType);?>
        <?php createFaqBlock('question2', $camps_global, $sites_global, $postType);?>
        <?php createFaqBlock('question3', $camps_global, $sites_global, $postType);?>
        <?php createFaqBlock('question4', $camps_global, $sites_global, $postType);?>
        <?php createFaqBlock('question5', $camps_global, $sites_global, $postType);?>
        <?php createFaqBlock('question6', $camps_global, $sites_global, $postType);?>
        <?php createFaqBlock('question7', $camps_global, $sites_global, $postType);?>
        <?php createFaqBlock('question8', $camps_global, $sites_global, $postType);?>
        <?php createFaqBlock('question9', $camps_global, $sites_global, $postType);?>
        <?php createFaqBlock('question10', $camps_global, $sites_global, $postType);?>
    </div>
</section>