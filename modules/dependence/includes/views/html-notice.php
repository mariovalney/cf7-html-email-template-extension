<?php
/**
 * Admin View: Notice.
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

?>

<div class="notice notice-<?php echo esc_attr( $notice[1] ?? 'error' ); ?>">
    <p><?php echo $notice[0]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
</div>
