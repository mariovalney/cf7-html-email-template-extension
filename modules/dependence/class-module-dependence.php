<?php

/**
 * CF7HETE_Module_Dependence
 * Module to notify about dependencies
 *
 * @package         Cf7_Html_Email_Template_Extension
 * @subpackage      CF7HETE_Module_Woocommerce
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! class_exists( 'CF7HETE_Module_Dependence' ) ) {

    class CF7HETE_Module_Dependence {

        /**
         * List of dependencies to check
         * @var array
         */
        private $dependencies = array();

        /**
         * List of notices to show
         * @var array
         */
        private $notices = array();

        /**
         * After Run
         *
         * @since    1.0.0
         * @return  void
         */
        public function after_run() {
            if ( ! current_user_can( 'install_plugins' ) ) {
                return;
            }

            // Check plugins
            include_once ABSPATH . 'wp-admin/includes/plugin.php';

            foreach ( $this->dependencies as $plugin ) {
                if ( is_plugin_active( $plugin->file ) ) {
                    continue;
                }

                if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin->file ) ) {
                    $notice = $this->create_activate_plugin_notice( $plugin );
                    $this->add_dependence_notice( $notice );
                    continue;
                }

                $notice = $this->create_install_plugin_notice( $plugin );
                $this->add_dependence_notice( $notice );
            }
        }

        /**
         * Define Hooks Run
         *
         * @since    1.0.0
         * @return  void
         */
        public function define_hooks() {
            $this->core->add_action( 'admin_notices', array( $this, 'admin_notices' ) );
        }

        /**
         * Add a plugin dependence
         *
         * @param string $plugin_file The plugin file like in is_plugin_active()
         * @param string $plugin_name The plugin name
         * @param string $plugin_slug The plugin slug (from repository)
         */
        public function add_dependence( $plugin_file, $plugin_name, $plugin_slug ) {
            $this->dependencies[] = (object) array(
                'file' => $plugin_file,
                'name' => $plugin_name,
                'slug' => $plugin_slug,
            );
        }

        /**
         * Add a notice
         *
         * @param string $notice The text
         * @param string $class  The HTML notice-$class
         */
        public function add_dependence_notice( $notice, $class = 'error' ) {
            $this->notices[] = array( $notice, $class );
        }

        /**
         * Action: 'admin_notices'
         * Add notice about dependencies
         */
        public function admin_notices() {
            foreach ( $this->notices as $notice ) {
                $notice = $notice;
                include_once CF7HETE_PLUGIN_PATH . '/modules/dependence/includes/views/html-notice.php';
            }
        }

        /**
         * Creates a notice to install a plugin
         *
         * @param  object $plugin A plugin data added with add_dependence
         * @return string
         */
        private function create_install_plugin_notice( $plugin ) {
            $url = wp_nonce_url(
                self_admin_url( 'update.php?action=install-plugin&plugin=' . $plugin->slug ),
                'install-plugin_' . $plugin->slug
            );

            return sprintf(
                /* translators: %1$s is the plugin name and %2%s is the action of click. */
                __( '<strong>HTML Template for CF7</strong> depends of %1$s to work. Click to %2$s.', 'api-improver-for-woocommerce' ),
                $plugin->name,
                '<a href="' . esc_url( $url ) . '">' . __( 'install the plugin', 'api-improver-for-woocommerce' ) . '</a>'
            );
        }

        /**
         * Creates a notice to activate a plugin
         *
         * @param  object $plugin A plugin data added with add_dependence
         * @return string
         */
        private function create_activate_plugin_notice( $plugin ) {
            $url = wp_nonce_url(
                self_admin_url( 'plugins.php?action=activate&plugin=' . $plugin->file ),
                'activate-plugin_' . $plugin->file
            );

            return sprintf(
                /* translators: %1$s is the plugin name and %2%s is the action of click. */
                __( '<strong>HTML Template for CF7</strong> depends of %1$s to work. Click to %2$s.', 'api-improver-for-woocommerce' ),
                $plugin->name,
                '<a href="' . esc_url( $url ) . '">' . __( 'activate the plugin', 'api-improver-for-woocommerce' ) . '</a>'
            );
        }

    }
}
