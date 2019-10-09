<?php
/**
 * Admin Page view
 */

defined('ABSPATH') || die('Cheatin\' uh?');
global $wp_version;
$heading_tag = version_compare( $wp_version, '4.3' ) >= 0 ? 'h1' : 'h2';
$notices->echoNotices();
$plugins_block['imagify']->set_button_text( array(
	'activated' => esc_html__( 'Activated', 'upload-max-file-size' ),
	'installed' =>  esc_html__( 'Activate now', 'upload-max-file-size' ),
	'not_installed' => esc_html__( 'Install now', 'upload-max-file-size' ),
) );
?>
<div class="wrap">
	<div class="heartbeat-control-settings">
		<<?php echo $heading_tag; ?> class="screen-reader-text"><?php echo esc_html( get_admin_page_title() ); ?></<?php echo $heading_tag; ?>>
	<div class="header">
		<div class="header-left">
			<div class="visuel">
				<img src="<?php echo $asset_image_url.'logo.svg' ?>" alt="">
			</div>
		</div>
		<div class="header-right">
			<div class="txt-1"><?php esc_html_e( 'Do you like this plugin ?', 'upload-max-file-size' ); ?></div>
			<div class="txt-2">
				<?php
				printf(
					__( 'Please, take a few seconds to %1$srate it on WordPress.org%2$s', 'upload-max-file-size' ),
					'<a href="https://wordpress.org/support/plugin/upload-max-file-size/reviews/?filter=5"><strong>',
					'</strong></a>'
				);
				?>
			</div>
			<div class="txt-3">
				<a href="https://wordpress.org/support/plugin/upload-max-file-size/reviews/?filter=5">
					<span class="dashicons dashicons-star-filled"></span>
					<span class="dashicons dashicons-star-filled"></span>
					<span class="dashicons dashicons-star-filled"></span>
					<span class="dashicons dashicons-star-filled"></span>
					<span class="dashicons dashicons-star-filled"></span>
				</a>
			</div>
		</div>
	</div>
	<div class="wrapper-nav">
		<h2 class="nav-tab-wrapper">
			<span class="nav-tab nav-tab-active" data-tab="general-settings"><?php esc_html_e( 'General settings', 'upload-max-file-size' ); ?></span>
<?php if( !$plugins_block['imagify']->is_activated() ): ?>
			<span class="nav-tab" data-tab="more-optimization"><?php esc_html_e( 'More optimization', 'upload-max-file-size' ); ?></span>
<?php endif; ?>
			<span class="nav-tab" data-tab="about-us" ><?php esc_html_e( 'About us', 'upload-max-file-size' ); ?></span>
		</h2>
	</div>
	<div id="tab_general-settings" class="tab tab-active"><?php WF_Upload_Max_File_Size::upload_max_file_size_form(); ?></div>
