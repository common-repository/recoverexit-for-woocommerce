<?php

if (!defined('ABSPATH'))exit;
    /*
    Plugin Name: Recover Exit For WooCommerce
    Plugin URI:  https://www.recoverexit.com/
    Description: Recover Exit For WooCommerce - Offer exiting users an instant discount on WooCommerce cart and checkout.
    Version:     1.0.3
    Author:      Plasmatize Media LTD
    Author URI:  https://www.recoverexit.com/about
    License:     GPL2

    RecoverExit For WooCommerce: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    any later version.

    RecoverExit For WooCommerce Plugin is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with RecoverExit For WooCommerce WordPress Plugin. If not, see https://www.gnu.org/licenses/gpl.txt.
    */
   
   if ( !defined('ABSPATH') ) {
        die("-1");   
    }
    
//admin area
require_once('admin_area.php');

	
// Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
require_once('recover_exit_main.php');
$OptionsArray = get_option( 'RecoverExitSettings' );

// if checkout option set
if (isset($OptionsArray["selected_show"])){
if (in_array("Checkout", $OptionsArray["selected_show"])){
$function_after_checkout = 'recover_exit';
add_action( 'woocommerce_after_checkout_form',  $function_after_checkout ); 
}
}

// if cart option set
if (isset($OptionsArray["selected_show"])){
if (in_array("Cart", $OptionsArray["selected_show"])){
$function_after_cart = 'recover_exit';
add_action( 'woocommerce_after_cart',  $function_after_cart ); 
}
}
}


	//STORE DEFAULT PLUGIN OPTIONS [ ON PLUGIN ACTIVATION ]
	register_activation_hook( __FILE__, 'add_default_option_data_exitrecover' );
	function add_default_option_data_exitrecover(){
	
	if (get_option( 'RecoverExitSettings' ) == false){
	$DefaultSettingsArray = array(
		//'selected_template' => array("SkyBlue [Free]"),//default template
		'time_length' => '15000',// 15 seconds
		'scroll_speed' => '130', // 130 scroll speed for mobile
		//'selected_show' => array("Cart","Checkout"),
		'feedback_log' => rand(99999,999999999),
		'feedback_setting' => 'No',
		'background_setting' => 'Yes',
		'first_timer' => 'yes',
		'storesettings' => 'yes',
		);	
	
	add_option( 'RecoverExitSettings', $DefaultSettingsArray );//store new settings 
	add_option( 'RecoverExitFirstTimer', 'true' );//store first timer value
	}
	
	// Plugin Update Fix, Stop existing, edited user templates, logs and stats being overwritten
	$UploadsDir = wp_upload_dir();
	$MasterDirectory = $UploadsDir["basedir"] . '/RecoverExit';//master folder
	$TemplateLogsDir = $MasterDirectory . '/logs/';//for template stats
	$UserEditedTemplatesDir = $MasterDirectory . '/templates/';//for user edited templates
	$masternfeedbacklogs = $MasterDirectory . '/masterfeedback/';//user feedback & master logs
	
	//check recoverexit folder exists, if not create it
	if (!file_exists($MasterDirectory)) {
    wp_mkdir_p($MasterDirectory, 0777, true);
	}	
	//check if logs folder exists, if not create it
	$LogsFolder = plugin_dir_path(__FILE__).'logs';
	if (!file_exists($TemplateLogsDir)) {
    wp_mkdir_p($TemplateLogsDir, 0777, true);
	}	
	//check if user edited templated directory exists, if not create it
	if (!file_exists($UserEditedTemplatesDir)) {
    wp_mkdir_p($UserEditedTemplatesDir, 0777, true);
	}	
	//check if user feedback and master log directory exists, if not create it
	if (!file_exists($masternfeedbacklogs)) {
    wp_mkdir_p($masternfeedbacklogs, 0777, true);
	}		
	
	//copy over templates [ stop edited templates being overwritten on plugin update]
	
	$RecoverExitTemplatesFolder = plugin_dir_path(__FILE__).'assets/orig_templates';
	$RecExitOrigTemps = array_diff(scandir($RecoverExitTemplatesFolder), array('.', '..'));
	
	$OrigTemplateDir = $RecoverExitTemplatesFolder . '/';
	
	foreach($RecExitOrigTemps as $origtempfile) {
		
		//reset values
		unset($CurrentOrig);
		unset($CurrentEdited);
		
		$CurrentOrig = $OrigTemplateDir.$origtempfile;
		$CurrentEdited = $UserEditedTemplatesDir . $origtempfile;
		
		//check if edited template file exists
		if (file_exists($CurrentEdited)){
		// edited tempalte exists, do nothing	
		}else{
		// edited template doesn't exist, copy orig over	
		copy($CurrentOrig, $CurrentEdited);
		}
	}
	
	}	
		
//function for recording how many times exit popup shown
function recexit_total_counter_funct() {
$thecount = intval( $_POST['thecount'] );
update_option("RE_Total_Counter", $thecount);//update counter
if (isset($_POST['uid'])){
$PostData = sanitize_text_field( $_POST['uid'] );
$LocalLog = date("d M Y") . ' @ ' . date("H:i:s") . ',EXIT-WINDOW-SHOWN,'.$PostData;
}else{
$LocalLog = date("d M Y") . ' @ ' . date("H:i:s") . ',EXIT-WINDOW-SHOWN,NA';	
}

$UploadsDir = wp_upload_dir();
$MasterDirectory = $UploadsDir["basedir"] . '/RecoverExit';//master folder
$masternfeedbacklogs = $MasterDirectory . '/masterfeedback/';//user feedback & master logs
$TemplateLogsDir = $MasterDirectory . '/logs/';//for template stats

//raw log;
$LogFile = $masternfeedbacklogs . 'log.txt';
file_put_contents($LogFile, $LocalLog.PHP_EOL , FILE_APPEND);

//total template log - >
//check folder exists, if not create it:
if (!file_exists($TemplateLogsDir.$_POST['uid'])) {
wp_mkdir_p( $TemplateLogsDir.sanitize_text_field( $_POST['uid']), 0777, true );
}
$totallogdata = date("d M Y") . ' @ ' . date("H:i:s");
$PostData = sanitize_text_field( $_POST['uid'] );
$totallogfile = $TemplateLogsDir.$PostData.'/total.txt';
file_put_contents($totallogfile, $totallogdata.PHP_EOL , FILE_APPEND);
die();
}	
add_action( 'wp_ajax_nopriv_recexit_total_counter_funct', 'recexit_total_counter_funct' );
add_action( 'wp_ajax_recexit_total_counter_funct', 'recexit_total_counter_funct' );

		
?>