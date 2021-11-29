<?php

// If this file is called directly, abort.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$activated = '0';
$header_html = $this->get_default_template( 'header' );
$footer_html = $this->get_default_template( 'footer' );

if ( ! empty( $contactform ) && is_a( $contactform, 'WPCF7_ContactForm' ) ) {
    $metadata = CF7HETE_Module_Cf7::METADATA;
    $properties = get_post_meta( $contactform->id(), '_' . $metadata, true );

    if ( ! empty( $properties['activate'] ) ) {
        $activated = '1';
    }

    if ( ! empty( $properties[ 'header-html' ] ) ) {
        $header_html = $properties['header-html'];
    }

    if ( ! empty( $properties[ 'footer-html' ] ) ) {
        $footer_html = $properties['footer-html'];
    }
}

?>

<h2>
    <?php _e( 'HTML Template', 'cf7-html-email-template-extension' ) ?>
</h2>

<fieldset style="margin-bottom: 40px;">
    <legend>
        <?php _ex( 'In the following fields, you can activate the HTML Template for emails.', 'HTML Template Module Legend', 'cf7-html-email-template-extension' ); ?>
    </legend>

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="wpcf7-mail-body">
                        <?php _e( 'Activate', 'cf7-html-email-template-extension' ) ?>
                    </label>
                </th>
                <td>
                    <p>
                        <label for="cf7hete-html-template-module-activate">
                            <input type="checkbox" id="cf7hete-html-template-module-activate" name="cf7hete-html-template-module-activate" value="1" <?php checked( $activated, "1" ) ?>>
                            <?php _e( 'Activate in this form ( force HTML content type for emails )', 'cf7-html-email-template-extension' ) ?>
                        </label>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</fieldset>

<h2>
    <?php _e( 'Advanced Settings', 'cf7-html-email-template-extension' ) ?>
</h2>

<fieldset class="contact-form-editor-box-mail">
    <legend style="width: 100%; padding: 0; margin-bottom: 20px;">
        <?php echo sprintf( __( 'In the following fields, you can set the markup of header and footer itself. %s Instructions%s', 'cf7-html-email-template-extension' ), '<a href="https://projetos.mariovalney.com/cf7-html-email-template-extension/" target="_blank">', '</a>' ) ?>
        <br>
        <?php echo __( 'You can use these tags to use dinamic content', 'cf7-html-email-template-extension' ) . ": " ?>
        <span class="mailtag code">[home_url]</span>
        <span class="mailtag code">[site_name]</span>
    </legend>

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="cf7hete-module-html-template-header-html">
                        <?php _e( 'HTML for Header', 'cf7-html-email-template-extension' ) ?>
                    </label>
                </th>
                <td>
                    <textarea id="cf7hete-module-html-template-header-html" name="cf7hete-module-html-template-header-html" cols="100" rows="10" class="large-text code"><?php echo esc_textarea( $header_html ); ?></textarea>
                    <div id="cf7hete-module-html-template-header-html-editor"></div>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="cf7hete-module-html-template-footer-html">
                        <?php _e( 'HTML for Footer', 'cf7-html-email-template-extension' ) ?>
                    </label>
                </th>
                <td>
                    <textarea id="cf7hete-module-html-template-footer-html" name="cf7hete-module-html-template-footer-html" cols="100" rows="10" class="large-text code"><?php echo esc_textarea( $footer_html ); ?></textarea>
                    <div id="cf7hete-module-html-template-footer-html-editor"></div>
                </td>
            </tr>
        </tbody>
    </table>
</fieldset>
