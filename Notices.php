<?php
/**
 * Contains the Upload_Max_File_Size\Notices class.
 *
 * Simple to use message flashbag for admin base on user_id.
 *
 * @package Upload_Max_File_Size
 */

namespace Upload_Max_File_Size;

defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Simple notification flashbag
 */
class Notices {
	/**
	 * The single instance of the class.
	 *
	 * @var Notices
	 * @access protected
	 */
	protected static $instance;

	/**
	 * The transient name.
	 *
	 * @var string
	 * @access protected
	 */
	protected $transient = 'upload-max-file-size_notices';

	/**
	 * Store notices.
	 *
	 * @var int
	 * @access protected
	 */
	protected $notices = false;

	/**
	 * The user ID.
	 *
	 * @var int
	 * @access protected
	 */
	protected $user_id;

	/**
	 * Main Plugin Instance.
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return Notices - Main instance.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new Notices();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @param string $transient overwrite default transient value.
	 */
	public function __construct( $transient = null ) {
		if ( ! is_null( $transient ) ) {
			$this->transient = $transient;
		}

		$this->notices = get_transient( $this->transient );
		$this->user_id = get_current_user_id();
	}

	/**
	 * Append a new notice for the current user.
	 *
	 * @param string $class  The class of the message use for styling and typing.
	 * @param string $notice The message of the notice.
	 */
	public function append( $class, $notice ) {
		$new_notices = array();

		if ( $this->notices ) {
			$new_notices = json_decode( $this->notices, true );
		}

		$new_notices[ $this->user_id ][] = array(
			'class'  => $class,
			'notice' => $notice,
		);
		$this->notices                   = json_encode( $new_notices ); // phpcs:ignore WordPress.WP.AlternativeFunctions

		set_transient( $this->transient, $this->notices, 30 );
	}

	/**
	 * Echo notices for the current user.
	 *
	 * @param boolean $trash [optional] If true the notices will be trash after the echo.
	 */
	public function echo_notices( $trash = true ) {
		if ( $this->notices ) {
			$notices = json_decode( $this->notices, true );
			if ( isset( $notices[ $this->user_id ] ) ) {
				foreach ( $notices[ $this->user_id ] as $n ) {
					echo '<div class="notice notice-' . esc_attr( $n['class'] ) . ' is-dismissible"><p>' . esc_html( $n['notice'] ) . '</p></div>';
				}

				if ( $trash ) {
					$this->trash( $notices, $this->user_id );
				}
			}
		}
	}

	/**
	 * Return the notices for the current user.
	 *
	 * @param  boolean $trash [optional] If true the notices will be trash after get returned.
	 * @return mixed Output a array if a notice or more exist, a false if not.
	 */
	public function get( $trash = true ) {
		if ( $this->notices ) {
			$notices = json_decode( $this->notices, true );
			if ( isset( $notices[ $this->user_id ] ) ) {
				if ( $trash ) {
					$this->trash( $notices, $this->user_id );
				}

				return $notices[ $this->user_id ];
			}
		}

		return false;
	}

	/**
	 * Unset notice for a given user and save the new notices as a transient.
	 *
	 * @param array $notices An array of $notices to clean.
	 * @param int   $user_id [optional] A user id, if null it's will find the current user id.
	 */
	private function trash( $notices, $user_id = null ) {
		if ( is_null( $user_id ) ) {
			$user_id = $this->user_id;
		}

		if ( isset( $notices[ $user_id ] ) ) {
			unset( $notices[ $user_id ] );
		}

		set_transient( $this->transient, json_encode( $notices ), 30 ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	}
}
