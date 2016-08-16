<?php

// If this file is called directly, abort.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


/**
 * Cf7hete_Module_Html_Template
 * Class responsible to create the HTML Template Stuff
 *
 * @package           Cf7hete_Module_Html_Template
 * @since             1.0.0
 *
 */

if ( ! class_exists( 'Cf7hete_Module_Html_Template' ) ) {

	class Cf7hete_Module_Html_Template {

		/**
		 * The Core object
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      Cf7_Html_Email_Template_Extension    $core	The core class
		 */
		private $core;

		/**
		 * The Module Indentify
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      Cf7_Html_Email_Template_Extension    $core	The core class
		 */
		const MODULE_SLUG = "html_template";

		/**
		 * Define the core functionality of the plugin.
		 *
		 * @since    1.0.0
		 * @param    array		$core	The Core object
		 * @param    array		$tag	The Core Tag
		 */
		public function __construct( Cf7_Html_Email_Template_Extension $core ) {

			$this->core = $core;

		}

		/**
		 * Register all the hooks for this module
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_hooks() {

			// CF7 Editor Tabs
			$this->add_filter( 'wpcf7_editor_panels', array( $this, 'wpcf7_editor_panels' ) );

			// CF7 Save Contact Form
			$this->add_action( 'wpcf7_save_contact_form', array( $this, 'wpcf7_save_contact_form' ) );

			// CF7 Properties
			$this->add_filter( 'wpcf7_contact_form_properties', array( $this, 'wpcf7_contact_form_properties' ), 10, 2 );

			// CF7 Mail Compose
			$this->add_filter( 'wpcf7_mail_components', array( $this, 'wpcf7_mail_components' ), 20, 2 );

		}

		/**
		 * Add a new action to the collection to be registered with WordPress.
		 *
		 * @since    1.0.0
		 * @see    Cf7_Html_Email_Template_Extension->add_action
		 */
		private function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {

			if ( $this->core != null ) {
				$this->core->add_action( $hook, $callback, $priority, $accepted_args );
			} else {
				if ( WP_DEBUG ) {
					trigger_error( __( 'Core was not passed in "Cf7hete_Module_Html_Template".' ), E_USER_WARNING );
				}
			}

		}

		/**
		 * Add a new filter to the collection to be registered with WordPress.
		 *
		 * @since    1.0.0
		 * @see    Cf7_Html_Email_Template_Extension->add_filter
		 */
		private function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {

			if ( $this->core != null ) {
				$this->core->add_filter( $hook, $callback, $priority, $accepted_args );
			} else {
				if ( WP_DEBUG ) {
					trigger_error( __( 'Core was not passed in "Cf7hete_Module_Html_Template".' ), E_USER_WARNING );
				}
			}

		}

		/**
		 * Get the default markup for Header
		 *
		 * @since    1.0.0
		 */
		private function get_default_header() {

			return file_get_contents( plugin_dir_path( __FILE__ ) . 'templates/default-header.htm' );

		}

		/**
		 * Get the default markup for Footer
		 *
		 * @since    1.0.0
		 */
		private function get_default_footer() {

			return file_get_contents( plugin_dir_path( __FILE__ ) . 'templates/default-footer.htm' );

		}

		/**
		 * Replace tags in $string
		 *
		 * @since    1.0.0
		 * @param    string		$string 	Text to be processed
		 */
		public function replace_tags( $text ) {

			$text = str_replace( '[home_url]', home_url(), $text );
			$text = str_replace( '[site_name]', get_bloginfo( "name" ), $text );

			return $text;

		}

		/**
		 * Filter the 'wpcf7_editor_panels' to add necessary tabs
		 *
		 * @since    1.0.0
		 * @param    WPCF7_ContactForm 	$contactform	Current ContactForm Obj
		 */
		public function cf7hete_html_template_panel_html( WPCF7_ContactForm $contactform ) {

			require plugin_dir_path( __FILE__ ) . 'admin/cf7hete-html-template-panel-html.php';

		}

		
		/**
		 * Filter the 'wpcf7_mail_components' to change componentes on composing email
		 *
		 * @since    1.0.0
		 * @param    array 				$components		Componentes from email
		 * @param    WPCF7_ContactForm 	$contactform	Current ContactForm Obj
		 */
		public function wpcf7_mail_components( $components, $contactform ) {

			$properties = $contactform->get_properties();
			if ( isset( $properties[ Cf7hete_Module_Html_Template::MODULE_SLUG ] ) ) {
				$properties = $properties[ Cf7hete_Module_Html_Template::MODULE_SLUG ];

				if ( $properties['activate'] ) {
					$body = $this->replace_tags( $properties['header-html'] );
					$body .= $components['body'];
					$body .= $this->replace_tags( $properties['footer-html'] );

					$components['body'] = $body;
				}
			}


			return $components;

		}

		/**
		 * Filter the 'wpcf7_editor_panels' to add necessary tabs
		 *
		 * @since    1.0.0
		 * @param    array 				$panels		Panels in CF7 Administration
		 */
		public function wpcf7_editor_panels( $panels ) {

			$panels['cf7hete-html-template-panel'] = array(
				'title'		=> __( 'HTML Template', CF7HETE_TEXTDOMAIN ),
				'callback'	=> array( $this, 'cf7hete_html_template_panel_html' ),
			);

			return $panels;

		}

		/**
		 * Filter the 'wpcf7_contact_form_properties' to add necessary properties
		 *
		 * @since    1.0.0
		 * @param    array 				$properties		ContactForm Obj Properties
		 * @param    obj 				$instance		ContactForm Obj Instance
		 */
		public function wpcf7_contact_form_properties( $properties, $instance ) {
			$module_slug = Cf7hete_Module_Html_Template::MODULE_SLUG;

			if ( ! isset( $properties[ $module_slug ] ) ) {
				$properties[ $module_slug ] = array();
			}

			if ( empty( $properties[ $module_slug ]['header-html'] ) ) {
				$properties[ $module_slug ]['header-html'] = $this->get_default_header();
			}

			if ( empty( $properties[ $module_slug ]['footer-html'] ) ) {
				$properties[ $module_slug ]['footer-html'] = $this->get_default_footer();
			}

			if ( isset( $properties[ $module_slug ]['activate'] ) && $properties[ $module_slug ]['activate'] ) {
				$properties['mail']['use_html'] = "1";
				$properties['mail_2']['use_html'] = "1";
			}

			return $properties;

		}

		/**
		 * Action 'wpcf7_save_contact_form' to save properties do Contact Form Post
		 *
		 * @since    1.0.0
		 * @param    WPCF7_ContactForm 	$contactform	Current ContactForm Obj
		 */
		public function wpcf7_save_contact_form( $contact_form ) {

			$module_slug = Cf7hete_Module_Html_Template::MODULE_SLUG;
			
			$new_property = array();

			if ( isset( $_POST['cf7hete-html-template-module-activate'] ) && $_POST['cf7hete-html-template-module-activate'] == "1" ) {
				$new_property[ 'activate' ] = "1";
			} else {
				$new_property[ 'activate' ] = "0";
			}

			if ( isset( $_POST['cf7hete-module-html-template-header-html'] ) ) {
				$new_property[ 'header-html' ] = trim( $_POST['cf7hete-module-html-template-header-html'] );
			}

			if ( isset( $_POST['cf7hete-module-html-template-footer-html'] ) ) {
				$new_property[ 'footer-html' ] = trim( $_POST['cf7hete-module-html-template-footer-html'] );
			}

			$properties = $contact_form->get_properties();
			$properties[ $module_slug ] = $new_property;
			$contact_form->set_properties( $properties );
		}

		/**
		 * Run the plugin.
		 *
		 * @since    1.0.0
		 */
		public function run() {

			$this->define_hooks();

		}

	}
}