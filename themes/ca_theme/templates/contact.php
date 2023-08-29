<?php
    $title = get_field('contact_title');
    $section_grey = get_field('contact-grey')
?>

<section class="contact <?php if ($section_grey = true) {echo "-grey-section";} ?>">
    <div class="contact-content">
        <h2><?php echo $title; ?></h2>
        <?php echo do_shortcode('[wpforms id="185"]'); ?>
    </div>
</section>