<?php
    /* Main footer file */
?>

    <footer class="footer">
            <div class="footer-content">
            <nav>
                <?php
                    wp_nav_menu( $arg = array (
                        'menu' => 'Header',
                        'menu_class' => 'footer-navigation',
                        'theme_location' => 'footer'
                    ));
                ?>
            </nav>
            <div class="contact-infos">
                <h3>Contact</h3>
                <ul>
                    <li>Québec: (418) 872-0129</li>
                    <li>Sans frais: 1-855-220-2267</li>
                    <li>info@campacademie.com</li>
                </ul>
            </div>
            <div class="campacademie_logo">
                <img src="<?php bloginfo('template_url') ?>/src/img/ca_rogne.png" alt="Logo du Camp Académie">
            </div>
        </div>
    </footer>

    <script src="<?php bloginfo('template_url') ?>/src/js/main.js"></script>
</body>
</html>