<?php if( !$plugins_block['imagify']->is_activated() ): ?>
	<div id="tab_more-optimization" class="tab">
		<div class="wrapper-content wrapper-intro">
			<div class="wrapper-left">
				<div class="wrapper-img">
					<img src="<?php echo $asset_image_url.'Imagify-Logo-Gray-Colored.svg'; ?>" alt="">
				</div>
				<div class="wrapper-txt">
						<?php
							printf(
								__( '%1$sLooking for more optimization?%2$s %1$sThen you should use %3$sImagify%4$s to speed up your website with %3$slighter images.%4$s Our algorithms will reduce the weight of your images without sacrificing their quality.%2$s', 'upload-max-file-size' ),
								'<p>', '</p>', '<strong>', '</strong>'
							);
						?>
				</div>
				<a class="btn referer-link <?php echo esc_attr( $plugins_block['imagify']->get_status() ); ?>" href="<?php echo $plugins_block['imagify']->get_install_url(); ?>">
					<?php echo $plugins_block['imagify']->get_button_text(); ?>
				</a>
				<div class="wrapper-img"></div>
			</div>
			<div class="wrapper-right">
				<div class="wrapper-right-img"></div>
			</div>
		</div>
		<div class="wrapper-content wrapper-numbers">
			<div class="top-part">
				<?php esc_html_e( 'Imagify will help you reach perfection!', 'upload-max-file-size' ); ?>
			</div>
			<div class="bottom-part">
				<ul>
					<li>
						<div class="visuel">
							<img src="<?php echo $asset_image_url.'fusee.svg'; ?>" alt="">
						</div>
						<div class="txt-title">
							<?php
								printf(
									__( '%1$sSpeed up your websites%2$s', 'upload-max-file-size' ),
									'<strong>', '</strong>'
								);
							?>
						</div>						
						<div class="txt">
							<?php esc_html_e( 'With lighter images, you will gain in speed, user experience and even in SEO.', 'upload-max-file-size' ); ?>
						</div>
					</li>
					<li>
						<div class="visuel">
							<img src="<?php echo $asset_image_url.'time.svg'; ?>" alt="">
						</div>
						<div class="txt-title">
							<?php
								printf(
									__( '%1$sSave time%2$s', 'upload-max-file-size' ),
									'<strong>', '</strong>'
								);
							?>
						</div>						
						<div class="txt">
							<?php esc_html_e( 'Stop fine-tuning your images, they are now automatically optimized.', 'upload-max-file-size' ); ?>
						</div>
					</li>
					<li>
						<div class="visuel">
							<img src="<?php echo $asset_image_url.'optimize.svg'; ?>" alt="">
						</div>
						<div class="txt-title">
							<?php
								printf(
									__( '%1$sOptimize every format%2$s', 'upload-max-file-size' ),
									'<strong>', '</strong>'
								);
							?>
						</div>						
						<div class="txt">
							<?php esc_html_e( 'Optimize pdf, jpg, png and gif formats. And for each image, you also get its WebP version.', 'upload-max-file-size' ); ?>
						</div>
					</li>
					<li>
						<div class="visuel">
							<img src="<?php echo $asset_image_url.'quality.svg'; ?>" alt="">
						</div>
						<div class="txt-title">
							<?php
								printf(
									__( '%1$sDon\'t sacrifice quality%2$s', 'upload-max-file-size' ),
									'<strong>', '</strong>'
								);
							?>
						</div>						
						<div class="txt">
							<?php esc_html_e( 'Reduce the weight of your images without sacrificing their quality. They will remain beautiful.', 'upload-max-file-size' ); ?>
						</div>
					</li>					
				</ul>
			</div>
		</div>
		<div class="wrapper-compare-imgs">
			<div class="txt-title">
				<?php esc_html_e( 'You will not see any image degradation!', 'upload-max-file-size' ); ?>
			</div>
			<div id="container1" class="twentytwenty-container">
				<img src="<?php echo $asset_image_url.'bridge-original.jpg'; ?>" alt="">
				<img src="<?php echo $asset_image_url.'bridge-normal.jpg'; ?>" alt="">
			</div>
		</div>
		<div class="wrapper-content wrapper-install">
			<div class="txt">
				<?php
					printf(
						__( 'Compress your images in one click with%1$s the Imagify WordPress plugin', 'upload-max-file-size' ),
						'<br>', '</strong>'
					);
				?>
			</div>
			<div class="install-btn">
				<a class="btn referer-link <?php echo esc_attr( $plugins_block['imagify']->get_status() ); ?>" href="<?php echo $plugins_block['imagify']->get_install_url(); ?>">
					<?php echo $plugins_block['imagify']->get_button_text(); ?>
				</a>
			</div>
		</div>
	</div>
<?php endif; ?>
	<div id="tab_about-us" class="tab">
		<div class="wrapper-top wrapper-info">
			<div class="top-img">
				<img src="<?php echo $asset_image_url.'team.jpg'; ?>" alt="">
			</div>
			<div class="top-txt">
				<h2><?php esc_html_e( 'Welcome to WP Media!', 'upload-max-file-size' ); ?></h2>
				<p><?php esc_html_e( 'Founded in 2014 in beautiful Lyon (France), WP Media is now a distributed company of more than 20 WordPress lovers living in the four corners of the world.', 'upload-max-file-size' ); ?></p>
				<p><?php esc_html_e( 'We develop plugins that make the web a better place - faster, lighter, and easier to use.', 'upload-max-file-size' ); ?></p>
				<p><?php esc_html_e( 'Check out our other plugins: we built them all to give a boost to the performance of your website!', 'upload-max-file-size' ); ?></p>
			</div>
		</div>
		<div class="wrapper-bottom wrapper-link">
			<?php $plugins_block['wp-rocket']->helper(); ?>
			<?php $plugins_block['imagify']->helper(); ?>
			<?php $plugins_block['rocket-lazy-load']->helper(); ?>
			<?php $plugins_block['heartbeat-control']->helper(); ?>
		</div>
	</div>
</div>
</div>
