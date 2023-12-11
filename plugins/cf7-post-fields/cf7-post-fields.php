<?php
/*
 * Plugin Name: Contact Form 7 - Post Fields
 * Description: Provides a dynamic post select, radio and checkbox field to your CF7 forms.
 * Version:     2.5.7
 * Author:      Markus Wiesenhofer
 * Author URI:  mailto:markusfroehlich01@gmail.com
 * Requires at least: 4.0
 * Tested up to: 5.9.2
 * Text Domain: cf7-post-fields
 * Domain Path: /languages/
 * License:     GPL v2 or later
 */

/**
 * Contact Form 7 - Post Fields provides a dynamic post select, radio and checkbox field to your CF7 forms.
 *
 * LICENSE
 * This file is part of Contact Form 7 - Post Fields.
 *
 * Contact Form 7 - Post Fields is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * @package    Contact Form 7 - Post Fields
 * @author     Markus Wiesenhofer <markusfroehlich01@gmail.com>
 * @copyright  Copyright 2016 Markus Wiesenhofer
 * @license    http://www.gnu.org/licenses/gpl.txt GPL 2.0
 * @link       https://wordpress.org/plugins/cf7-post-fields/
 * @since      0.2
 */

if(!defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!class_exists('WPCF7_Post_Fields') )
{
    class wpcf7_post_fields
    {
        /*
         * Datafields
         */
        public $select = null;
        public $checkbox = null;
        public $image_select = null;
        public $image_checkbox = null;

        /*
         *  Constructor
         */
        public function __construct()
        {
            // Define WPCF7_POST_FIELDS_PLUGIN.
            if ( ! defined( 'WPCF7_POST_FIELDS_PLUGIN' ) ) {
                define( 'WPCF7_POST_FIELDS_PLUGIN', __FILE__ );
            }

            $this->includes();

            // Hooks
            add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
            add_action('wpcf7_init', array($this, 'wpcf7_add_post_image_size'));

            $required_plugin = new wpcf7_required_plugin_checker(__FILE__, 'contact-form-7/wp-contact-form-7.php');

            // Check if Contact Form 7 is activated
            if($required_plugin->is_active())
            {
                // Ajax Requests
                add_action('wp_ajax_wpcf7_post_fields_get_taxonomies', array($this, 'get_ajax_post_type_taxonomies'));

                // Load Post Field modules
                add_action('plugins_loaded', array($this, 'load_wpcf7_post_field_modules'), 50);

                add_filter('wpcf7_mail_components', array($this, 'wpcf7_post_field_components'), 10, 3);
            }

            add_filter('plugin_row_meta' , array($this, 'plugin_row_meta'), 10, 2);
            add_action('admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
        }

        /**
         * Register admin styles
         */
        public static function admin_enqueue_scripts()
        {
            $screen = get_current_screen();
            $screen_id = $screen ? $screen->id : '';

            if( $screen_id === 'plugins' ) {
                wp_enqueue_style( 'cf7_post_fields_backend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/assets/css/admin.css', '', '2.5.1' );
            }
        }

        /**
         * Star rating on the plugin page :)
         */
        function plugin_row_meta($meta_fields, $file)
        {
            if ( plugin_basename(__FILE__) === $file )
            {
                $plugin_url = "https://wordpress.org/support/plugin/cf7-post-fields/reviews/?rate=5#new-post";

                $meta_fields[] = "<a href='" . esc_url($plugin_url) ."' target='_blank' title='" . esc_html__('Rate', 'cf7-post-fields') . "'>
                            <i class='cf7-post-fields-rating'>"
                    . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
                    . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
                    . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
                    . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
                    . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
                    . "</i></a>";
            }

            return $meta_fields;
        }

        /**
         * Include core modules
         */
        private function includes()
        {
            require_once dirname(__FILE__).'/includes/class-required-plugin-checker.php';
            require_once dirname(__FILE__).'/modules/module.php';
            require_once dirname(__FILE__).'/modules/select.php';
            require_once dirname(__FILE__).'/modules/image-select.php';
            require_once dirname(__FILE__).'/modules/checkbox.php';
            require_once dirname(__FILE__).'/modules/image-checkbox.php';
        }

        /*
         * HOOK
         * Initialize the textdomain
         */
        public function load_plugin_textdomain() {
            load_plugin_textdomain('cf7-post-fields', false, plugin_basename( dirname(__FILE__) ) . '/languages' );
        }

        /**
         * Register the post image field size.
         */
        public function wpcf7_add_post_image_size() {
            add_image_size('wpcf7-post-image', 80, 80, true);
        }

        /*
         * HOOK
         * Load the post field modules
         */
        public function load_wpcf7_post_field_modules()
        {
            $this->select           = new wpcf7_post_fields_select(__FILE__);
            $this->checkbox         = new wpcf7_post_fields_checkbox(__FILE__);
            $this->image_select     = new wpcf7_post_fields_image_select(__FILE__);
            $this->image_checkbox   = new wpcf7_post_fields_image_checkbox(__FILE__);
        }

        /*
         * Ajax Request
         * Get the taxonomies from a specific post type
         */
        public function get_ajax_post_type_taxonomies()
        {
            if(!wp_verify_nonce($_POST['security'], 'wpcf7-post-field-tax-nonce')) {
                wp_send_json_error(__('An error has occurred. Please reload the page and try again.'));
            }

            $post_type = sanitize_text_field($_POST['post_type']);
            $object_taxonomies = get_object_taxonomies($post_type, 'object');
            $taxonomies = wp_list_pluck($object_taxonomies, 'label', 'name');

            wp_send_json_success($taxonomies);
        }

        /*
         * Filter the body mail content
         */
        public function wpcf7_post_field_components($components, $form, $instance)
        {
            $properties = $form->get_properties();
            $email_name = $instance->name();

            $components['body'] = $this->replace_permalink_tags($components['body'], $properties[$email_name]['use_html']);
            $components['body'] = $this->replace_thumbnail_tags($components['body'], $properties[$email_name]['use_html']);

            return $components;
        }

        /*
         * Replace all permalink tags with (pretty) links
         */
        private function replace_permalink_tags($content, $use_html)
        {
            if(strpos($content, '[permalink') === false) {
                return $content;
            }

            // Find all registered tag names in $content.
            preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);

            foreach($matches[1] as $match)
            {
                if(strpos($match, 'permalink') !== false)
                {
                    $post_id = absint(filter_var($match, FILTER_SANITIZE_NUMBER_INT));

                    if(get_post_status($post_id) !== false)
                    {
                        // Use HTML content type
                        if($use_html) {
                            $permalink = sprintf('<a href="%1$s" target="_blank" title="%2$s">%2$s</a>', get_permalink($post_id), get_the_title($post_id));
                        } else {
                            $permalink = get_permalink($post_id);
                        }

                        $replace_tag = '[permalink-'.$post_id.']';

                        $content = str_replace($replace_tag, $permalink, $content);
                    }
                }
            }

            return $content;
        }

        /*
         * Replace all thumbnail tags with (pretty) images
         */
        private function replace_thumbnail_tags($content, $use_html)
        {
            if(strpos($content, '[thumbnail') === false) {
                return $content;
            }

            // Find all registered tag names in $content.
            preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);

            foreach($matches[1] as $match)
            {
                if(strpos($match, 'thumbnail') !== false)
                {
                    $post_id = absint(filter_var($match, FILTER_SANITIZE_NUMBER_INT));

                    if(get_post_status($post_id) !== false)
                    {
                        // Use HTML content type
                        if($use_html)
                        {
                            if(get_post_type($post_id) === 'attachment') {
                                $permalink = wp_get_attachment_link($post_id, 'thumbnail', true);
                            } else if(has_post_thumbnail($post_id)) {
                                $permalink = sprintf('<a href="%s" target="_blank" title="%s">%s</a>', get_permalink($post_id), get_the_title($post_id), get_the_post_thumbnail($post_id, 'thumbnail'));
                            } else {
                                $permalink = sprintf('<a href="%1$s" target="_blank" title="%2$s">%2$s</a>', get_permalink($post_id), get_the_title($post_id));
                            }
                        }
                        else
                        {
                            $permalink = get_permalink($post_id);
                        }

                        $replace_tag = '[thumbnail-'.$post_id.']';

                        $content = str_replace($replace_tag, $permalink, $content);
                    }
                }
            }

            return $content;
        }
    }
}

/**
 * Main instance of Contact Form 7 - Post Fields.
 *
 * Returns the main instance of WPCF7_Post_Fields to prevent the need to use globals.
 *
 * @return WPCF7_Post_Fields
 */
function wpcf7_post_fields() {
	return new WPCF7_Post_Fields();
}

// Global for backwards compatibility.
$GLOBALS['wpcf7_post_fields'] = wpcf7_post_fields();