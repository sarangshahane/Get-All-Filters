<?php

/**
 * Admin HTML Mark up
 *
 * @link       sarangshshane.in
 * @since      1.0.0
 *
 * @package    Get_All_Filters
 * @subpackage Get_All_Filters/public/partials
 */

?>

<div class="gaf-menu-page-wrapper">
	<div id="gaf-menu-page">
		<div class="gaf-menu-page-header <?php echo esc_attr( implode( ' ', $header_wrapper_class ) ); ?>">
			<div class="gaf-container gaf-flex">
				<div class="gaf-title">
					<span class="screen-reader-text"><?php echo GAF_PLUGIN_SHORT_NAME; ?></span>
					<img class="gaf-logo" src="<?php echo GET_ALL_FILTERS_URL . ''; ?>" />
				</div>
				<div class="gaf-top-links">
					<?php
						esc_attr_e( 'Modernizing WordPress eCommerce!', 'get-all-filters' );
					?>
				</div>
			</div>
		</div>

		<?php
		// Settings update message.
		if ( isset( $_REQUEST['message'] ) && ( 'saved' == $_REQUEST['message'] || 'saved_ext' == $_REQUEST['message'] ) ) {
			?>
				<div id="message" class="notice notice-success is-dismissive gaf-notice"><p> <?php esc_html_e( 'Settings saved successfully.', 'cartflows' ); ?> </p></div>
			<?php
		}
		?>
		<?php do_action( 'get_all_filters_render_admin_content' ); ?>
	</div>
</div>