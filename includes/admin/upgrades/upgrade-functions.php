<?php
/**
 * Plugin_Name Upgrade Functions
 *
 * {Description of the type of functions within this file. i.e. 'Upgrade Functions'}
 *
 * @package     KBS_PLUGIN_NAME
 * @subpackage  Functions
 * @copyright   Copyright (c) 2016, {Author Name}
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Perform automatic database upgrades when necessary
 *
 * @since	1.0
 * @return	void
*/
function kbs_Plugin_Name_do_automatic_upgrades() {

	$did_upgrade     = false;
	$kbs_Plugin_Name_version = preg_replace( '/[^0-9.].*/', '', get_option( 'kbs_Plugin_Name_version' ) );

	// Example
	/*if ( version_compare( $kbs_Plugin_Name_version, '1.1', '<' ) ) {
		kbs_Plugin_Name_v11_upgrades();
	}*/

	if ( version_compare( $kbs_ems_version, KBS_PLUGIN_NAME_VERSION, '<' ) )	{
		// Let us know that an upgrade has happened
		$did_upgrade = true;
	}

	if ( $did_upgrade )	{
		update_option( 'kbs_Plugin_Name_version_upgraded_from', get_option( 'kbs_Plugin_Name_version' ) );
		update_option( 'kbs_Plugin_Name_version', preg_replace( '/[^0-9.].*/', '', KBS_PLUGIN_NAME_VERSION ) );
	}

} // kbs_Plugin_Name_do_automatic_upgrades
add_action( 'admin_init', 'kbs_Plugin_Name_do_automatic_upgrades' );
