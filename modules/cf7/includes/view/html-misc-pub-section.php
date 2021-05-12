<?php

// If this file is called directly, abort.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

?>

<div class="cfhete-preview-wrapper">
    <a href="<?php echo esc_attr( add_query_arg( 'cf7hete', 'preview' ) ); ?>" target="cfhete_preview" class="button">
        <?php _e( 'Preview your mail', 'cf7-html-email-template-extension' ) ?>
    </a>
</div>
