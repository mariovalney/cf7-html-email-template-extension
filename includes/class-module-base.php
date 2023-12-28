<?php

/**
 * CF7HETE_Module_Base
 *
 * @package         Cf7_Html_Email_Template_Extension
 * @since           2.2.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! class_exists( 'CF7HETE_Module_Base' ) ) {

    class CF7HETE_Module_Base {

        /**
         * @access   protected
         * @var      Cf7_Html_Email_Template_Extension
         */
        protected $core;

        /**
         * Define the core functionality of the plugin.
         *
         * @since    1.0.0
         */
        public function __construct( Cf7_Html_Email_Template_Extension $core ) {
            $this->core = $core;
        }

    }

}