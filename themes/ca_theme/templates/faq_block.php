<?php
    $args = wp_parse_args(
        $args,
        array(
            'question' => '',
            'reponse' => ''
        )
        );
?>

<div class="faq-block">
    <button class="faq-block_question-btn">
        <h3 class="faq-question"><?php echo $args['question']; ?></h3>
        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
    </button>
    <div class="faq-answer">
        <div class="faq-answer-content">
            <?php echo $args['reponse']; ?>
        </div>
    </div>
</div>