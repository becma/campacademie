<?php

    // CUSTOM POSTS TYPES

    function create_posttype() {

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
        
        register_post_type( 'camps',
                array(
                    'labels' => array(
                        'name' => __( 'Camps' ),
                        'singular_name' => __( 'Camp' )
                    ),
                    'public' => true,
                    'has_archive' => true,
                    'menu_icon' => 'dashicons-buddicons-activity',
                    'rewrite' => array('slug' => 'camps'),
                    'show_in_rest' => true,
                    'supports' => array('title', 'id'),       
                )
        );

        register_post_type( 'categories',
                array(
                    'labels' => array(
                        'name' => __( 'Catégories' ),
                        'singular_name' => __( 'Catégorie' )
                    ),
                    'public' => true,
                    'has_archive' => true,
                    'menu_icon' => 'dashicons-filter',
                    'rewrite' => array('slug' => 'categories'),
                    'show_in_rest' => true,
                    'supports' => array('title', 'id'),       
                )
        );

        register_post_type( 'globalinfos',
                array(
                    'labels' => array(
                        'name' => __( 'Infos globales' ),
                        'singular_name' => __( 'Info globale' )
                    ),
                    'public' => true,
                    'has_archive' => true,
                    'menu_icon' => 'dashicons-megaphone',
                    'rewrite' => array('slug' => 'infoglobales'),
                    'show_in_rest' => true,
                    'supports' => array('title', 'id'),       
                )
        );
    };


    // REMOVE WYSIWYG

    function remove_support() {
        remove_post_type_support( 'post', 'editor');
        remove_post_type_support( 'page', 'editor');
        remove_post_type_support( 'product', 'editor');
    }


    // REMOVE UNUSED DASHBOARD SECTIONS

    function remove_menus() {
        remove_menu_page('edit.php');
        remove_menu_page('edit-comments.php');
    }

    add_action('init', 'create_posttype');
    add_action('init', 'remove_support');
    add_action('admin_menu', 'remove_menus');
?>