<?php include get_template_directory() . '/global-info.php' ?>

<section class="infos-importantes">
    <div class="infos-importantes-content">
        <div class="infos-importantes-content-absence">
            <?php the_field("absence_memo", $sites_global); ?>
        </div>
        <div class="infos-importantes-content-questions">
            <?php the_field("questions_memo", $sites_global); ?>
        </div>
    </div>
</section>