<?php include get_template_directory() . '/global-info.php' ?>

<?php
    $title = !empty(get_field('contact_title')) ? get_field('contact_title') : get_field('contact_title', $sites_global);
    $section_grey = !empty(get_field('contact_grey')) ? get_field('contact_grey') : get_field('contact_grey', $sites_global);
?>

<section class="contact <?php if ($section_grey === true) {echo "-grey-section";} ?>">
    <div class="contact-content">
        <h2><?php echo $title; ?></h2>
        <?php echo do_shortcode('[contact-form-7 id="446" title="Contact"]'); ?>
    </div>
</section>