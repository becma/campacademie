<?php
/*
 * A module for [post_select] and [post_select*]
 * Author: Markus Froehlich
 */
if(!defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!class_exists('wpcf7_post_fields_select') )
{
    class wpcf7_post_fields_select extends wpcf7_post_fields_module
    {
        /*
         *  Constructor
         */
        public function __construct($plugin_file)
        {
            parent::__construct($plugin_file);

            // Add shortcode
            add_action( 'wpcf7_init', array($this, 'wpcf7_add_form_tag_post_select'));

            // Validation filter
            add_filter( 'wpcf7_validate_post_select', array($this, 'wpcf7_post_select_validation_filter'), 10, 2 );
            add_filter( 'wpcf7_validate_post_select*', array($this, 'wpcf7_post_select_validation_filter'), 10, 2 );

            add_action( 'wpcf7_admin_init', array($this, 'wpcf7_add_tag_generator_menu'), 90 );
        }

        public function wpcf7_add_form_tag_post_select()
        {
            if (function_exists('wpcf7_add_form_tag')) {
                wpcf7_add_form_tag(array('post_select', 'post_select*'), array($this, 'wpcf7_post_select_shortcode_handler'), true);
            }
        }

        public function wpcf7_post_select_shortcode_handler( $tag )
        {
            $tag = new WPCF7_FormTag( $tag );

            if ( empty( $tag->name ) ) {
                return '';
            }

            $validation_error = wpcf7_get_validation_error( $tag->name );

            $class = wpcf7_form_controls_class( 'select post' );

            if ( $validation_error ) {
                $class .= ' wpcf7-not-valid';
            }

            $atts = array();

            $atts['class'] = $tag->get_class_option( $class );
            $atts['id'] = $tag->get_id_option();
            $atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

            if ( $tag->is_required() ) {
                $atts['aria-required'] = 'true';
            }

            $atts['aria-invalid'] = $validation_error ? 'true' : 'false';

            $multiple = $tag->has_option( 'multiple' );

            // No include blank on multiple select
            $include_blank = !$multiple ? $tag->has_option( 'include_blank' ) : false;
            $first_as_label = $tag->has_option( 'first_as_label' );
            $search_box = $tag->has_option( 'search_box' );

            if ( $tag->has_option( 'size' ) ) {
                $size = $tag->get_option( 'size', 'int', true );

                if ( $size ) {
                    $atts['size'] = $size;
                } elseif ( $multiple ) {
                    $atts['size'] = 4;
                } else {
                    $atts['size'] = 1;
                }
            }

            // Sanitize custom fields
            $atts['allow-clear'] = $include_blank ? 'true' : 'false';
            $atts['search-box'] = $search_box ? 'true' : 'false';

            $post_values = $this->get_post_values($tag);

            $labels = $post_values['labels'];
            $values = $post_values['values'];
            $ids    = $post_values['ids'];

            $defaults = array();

            $default_choice = $tag->get_default_option( null, 'multiple=1' );

            // Set default value from current post
            if(count($default_choice) === 0 && $tag->get_option('default', '', true) === 'current_post') {
                $default_choice[] = get_the_ID();
            }

            foreach ( $default_choice as $value )
            {
                $key = array_search( $value, $values, true );

                if ( false !== $key ) {
                    $defaults[] = (int) $key + 1;
                }
            }

            // Abfrage nach post_id
            foreach ( $default_choice as $id )
            {
                if(is_numeric($id))
                {
                    $key = array_search( (int)$id, $ids, true );

                    if ( false !== $key ) {
                        $defaults[] = (int) $key + 1;
                    }
                }
            }

            if ( $matches = $tag->get_first_match_option( '/^default:([0-9_]+)$/' ) ) {
                $defaults = array_merge( $defaults, explode( '_', $matches[1] ) );
            }

            $defaults = apply_filters('wpcf7_'.$tag->name.'_defaults', array_unique( $defaults ), $default_choice, $post_values, $tag);

            $shifted = false;

            /*
             * Filter for a custom placeholder like "Select Book"
             *
             * Example: get_post_type_object( $post_type )->labels->singular_name"
             */
            $placeholder = apply_filters('wpcf7_'.$tag->name.'_placeholder', __('&mdash; Select &mdash;'), $tag->get_option('post-type', '', true), $tag);

            if ( $include_blank || empty( $values ) ) {
                array_unshift( $labels, $placeholder );
                array_unshift( $values, '' );
                array_unshift( $ids, -1 );
                $shifted = true;
            } elseif ( $first_as_label ) {
                $values[0] = '';
            }

            $html = '';
            $hangover = wpcf7_get_hangover( $tag->name );

            foreach ( $values as $key => $value ) {
                $selected = false;

                if ( $hangover ) {
                    if ( $multiple ) {
                        $selected = in_array( esc_sql( $value ), (array) $hangover );
                    } else {
                        $selected = ( $hangover == esc_sql( $value ) );
                    }
                } else {
                    if ( ! $shifted && in_array( (int) $key + 1, (array) $defaults ) ) {
                        $selected = true;
                    } elseif ( $shifted && in_array( (int) $key, (array) $defaults ) ) {
                        $selected = true;
                    }
                }

                $item_atts = array(
                    'value' => $value,
                    'data-id' => $ids[$key],
                    'selected' => $selected ? 'selected' : '' );

                $item_atts = wpcf7_format_atts( apply_filters('wpcf7_'.$tag->name.'_'.$tag->basetype.'_item_atts', $item_atts, $value, $selected, $ids[$key] ) );

                $label = isset( $labels[$key] ) ? $labels[$key] : $value;

                $label = apply_filters('wpcf7_'.$tag->name.'_'.$tag->basetype.'_item_label', esc_html( $label ), $value, $selected, false, $ids[$key] );

                $html .= sprintf( '<option %1$s>%2$s</option>', $item_atts, $label );
            }

            /*
             * Enqueue select2 scripts
             */
            if ( ! wp_style_is( 'wpcf7-select2', 'registered' ) ) {
                $this->wpcf7_select2_register_styles();
            }

            if ( ! wp_script_is( 'wpcf7-post-select2', 'registered' )) {
                $this->wpcf7_select2_register_scripts();
            }

            // Enqueue style and script only when search box or multiple is set
            if($search_box || $multiple)
            {
                wp_enqueue_style('wpcf7-select2');
                wp_enqueue_script( 'wpcf7-post-select2' );
            }

            if ( $multiple ) {
                $atts['multiple'] = 'multiple';
            }

            $atts['name'] = $tag->name . ( $multiple ? '[]' : '' );
            $atts['placeholder'] = $placeholder;

            $atts = apply_filters('wpcf7_'.$tag->name.'_atts', $atts, $tag);

            $html = sprintf(
                '<span class="wpcf7-form-control-wrap %1$s"><select %2$s>%3$s</select>%4$s</span>',
                sanitize_html_class( $tag->name ), wpcf7_format_atts( $atts ), $html, $validation_error );

            return $html;
        }

        /*
         * Validation Filter
         */
        public function wpcf7_post_select_validation_filter( $result, $tag )
        {
	        $tag = new WPCF7_FormTag( $tag );

            $name = $tag->name;

            if ( isset( $_POST[$name] ) && is_array( $_POST[$name] ) ) {
                foreach ( $_POST[$name] as $key => $value ) {
                    if ( '' === $value )
                        unset( $_POST[$name][$key] );
                }
            }

            $empty = ! isset( $_POST[$name] ) || empty( $_POST[$name] ) && '0' !== $_POST[$name];

            if ( $tag->is_required() && $empty ) {
                $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
            }

            return $result;
        }

        public function wpcf7_add_tag_generator_menu()
        {
            if (class_exists('WPCF7_TagGenerator'))
            {
                $tag_generator = WPCF7_TagGenerator::get_instance();
                $tag_generator->add('post_select', __('posts').' '.__( 'drop-down menu', 'contact-form-7' ), array($this, 'wpcf7_tag_generator_menu'));
            }
        }

        public function wpcf7_tag_generator_menu( $contact_form, $args = '' )
        {
            $args = wp_parse_args( $args, array() );
            $description = __('Generate a form-tag for a posts drop-down menu.', 'cf7-post-fields');

            include dirname(__FILE__) . '/generators/select.php';

            $this->enqueue_post_field_javascript($args);
        }
    }
}