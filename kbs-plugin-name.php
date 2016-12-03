<?php
/**
 * Use this extension boiler plate to follow best practices and standards
 * when developing extensions for the KB Support plugin.
 *
 * @Author	Mike Howard
 * @Updated	2nd December 2016
 *
 * Replace all instances of 'Plugin_Name' with your plugin name
 * Replace all instances of 'PLUGIN_NAME' with your plugin name in uppercase
 * Replace all instances of 'plugin-name' with your plugin slug
 * Replace all text wrapped in '{}' with your own text
 */

/**
 * Plugin Name:	KB Support - Plugin_Name
 * Plugin URI:	{Plugin website address}
 * Description:	{A short description of your extension}
 * Version:		{Current plugin version number}
 * Date:		{Date}
 * Author:		{Author Name} <{author email address}>
 * Author URI:	{Author web address}
 * Text Domain:	plugin-name
 * Domain Path:	/languages
 *
 * @package		KBS\{Plugin_Name}
 * @author		{Author Name}
 * @copyright	Copyright (c) 2016, {Plugin Name}
 */
if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists( 'KBS_Plugin_Name' ) )	{

	class KBS_Plugin_Name	{
		/**
         * @var		KBS_PLUGIN_NAME	$instance	The one true KBS_PLUGIN_NAME
         * @since	1.0
         */
		private static $instance;

		/**
         * @var		int		$required_kbs	The minimum required KB Support version
         * @since	1.0
         */
		private static $required_kbs = '0.9'; // Enter the minimum required KBS version

		/**
         * Get active instance
         *
         * @access	public
         * @since	1.0
         * @return	object	self::$instance		The one true KBS_PLUGIN_NAME
         */
		public static function instance()	{
			// Do nothing if KBS is not activated or at required version
			if ( ! class_exists( 'KB_Support', false ) || version_compare( self::$required_kbs, KBS_VERSION, '>' ) ) {
				add_action( 'admin_notices', array( __CLASS__, 'notices' ) );
				return;
			}

			if ( ! self::$instance )	{
				self::$instance = new KBS_Plugin_Name();
				self::$instance->define_constants();
                self::$instance->includes();
                self::$instance->load_textdomain();
                self::$instance->hooks();
			}

			return self::$instance;
		} // __construct

		/**
		 * Define our constants
		 * @since	1.0
		 */
		public static function define_constants()	{
			define( 'KBS_PLUGIN_NAME_DIR', untrailingslashit( dirname( __FILE__ ) ) );
			define( 'KBS_PLUGIN_NAME_BASENAME', plugin_basename( __FILE__ ) );
			define( 'KBS_PLUGIN_NAME_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );
			define( 'KBS_PLUGIN_NAME_NAME', 'Plugin_Name' );
		} // define_constants

		/**
		 * Calls the files that are required
		 * @since	1.0
		 */
		public static function includes()	{	
			require_once KBS_PLUGIN_NAME_DIR . '/includes/plugin-name-functions.php';
		} // includes

		/**
		 * Hooks
		 * @since	1.0
		 */
		public static function hooks()	{

			add_filter( 'kbs_settings_sections_extensions',        array( self::$instance, 'settings_section' ) );
			add_filter( 'kbs_settings_extensions',                 array( self::$instance, 'settings' ) );
			add_filter( 'kbs_settings_extensions_contextual_help', array( self::$instance, 'contextual_help' ) );

			// If your plugin requires a license, don't forget this!
			// If no license is required, you can remove
			if ( class_exists( 'KBS_License' ) ) {
                $license = new KBS_License( __FILE__, KBS_PLUGIN_NAME_NAME, KBS_PLUGIN_NAME_VERSION, '{Author Name}' );
            }

		} // hooks

		/**
         * Internationalization
         *
         * @access	public
         * @since	1.0
         * @return	void
         */
        public function load_textdomain()	{
            $lang_dir = KBS_PLUGIN_NAME_DIR . '/languages/';

            $locale = 'kbs-plugin-name';
            $mofile = sprintf( '%1$s-%2$s.mo', 'kbs-plugin-name', $locale );

            $mofile_local   = $lang_dir . $mofile;
            $mofile_global  = WP_LANG_DIR . '/kbs-plugin-name/' . $mofile;

            if ( file_exists( $mofile_global ) )	{
                load_textdomain( 'kbs-plugin-name', $mofile_global );
            } elseif ( file_exists( $mofile_local ) ) {
                load_textdomain( 'kbs-plugin-name', $mofile_local );
            } else {
                load_plugin_textdomain( 'kbs-plugin-name', false, $lang_dir );
            }
        } // load_textdomain

		/**
		 * Display a notice if KBS not active or at required version.
		 *
		 * @since	1.0
		 */
		public static function notices()	{

			if ( ! defined( 'KBS_VERSION' ) )	{
				$message = sprintf(
					__( '%s requires that KB Support must be installed and activated.', 'kbs-plugin-name' ),
					KBS_PLUGIN_NAME_NAME
				);
			} else	{
				$message = sprintf(
					__( '%s requires KB Support version %s and higher.', 'kbs-plugin-name' ),
					KBS_PLUGIN_NAME_NAME,
					self::$required_kbs
				);
			}

			echo '<div class="notice notice-error is-dismissible">';
			echo '<p>' . $message . '</p>';
			echo '</div>';

		} // notices

		/**
		 *
		 * Add settings section.
		 *
		 * @access	public
		 * @since	1.0
		 * @param	arr		$sections	Registered sections array
		 * @return	arr		Updated registered sections array
		 */
		function settings_section( $sections ) {
			$sections['kbs_plugin_name'] = __( '{Plugin Name}', 'kbs-plugin-name' );
		
			return $sections;
		} // settings_section

		/**
         * Add settings
         *
         * @access		public
         * @since		1.0
         * @param		arr		$settings The existing KBS settings array
         * @return		arr		The modified KBS settings array
         */
        public function settings( $settings ) {
            $kbs_Plugin_Name_settings = array(
				'kbs_plugin_name' => array(
					array(
						'id'    => 'kbs_plugin_name_settings',
						'name'  => '<strong>' . __( '{Plugin Name} Settings', 'kbs-plugin-name' ) . '</strong>',
						'desc'  => __( 'Configure MailChimp Settings', 'kbs-plugin-name' ),
						'type'  => 'header',
					),
					array(
						'id'      => 'kbs_{test_option}',
						'name'    => __( '{Setting Name}', 'kbs-plugin-name' ),
						'desc'    => __( '{Description of setting}', 'kbs-plugin-name' ),
						'type'    => 'text'
					)
				)
            );

            return array_merge( $settings, $kbs_Plugin_Name_settings );
        } // settings

		/**
		 *
		 * Add contextual help.
		 *
		 * @access	public
		 * @since	1.0
		 * @param	str		$conextual_help		Original help text
		 * @return	str
		 */
		function contextual_help( $contextual_help ) {
			$contextual_help .=
				'<p>' . __( '<strong>{Plugin Name} Settings</strong>', 'kbs-plugin-name' ) . '</p>' .
				'<ul>' .
					'<li>' . __( '<strong>{Setting Name}</strong> - {Setting Description}', 'kb-support' ) .
				'</ul>';

			return $contextual_help;
		} // contextual_help

	} // KBS_Plugin_Name

} // if ( ! class_exists( 'KBS_Plugin_Name' ) )

// Instantiate the plugin class from the plugins_loaded hook
function KBS_Plugin_Name_Load()	{
	return KBS_Plugin_Name::instance();
} // KBS_Plugin_Name_Load
add_action( 'plugins_loaded', 'KBS_Plugin_Name_Load' );
