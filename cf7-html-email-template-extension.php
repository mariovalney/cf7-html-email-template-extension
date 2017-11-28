<?php

/**
 *
 * @package           Cf7_Html_Email_Template_Extension
 * @since             1.0.0
 *
 * Plugin Name:       CF7 - HTML Email Template Extension
 * Plugin URI:        http://projetos.mariovalney.com/cf7-html-email-template-extension
 * Description:       Improve your Contact Form 7 emails with a HTML Template.
 * Version:           1.0.1
 * Author:            Mário Valney
 * Author URI:        http://mariovalney.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cf7-html-email-template-extension
 * Domain Path:       /languages
 *
 */

// If this file is called directly, abort.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( ! class_exists( 'Cf7_Html_Email_Template_Extension' ) ) {

	class Cf7_Html_Email_Template_Extension {

		/**
		 * The unique internal identifier of this plugin to avoid overwritten class.
		 * Discussed with @gugaalves and @leobaiano in WordCamp Fortaleza 2016...
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      string    $class_tag	The string used to uniquely identify this class.
		 */
		public $class_tag;

		/**
		 * The unique identifier of this plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
		 */
		protected $plugin_name;

		/**
		 * The current version of the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $version    The current version of the plugin.
		 */
		protected $version;

		/**
		 * The array of actions registered with WordPress.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
		 */
		protected $actions;

		/**
		 * The array of filters registered with WordPress.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
		 */
		protected $filters;

		/**
		 * The array of modules of plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      array    $modules    The modules to be used in this plugin.
		 */
		protected $modules;

		/**
		 * Define the core functionality of the plugin.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

			$this->plugin_name = CF7HETE_TEXTDOMAIN;
			$this->version = CF7HETE_VERSION;
			$this->class_tag = CF7HETE_TAG;

			$this->actions = $this->filters = $this->modules = array();

			$this->define_hooks();
			$this->add_modules();

		}

		/**
		 * The name of the plugin.
		 *
		 * @since     1.0.0
		 * @return    string    The name of the plugin.
		 */
		public function get_plugin_name() {

			return $this->plugin_name;

		}

		/**
		 * The version number of the plugin.
		 *
		 * @since     1.0.0
		 * @return    string    The version number of the plugin.
		 */
		public function get_version() {

			return $this->version;

		}

		/**
		 * Register the hooks for Core
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_hooks() {

			// Internationalization
			$this->add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

			// Admin Hooks
			$this->add_action( 'admin_notices', array( $this, 'check_cf7_plugin' ) );

		}

		/**
		 * Load all the plugins modules.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function add_modules() {

			require_once plugin_dir_path( __FILE__ ) . 'modules/html-template/class-cf7hete-module-html-template.php';

			$this->modules['html_template'] = new Cf7hete_Module_Html_Template( $this, CF7HETE_TAG );

		}

		/**
		 * A utility function that is used to register the actions and hooks into a single
		 * collection.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @param    array		$hooks				The collection of hooks that is being registered (that is, actions or filters).
		 * @param    string 	$hook 				The name of the WordPress filter that is being registered.
		 * @param    string 	$callback 			The callback function or a array( $obj, 'method' ) to public method of a class.
		 * @param    int		$priority 			The priority at which the function should be fired.
		 * @param    int		$accepted_args 		The number of arguments that should be passed to the $callback.
		 * @return   array 							The collection of actions and filters registered with WordPress.
		 */
		private function add_hook( $hooks, $hook, $callback, $priority, $accepted_args ) {

			$hooks[] = array(
				'hook'          => $hook,
				'callback'      => $callback,
				'priority'      => $priority,
				'accepted_args' => $accepted_args
			);

			return $hooks;

		}

		/**
		 * Add a new action to the collection to be registered with WordPress.
		 *
		 * @since    1.0.0
		 * @param    string		$hook             The name of the WordPress action that is being registered.
		 * @param    string		$callback         The callback function or a array( $obj, 'method' ) to public method of a class.
		 * @param    int		$priority         Optional. he priority at which the function should be fired. Default is 10.
		 * @param    int		$accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
		 */
		public function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {

			$this->actions = $this->add_hook( $this->actions, $hook, $callback, $priority, $accepted_args );

		}

		/**
		 * Add a new filter to the collection to be registered with WordPress.
		 *
		 * @since    1.0.0
		 * @param    string		$hook             The name of the WordPress filter that is being registered.
		 * @param    string		$callback         The callback function or a array( $obj, 'method' ) to public method of a class.
		 * @param    int		$priority         Optional. he priority at which the function should be fired. Default is 10.
		 * @param    int		$accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
		 */
		public function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {

			$this->filters = $this->add_hook( $this->filters, $hook, $callback, $priority, $accepted_args );

		}

		/**
		 * Define the locale for this plugin for internationalization.
		 *
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		public function load_plugin_textdomain() {

			load_plugin_textdomain( CF7HETE_TEXTDOMAIN, false, basename( dirname( __FILE__ ) ) . '/languages/' );

		}

		/**
		 * Check Contact Form 7 Plugin is active
		 * It's a dependency in this version
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		public function check_cf7_plugin() {

			if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
				echo '<div class="notice notice-error is-dismissible">';
				echo '<p>' . sprintf( __( "You need to install/activate %s Contact Form 7%s plugin to enable %s HTML Email Template Extension %s ", CF7HETE_TEXTDOMAIN ), '<a href="http://contactform7.com/" target="_blank">', '</a>', '<strong>', '</strong>' );


				if ( file_exists( ABSPATH . PLUGINDIR . '/contact-form-7/wp-contact-form-7.php' ) ) {
					$url = 'plugins.php';
				} else {
					$url = 'plugin-install.php?tab=search&s=Contact+form+7';
				}

				echo '. <a href="' . admin_url( $url ) . '">' . __( "Do it now?", CF7HETE_TEXTDOMAIN ) . '</a></p>';
				echo '</div>';
			}

		}

		/**
		 * Run the plugin.
		 *
		 * @since    1.0.0
		 */
		public function run() {

			define( 'CF7HETE_LOADED', '1' );

			// Running Modules (first of all)
			foreach ( $this->modules as $module ) {
				$module->run();
			}

			// Running Filters
			foreach ( $this->filters as $hook ) {
				add_filter( $hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args'] );
			}

			// Running Actions
			foreach ( $this->actions as $hook ) {
				add_action( $hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args'] );
			}

		}

	}
}

/**
 * Making things happening
 *
 * @since    1.0.0
 */
function cf7hete_starts() {

	define( 'CF7HETE_VERSION', '1.0.0' );
	define( 'CF7HETE_TEXTDOMAIN', 'cf7-html-email-template-extension' );
	define( 'CF7HETE_TAG', 'cf7_html_email_template_extension' );

	$plugin = new Cf7_Html_Email_Template_Extension();

	if ( CF7HETE_TAG == $plugin->class_tag ) {
		$plugin->run();
	} else {
		trigger_error( __( 'The Cf7_Html_Email_Template_Extension was overwritten...' ), E_USER_WARNING );
	}

}

cf7hete_starts();
