<?php

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/**
 * Filter: cf7hete_disable_ace_editor
 *
 * You can return true to avoid add Ace Editor scripts and styles
 *
 * @since    2.0.0
 */
add_filter( 'cf7hete_disable_ace_editor', 'cf7hete_deprecated_disable_ace_editor', 1 );
function cf7hete_deprecated_disable_ace_editor( $falsy ) {
    return apply_filters( 'cf7hete-disable-ace-editor', $falsy );
}
