<?php
/*
 * A module for [post_checkbox] and [post_checkbox*]
 * Author: Markus Froehlich
 */
if(!defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!class_exists('wpcf7_post_fields_checkbox') )
{
    class wpcf7_post_fields_checkbox extends wpcf7_post_fields_module
    {
        /*
         *  Constructor
         */
        public function __construct($plugin_file)
        {
            parent::__construct($plugin_file);

            // Add shortcode
            add_action( 'wpcf7_init', array($this, 'wpcf7_add_form_tag_post_checkbox'));

            // Validation filter
            add_filter( 'wpcf7_validate_post_checkbox', array($this, 'wpcf7_post_checkbox_validation_filter'), 10, 2 );
            add_filter( 'wpcf7_validate_post_checkbox*', array($this, 'wpcf7_post_checkbox_validation_filter'), 10, 2 );
            add_filter( 'wpcf7_validate_post_radio', array($this, 'wpcf7_post_checkbox_validation_filter'), 10, 2 );
            add_filter( 'wpcf7_validate_post_radio*', array($this, 'wpcf7_post_checkbox_validation_filter'), 10, 2 );

            // Adding free text field
            add_filter( 'wpcf7_posted_data', array($this, 'wpcf7_post_checkbox_posted_data'));

            add_action( 'wpcf7_admin_init', array($this, 'wpcf7_add_tag_generator_menu'), 90 );
        }


        public function wpcf7_add_form_tag_post_checkbox()
        {
            if (function_exists('wpcf7_add_form_tag')) {
                wpcf7_add_form_tag(array('post_checkbox', 'post_checkbox*', 'post_radio', 'post_radio*'), array($this, 'wpcf7_post_checkbox_shortcode_handler'), true);
            }
        }

        public function wpcf7_post_checkbox_shortcode_handler( $tag )
        {
            $tag = new WPCF7_FormTag( $tag );

            if ( empty( $tag->name ) ) {
                return '';
            }

            $validation_error = wpcf7_get_validation_error( $tag->name );

            $class = wpcf7_form_controls_class( $tag->type );

            if ( $validation_error ) {
                $class .= ' wpcf7-not-valid';
            }

            $label_first = $tag->has_option( 'label_first' );
            $use_label_element = $tag->has_option( 'use_label_element' );
            $exclusive = $tag->has_option( 'exclusive' );
            $free_text = $tag->has_option( 'free_text' );
            $multiple = false;

            if ( 'post_checkbox' == $tag->basetype )
                $multiple = ! $exclusive;
            else // radio
                $exclusive = false;

            if ( $exclusive )
                $class .= ' wpcf7-exclusive-checkbox';

            $atts = array();

            $atts['class'] = $tag->get_class_option( $class );
            $atts['id'] = $tag->get_id_option();

            $tabindex = $tag->get_option( 'tabindex', 'int', true );

            if ( false !== $tabindex )
                $tabindex = absint( $tabindex );

            $html = '';
            $count = 0;

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

            $hangover = wpcf7_get_hangover( $tag->name, $multiple ? array() : '' );

            foreach ( $values as $key => $value ) {
                $class = 'wpcf7-list-item';

                $checked = false;

                if ( $hangover ) {
                    if ( $multiple ) {
                        $checked = in_array( esc_sql( $value ), (array) $hangover );
                    } else {
                        $checked = ( $hangover == esc_sql( $value ) );
                    }
                } else {
                    $checked = in_array( $key + 1, (array) $defaults );
                }

                $label = isset( $labels[$key] ) ? $labels[$key] : $value;

                $type = ($tag->basetype == 'post_checkbox') ? 'checkbox' : 'radio';

                $item_atts = array(
                    'type' => $type,
                    'name' => $tag->name . ( $multiple ? '[]' : '' ),
                    'value' => $value,
                    'data-id' => $ids[$key],
                    'checked' => $checked ? 'checked' : '',
                    'tabindex' => $tabindex ? $tabindex : '' );

                $item_atts = wpcf7_format_atts( apply_filters('wpcf7_'.$tag->name.'_'.$tag->basetype.'_item_atts', $item_atts, $value, $checked, $ids[$key] ) );

                $label = apply_filters('wpcf7_'.$tag->name.'_'.$tag->basetype.'_item_label', esc_html( $label ), $value, $checked, $tabindex, $ids[$key] );

                if ( $label_first ) { // put label first, input last
                    $item = sprintf('<span class="wpcf7-list-item-label">%1$s</span><input %2$s />', $label, $item_atts );
                } else {
                    $item = sprintf('<input %2$s /><span class="wpcf7-list-item-label">%1$s</span>', $label, $item_atts );
                }

                if ( $use_label_element )
                    $item = '<label>' . $item . '</label>';

                if ( false !== $tabindex )
                    $tabindex += 1;

                $count += 1;

                if ( 1 == $count ) {
                    $class .= ' first';
                }

                if ( count( $values ) == $count ) { // last round
                    $class .= ' last';

                    if ( $free_text ) {
                        $free_text_name = sprintf(
                            '_wpcf7_%1$s_free_text_%2$s', $tag->basetype, $tag->name );

                        $free_text_atts = array(
                            'name' => $free_text_name,
                            'class' => 'wpcf7-free-text',
                            'tabindex' => $tabindex ? $tabindex : '' );

                        if ( wpcf7_is_posted() && isset( $_POST[$free_text_name] ) ) {
                            $free_text_atts['value'] = wp_unslash(
                                $_POST[$free_text_name] );
                        }

                        $free_text_atts = wpcf7_format_atts( $free_text_atts );

                        $item .= sprintf( ' <input type="text" %s />', $free_text_atts );

                        $class .= ' has-free-text';
                    }
                }

                $item = '<span class="' . esc_attr( $class ) . '">' . $item . '</span>';
                $html .= $item;
            }

            $atts = apply_filters('wpcf7_'.$tag->name.'_atts', $atts, $tag);

            $html = sprintf(
                '<span class="wpcf7-form-control-wrap %1$s"><span %2$s>%3$s</span>%4$s</span>',
                sanitize_html_class( $tag->name ), wpcf7_format_atts( $atts ), $html, $validation_error );

            return $html;
        }

        /*
         * Validation Filter
         */
        public function wpcf7_post_checkbox_validation_filter( $result, $tag )
        {
            $tag = new WPCF7_FormTag( $tag );

            $type = $tag->type;
            $name = $tag->name;

            $value = isset( $_POST[$name] ) ? (array) $_POST[$name] : array();

            if ( $tag->is_required() && empty( $value ) ) {
                $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
            }

            return $result;
        }

        public function wpcf7_post_checkbox_posted_data( $posted_data )
        {
            $tags = wpcf7_scan_shortcode(
                array( 'type' => array( 'checkbox', 'checkbox*', 'radio', 'post_radio*' ) ) );

            if ( empty( $tags ) ) {
                return $posted_data;
            }

            foreach ( $tags as $tag ) {
                $tag = new WPCF7_FormTag( $tag );

                if ( ! isset( $posted_data[$tag->name] ) ) {
                    continue;
                }

                $posted_items = (array) $posted_data[$tag->name];

                if ( $tag->has_option( 'free_text' ) ) {
                    if ( WPCF7_USE_PIPE ) {
                        $values = $tag->pipes->collect_afters();
                    } else {
                        $values = $tag->values;
                    }

                    $last = array_pop( $values );
                    $last = html_entity_decode( $last, ENT_QUOTES, 'UTF-8' );

                    if ( in_array( $last, $posted_items ) ) {
                        $posted_items = array_diff( $posted_items, array( $last ) );

                        $free_text_name = sprintf(
                            '_wpcf7_%1$s_free_text_%2$s', $tag->basetype, $tag->name );

                        $free_text = $posted_data[$free_text_name];

                        if ( ! empty( $free_text ) ) {
                            $posted_items[] = trim( $last . ' ' . $free_text );
                        } else {
                            $posted_items[] = $last;
                        }
                    }
                }

                $posted_data[$tag->name] = $posted_items;
            }

            return $posted_data;
        }

        public function wpcf7_add_tag_generator_menu()
        {
            if (class_exists('WPCF7_TagGenerator'))
            {
                $tag_generator = WPCF7_TagGenerator::get_instance();
                $tag_generator->add( 'post_checkbox', __('Post').' '.__( 'checkboxes', 'contact-form-7' ), array($this, 'wpcf7_tag_generator_menu'));
                $tag_generator->add( 'post_radio', __('Post').' '.__( 'radio buttons', 'contact-form-7' ), array($this, 'wpcf7_tag_generator_menu'));
            }
        }

        public function wpcf7_tag_generator_menu( $contact_form, $args = '' )
        {
            $args = wp_parse_args( $args, array() );
            $type = $args['id'];

            if ( 'post_radio' != $type ) {
                $type = 'post_checkbox';
            }

            if ( 'post_checkbox' == $type ) {
                $description = __('Generate a form-tag for a group of post checkboxes.', 'cf7-post-fields');
            } elseif ( 'post_radio' == $type ) {
                $description = __('Generate a form-tag for a group of post radio buttons.', 'cf7-post-fields');
            }

            include dirname(__FILE__) . '/generators/checkbox.php';

            $this->enqueue_post_field_javascript($args);
        }
    }
}