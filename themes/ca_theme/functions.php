<?php
    function create_posttype() {

        register_post_type( 'realisations',
        array(
            'labels' => array(
                'name' => __( 'Réalisations' ),
                'singular_name' => __( 'Réalisation' )
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-buddicons-activity',
            'rewrite' => array('slug' => 'realisations'),
            'show_in_rest' => true,
            'supports' => array('title', 'id')
        ));
    };

    add_action( 'init', 'create_posttype' );

    
    register_post_type( 'sites',
            array(
                'labels' => array(
                    'name' => __( 'Sites' ),
                    'singular_name' => __( 'Site' )
                ),
                'public' => true,
                'has_archive' => true,
                'menu_icon' => 'dashicons-admin-multisite',
                'rewrite' => array('slug' => 'sites'),
                'show_in_rest' => true,
                'supports' => array('title', 'id'),
    
            )
    );
?>