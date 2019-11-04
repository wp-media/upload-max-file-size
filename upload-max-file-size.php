<?php
/**
 * Plugin Name: Increase Maximum Upload File Size
 * Description: Increase maximum upload file size with one click.
 * Author: Imagify
 * Author URI: https://wordpress.org/plugins/imagify/
 * Plugin URI: https://wordpress.org/plugins/upload-max-file-size/
 * Version: 2.0
 * License: GPL2
 * Text Domain: upload-max-file-size
 */

define( 'UMFS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'UMFS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

class WF_Upload_Max_File_Size {
	/**
	 * A array of plugin card.
	 *
	 * @var array of Plugin_Card_Helper Object
	 */
	protected $plugins_block = array();

	/**
	 * Plugin init.
	 *
	 * @return void
	 */
	public static function init() {
		if ( is_admin() ) {
			add_action( 'admin_menu', array( __CLASS__, 'upload_max_file_size_add_pages' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( __CLASS__, 'plugin_action_links' ) );
			add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_meta_links' ), 10, 2 );

			self::process_settings();
			self::init_card();
		}

		add_filter( 'upload_size_limit', array( __CLASS__, 'upload_max_increase_upload' ) );
	}

	/**
	 * Plugin card init.
	 *
	 * @return void
	 */
	public static function init_card() {
		require_once UMFS_PLUGIN_PATH . 'UMFS_Notices.php';
		require_once UMFS_PLUGIN_PATH . 'UMFS_Imagify_Partner.php';
		require_once UMFS_PLUGIN_PATH . 'UMFS_Plugin_Card_Helper.php';

		$imagify_partner = new UMFS_Imagify_Partner( 'upload-max-file-size' );
		$imagify_partner->init();
		self::$plugins_block = array(
			'rocket-lazy-load'  => new UMFS_Plugin_Card_Helper(
				array(
					'plugin_slug' => 'rocket-lazy-load',
				)
			),
			'heartbeat-control' => new UMFS_Plugin_Card_Helper(
				array(
					'plugin_slug' => 'heartbeat-control',
				)
			),
			'wp-rocket'         => new UMFS_Plugin_Card_Helper(
				array(
					'plugin_slug' => 'wp-rocket',
				)
			),
			'imagify'           => new UMFS_Plugin_Card_Helper(
				array(
					'plugin_slug' => 'imagify',
				),
				array(
					'imagify_partner' => $imagify_partner,
				)
			),
		);
	}

	/**
	 * Process the settings changes.
	 *
	 * @return void
	 */
	public static function process_settings() {
		if ( isset( $_POST['upload_max_file_size_field'], $_POST['upload_max_file_size_nonce'] )
			&& wp_verify_nonce( sanitize_key( $_POST['upload_max_file_size_nonce'] ), 'upload_max_file_size_action' )
			&& is_numeric( $_POST['upload_max_file_size_field'] ) ) {
			$notices  = UMFS_Notices::get_instance();
			$max_size = (int) $_POST['upload_max_file_size_field'] * 1024 * 1024;

			if ( update_option( 'max_file_size', $max_size ) ) {
				$notices->append( 'success', __( 'Maximum upload file size saved &amp; changed!', 'upload-max-file-size' ) );
			} else {
				$notices->append( 'error', __( 'Maximum upload file size has not changed!', 'upload-max-file-size' ) );
			}
		}
	}

	/**
	 * HOOKED
	 * add a link to the plugin settings page into item of the plugin list.
	 *
	 * @param  string $links See https://developer.wordpress.org/reference/hooks/plugin_action_links_plugin_file/.
	 * @return string $links A link to the page settings.
	 */
	public static function plugin_action_links( $links ) {
		$settings_link = '<a href="' . admin_url( 'options-general.php?page=upload-max-file-size' ) . '" title="Adjust Max File Upload Size Settings">Settings</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Add a link to the WordPress plugin depository page into item of the plugin list.
	 *
	 * @param  string $links See https://developer.wordpress.org/reference/hooks/plugin_row_meta/.
	 * @param  string $file  See https://developer.wordpress.org/reference/hooks/plugin_row_meta/.
	 * @return string $links A link to the WordPress plugin depository.
	 */
	public static function plugin_meta_links( $links, $file ) {
		$support_link = '<a target="_blank" href="https://wordpress.org/support/plugin/upload-max-file-size" title="Get help">Support</a>';

		if ( plugin_basename( __FILE__ ) === $file ) {
			$links[] = $support_link;
		}

		return $links;
	}

	/**
	 * Add menu pages.
	 *
	 * @return void
	 */
	public static function upload_max_file_size_add_pages() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_options_page( 'Increase Max Upload File Size', 'Increase Maximum Upload File Size', 'manage_options', 'upload-max-file-size', array( __CLASS__, 'admin_controller_options' ) );
	}

	/**
	 * Get closest value from array.
	 *
	 * @param  int   $search  Search value.
	 * @param  array $arr     Array to find closest value in.
	 * @return int   $closest The closest value in MB.
	 */
	public static function get_closest( $search, $arr ) {
		$closest = null;

		foreach ( $arr as $item ) {
			if ( null === $closest || abs( $search - $closest ) > abs( $item - $search ) ) {
				$closest = $item;
			}
		}

		return $closest;
	}

	/**
	 * Option admin page enqueue script and style.
	 *
	 * @param  string $hook Use for context validation.
	 * @return void
	 */
	public static function enqueue_scripts( $hook ) {
		if ( 'settings_page_upload-max-file-size' !== $hook ) {
			return;
		}

		wp_register_style( 'umfs_admin_style', UMFS_PLUGIN_URL . 'assets/css/style.min.css', array(), '1.0' );
		wp_enqueue_style( 'umfs_admin_style' );
		wp_register_script( 'umfs_admin_event', UMFS_PLUGIN_URL . 'assets/js/jquery.event.move.js', array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( 'umfs_admin_event' );
		wp_register_script( 'umfs_admin_twenty', UMFS_PLUGIN_URL . 'assets/js/jquery.twentytwenty.js', array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( 'umfs_admin_twenty' );
		wp_register_script( 'umfs_admin_test', UMFS_PLUGIN_URL . 'assets/js/imagesLoaded.js', array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( 'umfs_admin_test' );

		wp_register_script( 'umfs_admin_script', UMFS_PLUGIN_URL . 'assets/js/script.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'umfs_admin_script' );
	}

	/**
	 * Simple admin option page controller.
	 *
	 * @return void
	 */
	public static function admin_controller_options() {
		$notices         = UMFS_Notices::get_instance();
		$plugins_block   = self::$plugins_block;
		$asset_image_url = UMFS_PLUGIN_URL . 'assets/img/';

		include_once UMFS_PLUGIN_PATH . 'views/admin-page.php';
	}

	/**
	 * Admin setting form controller.
	 *
	 * @return void
	 */
	public static function upload_max_file_size_form() {
		$ini_size = ini_get( 'upload_max_filesize' );

		if ( ! $ini_size ) {
			$ini_size = 'unknown';
		} elseif ( is_numeric( $ini_size ) ) {
			$ini_size .= ' bytes';
		} else {
			$ini_size .= 'B';
		}

		$wp_size = wp_max_upload_size();

		if ( ! $wp_size ) {
			$wp_size = 'unknown';
		} else {
			$wp_size = round( ( $wp_size / 1024 / 1024 ) );
			$wp_size = 1024 === $wp_size ? '1GB' : $wp_size . 'MB';
		}

		$max_size = get_option( 'max_file_size' );

		if ( ! $max_size ) {
			$max_size = 64 * 1024 * 1024;
		}

		$max_size         = $max_size / 1024 / 1024;
		$upload_sizes     = array( 16, 32, 64, 128, 256, 512, 1024 );
		$current_max_size = self::get_closest( $max_size, $upload_sizes );

		include_once UMFS_PLUGIN_PATH . 'views/admin-form.php';
	}


	/**
	 * Filter to increase max_file_size
	 *
	 * @return int max_size in bytes
	 */
	public static function upload_max_increase_upload() {
		$max_size = (int) get_option( 'max_file_size' );

		if ( ! $max_size ) {
			$max_size = 64 * 1024 * 1024;
		}

		return $max_size;
	}
}

add_action( 'init', array( 'WF_Upload_Max_File_Size', 'init' ) );
