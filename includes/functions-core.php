<?php

function cf7hete_log( $message, $file = 'errors.log' ) {
    error_log( $message . "\n", 3, CF7HETE_PLUGIN_PATH . '/' . $file );
}
