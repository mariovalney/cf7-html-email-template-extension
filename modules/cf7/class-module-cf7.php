<?php

/**
 * CF7HETE_Module_Cf7
 * Class responsible to manage all CF7 stuff
 *
 * Depends: dependence
 *
 * @package         Cf7_Html_Email_Template_Extension
 * @subpackage      CF7HETE_Module_Cf7
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! class_exists( 'CF7HETE_Module_Cf7' ) ) {

    class CF7HETE_Module_Cf7 {

        /**
         * Metadada slug
         *
         * @since    1.0.0
         * @access   public
         * @var      string
         */
        const METADATA = 'html_template';

        /**
         * Run
         *
         * @since    1.0.0
         */
        public function run() {
            $module = $this->core->get_module( 'dependence' );

            // Checking Dependences
            $module->add_dependence( 'contact-form-7/wp-contact-form-7.php', 'Contact Form 7', 'contact-form-7' );
        }

        /**
         * Define hooks
         *
         * @since    1.0.0
         * @param    Cf7_Html_Email_Template_Extension      $core   The Core object
         */
        public function define_hooks() {
            $this->core->add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
            $this->core->add_action( 'wpcf7_save_contact_form', array( $this, 'wpcf7_save_contact_form' ) );

            $this->core->add_filter( 'wpcf7_editor_panels', array( $this, 'wpcf7_editor_panels' ) );
            $this->core->add_filter( 'wpcf7_contact_form_properties', array( $this, 'wpcf7_contact_form_properties' ), 10, 2 );
            $this->core->add_filter( 'wpcf7_mail_components', array( $this, 'wpcf7_mail_components' ), 20, 2 );
        }

        /**
         * Action: 'admin_enqueue_scripts'
         * Add scripts to CF7 panels
         *
         * @return void
         */
        public function admin_enqueue_scripts() {
            /**
             * Filter
             *
             * You can return true to avoid add Ace Editor scripts and styles
             */
            if ( apply_filters( 'cf7hete-disable-ace-editor', false ) ) {
                return;
            }

            wp_enqueue_script( 'cf7hete-ace-editor-script', CF7HETE_PLUGIN_URL . '/modules/cf7/includes/assets/ace-editor/ace.js', ['wpcf7-admin'] );
            wp_enqueue_script( 'cf7hete-script', CF7HETE_PLUGIN_URL . '/modules/cf7/includes/assets/cf7hete-script.js', ['cf7hete-ace-editor-script'] );

            wp_enqueue_style( 'cf7hete-style', CF7HETE_PLUGIN_URL . '/modules/cf7/includes/assets/cf7hete-styles.css', ['contact-form-7-admin'] );
        }

        /**
         * Action: 'wpcf7_save_contact_form'
         * Save the contact form options
         *
         * @param WPCF7_ContactForm  $contactform
         * @return  void
         */
        public function wpcf7_save_contact_form( $contact_form ) {
            $metadata = CF7HETE_Module_Cf7::METADATA;

            $new_property = ['activate' => '0'];

            if ( ! empty( $_POST['cf7hete-html-template-module-activate'] ) ) {
                $new_property['activate'] = '1';
            }

            if ( isset( $_POST['cf7hete-module-html-template-header-html'] ) ) {
                $new_property['header-html'] = trim( $_POST['cf7hete-module-html-template-header-html'] );
            }

            if ( isset( $_POST['cf7hete-module-html-template-footer-html'] ) ) {
                $new_property['footer-html'] = trim( $_POST['cf7hete-module-html-template-footer-html'] );
            }

            // Save settings
            $properties = $contact_form->get_properties();
            $properties[ $metadata ] = $new_property;
            $contact_form->set_properties( $properties );
        }

        /**
         * Filter: 'wpcf7_editor_panels'
         * Add CF7 panels
         *
         * @return void
         */
        public function wpcf7_editor_panels( $panels ) {
            $panels['cf7hete-html-template-panel'] = array(
                'title'     => __( 'HTML Template', 'cf7-html-email-template-extension' ),
                'callback'  => [ $this, 'render_html_template_panel' ],
            );

            return $panels;
        }

        /**
         * Filter: 'wpcf7_contact_form_properties'
         * Add necessary properties
         *
         * @return void
         */
        public function wpcf7_contact_form_properties( $properties, $instance ) {
            $metadata = CF7HETE_Module_Cf7::METADATA;

            if ( empty( $properties[ $metadata ] ) ) {
                $properties[ $metadata ] = [];
            }

            if ( empty( $properties[ $metadata ]['header-html'] ) ) {
                $properties[ $metadata ]['header-html'] = $this->get_default_template( 'header' );
            }

            if ( empty( $properties[ $metadata ]['footer-html'] ) ) {
                $properties[ $metadata ]['footer-html'] = $this->get_default_template( 'footer' );
            }

            if ( isset( $properties[ $metadata ]['activate'] ) && $properties[ $metadata ]['activate'] ) {
                $properties['mail']['use_html'] = '1';
                $properties['mail_2']['use_html'] = '1';
            }

            return $properties;
        }

        /**
         * Filter: 'wpcf7_mail_components'
         * Description of the filter
         *
         * @param array
         * @param WPCF7_ContactForm
         * @return void
         */
        public function wpcf7_mail_components( $components, $contactform ) {
            $properties = $contactform->get_properties();

            if ( ! isset( $properties[ CF7HETE_Module_Cf7::METADATA ] ) ) {
                return $components;
            }

            $properties = $properties[ CF7HETE_Module_Cf7::METADATA ];

            if ( $properties['activate'] ) {
                $body = $this->replace_tags( $properties['header-html'] );
                $body .= $components['body'];
                $body .= $this->replace_tags( $properties['footer-html'] );

                $components['body'] = $body;
            }

            return $components;
        }

        /**
         * Callback to add panel HTML
         *
         * @since    1.0.0
         * @param    WPCF7_ContactForm  $contactform
         */
        public function render_html_template_panel( WPCF7_ContactForm $contactform ) {
            require CF7HETE_PLUGIN_PATH . '/modules/cf7/includes/view/html-template-panel-html.php';
        }

        /**
         * Get the default markup file
         *
         * @since    1.0.0
         */
        private function get_default_template( $name ) {
            return file_get_contents( CF7HETE_PLUGIN_PATH . '/modules/cf7/includes/templates/default-' . $name . '.htm' );
        }

        /**
         * Replace tags in $string
         *
         * @since    1.0.0
         * @param    string     $string     Text to be processed
         */
        private function replace_tags( $text ) {
            $text = str_replace( '[home_url]', home_url(), $text );
            $text = str_replace( '[site_name]', get_bloginfo( "name" ), $text );

            return $text;
        }

    }

}
