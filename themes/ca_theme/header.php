<?php
/* Header Template */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php wp_head(); ?>
</head>

<body>
    <header class="header">
        <nav class="header-content">
            <div class="logo">
                <a href="<?php echo site_url(); ?>">
                    <img src="<?php bloginfo('template_url'); ?>/src/img/ca_rogne.png" alt="">
                </a>
            </div>
            <button class="nav-btn" aria-label="Ouvrir le menu">
                <i class="fa-solid fa-bars -active" aria-hidden="true"></i>
                <i class="fa-solid fa-x" aria-hidden="true"></i>
            </button>
                <?php
                    wp_nav_menu( $arg = array (
                        'menu' => 'Header',
                        'menu_class' => 'main-navigation',
                        'theme_location' => 'primary'
                    ));
                ?>
        </nav>
    </header>