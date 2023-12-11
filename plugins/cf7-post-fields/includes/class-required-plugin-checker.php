<?php
/*
 * Class: wp_required_plugin_checker
 * Check if a required Plugin is active
 * Author: Markus Froehlich
 */
if(!defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!class_exists('wpcf7_required_plugin_checker') )
{
    require_once(ABSPATH.'wp-admin/includes/plugin.php');

    class wpcf7_required_plugin_checker
    {
        /*
         * Data fields
         */
        private $plugin_file;
        private $required_plugin;
        private $required_plugin_is_active;

        /*
         * Properties
         */
        public function is_active() {
            return $this->required_plugin_is_active;
        }

        /*
         *  Constructor
         */
        public function __construct($plugin_file, $required_plugin)
        {
            $this->plugin_file = $plugin_file;
            $this->required_plugin = $required_plugin;

            $this->required_plugin_is_active = is_plugin_active($this->required_plugin);

            // Hooks
            register_activation_hook($this->plugin_file, array($this, 'activate_plugin'));
            add_action('admin_init', array($this, 'check_required_plugin'));
        }

        /**
         * When the base plugin is activated
         */
        public function activate_plugin()
        {
            if (!$this->required_plugin_is_active)
            {
                deactivate_plugins( plugin_basename( $this->plugin_file ) );
                add_action('admin_notices', array($this, 'plugin_error_notice'));
            }
        }

        /*
         * Check if the required plugin is active
         */
        public function check_required_plugin()
        {
            if (!$this->required_plugin_is_active)
            {
                if ( is_plugin_active( plugin_basename( $this->plugin_file ) ) )
                {
                    deactivate_plugins( plugin_basename( $this->plugin_file ) );
                    add_action('admin_notices', array($this, 'plugin_error_notice'));

                    if ( isset( $_GET['activate'] ) ) {
                        unset( $_GET['activate'] );
                    }
                }
            }
        }

        /*
         * Print the plugin error message notice
         */
        public function plugin_error_notice()
        {
            if(!function_exists('plugins_api')) {
                require_once(ABSPATH.'wp-admin/includes/plugin-install.php');
            }

            /** Prepare our query */
            $call_plugin_api = plugins_api('plugin_information', array(
                'slug'      => dirname($this->required_plugin),
            ));

            if(!is_wp_error($call_plugin_api))
            {
                $error_message = '<a href="'.$call_plugin_api->homepage.'" target="_blank">'.$call_plugin_api->name.'</a>'.' '.__('Plugin <strong>deactivated</strong>.');
            }
            else
            {
                $error_message = dirname($this->required_plugin).' '.__('Plugin <strong>deactivated</strong>.');

                // Additional error from the plugin api
                echo '<div class="notice notice-error is-dismissible"><p>'.$call_plugin_api->get_error_message().'</p></div>';
            }

            $base_plugin_data = get_plugin_data($this->plugin_file, false);

            $notice_error = sprintf(__( 'The plugin %1$s has been <strong>deactivated</strong> due to an error: %2$s' ), '<b>'.$base_plugin_data['Name'].'</b>', $error_message);

            echo '<div class="notice notice-error is-dismissible"><p>'.$notice_error.'</p></div>';
        }
    }
}