<?php
/**
 * Plugin Name: Deposits Enable Plans and Deposits
 * Plugin URI: https://example.com/deposits-enable-plans-and-deposits
 * Description: Enables plans and deposits functionality for WooCommerce.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: deposits-enable-plans-and-deposits
 * Domain Path: /languages
 * Requires at least: 5.8
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * WC requires at least: 6.0
 * WC tested up to: 8.0
 * WC requires PHP: 7.4
 * 
 * Plugin Dependencies:
 * - woocommerce/woocommerce.php
 * - woocommerce-deposits/woocommerce-deposits.php
 * 
 * Woo: 12345:342928dfsfhsf2349842374wdf4234sfd
 * WC requires at least: 6.0
 * WC tested up to: 8.0
 * 
 * WooCommerce Features:
 * - hpos
 * - cost-of-goods
 * 
 * WooCommerce Incompatibilities:
 * - checkout-block
 * - cart-block
 * 
 * @package Deposits_Enable_Plans_And_Deposits
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants
define( 'DEPOSITS_ENABLE_PLANS_VERSION', '1.0.0' );
define( 'DEPOSITS_ENABLE_PLANS_PLUGIN_FILE', __FILE__ );
define( 'DEPOSITS_ENABLE_PLANS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DEPOSITS_ENABLE_PLANS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Main plugin class
 */
class Deposits_Enable_Plans_And_Deposits {

	/**
	 * Plugin instance
	 *
	 * @var Deposits_Enable_Plans_And_Deposits
	 */
	private static $instance = null;

	/**
	 * Get plugin instance
	 *
	 * @return Deposits_Enable_Plans_And_Deposits
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
		add_action( 'init', array( $this, 'load_textdomain' ) );
	}

	/**
	 * Initialize plugin
	 */
	public function init() {
		// Check if WooCommerce is active
		if ( ! class_exists( 'WooCommerce' ) ) {
			add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
			return;
		}

		// Check if WooCommerce Deposits is active
		if ( ! class_exists( 'WC_Deposits' ) ) {
			add_action( 'admin_notices', array( $this, 'deposits_missing_notice' ) );
			return;
		}

		// Load includes
		$this->load_includes();
	}

	/**
	 * Load plugin includes
	 */
	private function load_includes() {
		$includes_dir = DEPOSITS_ENABLE_PLANS_PLUGIN_DIR . 'includes/';
		
		// Load files from includes directory
		if ( is_dir( $includes_dir ) ) {
			$files = glob( $includes_dir . '*.php' );
			foreach ( $files as $file ) {
				require_once $file;
			}
		}
	}

	/**
	 * Load text domain
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'deposits-enable-plans-and-deposits',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}

	/**
	 * WooCommerce missing notice
	 */
	public function woocommerce_missing_notice() {
		echo '<div class="error"><p>';
		printf(
			/* translators: %s: WooCommerce URL */
			esc_html__( 'Deposits Enable Plans and Deposits requires WooCommerce to be installed and active. You can download %s here.', 'deposits-enable-plans-and-deposits' ),
			'<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>'
		);
		echo '</p></div>';
	}

	/**
	 * WooCommerce Deposits missing notice
	 */
	public function deposits_missing_notice() {
		echo '<div class="error"><p>';
		printf(
			/* translators: %s: WooCommerce Deposits URL */
			esc_html__( 'Deposits Enable Plans and Deposits requires WooCommerce Deposits to be installed and active. You can download %s here.', 'deposits-enable-plans-and-deposits' ),
			'<a href="https://woocommerce.com/products/woocommerce-deposits/" target="_blank">WooCommerce Deposits</a>'
		);
		echo '</p></div>';
	}

	/**
	 * Get plugin URL
	 *
	 * @param string $path Optional path to append to the plugin URL.
	 * @return string
	 */
	public function get_plugin_url( $path = '' ) {
		return DEPOSITS_ENABLE_PLANS_PLUGIN_URL . $path;
	}

	/**
	 * Get plugin path
	 *
	 * @param string $path Optional path to append to the plugin path.
	 * @return string
	 */
	public function get_plugin_path( $path = '' ) {
		return DEPOSITS_ENABLE_PLANS_PLUGIN_DIR . $path;
	}
}

// Initialize the plugin
Deposits_Enable_Plans_And_Deposits::get_instance();
