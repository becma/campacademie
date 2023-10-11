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

    // ADD CUSTOM "VISIBLE" STATUS IN POSTS

    function visible_status_creation(){
        register_post_status( 'visible', array(
        'label'                     => _x( 'Visible', 'post' ),
        'label_count'               => _n_noop( 'Visible <span class="count">(%s)</span>', 'Visible <span 
        class="count">(%s)</span>'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true
        ));
    }

    function add_to_post_visible_status_dropdown()
    {
        global $post;
        $status = ($post->post_status == 'visible') ? "jQuery( '#post-status-display' ).text( 'Visible' ); jQuery( 
        'select[name=\"post_status\"]' ).val('visible');" : '';
        echo "<script>
        jQuery(document).ready( function() {
        jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"visible\">Visible</option>' );
        ".$status."
        });
        </script>";
    }

    function visible_status_add_in_quick_edit() {
        global $post;
        echo "<script>
        jQuery(document).ready( function() {
        jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"visible\">Visible</option>' );
        });
        </script>";
    }

    function display_archive_state_visible( $states ) {
        global $post;
        $arg = get_query_var( 'post_status' );
        if($arg != 'visible'){
            if($post->post_status == 'visible'){
                echo "<script>
                jQuery(document).ready( function() {
                jQuery( '#post-status-display' ).text( 'Visible' );
                });
                </script>";
                return array('Visible');
            }
        }
        return $states;
    }

    // ADD CUSTOM "HIDDEN" STATUS IN POSTS

    function hidden_status_creation(){
        register_post_status( 'hidden', array(
            'label'                     => _x( 'Hidden', 'post' ),
            'label_count'               => _n_noop( 'Hidden <span class="count">(%s)</span>', 'Hidden <span 
            class="count">(%s)</span>'),
            'public'                    => false,
            'exclude_from_search'       => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'private'                   => true
        ));
    }

    function add_to_post_hidden_status_dropdown()
    {
        global $post;
        $status = ($post->post_status == 'hidden') ? "jQuery( '#post-status-display' ).text( 'Hidden' ); jQuery( 
        'select[name=\"post_status\"]' ).val('hidden');" : '';
        echo "<script>
        jQuery(document).ready( function() {
        jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"hidden\">Hidden</option>' );
        ".$status."
        });
        </script>";
    }

    function hidden_status_add_in_quick_edit() {
        global $post;
        echo "<script>
        jQuery(document).ready( function() {
        jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"hidden\">Hidden</option>' );
        });
        </script>";
    }

    function display_archive_state_hidden( $states ) {
        global $post;
        $arg = get_query_var( 'post_status' );
        if($arg != 'hidden'){
            if($post->post_status == 'hidden'){
                echo "<script>
                jQuery(document).ready( function() {
                jQuery( '#post-status-display' ).text( 'Hidden' );
                });
                </script>";
                return array('Hidden');
            }
        }
        return $states;
    }

    function hidepoststatus() {

        global $post;

?>
    
        
        <style>
            #post_status option[value="publish"], #post_status option[value="pending"], #post_status option[value="draft"], #post_status option[value="private"] {
                display: none;
            }

            .inline-edit-status option[value="publish"], .inline-edit-status option[value="pending"], .inline-edit-status option[value="draft"], .inline-edit-status option[value="private"] {
                display: none;
            }
        </style>
        
<?php
        
          }

    add_action('init', 'create_posttype');
    add_action('init', 'remove_support');
    add_action('admin_menu', 'remove_menus');
    add_action('init', 'visible_status_creation');
    add_action('post_submitbox_misc_actions', 'add_to_post_visible_status_dropdown');
    add_action('admin_footer-edit.php','visible_status_add_in_quick_edit');
    add_filter( 'display_post_states', 'display_archive_state_visible' );
    add_action('init', 'hidden_status_creation');
    add_action('post_submitbox_misc_actions', 'add_to_post_hidden_status_dropdown');
    add_action('admin_footer-edit.php','hidden_status_add_in_quick_edit');
    add_filter( 'display_post_states', 'display_archive_state_hidden' );
    add_action( 'admin_head', 'hidepoststatus' );
?>