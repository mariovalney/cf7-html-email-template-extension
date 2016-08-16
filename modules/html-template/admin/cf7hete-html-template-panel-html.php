<?php

// If this file is called directly, abort.
defined( 'CF7HETE_LOADED' ) or die( 'No script kiddies please!' );

$activated = "0";
$header_html = "";
$footer_html = "";

if ( is_a( $contactform, 'WPCF7_ContactForm' ) ) {//

	$module_slug = Cf7hete_Module_Html_Template::MODULE_SLUG;

	$properties = get_post_meta( $contactform->id(), "_" . $module_slug, true );

	if ( isset( $properties[ 'activate' ] ) ) {
		$activated = $properties[ 'activate' ];
	}

	if ( isset( $properties[ 'header-html' ] ) ) {
		$header_html = $properties[ 'header-html' ];
	}

	if ( isset( $properties[ 'footer-html' ] ) ) {
		$footer_html = $properties[ 'footer-html' ];
	}

}

?>

<h2>
	<?php _e( 'HTML Template', CF7HETE_TEXTDOMAIN ) ?>
</h2>

<fieldset style="margin-bottom: 40px;">
	<legend>
		<?php _ex( 'In the following fields, you can activate the HTML Template for emails.', 'HTML Template Module Legend', CF7HETE_TEXTDOMAIN ); ?>
	</legend>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="wpcf7-mail-body">
						<?php _e( 'Activate', CF7HETE_TEXTDOMAIN ) ?>
					</label>
				</th>
				<td>
					<p>
						<label for="cf7hete-html-template-module-activate">
							<input type="checkbox" id="cf7hete-html-template-module-activate" name="cf7hete-html-template-module-activate" value="1" <?php checked( $activated, "1" ) ?>>
							<?php _e( 'Activate in this form ( force HTML content type for emails )', CF7HETE_TEXTDOMAIN ) ?>
						</label>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>

<h2>
	<?php _e( 'Advanced Settings', CF7HETE_TEXTDOMAIN ) ?>
</h2>

<fieldset class="contact-form-editor-box-mail">
	<legend style="width: 100%; padding: 0; margin-bottom: 20px;">
		<?php echo sprintf( __( 'In the following fields, you can set the markup of header and footer itself. %s Instructions%s', CF7HETE_TEXTDOMAIN ), '<a href="https://projetos.mariovalney.com/cf7-html-email-template-extension/" target="_blank">', '</a>' ) ?>
		<br>
		<?php echo __( 'You can use these tags to use dinamic content', CF7HETE_TEXTDOMAIN ) . ": " ?>
		<span class="mailtag code">[home_url]</span>
		<span class="mailtag code">[site_name]</span>
	</legend>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="cf7hete-module-html-template-header-html">
						<?php _e( 'HTML for Header', CF7HETE_TEXTDOMAIN ) ?>
					</label>
				</th>
				<td>
					<textarea id="cf7hete-module-html-template-header-html" name="cf7hete-module-html-template-header-html" cols="100" rows="10" class="large-text code"><?php echo esc_textarea( $header_html ); ?></textarea>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="cf7hete-module-html-template-footer-html">
						<?php _e( 'HTML for Footer', CF7HETE_TEXTDOMAIN ) ?>
					</label>
				</th>
				<td>
					<textarea id="cf7hete-module-html-template-footer-html" name="cf7hete-module-html-template-footer-html" cols="100" rows="10" class="large-text code"><?php echo esc_textarea( $footer_html ); ?></textarea>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>