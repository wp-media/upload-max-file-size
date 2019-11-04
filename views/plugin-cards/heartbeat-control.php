<?php
/**
 * Plugin card template HeartBeat Control
 */

$helper->set_title( 'HeartBeat Control' );
$helper->set_description(
	sprintf(
		// translators: %1$s %2$s: bold markup.
		esc_html__( 'Helps you control the WordPress Heartbeat API and %1$sreduce CPU usage%2$s.', 'upload-max-file-size' ),
		'<strong>',
		'</strong>'
	)
);
?>
<div class="card single-link heartbeat">
	<div class="link-infos">
		<div class="link-infos-logo"><?php echo $helper->get_icon(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
		<span class="link-infos-txt">
			<h3><?php echo esc_html( $helper->get_title() ); ?></h3>
			<p>
			<?php
			printf(
				// translators: %1$s: status (not installed, installed or activated).
				esc_html__( 'Status : %1$s', 'upload-max-file-size' ),
				esc_html( $helper->get_status_text() )
			);
			?>
			</p>
		</span>
	</div>
	<div class="link-content"><?php echo $helper->get_description(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
	<?php if ( 'activated' === $helper->get_status() ) : ?>
		<span class="wrapper-infos-active"><span class="dashicons dashicons-yes"></span><span class="info-active"><?php echo esc_html( $helper->get_button_text() ); ?></span></span>
	<?php else : ?>
		<a class="link-btn button-primary referer-link <?php echo esc_attr( $helper->get_status() ); ?>" href="<?php echo esc_url( $helper->get_install_url() ); ?>"><?php echo esc_html( $helper->get_button_text() ); ?></a>
	<?php endif; ?>
</div>
