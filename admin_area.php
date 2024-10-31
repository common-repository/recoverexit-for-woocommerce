<?php
defined( 'ABSPATH' ) OR exit;

//include additional functions
include plugin_dir_path(__FILE__).'/includes/functions.php';

//admin page style
function reocverexit_woo_admin_styles() {
wp_enqueue_style( 'recoverexit_woo_admin', plugins_url( '/assets/css/admin-styles.css', __FILE__ ) );
wp_enqueue_style( 'recoverexit_woo_admin_frontpreview', plugins_url( '/assets/css/previewadminstyle.css', __FILE__ ) );
wp_enqueue_script('recoverexit_woo_admin_js', plugins_url( '/assets/js/admin-features.js', __FILE__ ) );
}

function recoverexit_woo_admin_menu(){
add_menu_page( 'RecoverExit', 'RecoverExit', 'manage_options', 'recoverexit-for-woocommerce', 'recoverexit_woo_admin_menu_admin', 'dashicons-products');
add_submenu_page( 'recoverexit-for-woocommerce', 'Settings - RecoverExit', 'Settings', 'manage_options', 'recover-exit-settings', 'recover_exit_settings' ); 
	add_submenu_page( 'recoverexit-for-woocommerce', 'Statistics - RecoverExit', 'Statistics', 'manage_options', 'recover-exit-stats', 'recover_exit_stats' ); 
	add_submenu_page( 'recoverexit-for-woocommerce', 'Template Editor - RecoverExit', 'Template Editor', 'manage_options', 'recover-exit-template-editor', 'recover_exit_template_editor' ); 
	add_submenu_page( 'recoverexit-for-woocommerce', 'Feedback - RecoverExit', 'Feedback', 'manage_options', 'recover-exit-feedback', 'recover_exit_feedback' ); 
	add_submenu_page( 'recoverexit-for-woocommerce', 'Bulk Add Coupons - RecoverExit', 'Bulk Add Coupons', 'manage_options', 'recover-exit-gen-coupons', 'recover_exit_gen_coupons' ); 
	add_submenu_page( 'recoverexit-for-woocommerce', 'Help & License - RecoverExit', 'Help & License', 'manage_options', 'recover-exit-help-license', 'recover_exit_help_license' ); 
}
 

function recoverexit_woo_admin_menu_admin(){
recexit_check_status_recoverexit();
random_recoverexit_check();	
recexit_check_re_exp_date();

if (get_option( 'recexitexpmsg' ) == true){	

if (isset($_GET["dmsgr"])){
update_option("disrecexitexpmsg", 'yes');	
}else{
	
$DismissLinkXY = get_admin_url( null, null, null ) . 'admin.php?page=recoverexit-for-woocommerce&dmsgr=true';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	

echo "<div class='notice notice-warning is-dismissible'>
<h3>Your License Will Expire Soon! <p class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong>You can <a style='font-weight:700;' href='https://www.recoverexit.com/your-license/?lic=".get_option('re_lic_setting')."' target='_blank'>renew your license for 50% less</a> than the price of a new license! <a style='font-size:14px; font-weight:700;' href='".$DismissLinkXY."'>[no thanks]</a></strong></p></h3>
	</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	
	

}
}

global $rekx;

echo '<h1 class="recexit-title">RecoverExit</h1>';
echo '<div style="height:30px" aria-hidden="true" class="admin-spacer"></div>';

if (isset($_GET["dm"])){
delete_option( 'RecoverExitFirstTimer' );	
}

$FirstTimer = get_option( 'RecoverExitFirstTimer' );

if (isset($FirstTimer)){
if ($FirstTimer == true){

//wizard
$TemplateQsPage = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor';
$DismissCurPage = get_admin_url( null, null, null ) . 'admin.php?page=recoverexit-for-woocommerce&dm=true';

echo "<div class='notice notice-success is-dismissible'>
       <h3>Quick Start Wizard<p class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong><mark>STEP1:</mark> Edit your first exit popup <a style='font-weight:700;' href='".$TemplateQsPage."'>with template editor!</a></strong> or <strong>[<a style='font-size:14px; font-weight:700;' href='".esc_url($DismissCurPage)."'>End quick start wizard</a>]</strong></p></h3>
	</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';
	

}		
}

// main screen menu
$recovexitadminp = get_admin_url( null, null, null );
$settingspage = $recovexitadminp.'admin.php?page=recover-exit-settings';
$statspage = $recovexitadminp.'admin.php?page=recover-exit-stats';
$templatepage = $recovexitadminp.'admin.php?page=recover-exit-template-editor';
$feedbackpage = $recovexitadminp.'admin.php?page=recover-exit-feedback';
$couponaddpage = $recovexitadminp.'admin.php?page=recover-exit-gen-coupons';
$helppage = $recovexitadminp.'admin.php?page=recover-exit-help-license';

echo '<div class="main-menu-container">';

echo '<div class="menu-item-container" style=" background: repeating-linear-gradient( 45deg, #FBFBFB, #FBFBFB 10px, #fff 20px, #fff 40px)!important; border-style: dashed!important; border-color: #000!important; border-radius: 15px!important;"><a href="'.esc_url($settingspage).'" rel="noopener noreferrer"> <img src="'.plugin_dir_url(__FILE__) . '/assets/images/settings.png" alt="Settings" width="204" height="204" ></a><h1 class="menu_item_text">Settings<p></p> </h1></div>';

echo '<div class="menu-item-container" style=" background: repeating-linear-gradient( 45deg, #FBFBFB, #FBFBFB 10px, #fff 20px, #fff 40px)!important; border-style: dashed!important; border-color: #000!important; border-radius: 15px!important;"><a href="'.esc_url($statspage).'" rel="noopener noreferrer"> <img src="'.plugin_dir_url(__FILE__) . '/assets/images/stats.png" alt="Statistics" width="204" height="204" ></a><h1 class="menu_item_text">Statistics<p></p> </h1></div>';

echo '<div class="menu-item-container" style=" background: repeating-linear-gradient( 45deg, #FBFBFB, #FBFBFB 10px, #fff 20px, #fff 40px)!important; border-style: dashed!important; border-color: #000!important; border-radius: 15px!important;"><a href="'.esc_url($templatepage).'" rel="noopener noreferrer"> <img src="'.plugin_dir_url(__FILE__) . '/assets/images/template-editor.png" alt="Tempalte Editor" width="204" height="204" ></a><h1 class="menu_item_text">Template Editor<p></p> </h1></div>';

echo '<div class="menu-item-container" style=" background: repeating-linear-gradient( 45deg, #FBFBFB, #FBFBFB 10px, #fff 20px, #fff 40px)!important; border-style: dashed!important; border-color: #000!important; border-radius: 15px!important;"><a href="'.esc_url($feedbackpage).'" rel="noopener noreferrer"> <img src="'.plugin_dir_url(__FILE__) . '/assets/images/feedback.png" alt="Feedback" width="204" height="204" ></a><h1 class="menu_item_text">Feedback<p></p> </h1></div>';

echo '<div class="menu-item-container" style=" background: repeating-linear-gradient( 45deg, #FBFBFB, #FBFBFB 10px, #fff 20px, #fff 40px)!important; border-style: dashed!important; border-color: #000!important; border-radius: 15px!important;"><a href="'.esc_url($couponaddpage).'" rel="noopener noreferrer"> <img src="'.plugin_dir_url(__FILE__) . '/assets/images/coupon.png" alt="Bulk Add Coupons" width="204" height="204" ></a><h1 class="menu_item_text">Bulk Add Coupons<p></p> </h1></div>';

echo '<div class="menu-item-container" style=" background: repeating-linear-gradient( 45deg, #FBFBFB, #FBFBFB 10px, #fff 20px, #fff 40px)!important; border-style: dashed!important; border-color: #000!important; border-radius: 15px!important;"><a href="'.esc_url($helppage).'" rel="noopener noreferrer"> <img src="'.plugin_dir_url(__FILE__) . '/assets/images/help.png" alt="Help" width="204" height="204" ></a><h1 class="menu_item_text">Help<p></p> </h1></div>';

if (isset($rekx)){
echo '<div class="menu-item-container" style=" background: repeating-linear-gradient( 45deg, #FBFBFB, #FBFBFB 10px, #fff 20px, #fff 40px)!important; border-style: dashed!important; border-color: #000!important; border-radius: 15px!important;"><a href="'.esc_url($helppage).'" rel="noopener noreferrer"> <img src="'.plugin_dir_url(__FILE__) . '/assets/images/gold.png" alt="Help" width="204" height="204" ></a><h1 class="menu_item_text">Premium Member<p></p> </h1></div>';
	
}else{
echo '<div class="menu-item-container" style=" background: repeating-linear-gradient( 45deg, #FBFBFB, #FBFBFB 10px, #fff 20px, #fff 40px)!important; border-style: dashed!important; border-color: #000!important; border-radius: 15px!important;"><a href="'.esc_url($helppage).'" rel="noopener noreferrer"> <img src="'.plugin_dir_url(__FILE__) . '/assets/images/bronze.png" alt="Help" width="204" height="204" ></a><h1 class="menu_item_text">Free Member <a href="'.$helppage.'" rel="noopener noreferrer">(Upgrade)</a><p></p> </h1></div>';
	
}


echo '</div>';


}
 

function recover_exit_stats(){
recexit_check_status_recoverexit();
random_recoverexit_check();	
recexit_check_re_exp_date();

if (get_option( 'recexitexpmsg' ) == true){	

if (isset($_GET["dmsgr"])){
update_option("disrecexitexpmsg", 'yes');	
}else{
	
$DismissLinkXY = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-stats&dmsgr=true';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	

echo "<div class='notice notice-warning is-dismissible'>
<h3>Your License Will Expire Soon! <p class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong>You can <a style='font-weight:700;' href='https://www.recoverexit.com/your-license/?lic=".get_option('re_lic_setting')."' target='_blank'>renew your license for 50% less</a> than the price of a new license! <a style='font-size:14px; font-weight:700;' href='".esc_url($DismissLinkXY)."'>[no thanks]</a></strong></p></h3>
	</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	
	

}
}
	
	$UploadsDir = wp_upload_dir();
	$MasterDirectory = $UploadsDir["basedir"] . '/RecoverExit';//master folder
	
	$TemplateLogsDir = $MasterDirectory . '/logs/';//for template stats
	$UserEditedTemplatesDir = $MasterDirectory . '/templates/';//for user edited templates
	$masternfeedbacklogs = $MasterDirectory . '/masterfeedback/';//user feedback & master logs	
	
global $rekx;	

// clear raw logs;
if (isset($_POST["clearrawlogs"])){
$RawLogFile = $masternfeedbacklogs.'log.txt';
if (file_exists($RawLogFile)){
unlink($RawLogFile);		
echo '<div class="notice notice-success is-dismissible">
       <h3>Recover Exit: Raw Log File Deleted!</h3>
    </div>';
}else{
echo '<div class="notice notice-error is-dismissible">
       <h3>Recover Exit: Raw Log File Does Not Exist!</h3>
    </div>';	
}
}

// clear individual template stats:
if (isset($_GET["resetstats"])){

if (isset($_GET["template"])){
	
$TemplateFile = sanitize_text_field( $_GET["template"] );

$TotalFile = $TemplateLogsDir.$TemplateFile.'/total.txt';

$ConvertFile = $TemplateLogsDir.$TemplateFile.'/convert.txt';

if (file_exists($TotalFile)){
unlink($TotalFile);	
}	
if (file_exists($ConvertFile)){
unlink($ConvertFile);	
}
	
}


$StatsPage = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-stats';
wp_redirect( $StatsPage );
exit;

}

//clear template logs:
if (isset($_POST["cleartemplatelogs"])){
	
$templatelogfolder = $TemplateLogsDir;
$templatelogfiles = scandir($templatelogfolder);
$templatelogfiles = array_diff(scandir($templatelogfolder), array('.', '..'));

foreach($templatelogfiles as $currenttemplog) {	
	
$TotalFile = $TemplateLogsDir.$currenttemplog.'/total.txt';
$ConvertFile = $TemplateLogsDir.$currenttemplog.'/convert.txt';

if (file_exists($TotalFile)){
unlink($TotalFile);		
}
if (file_exists($ConvertFile)){
unlink($ConvertFile);	
}

}	

echo '<div class="notice notice-success is-dismissible">
       <h3>Recover Exit: All Template Logs Deleted!</h3>
    </div>';	

}
	
//clear stat counter:
if (isset($_POST["resetoverall"])){
update_option("RE_Total_Counter", 0);
update_option("RE_conversion_Counter", 0);
echo '<div class="notice notice-success is-dismissible">
       <h3>Recover Exit: Settings were updated!</h3>
    </div>';	
}
	
echo '<h1 class="recexit-title">RecoverExit Statistics</h1>';
echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';
echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png"> Overall ExitRecover Stats</p>';	

$TotalSkipCounter = get_option('RE_Total_Counter') - get_option('RE_conversion_Counter');

//work out conversion rate:
if (get_option('RE_conversion_Counter') == 0){
$WoConvRate = 'NA';
}else{
$WoConvRate = get_option('RE_conversion_Counter') /  get_option('RE_Total_Counter') * 100;
$WoConvRate = round($WoConvRate, 2) . '%';
}



echo '<table id="tablestats-25" class="tablestats tablestats-id-25">
<thead style="background-color:#fff; text-align:left; width:700px!important;">
<tr class="row-1 odd">
<th class="column-1">TOTAL SHOWN</th><th class="column-2"><span style="color: #222222;"><span style="color: #222222;">BUTTON CLICKS</span></span></th><th class="column-3"><span style="color: #222222;"><span style="color: #222222;">SKIPPED</span></span></th><th class="column-4"><span style="color: #222222;"><span style="color: #222222;">CTR (%)</span></span></th>
</tr>
</thead>
<tbody class="row-hover">';


echo wp_kses_post('<tr class="row-2 odd">
<td class="column-1">'.get_option('RE_Total_Counter').'</td><td class="column-2">'.get_option('RE_conversion_Counter').'</td><td class="column-3">'.$TotalSkipCounter.'</td><td class="column-4">'.$WoConvRate.'
</tr>');

echo '</tbody></table>';

echo '<form id="resetoverall" method="POST" action="">';
echo '<input type="hidden" id="resetoverall" name="resetoverall" value="yes">';
echo '<div style="margin-bottom: 12px!important;" class="gen_button_sign"><button type="submit" class="clear-logs-btn" id="AddList">Reset Overall Stat Counters</button></div>';
echo '</form>';


echo '<div id="close" style="color: #00548A!important; font-size: 16px!important; font-weight: 600!important; text-decoration: underline!important;" onclick="HelpSectionToggle1()"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> Need Help?</div>';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';

echo '<div id="HelpSection1" style="display:none;">';
echo '<p class="backend-font-heavy-big">Overall Stats Explained..</p>';
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>TOTAL SHOWN</strong> - The total number of ExitRecover templates that have been shown to users.</p>';
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>BUTTON CLICKS</strong> - The total number of "APPLY DISCOUNT" button(s) that have been clicked.</p>';
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>TOTAL SKIPPED</strong> - The total number skips or no action taken by users.</p>';
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>TOTAL CTR</strong> - The total click through rate of "APPLY DISCOUNT" buttons.</p>';
echo '</div>';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';

echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png"> Advanced Template Stats (sortable)</p>';

$partpr01 = '<table id="tablestats-25" class="tablestats tablestats-id-25">

<tr style="background-color:#fff!important" class="row-1 odd">
<th class="column-1">ENABLED</th><th class="column-2">TEMPLATE</th><th class="column-3"><span style="color: #222222;"><span style="color: #222222;">TOTAL</span></span></th><th class="column-4"><span style="color: #222222;"><span style="color: #222222;">BUTTON CLICKS</span></span></th><th class="column-5"><span style="color: #222222;"><span style="color: #222222;">SKIPPED</span></span></th><th class="column-6"><span style="color: #222222;"><span style="color: #222222;">CTR</span></span></th><th class="column-7"><span style="color: #222222;"><span style="color: #222222;">COUPON USES</span></span></th><th class="column-8"><span style="color: #222222;"><span style="color: #222222;">CONV RATE</span></span></th><th class="column-9"><span style="color: #222222;"><span style="color: #222222;">COUPON STATUS</span></span></th><th class="column-10"><span style="color: #222222;">RESET STATS<span style="color: #222222;"></span></span></th>
</tr>';



echo wp_kses_post($partpr01);

$oddeven = 'even';
$rowcounter = '2';

$templatefolder = $UserEditedTemplatesDir;
$templatefiles = scandir($templatefolder);
$templatefiles = array_diff(scandir($templatefolder), array('.', '..'));

foreach($templatefiles as $templateitem) {

unset($TempisPrem);	
unset($CheckOutCode);
$currenttemplatefile = $UserEditedTemplatesDir.$templateitem;
include $currenttemplatefile; //to get checkout code for template stats

unset($Enabled);
unset($EnabledCheck);
unset($ColCol);
// check if current template activate:
$OptionsArray = get_option( 'RecoverExitSettings' );
if (isset($OptionsArray["selected_template"])){
$SelectedTemplateOpts = $OptionsArray["selected_template"];

$EnabledCheck = str_replace(".php","",$templateitem);


if (in_array($EnabledCheck, $SelectedTemplateOpts)){

$Enabled = 'YES';
$ColCol = 'green';
	
}else{
	
$Enabled = 'NO';	
$ColCol = 'red';

}
}

$templateitem = str_replace(".php","",$templateitem);
$logfilelocno = str_replace("template","",$templateitem);

$TotalLogFile = $TemplateLogsDir.$logfilelocno.'/total.txt';
$SkippedLogFile = $TemplateLogsDir.$logfilelocno.'/skipped.txt';
$ConvertedLogFile = $TemplateLogsDir.$logfilelocno.'/convert.txt';



//reset values, in-case nothing is found
$TotalTimesShown = '0';
$TotalTimesSkipped = '0';
$TotalTimesConverted = '0';
$TotalConvRate = '0';
$CoupConvRate = '0';
unset($skipconvr);
unset($coupon_code);
unset($coupon);
unset($count);


$Disabled = 'No';
if (isset($TempisPrem)){	
if (empty($rekx)){
unset($Disabled);
}
}


//check coupon usage for further tracking
if (isset($CheckOutCode)){
$coupon_code = $CheckOutCode;
$coupon = new WC_Coupon( $coupon_code );
$count = $coupon->get_usage_count();
}



if (file_exists($TotalLogFile)){
//count logfile contents
$TotalTimesShown = count(file($TotalLogFile));	

if (isset($count)){
$CoupConvRate = $count / $TotalTimesShown * 100;
$CoupConvRate = round($CoupConvRate, 2) . '%';	
}

}
if (file_exists($ConvertedLogFile)){
//count logfile contents
$TotalTimesConverted = count(file($ConvertedLogFile));		
}
if ($TotalTimesShown == 0){
$skipconvr = true;	
}else{
$TotalTimesSkipped = $TotalTimesShown;//will change if click occured.
}
if ($TotalTimesConverted == 0){
$skipconvr = true;	
}

if (!isset($skipconvr)){

$TotalTimesSkipped = $TotalTimesShown - $TotalTimesConverted;
$TotalConvRate = $TotalTimesConverted / $TotalTimesShown * 100;
$TotalConvRate = round($TotalConvRate, 2) . '%';
	
}

//set edit coupon code link
unset($EditCouponURL);

if (!isset($coupon)){
$coupon = 'error';	
}

if ($coupon->get_id() == 0){
$AdminURLForCoupon = get_admin_url( null, null, null ) . 'post-new.php?post_type=shop_coupon&post_title='.$coupon->get_code();	
$EditCouponURL = '"'.$coupon->get_code().'"'.'<a style="color: #C91A1E;" href="' . esc_url($AdminURLForCoupon) . '" target="_blank">[add now]</a>';

}else{
$AdminURLForCoupon = get_admin_url( null, null, null ) . 'post.php?post=' .$coupon->get_id().'&action=edit';	
$EditCouponURL = '"'.$coupon->get_code() . '" <a style="color: #1D751E;" href="' . esc_url($AdminURLForCoupon) . '" target="_blank">[edit coupon]</a>';

}

unset($EditTemplateURL);
$EditTemplateLinkURL = ' <a href="'. get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor&edittemp=true&template='.$templateitem. '" target="_blank">'.$templateitem.'</a>';	

//reset stats link
$ResetStatsLink = ' <a href="'. get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-stats&resetstats=true&template='.$templateitem. '">(reset stats)</a>';	

if (!isset($Enabled)){
$Enabled = 'NO';
$ColCol = 'red';
}

if (isset($rekx)){
	
echo wp_kses_post('<tr class="row-'.$rowcounter.' '.$oddeven.'">
<td class="column-'.$ColCol.'">'.$Enabled.'</td><td class="column-2">'.$EditTemplateLinkURL.'</td><td class="column-3">'.$TotalTimesShown.'</td><td class="column-4">'.$TotalTimesConverted.'</td><td class="column-5">'.$TotalTimesSkipped.'</td><td class="column-6">'.$TotalConvRate.'</td><td class="column-7">'.$count.'</td><td class="column-8">'.$CoupConvRate.'</td><td class="column-9">'.$EditCouponURL.'</td><td class="column-10">'.$ResetStatsLink.'</td>
</tr>');

}else{
	
$AdminURLForUpgrade = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-help-license&upgrade=true';	
$UpgradeLink = '<a href="'.esc_url($AdminURLForUpgrade).'">UPGRADE</a>';

if (isset($Disabled)){

	
echo wp_kses_post('<tr class="row-'.$rowcounter.' '.$oddeven.'">
<td class="column-'.$ColCol.'">'.$Enabled.'</td><td class="column-2">'.$EditTemplateLinkURL.'</td><td class="column-3">'.$TotalTimesShown.'</td><td class="column-4">'.$TotalTimesConverted.'</td><td class="column-5">'.$TotalTimesSkipped.'</td><td class="column-6">'.$TotalConvRate.'</td><td class="column-7">'.$UpgradeLink.'</td><td class="column-8">'.$UpgradeLink.'</td><td class="column-9">'.$EditCouponURL.'</td><td class="column-10">'.$ResetStatsLink.'</td>
</tr>');

}
	
}

$rowcounter++;

if ($oddeven == 'even'){
$oddeven = 'odd';
}else{
$oddeven = 'even';	
}


} 


echo '</table>';

echo '<form id="cleartemplatelogs" method="POST" action="">';
echo '<input type="hidden" id="cleartemplatelogs" name="cleartemplatelogs" value="yes">';
echo '<div style="margin-bottom: 12px!important;" class="gen_button_sign"><button type="submit" class="clear-logs-btn" id="AddList">Reset All Template Stats</button></div>';
echo '</form>';

echo '<div id="close" style="color: #00548A!important; font-size: 16px!important; font-weight: 600!important; text-decoration: underline!important;" onclick="HelpSectionToggle()"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> Need Help?</div>';



echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';



echo '<div id="HelpSection" style="display:none;">';

echo '<p class="backend-font-heavy-big">Template Stats Explained..</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Video Tutorial?</strong> - <a href="https://www.youtube.com/watch?v=YSbg28YFAfE" target="_blank"><strong>Watch statistics explained video tutorial on YouTube (0:57)</strong></a></p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>ENABLED</strong> - Whether or not this template is currently activate on checkout and/or cart.</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>TEMPLATE</strong> - The template ID.</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>TOTAL</strong> - The total times this template has been displayed to users.</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>BUTTON CLICKS</strong> - How many times the "APPLY discount" button has been clicked.</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>SKIPPED</strong> - The total amount of times skip text or no action was taken after exit window shown.</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>CTR</strong> - Percentage of times the "APPLY discount" button was clicked.</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>COUPON USES</strong> - How many times the templates coupon has been used, if the coupon is unique to this template you can track conversions.</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>CONV RATE</strong> - Conversion rate based off total views and coupon uses.</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>COUPON STATUS</strong> - Shows the discount coupon that is set for the template. [add now] is displayed if the coupon does not exist, if the coupon exists [edit coupon] is shown.</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>RESET STATS</strong> - Resets the stats counter to 0 for the specified template.</p>';

echo '</div>';

//loop through stat files.


	
echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';


	
	echo '<h2>Raw Activity Log (Last 100 Actions)</h2>';
	
	//LOG FILE OUTPUT:
	$LogFile = $masternfeedbacklogs.'log.txt';
	if (file_exists($LogFile)){
	$fileforlog = file($LogFile);
	$xlogcount = count($fileforlog);	
	$searchfilesize = file($LogFile, FILE_IGNORE_NEW_LINES);
	$limitsearch = 100;
	
	
	echo '<textarea id="searchlog" class="backendsearchrecexit" class="box" rows="10">';
	//return log file..
	foreach($searchfilesize as $searchfilesize){
	if ($limitsearch <=0){
	}else{
	--$limitsearch;	
	--$xlogcount;
	echo esc_textarea($fileforlog[$xlogcount]);	
	}
	}
	echo '</textarea>';	
	//echo '<br>To view all ' . count($fileforlog) . ' records, <a href="' . plugin_dir_url(__FILE__) . 'assets/log.txt" target="_blank">View the full log now</a>';
	echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';
	
echo '<form id="clearrawlogs" method="POST" action="">';
echo '<input type="hidden" id="clearrawlogs" name="clearrawlogs" value="yes">';
echo '<div class="gen_button_sign"><button type="submit" class="clear-logs-btn" id="AddList">Clear Raw Logs</button></div>';
echo '</form>';

}else{
//raw log does not yet exist
echo '<textarea id="searchlog" class="backendsearchrecexit" rows="10">Nothing to report, raw activity logs will appear once there is something to show..</textarea>';	
}

echo '<div style="height:32px" aria-hidden="true" class="admin-spacer"></div>';
	


}


function recover_exit_template_editor(){
recexit_check_status_recoverexit();
random_recoverexit_check();	
recexit_check_re_exp_date();

if (get_option( 'recexitexpmsg' ) == true){	

if (isset($_GET["dmsgr"])){
update_option("disrecexitexpmsg", 'yes');	
}else{
	
$DismissLinkXY = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor&dmsgr=true';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	

echo "<div class='notice notice-warning is-dismissible'>
<h3>Your License Will Expire Soon! <p class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong>You can <a style='font-weight:700;' href='https://www.recoverexit.com/your-license/?lic=".get_option('re_lic_setting')."' target='_blank'>renew your license for 50% less</a> than the price of a new license! <a style='font-size:14px; font-weight:700;' href='".esc_url($DismissLinkXY)."'>[no thanks]</a></strong></p></h3>
	</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	
	

}
}
	
	$UploadsDir = wp_upload_dir();
	$MasterDirectory = $UploadsDir["basedir"] . '/RecoverExit';//master folder
	
	$TemplateLogsDir = $MasterDirectory . '/logs/';//for template stats
	$UserEditedTemplatesDir = $MasterDirectory . '/templates/';//for user edited templates
	$masternfeedbacklogs = $MasterDirectory . '/masterfeedback/';//user feedback & master logs		
	
$SkipArea = 'no';

echo '<h1 class="recexit-title">RecoverExit Template Editor</h1>';
echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';



//Create duplicate of template.
if (isset($_POST["duplicatemplate"])){
	
//orig copy file-location
$TemplateFileOrig = $UserEditedTemplatesDir.sanitize_text_field( $_POST["template"]).'.php';

//new copy file-location	
$TemplateFileNew = $UserEditedTemplatesDir.sanitize_text_field( $_POST["dupetempname"]).'.php';


// create copy of template
if (file_exists($TemplateFileOrig)){
	
if (!copy($TemplateFileOrig, $TemplateFileNew)) {
    echo "FAILED TO COPY TEMPLATE";
	die();
}else{
//template copied alright.. edit template name in new file.
$TemplateIDLine = '$TemplateID = "'.sanitize_text_field($_POST["dupetempname"]).'";';
$filex = file($TemplateFileNew);
$output = $filex[0];
$filex[9] = $TemplateIDLine.PHP_EOL;	

$AdminURLForEditDupe = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor';
wp_redirect( $AdminURLForEditDupe );
exit;
	
}



	
	
}





}


//duplicate a template...
if (isset($_GET["dupetemp"])){
$AdminURLForEditDel = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor';

echo '<p class="backend-font-heavy-big"><strong>DUPLICATE TEMPLATE:</strong><br><br>You are about to create a duplicate copy of the '.sanitize_text_field($_GET["template"]).' template, please give this template a unique name.</p>';

echo '<div style="height:15px" aria-hidden="true" class="admin-spacer"></div>';

echo '<form id="duplicatemplate" method="POST" action="">';

echo '<label for="dupetempname">Duplicated Template Name:</label><br>';
echo '<input type="text" class="options-box-9" id="dupetempname" name="dupetempname" value="'.esc_attr($_GET["template"]).' '.rand(1000,99999).'">';

echo '<input type="hidden" id="duplicatemplate" name="duplicatemplate" value="yes">';
echo '<input type="hidden" id="template" name="template" value="'.esc_attr($_GET["template"]).'">';

echo '<div style="height:16px" aria-hidden="true" class="admin-spacer"></div>';

echo '<button type="submit" class="lookup-tool-search-recexit" id="perdel">Duplicate Template</button>';
echo '</form>';

echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';

$AdminURLForEditDel = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor';
echo '<a style="font-size:16px; font-weight:700;" href="'.esc_url($AdminURLForEditDel).'"><< Changed Your Mind? [Go Back]</a>';

unset($SkipArea);

}






//delete template... [confirmation]
if (isset($_GET["delete"])){
if ($_GET["template"] == 'SkyBlue'){
echo '<p class="backend-font-heavy-big"><mark><strong>Default template cannot be deleted.</strong></mark></p>';
unset($SkipArea);
}else{
$AdminURLForEditDel = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor';
echo '<p class="backend-font-heavy-big"><mark><strong>PLEASE CONFIRM</strong></mark> you want to delete the <strong>'.sanitize_text_field($_GET["template"]).'</strong> template?</p>';
echo '<p class="backend-font-heavy-big"><strong>PLEASE NOTE:</strong> doing this will permanently delete the template and stats.</p>';
//permanently delete
echo '<div style="height:15px" aria-hidden="true" class="admin-spacer"></div>';

echo '<form id="permdelete" method="POST" action="">';
echo '<input type="hidden" id="permdelete" name="permdelete" value="yes">';
echo '<input type="hidden" id="template" name="template" value="'.esc_attr($_GET["template"]).'">';
echo '<button type="submit" class="red_button_1" id="perdel">Yes, Permanently Delete</button>';
echo '</form>';

echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';


$AdminURLForEditDel = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor';
echo '<a style="font-size:16px; font-weight:700;" href="'.esc_url($AdminURLForEditDel).'"><< Changed Your Mind? [Go Back]</a>';




unset($SkipArea);

}
}

//PERM delete template...
if (isset($_POST["permdelete"])){

// delete template
$TemplateFileDel = $UserEditedTemplatesDir.sanitize_text_field( $_POST["template"]).'.php';
if (file_exists($TemplateFileDel)){
unlink($TemplateFileDel);	
}
// delete logs
$TemplateLogF1 = $TemplateLogsDir.sanitize_text_field( $_POST["template"]).'/total.txt';
if (file_exists($TemplateLogF1)){
unlink($TemplateLogF1);	
}

$TemplateLogF2 = $TemplateLogsDir.sanitize_text_field( $_POST["template"]).'/convert.txt';
if (file_exists($TemplateLogF2)){
unlink($TemplateLogF2);	
}

$AdminURLForEditDel = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor';
wp_redirect( $AdminURLForEditDel );
exit;
}

if (isset($_POST["savetemplate"])){
//perform checks and save new template data

//top header
$H1Text = sanitize_text_field( $_POST["headertext"]) ;
//sub header text
$SubHText = sanitize_text_field( $_POST["subheadertext"]);
//description text
$descriptiontext = sanitize_text_field( $_POST["descriptiontext"]);
//button text
$buttontext = sanitize_text_field( $_POST["buttontext"]);
//close text
$closetext = sanitize_text_field( $_POST["closetext"]);
//voucher code
$vouchercode = sanitize_text_field( $_POST["vouchercode"]);
//templatefileloc[ORIG]
$TemplateFileOrig = $UserEditedTemplatesDir.sanitize_text_field( $_POST["origtemplatename"]).'.php';
//templatefileloc[new]
$TemplateFileNew = $UserEditedTemplatesDir.sanitize_text_field( $_POST["newtemplatename"]).'.php';

//set lines to save
$H1Line = '$HeaderText = "'.$H1Text . '";';
$SubHLine = '$SubHeaderText = "'.$SubHText.'";';
$DescLine = '$DescriptionText = "'.$descriptiontext.'";';
$ButtonTextLine = '$ButtonText = "'.$buttontext . '";';
$CloseTLine = '$CloseText = "'.$closetext.'";';
$CheckoutCodeLine = '$CheckOutCode = "'.$vouchercode.'";';
$CheckOutURLLine = '$checkout_url = wc_get_page_permalink( "checkout" );';
$TemplateIDLine = '$TemplateID = "'.sanitize_text_field( $_POST["newtemplatename"]).'";';

  $filex = file($TemplateFileOrig);
  $output = $filex[0];
$filex[0] = "<?php
";
	$filex[1] = "//TEMPLATE TEXT & SETTINGS".PHP_EOL;
    $filex[2] = $H1Line.PHP_EOL;
	$filex[3] = $SubHLine.PHP_EOL;
	$filex[4] = $DescLine.PHP_EOL;
	$filex[5] = $ButtonTextLine.PHP_EOL;
	$filex[6] = $CloseTLine.PHP_EOL;
	$filex[7] = $CheckoutCodeLine.PHP_EOL;
	$filex[8] = $CheckOutURLLine.PHP_EOL;
	$filex[9] = $TemplateIDLine.PHP_EOL;


//check if template name has changed:
if ($_POST["newtemplatename"] == $_POST["origtemplatename"]){
// template name is the same.
file_put_contents($TemplateFileOrig, $filex);


}else{
// template name has changed, delete old template file after saving new
file_put_contents($TemplateFileNew, $filex);
unlink($TemplateFileOrig);

// if stats data exists, rename to match new template name

$TemplateFileOrig = $UserEditedTemplatesDir.sanitize_text_field( $_POST["origtemplatename"]).'.php';
//templatefileloc[new]
$TemplateFileNew = $UserEditedTemplatesDir.sanitize_text_field( $_POST["newtemplatename"]).'.php';

$origstatdir = $TemplateLogsDir.sanitize_text_field( $_POST["origtemplatename"]);
$newstatdir = $TemplateLogsDir.sanitize_text_field( $_POST["newtemplatename"]);
if ( is_dir( $origstatdir ) ) {
rename($origstatdir,$newstatdir);  
}	
}

// send user back to preview edited template
echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';

$SettingsPageCus = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-settings&qst='.sanitize_text_field( $_POST["newtemplatename"]);

echo "<div class='notice notice-success is-dismissible'>
       <h3><p style='font-weight:700;' class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong><mark>Congratulations!</mark> you just edited & saved your exit popup template! - head over to the <a style='font-weight:700;' href='".esc_url($SettingsPageCus)."'>settings page</a> to enable it on the checkout and/or cart now!</p></h3>
	</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';




//PREVIEW NEW TEMPLATE:
echo '<h3>'.esc_html( $_POST["newtemplatename"]).' Template Saved:</h3>';
include ($UserEditedTemplatesDir.sanitize_text_field( $_POST["newtemplatename"]).'.php');

//$Template = str_replace("visibility: hidden;","",$Template);//for preview
//echo $Template;


	if (isset($BackgroundType)){
		
	if ($BackgroundType == 1){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="background-color: <?php echo esc_html($BackgroundColor) ?>!important; border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">	
	<?php	
	}
	if ($BackgroundType == 2){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="background-color: <?php echo esc_html($BackgroundColor) ?>!important; background-image: linear-gradient(180deg, <?php echo esc_html($BackGroundGradCol1) ?> 0%, <?php echo esc_html($BackGroundGradCol2) ?> 100%); border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">
	<?php	
	}
	if ($BackgroundType == 3){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="background: repeating-linear-gradient( 45deg, <?php echo esc_html($BackGroundGradCol1) ?>, <?php echo esc_html($BackGroundGradCol1) ?> 10px, <?php echo esc_html($BackGroundGradCol2) ?> 20px, <?php echo esc_html($BackGroundGradCol2) ?> 40px)!important; border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">
	<?php
	}
	
	
	
	?>
	
		<div class="inner-window-checkout">
        <p style="font-size: <?php echo esc_html($TopHeadingFontSize) ?>; font-weight: <?php echo esc_html($Topfontweight) ?>; color: <?php echo esc_html($TopHeaderColour) ?>; text-align: center; margin-top: <?php echo esc_html($TopHeaderMaginTop) ?>; margin-bottom: <?php echo esc_html($TopHeaderMaginBottom) ?>!important;"><?php echo esc_html($HeaderText) ?></p>
		<p style="font-size: <?php echo esc_html($SubHeaderFontSize) ?>; font-weight: <?php echo esc_html($SubHeaderWeight) ?>; color: <?php echo esc_html($SubHeaderColour) ?>; text-align: center; margin-bottom: <?php echo esc_html($SubHeaderMarginBottom) ?>!important;"><?php echo esc_html($SubHeaderText) ?></p>
        <p style="font-size: <?php echo esc_html($DescriptionFontSize) ?>; font-weight: <?php echo esc_html($DescFontWeight) ?>; color: <?php echo esc_html($DescFontColour) ?>; margin-bottom: <?php echo esc_html($DescMarginBottom) ?>!important; margin-top: <?php echo esc_html($DescMarginTop) ?>!important; margin-left: 10px!important; margin-right: 10px!important;"><?php echo esc_html($DescriptionText) ?></p>
        <form action="<?php echo esc_url( $checkout_url ); ?>" method="post" enctype="multipart/form-data">
		<input name="discount" type="hidden" value="<?php echo esc_attr(true) ?>">
		<input name="uid1" type="hidden" value="<?php echo esc_attr(rand(99999,99999999)) ?>">
		<input name="tpf" type="hidden" value="<?php echo esc_attr($TemplateID) ?>">
		<button type="submit" id="applyofferbutton" onclick="applyingtext()" class="buttoncostyle" style="background-color: <?php echo esc_html($ButtonBackgroundColor) ?>!important; color: <?php echo esc_html($ButtonTextColor) ?>!important; margin-top: 10px!important; margin-bottom: 10px!important; border-radius: 5px!important; font-size: <?php echo esc_html($ButtonFont) ?>!important; margin-top: 20px!important; margin-bottom: 18px!important;" disabled><b><?php echo esc_html($ButtonText) ?></b></button>
		</form>
       	<div id="close" style="color: <?php echo esc_html($CloseTextCol) ?>!important; text-align: <?php echo esc_html($CloseTextAlign) ?>!important; z-index: 1004!important; padding-left: <?php echo esc_html($ClosePaddingLeft) ?>!important; padding-right: <?php echo esc_html($ClosePaddingRight) ?>!important; font-size: 16px!important; font-weight: 600!important; margin-top: 15px!important; margin-bottom:25px!important; text-decoration: underline!important;" onclick="closebox()"><?php echo esc_html($CloseText) ?></div>
    </div>
</div>
	
	
	<?php
	}



echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';


$AdminURLForEditor = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor';
echo '<a style="font-size:16px; font-weight:700;" href="'.esc_url($AdminURLForEditor).'"><< Go Back To Template Editor</a>';



}

//TEMPLATE EDITOR
if (isset($_GET["edittemp"])){
if (isset($_POST["savetemplate"])){
// skip loading edit template
unset($SkipArea);
}else{
	
$SetTemplate = sanitize_text_field( $_GET["template"]);	
$TemplateFile = $UserEditedTemplatesDir.sanitize_text_field( $_GET["template"]).'.php';

//Start of quick start wizard
if (isset($_GET["dm"])){
delete_option( 'RecoverExitFirstTimer' );	
}

$FirstTimer = get_option( 'RecoverExitFirstTimer' );

if (isset($FirstTimer)){
if ($FirstTimer == true){
//wizard
$DismissCurPage = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor&edittemp=true&template='.$SetTemplate.'&dm=true';

echo "<div class='notice notice-success is-dismissible'>
       <h3>Quick Start Wizard <p style='font-weight:700;' class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong><mark>STEP3:</mark><br><br>1. Click the text inside the template and type in your custom text!<br>2. Add your WooCommerce coupon code to the *Coupon Code to Apply:* text box (make it new & unique for coupon conversion tracking)<br>3. Give this template a new name or leave it unchanged.<br>4. Click 'Save Template!'</strong>.<br><br> [<strong><a style='font-size:14px; font-weight:700;' href='".esc_url($DismissCurPage)."'>End quick start wizard</a></strong>]</p></h3>
	</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';
}	
}//end of quick start wizard    

echo '<h3>Editing Template ['.wp_kses_post($SetTemplate).']</h3>';

if (file_exists($TemplateFile)){


echo '<form id="savetemplate" method="POST" action="">';
echo '<input type="hidden" id="savetemplate" name="savetemplate" value="yes">';
echo '<input type="hidden" id="origtemplatename" name="origtemplatename" value="'.esc_attr($SetTemplate).'">';

include ($TemplateFile);

echo '<div id="lcwindow" class="checkout-spec-oo" style="background-color: '.esc_html($BackgroundColor).'!important; background-image: linear-gradient(180deg, '.esc_html($BackGroundGradCol1).' 0%, '.esc_html($BackGroundGradCol2).' 100%); border-style: '.esc_html($BorderStyle).'!important; border-color: '.esc_html($Bordercolour).'!important; border-radius: '.esc_html($BorderRadius).'!important;">
    <div class="inner-window-checkout">';
	
//header
echo '<p style="font-size: '.esc_html($TopHeadingFontSize).'; font-weight: '.esc_html($Topfontweight).'; color: '.esc_html($TopHeaderColour).'; text-align: center; margin-top: '.esc_html($TopHeaderMaginTop).'; margin-bottom: '.esc_html($TopHeaderMaginBottom).'!important;"> <input type="text" id="headertext" name="headertext" style="font-size: '.esc_html($TopHeadingFontSize).'; text-align: center; background-color:'.esc_html($BackgroundColor).'; color: '.esc_html($TopHeaderColour).'; line-height:0.1; border:0px!important;" value="'.esc_html($HeaderText).'"></p>';	
//subheader
echo '<p style="font-size: '.esc_html($SubHeaderFontSize).'; font-weight: '.esc_html($SubHeaderWeight).'; color: '.esc_html($SubHeaderColour).'; text-align: center; margin-bottom: '.esc_html($SubHeaderMarginBottom).'!important;"> <input type="text" id="subheadertext" name="subheadertext" style="font-size: '.esc_html($SubHeaderFontSize).'; text-align: center; background-color:'.esc_html($BackgroundColor).'; color: '.esc_html($SubHeaderColour).'; line-height:0.1; border:0px!important;" value="'.esc_html($SubHeaderText).'"></p>';
//description
echo '<p style="font-size:'.esc_html($DescriptionFontSize).'; font-weight:'.esc_html($DescFontWeight).'; color:'.esc_html($DescFontColour).'; margin-bottom: '.esc_html($DescMarginBottom).'!important; margin-top: '.esc_html($DescMarginTop).'!important; margin-left: 10px!important; margin-right: 10px!important;"> <input text="text" id="descriptiontext" name="descriptiontext" style="font-size: '.esc_html($DescriptionFontSize).'; text-align: center; font-weight:'.esc_html($DescFontWeight).'; background-color:'.esc_html($BackgroundColor).'; color: '.esc_html($SubHeaderColour).'; line-height:0.1; border:0px!important; width:98%!important;" value="'.esc_html($DescriptionText).'"></p>';
//button
echo '<input text="text" class="buttoncostyle" id="buttontext" name="buttontext" style="font-size: '.esc_html($DescriptionFontSize).'; text-align: center; font-weight:'.esc_html($DescFontWeight).'; background-color:'.esc_html($ButtonBackgroundColor).'; color: '.esc_html($ButtonTextColor).'; line-height:0.1; border:0px!important; border-radius: 5px!important; font-size: medium!important; margin-top: 20px!important; margin-bottom: 18px!important; font-weight: 700!important; margin-bottom:18px!important;" value="'.esc_html($ButtonText).'">';
//close text
echo '<input text="text" class="close" id="closetext" name="closetext" style="background-color:'.esc_html($BackgroundColor).'; color: '.esc_html($CloseTextCol).'!important; text-align: '.esc_html($CloseTextAlign).'!important; z-index: 1004!important; padding-left: '.esc_html($ClosePaddingLeft).'!important; padding-right: '.esc_html($ClosePaddingRight).'!important; font-size: 16px!important; font-weight: 600!important; margin-top: 15px!important; margin-bottom:25px!important; text-decoration: underline!important; line-height:0.1; border:0px!important; width:98%!important" value="'.esc_html($CloseText).'">';

echo '</div>
</div>';


echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';

echo '<label for="vouchercode">Coupon Code to Apply:</label> 
<br>
<input type="text" class="options-box-9" id="vouchercode" name="vouchercode" value="'.esc_attr($CheckOutCode).'"><br>';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';

echo '<label for="newtemplatename">Template Name:</label><br>
<input type="text" class="options-box-9" id="newtemplatename" name="newtemplatename" value="'.esc_attr($SetTemplate).'"><br>';

echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';

echo '<button type="submit" class="green-button-ck" id="SaveTemp">Save Template!</button>';

echo '</form>';

echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';

$AdminURLForEditDel = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor';
echo '<a style="font-size:16px; font-weight:700;" href="'.esc_url($AdminURLForEditDel).'"><< Go Back (changes will be lost)</a>';

echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';


echo '<p class="backend-font-heavy-big">Template Editor Help & Useful Info</p>';
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Video Tutorial?</strong> - <a href="https://www.youtube.com/watch?v=a0bY_sF7Tbo" target="_blank"><strong>Watch template editor video tutorial on YouTube (2:41)</strong></a></p>';
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>How To edit?</strong> - Simply click the text and delete/type your custom text.</p>';
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Coupon Code to Apply</strong> - Use a new and unique coupon code for success rate tracking of this template <mark>[HIGHLY RECOMMENDED]</mark>.</p>';
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Template Name</strong> - Keep this the same or change it!</p>';
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Adding Coupons</strong> - <a href="'.esc_url(get_admin_url( null, null, null ) ). 'post-new.php?post_type=shop_coupon" target="_blank">Add a Single Coupon</a> OR <a href="'. esc_url(get_admin_url( null, null, null )) . 'admin.php?page=recover-exit-gen-coupons" target="_blank">Add Multiple Coupons at Once</a></p>';
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Please Note</strong> - Templates may appear slightly different in editor, this will not effect the template style/look.</p>';



}else{
echo '<h3>ERROR - TEMPLATE FILE NOT FOUND!</h3>';
}

//stop
unset($SkipArea);
}
}	



if (isset($SkipArea)){

// set default template view-all	
if (empty($_POST["settemp"])){
// post not set, make default display all templates
$_POST['select_your_template'] = 'Select a Template..';	
$_POST['settemp'] = 'yes';	
}

// set default template view-all	
if (($_POST["select_your_template"]) == '[View All Templates]'){
// post not set, make default display all templates
$_POST['select_your_template'] = 'Select a Template..';	
$_POST['settemp'] = 'yes';	
}

	
$templatefolder1 = $UserEditedTemplatesDir;
$templatefiles1 = scandir($templatefolder1);
$templatefiles1 = array_diff(scandir($templatefolder1), array('.', '..'));	

$FreeTemplates = array();
$PremTemplates = array();


//SORT template list order
foreach($templatefiles1 as $templateitem2) {
unset($TempisPrem);
include ($UserEditedTemplatesDir.$templateitem2);

if (isset($TempisPrem)){
array_push($PremTemplates,$templateitem2);	
}else{
array_push($FreeTemplates,$templateitem2);	
}
}


//wipe existing array
unset($templatefiles1);
$templatefiles1 = array();

global $rekx;

if (isset($rekx)){
// prem at top
//join arrays
foreach($PremTemplates as $PremTemplates123) {
array_push($templatefiles1,$PremTemplates123);	
}
foreach($FreeTemplates as $FreeTemplates123) {
array_push($templatefiles1,$FreeTemplates123);	
}

}else{
// prem at bottom
//join arrays
foreach($FreeTemplates as $FreeTemplates123) {
array_push($templatefiles1,$FreeTemplates123);	
}
foreach($PremTemplates as $PremTemplates123) {
array_push($templatefiles1,$PremTemplates123);	
}		
}


echo '<form id="settemp" method="POST" action="">';
echo '<input type="hidden" id="settemp" name="settemp" value="yes">';


echo '<label for="select_your_template">Select a Template:</label>';	

echo '<div style="height:2px" aria-hidden="true" class="admin-spacer"></div>';

echo '<select name="select_your_template" id="select_your_template" onchange="this.form.submit()">';



echo '<option value="Select a Template..">Select a Template..</option>';

echo '<option value="[View All Templates]">[View All Templates]</option>';


foreach($templatefiles1 as $templateitem1) {
	
$templateitem1 = str_replace(".php","",$templateitem1);
$logfilelocno1 = str_replace("template","",$templateitem1);	


if (isset($_POST["select_your_template"])){
if ($_POST["select_your_template"] == $templateitem1){
echo '<option value="'.esc_attr($templateitem1).'" selected="selected">'.esc_attr($templateitem1).'</option>';	
}else{
//standard
echo '<option value="'.esc_attr($templateitem1).'">'.esc_attr($templateitem1).'</option>';	
}
}else{
//standard	
echo '<option value="'.esc_attr($templateitem1).'">'.esc_attr($templateitem1).'</option>';	
}
}//end of loop



echo '</select>';
echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';

echo '<div class="gen_button_sign"><button type="submit" class="green-button-ck" id="AddList">View Template</button></div>';
echo '</form>';


echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';

if (isset($_POST["select_your_template"])){
if ($_POST["select_your_template"] == 'Select a Template..'){
echo '<h1 style="margin-left:12px!important;">Showing All Templates</h1>';

//Start of quick start wizard
if (isset($_GET["dm"])){
delete_option( 'RecoverExitFirstTimer' );	
}

$FirstTimer = get_option( 'RecoverExitFirstTimer' );

if (isset($FirstTimer)){
if ($FirstTimer == true){
//wizard
$DismissCurPage = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor&dm=true';

echo "<div class='notice notice-success is-dismissible'>
       <h3>Quick Start Wizard <p style='font-weight:700;' class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong><mark>STEP2:</mark> Find an exit popup template you want to use and click the 'EDIT' button!</strong>.  [<strong><a style='font-size:14px; font-weight:700;' href='".esc_url($DismissCurPage)."'>End quick start wizard</a></strong>]</p></h3>
	</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';
}	
}//end of quick start wizard    
    
    
 
echo '<div style="width:100%!important; position: relative; margin: 0 auto;">';
foreach($templatefiles1 as $templateitem12) {
	
$templateitem12 = str_replace(".php","",$templateitem12);
$logfilelocno12 = str_replace("template","",$templateitem12);	

// All templates previewed on same page:

//unset($Template);
//echo 'template='.$templateitem12.'<br>';

echo '<div style="width:48%!important;float: left!important; margin:15px!important;">';

echo '<h3>'.$templateitem12.' Preview:</h3>';

unset($TempisPrem);	
include ($UserEditedTemplatesDir.$templateitem12.'.php');

//if (isset($Template)){

//$Template = str_replace("display: none;","",$Template);//for preview
//$Template = str_replace('<button type="submit" ','<button type="submit" disabled ',$Template);//disable button for preview

//echo $Template;
	if (isset($BackgroundType)){
		
	if ($BackgroundType == 1){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="background-color: <?php echo esc_html($BackgroundColor) ?>!important; border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">	
	<?php	
	}
	if ($BackgroundType == 2){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="background-color: <?php echo esc_html($BackgroundColor) ?>!important; background-image: linear-gradient(180deg, <?php echo esc_html($BackGroundGradCol1) ?> 0%, <?php echo esc_html($BackGroundGradCol2) ?> 100%); border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">
	<?php	
	}
	if ($BackgroundType == 3){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="background: repeating-linear-gradient( 45deg, <?php echo esc_html($BackGroundGradCol1) ?>, <?php echo esc_html($BackGroundGradCol1) ?> 10px, <?php echo esc_html($BackGroundGradCol2) ?> 20px, <?php echo esc_html($BackGroundGradCol2) ?> 40px)!important; border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">
	<?php
	}
	
	
	
	?>
	
		<div class="inner-window-checkout">
        <p style="font-size: <?php echo esc_html($TopHeadingFontSize) ?>; font-weight: <?php echo esc_html($Topfontweight) ?>; color: <?php echo esc_html($TopHeaderColour) ?>; text-align: center; margin-top: <?php echo esc_html($TopHeaderMaginTop) ?>; margin-bottom: <?php echo esc_html($TopHeaderMaginBottom) ?>!important;"><?php echo esc_html($HeaderText) ?></p>
		<p style="font-size: <?php echo esc_html($SubHeaderFontSize) ?>; font-weight: <?php echo esc_html($SubHeaderWeight) ?>; color: <?php echo esc_html($SubHeaderColour) ?>; text-align: center; margin-bottom: <?php echo esc_html($SubHeaderMarginBottom) ?>!important;"><?php echo esc_html($SubHeaderText) ?></p>
        <p style="font-size: <?php echo esc_html($DescriptionFontSize) ?>; font-weight: <?php echo esc_html($DescFontWeight) ?>; color: <?php echo esc_html($DescFontColour) ?>; margin-bottom: <?php echo esc_html($DescMarginBottom) ?>!important; margin-top: <?php echo esc_html($DescMarginTop) ?>!important; margin-left: 10px!important; margin-right: 10px!important;"><?php echo esc_html($DescriptionText) ?></p>
        <form action="<?php echo esc_url( $checkout_url ); ?>" method="post" enctype="multipart/form-data">
		<input name="discount" type="hidden" value="<?php echo esc_attr(true) ?>">
		<input name="uid1" type="hidden" value="<?php echo esc_attr(rand(99999,99999999)) ?>">
		<input name="tpf" type="hidden" value="<?php echo esc_attr($TemplateID) ?>">
		<button type="submit" id="applyofferbutton" onclick="applyingtext()" class="buttoncostyle" style="background-color: <?php echo esc_html($ButtonBackgroundColor) ?>!important; color: <?php echo esc_html($ButtonTextColor) ?>!important; margin-top: 10px!important; margin-bottom: 10px!important; border-radius: 5px!important; font-size: <?php echo esc_html($ButtonFont) ?>!important; margin-top: 20px!important; margin-bottom: 18px!important;" disabled><b><?php echo esc_html($ButtonText) ?></b></button>
		</form>
       	<div id="close" style="color: <?php echo esc_html($CloseTextCol) ?>!important; text-align: <?php echo esc_html($CloseTextAlign) ?>!important; z-index: 1004!important; padding-left: <?php echo esc_html($ClosePaddingLeft) ?>!important; padding-right: <?php echo esc_html($ClosePaddingRight) ?>!important; font-size: 16px!important; font-weight: 600!important; margin-top: 15px!important; margin-bottom:25px!important; text-decoration: underline!important;" onclick="closebox()"><?php echo esc_html($CloseText) ?></div>
    </div>
</div>
	
	
	<?php
	}


//}

//edit,delete,duplicate buttons..

unset($AdminURLForEditDel);
$AdminURLForEditDel = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor';
global $rekx;	

echo '<h3>Modify This Template?</h3>';

if (isset($TempisPrem)){
if (isset($rekx)){

echo '<div class="button-contl">';
echo '<a class="btn-opt1l" href="'.esc_url($AdminURLForEditDel.'&edittemp=true&template='.$templateitem12).'" title="">EDIT</a>';
echo '<a class="btn-opt2l" href="'.esc_url($AdminURLForEditDel.'&delete=true&template='.$templateitem12).'" title="">DELETE</a>';
echo '<a class="btn-opt3l" href="'.esc_url($AdminURLForEditDel.'&dupetemp=true&template='.$templateitem12).'" title="">DUPLICATE</a>';
echo '</div>';

echo '<br><br>';	
	
}else{

$AdminURLForUpgrade = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-help-license&upgrade=true';	
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'/assets/images/question.png" height="16" width="16"> <strong><a style="font-weight:700;" href="'.esc_url($AdminURLForUpgrade).'">Please upgrade</a></strong> to use and edit this template OR select a [Free] template.</p>';
		
	
}


}else{
//free template
echo '<div class="button-contl">';
echo '<a class="btn-opt1l" href="'.esc_url($AdminURLForEditDel.'&edittemp=true&template='.$templateitem12).'" title="">EDIT</a>';
echo '<a class="btn-opt2l" href="'.esc_url($AdminURLForEditDel.'&delete=true&template='.$templateitem12).'" title="">DELETE</a>';
echo '<a class="btn-opt3l" href="'.esc_url($AdminURLForEditDel.'&dupetemp=true&template='.$templateitem12).'" title="">DUPLICATE</a>';
echo '</div>';

echo '<div style="height:30px" aria-hidden="true" class="admin-spacer"></div>';

	
}


echo '</div>';
}




echo '</div>';

	
}else{
	

echo '<h3>'.esc_html( $_POST["select_your_template"]).' Preview:</h3>';	

include ($UserEditedTemplatesDir.sanitize_text_field( $_POST["select_your_template"]).'.php');


	if (isset($BackgroundType)){
		
	if ($BackgroundType == 1){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="background-color: <?php echo esc_html($BackgroundColor) ?>!important; border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">	
	<?php	
	}
	if ($BackgroundType == 2){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="background-color: <?php echo esc_html($BackgroundColor) ?>!important; background-image: linear-gradient(180deg, <?php echo esc_html($BackGroundGradCol1) ?> 0%, <?php echo esc_html($BackGroundGradCol2) ?> 100%); border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">
	<?php	
	}
	if ($BackgroundType == 3){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="background: repeating-linear-gradient( 45deg, <?php echo esc_html($BackGroundGradCol1) ?>, <?php echo esc_html($BackGroundGradCol1) ?> 10px, <?php echo esc_html($BackGroundGradCol2) ?> 20px, <?php echo esc_html($BackGroundGradCol2) ?> 40px)!important; border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">
	<?php
	}
	
	
	
	?>
	
		<div class="inner-window-checkout">
        <p style="font-size: <?php echo esc_html($TopHeadingFontSize) ?>; font-weight: <?php echo esc_html($Topfontweight) ?>; color: <?php echo esc_html($TopHeaderColour) ?>; text-align: center; margin-top: <?php echo esc_html($TopHeaderMaginTop) ?>; margin-bottom: <?php echo esc_html($TopHeaderMaginBottom) ?>!important;"><?php echo esc_html($HeaderText) ?></p>
		<p style="font-size: <?php echo esc_html($SubHeaderFontSize) ?>; font-weight: <?php echo esc_html($SubHeaderWeight) ?>; color: <?php echo esc_html($SubHeaderColour) ?>; text-align: center; margin-bottom: <?php echo esc_html($SubHeaderMarginBottom) ?>!important;"><?php echo esc_html($SubHeaderText) ?></p>
        <p style="font-size: <?php echo esc_html($DescriptionFontSize) ?>; font-weight: <?php echo esc_html($DescFontWeight) ?>; color: <?php echo esc_html($DescFontColour) ?>; margin-bottom: <?php echo esc_html($DescMarginBottom) ?>!important; margin-top: <?php echo esc_html($DescMarginTop) ?>!important; margin-left: 10px!important; margin-right: 10px!important;"><?php echo esc_html($DescriptionText) ?></p>
        <form action="<?php echo esc_url( $checkout_url ); ?>" method="post" enctype="multipart/form-data">
		<input name="discount" type="hidden" value="<?php echo esc_attr(true) ?>">
		<input name="uid1" type="hidden" value="<?php echo esc_attr(rand(99999,99999999)) ?>">
		<input name="tpf" type="hidden" value="<?php echo esc_attr($TemplateID) ?>">
		<button type="submit" id="applyofferbutton" onclick="applyingtext()" class="buttoncostyle" style="background-color: <?php echo esc_html($ButtonBackgroundColor) ?>!important; color: <?php echo esc_html($ButtonTextColor) ?>!important; margin-top: 10px!important; margin-bottom: 10px!important; border-radius: 5px!important; font-size: <?php echo esc_html($ButtonFont) ?>!important; margin-top: 20px!important; margin-bottom: 18px!important;" disabled><b><?php echo esc_html($ButtonText) ?></b></button>
		</form>
       	<div id="close" style="color: <?php echo esc_html($CloseTextCol) ?>!important; text-align: <?php echo esc_html($CloseTextAlign) ?>!important; z-index: 1004!important; padding-left: <?php echo esc_html($ClosePaddingLeft) ?>!important; padding-right: <?php echo esc_html($ClosePaddingRight) ?>!important; font-size: 16px!important; font-weight: 600!important; margin-top: 15px!important; margin-bottom:25px!important; text-decoration: underline!important;" onclick="closebox()"><?php echo esc_html($CloseText) ?></div>
    </div>
</div>
	
	
	<?php
	}




}

}

if (isset($_POST["select_your_template"])){
	
if ($_POST["select_your_template"] == 'Select a Template..'){
	
}else{
//edit and delete buttons
$AdminURLForEditDel = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-template-editor';
global $rekx;	

echo '<h3>Modify This Template?</h3>';

if (isset($TempisPrem)){
if (isset($rekx)){

echo '<div class="button-contl">';
echo '<a class="btn-opt1l" href="'.esc_url($AdminURLForEditDel.'&edittemp=true&template='.$_POST["select_your_template"]).'" title="">EDIT</a>';
echo '<a class="btn-opt2l" href="'.esc_url($AdminURLForEditDel.'&delete=true&template='.$_POST["select_your_template"]).'" title="">DELETE</a>';
echo '<a class="btn-opt3l" href="'.esc_url($AdminURLForEditDel.'&dupetemp=true&template='.$_POST["select_your_template"]).'" title="">DUPLICATE</a>';
echo '</div>';

echo '<br><br>';	
	
}else{

$AdminURLForUpgrade = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-help-license&upgrade=true';	
echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'/assets/images/question.png" height="16" width="16"> <strong><a style="font-weight:700;" href="'.esc_url($AdminURLForUpgrade).'">Please upgrade</a></strong> to use and edit this template OR select a [Free] template.</p>';
		
	
}


}else{
//free template
echo '<div class="button-contl">';
echo '<a class="btn-opt1l" href="'.esc_url($AdminURLForEditDel.'&edittemp=true&template='. $_POST["select_your_template"]).'" title="">EDIT</a>';
echo '<a class="btn-opt2l" href="'.esc_url($AdminURLForEditDel.'&delete=true&template='. $_POST["select_your_template"]).'" title="">DELETE</a>';
echo '<a class="btn-opt3l" href="'.esc_url($AdminURLForEditDel.'&dupetemp=true&template='. $_POST["select_your_template"]).'" title="">DUPLICATE</a>';
echo '</div>';

echo '<br><br>';	
	
}





}
}
}


}

function recover_exit_settings(){
recexit_check_status_recoverexit();
random_recoverexit_check();	
recexit_check_re_exp_date();

if (get_option( 'recexitexpmsg' ) == true){	

if (isset($_GET["dmsgr"])){
update_option("disrecexitexpmsg", 'yes');	
}else{
	
$DismissLinkXY = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-settings&dmsgr=true';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	

echo "<div class='notice notice-warning is-dismissible'>
<h3>Your License Will Expire Soon! <p class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong>You can <a style='font-weight:700;' href='https://www.recoverexit.com/your-license/?lic=".get_option('re_lic_setting')."' target='_blank'>renew your license for 50% less</a> than the price of a new license! <a style='font-size:14px; font-weight:700;' href='".esc_url($DismissLinkXY)."'>[no thanks]</a></strong></p></h3>
	</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	
	

}
}

	
	$UploadsDir = wp_upload_dir();
	$MasterDirectory = $UploadsDir["basedir"] . '/RecoverExit';//master folder
	
	$TemplateLogsDir = $MasterDirectory . '/logs/';//for template stats
	$UserEditedTemplatesDir = $MasterDirectory . '/templates/';//for user edited templates
	$masternfeedbacklogs = $MasterDirectory . '/masterfeedback/';//user feedback & master logs		
	
global $rekx;	
	
	
// reset to default settings
if (isset($_POST["resetsettings"])){
	delete_option( 'RecoverExitSettings' );

	$FeedBackLog = sanitize_text_field($_POST["feedback_log"]);

	$DefaultSettingsArray = array(
		//'selected_template' => array("SkyBlue [Free]"),
		'time_length' => '15000',// 15 seconds
		'scroll_speed' => '130', // 130 scroll speed for mobile
		//'selected_show' => array("Cart","Checkout"),
		'feedback_log' => $FeedBackLog,
		'feedback_setting' => 'No',
		'background_setting' => 'Yes',
		'storesettings' => 'yes',
		);	
	
add_option( 'RecoverExitSettings', $DefaultSettingsArray );//store new settings 
//add_option( 'RecoverExitFirstTimer', 'true' );//store first timer value

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';
echo '<div class="notice notice-success is-dismissible">
<h3>Recover Exit: Default Settings have been saved!</h3>
</div>';	
}	


	//store plugin settings
if (isset($_POST["storesettings"])){

global $rekx;

if (isset($rekx)){
//no action	
}else{
if (isset($_POST["selected_template"])){
if (count($_POST["selected_template"]) >8){
$ErrorMsg = true;	
$ErMessage = 'to select more than 8 templates at once!';
}
}
if (isset($_POST["feedback_setting"])){
if (($_POST["feedback_setting"]) == 'Yes'){	
$ErrorMsg = true;	
$ErMessage = 'to enable user feedback feature!';	
}	
}
}

if (isset($ErrorMsg)){
$AdminURLForUpgrade = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-help-license&upgrade=true';	
echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	
echo '<div class="notice notice-error is-dismissible">
<h3>Recover Exit: Settings not saved, <a style="font-weight:700;" href="'.esc_url($AdminURLForUpgrade).'">Please upgrade</a> '.$ErMessage.'</h3>
</div>';

}else{
delete_option( 'RecoverExitSettings' );
add_option( 'RecoverExitSettings', $_POST );//store new settings 

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';
echo '<div class="notice notice-success is-dismissible">
<h3>Recover Exit: Settings updated!</h3>
</div>';
}

}//end of store settings


echo '<h1 class="recexit-title">RecoverExit Settings</h1>';
echo '<div style="height:30px" aria-hidden="true" class="admin-spacer"></div>';

$AntiConflict = 'stop';

if (isset($_GET["dm"])){
delete_option( 'RecoverExitFirstTimer' );	
}

$FirstTimer = get_option( 'RecoverExitFirstTimer' );

if (isset($FirstTimer)){
if ($FirstTimer == true){

//wizard
$StatsPageQs = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-stats';
$HelpPageQs = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-help-license';
$DismissCurPage = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-settings&dm=true';


if (isset($_GET["qst"])){
$Msg1 = 'You just edited <u>' . sanitize_text_field($_GET["qst"]) . '</u> (tick that template!)';	
delete_option( 'RecoverExitFirstTimer' );
}else{
$Msg1 = 'Select the exit popup templates you want to display!';		
}


echo "<div class='notice notice-success is-dismissible'>
       <h3>Quick Start Wizard<p class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong><mark>NEARLY THERE - SWITCH ON TIME!</mark><br><br> 
	   <mark>Required:</mark><br>
	   [Show RecoverExit] This is where your exit popups will show, select cart, checkout or both!<br>[Select Your Template(s) To Display] ".wp_kses_post($Msg1)."
	   <br><br><mark>Optional (can be left unchanged):</mark><br>Delay Before Listening for Exit (Seconds): - The length of time in seconds, before RecoverExit listens for a user exiting the cart/checkout. [Default: 15]<br>
 Mobile Scroll Speed Trigger - The upwards scroll speed sensitivity of mobile exit popups, Lower = more sensitive, Higher = less sensitive. [Default: 130]<br>
 Enable Dark Background Overlay? - Selecting 'Yes' will show a dark overlay on the checkout/cart, this in theory draws more attention to the exit offer.
	   <br><br>
	   Click 'Update Settings Now!' button when done!
	   <br><br>
	   Optional: check out the <a style='font-weight:700;' href='".esc_url($StatsPageQs)."'>statistics page</a> to see how your templates are performing!
	   <br>
	   Optional: watch the help videos in <a style='font-weight:700;' href='".esc_url($HelpPageQs)."'>help section</a> to learn more about using RecoverExit!
	   <br><br>
	   <strong>[<a style='font-size:14px; font-weight:700;' href='".esc_url($DismissCurPage)."'>End quick start wizard</a>]</strong>
	   </p></h3>
	</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';

unset($AntiConflict);	
}		
}

if (isset($AntiConflict)){
if (isset($_GET["qst"])){
// display template to enable alert [just edited and passed to settings page]

echo '<div class="notice notice-success is-dismissible">
       <h3><p style="font-weight:700;" class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>For your information, you just edited: <mark>'.sanitize_text_field($_GET["qst"]).'</mark></strong></p></h3><strong>
	</strong><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';


echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';
}	
}



$OptionsArray = get_option( 'RecoverExitSettings' );

$templatefolder = $UserEditedTemplatesDir;
$templatefiles = scandir($templatefolder);
$templatefiles = array_diff(scandir($templatefolder), array('.', '..'));



echo '<form id="settingsupdater" method="POST" action="">';

echo '<label for="selected_template">Show RecoverExit On:</label>';
echo '<div style="height:2px" aria-hidden="true" class="admin-spacer"></div>';

if (isset($OptionsArray["selected_show"])){
if (in_array("Cart", $OptionsArray["selected_show"])){
// show on cart setting selected
echo '<input type="checkbox" id="Cart" name="selected_show[]" value="Cart" checked="checked">
<label for="Cart">Cart</label><br>';
}else{
// cart not selected:
echo '<input type="checkbox" id="Cart" name="selected_show[]" value="Cart">
<label for="Cart">Cart</label><br>';	
}

if (in_array("Checkout", $OptionsArray["selected_show"])){
// show on checkout setting selected
echo '<input type="checkbox" id="Checkout" name="selected_show[]" value="Checkout" checked="checked">
<label for="Checkout">Checkout</label>';
}else{
//show on checkout not selected	
echo '<input type="checkbox" id="Checkout" name="selected_show[]" value="Checkout">
<label for="Checkout">Checkout</label>';	
}


}else{
// no settings selected yet.
echo '<input type="checkbox" id="Cart" name="selected_show[]" value="Cart">
<label for="Cart">Cart</label><br>';
echo '<input type="checkbox" id="Checkout" name="selected_show[]" value="Checkout">
<label for="Checkout">Checkout</label>';	
}






echo '<div style="height:15px" aria-hidden="true" class="admin-spacer"></div>';

echo '<label for="selected_template">Select Your Template(s) To Display:</label>';
echo '<div style="height:2px" aria-hidden="true" class="admin-spacer"></div>';

if (isset($OptionsArray["selected_template"])){
$SelectedTemplateOpts = $OptionsArray["selected_template"];
}

foreach($templatefiles as $templateitem) {
//$templateitem = str_replace("template","",$templateitem);
$templateitem = str_replace(".php","",$templateitem);


$Disabled = 'No';
if (strpos($templateitem, 'Premium') !== false) {
if (empty($rekx)){
unset($Disabled);
}
}

unset($Marked);
unset($Marked1);
//check if just edited and highlight:
if (isset($_GET["qst"])){
if ($templateitem == $_GET["qst"]){
$Marked = '<mark>';
$Marked1 = '</mark>';	
}	
}


if (isset($OptionsArray["selected_template"])){
if (in_array($templateitem, $SelectedTemplateOpts)){
if (isset($Disabled)){
if (isset($Marked)){
echo wp_kses_post($Marked);	
}
echo '<input type="checkbox" id="'.esc_attr($templateitem).'" name="selected_template[]" value="'.esc_attr($templateitem).'" checked="checked">
  <label for="'.esc_attr($templateitem).'">'.esc_attr($templateitem).'</label><div style="height:1px" aria-hidden="true" class="admin-spacer"></div>';	

if (isset($Marked1)){
echo wp_kses_post($Marked1);	
}

}//end of disabled
}else{
if (isset($Disabled)){

if (isset($Marked)){
echo wp_kses_post($Marked);	
}
	
echo '<input type="checkbox" id="'.esc_attr($templateitem).'" name="selected_template[]" value="'.esc_attr($templateitem).'">
  <label for="'.esc_attr($templateitem).'">'.esc_attr($templateitem).'</label><div style="height:1px" aria-hidden="true" class="admin-spacer"></div>';	

if (isset($Marked1)){
echo wp_kses_post($Marked1);	
}

}//end of disabled

}

}else{
if (isset($Disabled)){

if (isset($Marked)){
echo wp_kses_post($Marked);	
}
	
echo '<input type="checkbox" id="'.esc_attr($templateitem).'" name="selected_template[]" value="'.esc_attr($templateitem).'">
  <label for="'.esc_attr($templateitem).'">'.esc_attr($templateitem).'</label><div style="height:1px" aria-hidden="true" class="admin-spacer"></div>';	

if (isset($Marked1)){
echo wp_kses_post($Marked1);	
}

}//end of disabled
}
}

if (isset($OptionsArray["time_length"])){
$CurrentTimeLSet = $OptionsArray["time_length"];
}

echo '<div style="height:15px" aria-hidden="true" class="admin-spacer"></div>';
echo '<label for="time_length">Delay Before Listening for Exit (Seconds):</label>';
echo '<div style="height:2px" aria-hidden="true" class="admin-spacer"></div>';
echo '<select name="time_length" id="time_length">';

//time_length
$SettingsTimeDelay = array("1","3","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","30");
foreach ($SettingsTimeDelay as $timevalue) {
	
$timevaluecheck = $timevalue . '000';	

if (isset($CurrentTimeLSet)){
if ($timevaluecheck == $CurrentTimeLSet){
//set as current option
echo '<option value="'.esc_attr($timevalue . '000').'" selected="selected">' . esc_attr($timevalue) . '</option>';	
}else{
echo '<option value="'.esc_attr($timevalue . '000').'">'.esc_attr($timevalue).'</option>';	
}	
}else{
echo '<option value="'.esc_attr($timevalue . '000').'">'.esc_attr($timevalue).'</option>';		
}
}
echo '</select>';


if (isset($OptionsArray["scroll_speed"])){
$CurrentScrollSpeed = $OptionsArray["scroll_speed"];
}

echo '<div style="height:15px" aria-hidden="true" class="admin-spacer"></div>';
echo '<label for="scroll_speed">Mobile Scroll Speed Trigger:</label>';
echo '<div style="height:2px" aria-hidden="true" class="admin-spacer"></div>';
echo '<select name="scroll_speed" id="scroll_speed">';

//time_length
$SettingsScrollSpeed = array("60","70","80","90","100","110","120","130","140","150","160");
foreach ($SettingsScrollSpeed as $scrollspeed) {

if (isset($CurrentScrollSpeed)){
if ($CurrentScrollSpeed == $scrollspeed){
echo '<option value="'.esc_attr($scrollspeed).'" selected="selected">' . esc_attr($scrollspeed) . '</option>';	
}else{
echo '<option value="'.esc_attr($scrollspeed).'">'.esc_attr($scrollspeed).'</option>';	
}
}else{
echo '<option value="'.esc_attr($scrollspeed).'">'.esc_attr($scrollspeed).'</option>';	
}
}

echo '</select>';



if (isset($OptionsArray["feedback_setting"])){
$CurrentFeedbackSetting = $OptionsArray["feedback_setting"];
}

echo '<div style="height:15px" aria-hidden="true" class="admin-spacer"></div>';
echo '<label for="feedback_setting">Enable User Feedback?</label>';
echo '<div style="height:2px" aria-hidden="true" class="admin-spacer"></div>';
echo '<select name="feedback_setting" id="feedback_setting">';

$userfeedbackarr = array("No","Yes");
foreach ($userfeedbackarr as $feedbackcur) {

if (isset($CurrentFeedbackSetting)){
if ($CurrentFeedbackSetting == $feedbackcur){
echo '<option value="'.esc_attr($feedbackcur).'" selected="selected">' . esc_attr($feedbackcur) . '</option>';	
}else{
echo '<option value="'.esc_attr($feedbackcur).'">'.esc_attr($feedbackcur).'</option>';	
}
}else{
echo '<option value="'.esc_attr($feedbackcur).'">'.esc_attr($feedbackcur).'</option>';	
}
}

echo '</select>';


if (isset($OptionsArray["background_setting"])){
$CurrentbgSetting = $OptionsArray["background_setting"];
}

echo '<div style="height:15px" aria-hidden="true" class="admin-spacer"></div>';
echo '<label for="background_setting">Enable Dark Background Overlay?</label>';
echo '<div style="height:2px" aria-hidden="true" class="admin-spacer"></div>';
echo '<select name="background_setting" id="background_setting">';


$BackgroundOverlay = array("No","Yes");
foreach ($BackgroundOverlay as $bgoverlaysett) {

if (isset($CurrentbgSetting)){
if ($CurrentbgSetting == $bgoverlaysett){
echo '<option value="'.esc_attr($bgoverlaysett).'" selected="selected">' . esc_attr($bgoverlaysett) . '</option>';	
}else{
echo '<option value="'.esc_attr($bgoverlaysett).'">'.esc_attr($bgoverlaysett).'</option>';	
}
}else{
echo '<option value="'.esc_attr($bgoverlaysett).'">'.esc_attr($bgoverlaysett).'</option>';	
}
}

echo '</select>';


echo '<input type="hidden" id="storesettings" name="storesettings" value="yes">';

if (isset($OptionsArray["feedback_log"])){
echo '<input type="hidden" id="feedback_log" name="feedback_log" value="'.$OptionsArray["feedback_log"].'">';	
}else{
echo '<input type="hidden" id="feedback_log" name="feedback_log" value="'.rand(99999,999999999).'">';	
}


echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';
echo '<div class="gen_button_sign"><button type="submit" class="lookup-tool-search-recexit" id="AddList">Update Settings Now!</button></div>';
echo '</form>';


echo '<form id="resetsettings" method="POST" action="">';
if (isset($OptionsArray["feedback_log"])){
echo '<input type="hidden" id="feedback_log" name="feedback_log" value="'.$OptionsArray["feedback_log"].'">';	
}else{
echo '<input type="hidden" id="feedback_log" name="feedback_log" value="'.rand(99999,999999999).'">';	
}
echo '<input type="hidden" id="resetsettings" name="resetsettings" value="yes">';
echo '<div class="gen_button_sign"><button type="submit" class="red_button_1" id="AddList">Reset to Default Settings</button></div>';
echo '</form>';

echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';

echo '<div id="close" style="color: #00548A!important; font-size: 16px!important; font-weight: 600!important; text-decoration: underline!important;" onclick="HelpSectionToggle2()"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> Need Help?</div>';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';

echo '<div id="HelpSection2" style="display:none;">';
//echo '<div style="height:32px" aria-hidden="true" class="admin-spacer"></div>';
echo '<p class="backend-font-heavy-big">Settings Explained..</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Video Tutorial?</strong> - <a href="https://www.youtube.com/watch?v=ARov9PH_ecY" target="_blank"><strong>Watch settings explained video tutorial on YouTube (3:58)</strong></a></p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Select Your Template(s)</strong> - Select which templates you want to show on your cart/checkout page, if your a premium member you can select multiple templates so they are shown at random.</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Delay Before Listening for Exit (Seconds):</strong> - The length of time in seconds, before RecoverExit listens for a user exiting the cart/checkout. [Default: 15]</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Mobile Scroll Speed Trigger</strong> - The upwards scroll speed sensitivity of mobile exit popups, Lower = more sensitive, Higher = less sensitive. [Default: 130]</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Enable User Feedback?</strong> - Selecting "Yes" will ask users for feedback that click the "No thanks" text at the bottom of exit popups.</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Enable Dark Background Overlay?</strong> - Selecting "Yes" will show a dark overlay on the checkout/cart, this in theory draws more attention to the exit offer.</p>';
echo '</div>';

}


function recover_exit_feedback(){
recexit_check_status_recoverexit();
random_recoverexit_check();
recexit_check_re_exp_date();	

if (get_option( 'recexitexpmsg' ) == true){	

if (isset($_GET["dmsgr"])){
update_option("disrecexitexpmsg", 'yes');	
}else{
	
$DismissLinkXY = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-feedback&dmsgr=true';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	

echo "<div class='notice notice-warning is-dismissible'>
<h3>Your License Will Expire Soon! <p class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong>You can <a style='font-weight:700;' href='https://www.recoverexit.com/your-license/?lic=".get_option('re_lic_setting')."' target='_blank'>renew your license for 50% less</a> than the price of a new license! <a style='font-size:14px; font-weight:700;' href='".esc_url($DismissLinkXY)."'>[no thanks]</a></strong></p></h3>
	</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	
	

}
}
	
	$UploadsDir = wp_upload_dir();
	$MasterDirectory = $UploadsDir["basedir"] . '/RecoverExit';//master folder
	
	$masternfeedbacklogs = $MasterDirectory . '/masterfeedback/';//user feedback & master logs		

$OptionsArray = get_option( 'RecoverExitSettings' );

// clear raw logs;
if (isset($_POST["clearfeedbacklog"])){
$RawLogFile = $masternfeedbacklogs.$OptionsArray["feedback_log"].'.txt';
if (file_exists($RawLogFile)){
unlink($RawLogFile);		
echo '<div class="notice notice-success is-dismissible">
       <h3>Recover Exit: Feedback Log Deleted!</h3>
    </div>';
}else{
echo '<div class="notice notice-error is-dismissible">
       <h3>Recover Exit: Feedback Log Does Not Exist!</h3>
    </div>';	
}
}

echo '<h1 class="recexit-title">RecoverExit User Feedback</h1>';
echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';

echo '<p class="backend-recexit-stats">View the feedback of users that clicked the "No thanks" text on your exit popups to see how you can make improvements.</p>';

global $rekx;

if (isset($rekx)){
//show feedback log

if (isset($OptionsArray["feedback_log"])){

//LOG FILE OUTPUT:
	$LogFile = $masternfeedbacklogs.$OptionsArray["feedback_log"].'.txt';
	}else{
	$LogFile = 'na';
	}

	if (file_exists($LogFile)){
	$fileforlog = file($LogFile);
	$xlogcount = count($fileforlog);	
	$searchfilesize = file($LogFile, FILE_IGNORE_NEW_LINES);
	$limitsearch = 100;
	
	
	echo '<textarea id="searchlog" style="width:650px!important;" class="backendsearchrecexit" class="box" rows="10">';
	//return log file..
	foreach($searchfilesize as $searchfilesize){
	if ($limitsearch <=0){
	}else{
	--$limitsearch;	
	--$xlogcount;
	echo esc_textarea($fileforlog[$xlogcount]);	
	}
	}
	echo '</textarea>';	
//	echo '<br>To view all ' . count($fileforlog) . ' records, <a href="' . plugin_dir_url(__FILE__) . 'assets/log.txt" target="_blank">View the full log now</a>';
	echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
	
echo '<form id="clearfeedbacklog" method="POST" action="">';
echo '<input type="hidden" id="clearfeedbacklog" name="clearfeedbacklog" value="yes">';
echo '<div class="gen_button_sign"><button type="submit" class="clear-logs-btn" id="AddList">Clear Feedback Logs</button></div>';
echo '</form>';
	
	
}else{



	
//raw log does not yet exist
echo '<textarea id="searchlog" style="width:650px!important;" class="backendsearchrecexit" rows="10">Nothing to report yet, user feedback will be shown here once collected from users that click the "No thanks" text.';

if ($OptionsArray["feedback_setting"] == 'No'){
echo '

This setting is currently disabled, to enable this option select "Yes" under "Enable User Feedback?" in Settings.';	
}
}

echo '</textarea><div style="height:32px" aria-hidden="true" class="admin-spacer"></div>';

}else{
//show demo log
echo '<textarea id="searchlog" style="width:650px!important;" class="backendsearchrecexit" rows="10">';
echo esc_textarea('Example "No thanks" user feedback log:

18th September 2021: I had a problem paying via card when checking out.
16th September 2021: I found a better deal at 123-shop.
13th September 2021: I was just checking the shipping cost, because i could not find it on the website.
10th September 2021: I wanted to see how long it would take to get this item delivered.');

echo '</textarea>';

$AdminURLForUpgrade = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-help-license&upgrade=true';	
echo '<p class="backend-recexit-stats"><img src="'. plugin_dir_url(__FILE__) . '/assets/images/question.png" height="16" width="16"> <strong><a style="font-weight:700;" href="'.esc_url($AdminURLForUpgrade).'">Please upgrade</a></strong> to enable "No thanks" user feedback.</p>';
echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';
}

echo '<p class="backend-font-heavy-big">What is RecoverExit User Feedback?</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <strong>Video Demo?</strong> - <a href="https://www.youtube.com/watch?v=-IjyTGU6_3Q" target="_blank"><strong>Watch user feedback module explained video on YouTube (0:50)</strong></a></p>';



}


function recover_exit_help_license(){
recexit_check_status_recoverexit();
random_recoverexit_check();	
recexit_check_re_exp_date();



if (get_option( 'recexitexpmsg' ) == true){	

if (isset($_GET["dmsgr"])){
update_option("disrecexitexpmsg", 'yes');	
}else{
	
$DismissLinkXY = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-help-license&dmsgr=true';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	

echo "<div class='notice notice-warning is-dismissible'>
<h3>Your License Will Expire Soon! <p class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong>You can <a style='font-weight:700;' href='https://www.recoverexit.com/your-license/?lic=".get_option('re_lic_setting')."' target='_blank'>renew your license for 50% less</a> than the price of a new license! <a style='font-size:14px; font-weight:700;' href='".esc_url($DismissLinkXY)."'>[no thanks]</a></strong></p></h3>
	</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	
	

}
}


	
$DrawArea = true;	

echo '<h1 class="recexit-title">RecoverExit Help & License</h1>';
echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';


global $rekx;

if (isset($_POST["enterlicensek"])){

$LetsCheck = rec_exit_checker(sanitize_text_field( $_POST["enterlicensek"]));	

if (strpos($LetsCheck, 'Error') !== false) {
	
$LicPage1 = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-help-license&enterlic=true&err=1&code='.sanitize_text_field( $_POST["enterlicensek"]);
wp_redirect( $LicPage1 );
exit;		

}else{

$LicPage = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-help-license';
wp_redirect( $LicPage );
exit;		
}
	

unset($DrawArea);	
}

if (isset($DrawArea)){
if (isset($_GET["enterlic"])){
	
if (isset($_GET["err"])){
echo '<div class="notice notice-error is-dismissible">
<h3>Error: License key is invalid, Please try again.</h3>
</div>';		
echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';
}	

if (isset($_GET["code"])){
echo '<form id="enterlicensek" method="POST" action=""><label for="enterlicensek">Enter Your License Key:</label><br><input type="text" class="options-box-9" id="enterlicensek" name="enterlicensek" value="'.esc_attr($_GET["code"]).'"><div style="height:16px" aria-hidden="true" class="admin-spacer"></div><button type="submit" class="green-button-ck" id="perdel">Validate License</button></form>';
}else{
echo '<form id="enterlicensek" method="POST" action=""><label for="enterlicensek">Enter Your License Key:</label><br><input type="text" class="options-box-9" id="enterlicensek" name="enterlicensek" value=""><div style="height:16px" aria-hidden="true" class="admin-spacer"></div><button type="submit" class="green-button-ck" id="perdel">Validate License</button></form>';
}

unset($DrawArea);
}
}

if (isset($DrawArea)){

if (isset($rekx)){
echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/gold-star.png"> [Premium] RecoverExit Member</p>';	

echo '<p class="clear-font-text">You are a premium member! this includes:</p>';

echo '<div style="height:6px" aria-hidden="true" class="admin-spacer"></div>';

echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/gold-star.png" height="16" width="16"> Unlimited template selection and random testing.</p>';

echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/gold-star.png" height="16" width="16"> Access to premium templates.</p>';

echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/gold-star.png" height="16" width="16"> "No Thanks" user feedback module.</p>';

echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/gold-star.png" height="16" width="16"> More accurate statistics with coupon conversion tracking.</p>';

echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/gold-star.png" height="16" width="16"> Dedicated premium support email.</p>';

echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';


echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/gold-star.png" height="22" width="22"> License Details</p>';
echo '<p class="backend-recexit-stats">Your License Key: <strong>'.get_option('re_lic_setting').'</strong></p>';
echo '<p class="backend-recexit-stats">Valid until renewal/expiry date: <strong>['.get_option('recexitexp').']</strong></p>';
echo '<p class="backend-recexit-stats">Manage License: <strong><a href="https://www.recoverexit.com/your-license/?lic='.get_option('re_lic_setting').'" target="_blank">Manage License Now</a></strong></p>';
echo '<p class="backend-recexit-stats">Premium support email: <strong>premium_support@recoverexit.com</strong></p>';


	
}else{
echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . '/assets/images/bronze-star.png">  [Free] RecoverExit Member</p>';	

echo '<p class="clear-font-text">You are a Free member, upgrade to premium to enjoy more features:</p>';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';

echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/gold-star.png" height="16" width="16"> Unlimited template selection and random testing.</p>';

echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/gold-star.png" height="16" width="16"> More accurate statistics with coupon conversion tracking.</p>';

echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/gold-star.png" height="16" width="16"> Access to premium templates.</p>';

echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/gold-star.png" height="16" width="16"> "No Thanks" user feedback module.</p>';

echo '<p class="clear-font-text"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/gold-star.png" height="16" width="16"> Dedicated premium support email.</p>';

echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';


$AdminURLForEnterLic = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-help-license&enterlic=true';


echo '<div class="button-cont">';
echo '<a class="btn-opt1" href="https://www.recoverexit.com/signup/" target="_blank" title="">UPGRADE NOW!</a>';
echo '<a class="btn-opt2" href="'.esc_url($AdminURLForEnterLic).'" title="">ENTER LICENSE</a>';
echo '</div>';

		
}
}

if (isset($DrawArea)){

// help video section
echo '<div style="height:38px" aria-hidden="true" class="admin-spacer"></div>';
echo '<p class="backend-font-heavy-big"><img src="' . plugin_dir_url(__FILE__) . 'assets/images/playicon.png" width="20px" height="20px"> [Video Tutorials]</p>';	
echo '<p class="clear-font-text">Be sure to watch these helpful video tutorials to get the most out of RecoverExit!</p>';
echo '<div style="height:38px" aria-hidden="true" class="admin-spacer"></div>';

//video 1 (RecoverExit 101)
echo '<div id="close" style="color: #00548A!important; font-size: 16px!important; font-weight: 600!important; text-decoration: underline!important;" onclick="videono1()"><img src="'. plugin_dir_url(__FILE__) .'assets/images/playicon.png" height="16" width="16"> 101: Setting up your first exit popup (1:44)</div>';
echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';
echo '<div id="VideoSection1" style="display:none;">';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<a href="https://www.youtube.com/watch?v=JYjJ4Z3gh_Y" target="_blank"><strong>Watch Video on YouTube</strong></a>';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<iframe width="912" height="513" src="https://www.youtube-nocookie.com/embed/JYjJ4Z3gh_Y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
echo '</div>';

echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';

//video 2 (Settings Explained)
echo '<div id="close" style="color: #00548A!important; font-size: 16px!important; font-weight: 600!important; text-decoration: underline!important;" onclick="videono2()"><img src="'. plugin_dir_url(__FILE__) .'assets/images/playicon.png" height="16" width="16"> Settings Explained (3:58)</div>';
echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';
echo '<div id="VideoSection2" style="display:none;">';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<a href="https://www.youtube.com/watch?v=ARov9PH_ecY" target="_blank"><strong>Watch Video on YouTube</strong></a>';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<iframe width="912" height="513" src="https://www.youtube.com/embed/ARov9PH_ecY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
echo '</div>';

echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';

//video 3 (Template Editor Tutorial)
echo '<div id="close" style="color: #00548A!important; font-size: 16px!important; font-weight: 600!important; text-decoration: underline!important;" onclick="videono3()"><img src="'. plugin_dir_url(__FILE__) .'assets/images/playicon.png" height="16" width="16"> Template Editor Tutorial (2:41)</div>';
echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';
echo '<div id="VideoSection3" style="display:none;">';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<a href="https://www.youtube.com/watch?v=a0bY_sF7Tbo" target="_blank"><strong>Watch Video on YouTube</strong></a>';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<iframe width="912" height="512" src="https://www.youtube.com/embed/a0bY_sF7Tbo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
echo '</div>';

echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';

//video 4 (Statistics Explained)
echo '<div id="close" style="color: #00548A!important; font-size: 16px!important; font-weight: 600!important; text-decoration: underline!important;" onclick="videono4()"><img src="'. plugin_dir_url(__FILE__) .'assets/images/playicon.png" height="16" width="16"> Statistics Explained (0:57)</div>';
echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';
echo '<div id="VideoSection4" style="display:none;">';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<a href="https://www.youtube.com/watch?v=YSbg28YFAfE" target="_blank"><strong>Watch Video on YouTube</strong></a>';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<iframe width="912" height="513" src="https://www.youtube.com/embed/YSbg28YFAfE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
echo '</div>';

echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';

//video 5 (Bulk Add Coupons Tool)
echo '<div id="close" style="color: #00548A!important; font-size: 16px!important; font-weight: 600!important; text-decoration: underline!important;" onclick="videono5()"><img src="'. plugin_dir_url(__FILE__) .'assets/images/playicon.png" height="16" width="16"> Bulk Add Coupons Tool (1:36)</div>';
echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';
echo '<div id="VideoSection5" style="display:none;">';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<a href="https://www.youtube.com/watch?v=wo7Fgo-lE34" target="_blank"><strong>Watch Video on YouTube</strong></a>';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<iframe width="912" height="513" src="https://www.youtube.com/embed/wo7Fgo-lE34" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
echo '</div>';

echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';

//video 6 (Bulk Add Coupons Tool)
echo '<div id="close" style="color: #00548A!important; font-size: 16px!important; font-weight: 600!important; text-decoration: underline!important;" onclick="videono6()"><img src="'. plugin_dir_url(__FILE__) .'assets/images/playicon.png" height="16" width="16"> User Feedback Module (0:50)</div>';
echo '<div style="height:18px" aria-hidden="true" class="admin-spacer"></div>';
echo '<div id="VideoSection6" style="display:none;">';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<a href="https://www.youtube.com/watch?v=-IjyTGU6_3Q" target="_blank"><strong>Watch Video on YouTube</strong></a>';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo '<iframe width="912" height="513" src="https://www.youtube.com/embed/-IjyTGU6_3Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
echo '</div>';



}

}


function recover_exit_gen_coupons(){
recexit_check_status_recoverexit();
random_recoverexit_check();	
recexit_check_re_exp_date();

if (get_option( 'recexitexpmsg' ) == true){	

if (isset($_GET["dmsgr"])){
update_option("disrecexitexpmsg", 'yes');	
}else{
	
$DismissLinkXY = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-gen-coupons&dmsgr=true';

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	

echo "<div class='notice notice-warning is-dismissible'>
<h3>Your License Will Expire Soon! <p class='backend-recexit-stats'><img src='" . plugin_dir_url(__FILE__) . "/assets/images/question.png' height='16' width='16'> <strong>You can <a style='font-weight:700;' href='https://www.recoverexit.com/your-license/?lic=".get_option('re_lic_setting')."' target='_blank'>renew your license for 50% less</a> than the price of a new license! <a style='font-size:14px; font-weight:700;' href='".esc_url($DismissLinkXY)."'>[no thanks]</a></strong></p></h3>
</div>";

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';	
	

}
}
	
$SkipNextArea = 'no';
	
if (isset($_POST["addcoupons"])){
echo '<h1 class="recexit-title">Your Coupons Were Added!</h1>';
echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';
echo '<p class="backend-recexit-stats"><mark>Please be sure to save them</mark> for later use:</p>';

///START OF BULK ADD COUPONS
$couponcodes = (explode("\n",sanitize_textarea_field($_POST["codesbox"])));

$DiscountAmount = sanitize_text_field($_POST['Amount']);
$individualuse = sanitize_text_field($_POST['individualuse']);
$typeofcode = sanitize_text_field($_POST['typeofdisc']);

echo '<div style="height:12px" aria-hidden="true" class="admin-spacer"></div>';
echo '<p class="backend-font-heavy-big">Codes Added to WooCommerce</p>';
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';

echo '<textarea id="codesbox" class="codesbox" name="codesbox" rows="10">';

foreach ($couponcodes as $codevalue) {

$codevalue = str_replace(array("\n","\r", " "), '', $codevalue);

if ($codevalue == null){
// do not add	
}else{
	
  echo $codevalue . "\n";
  
   

$coupon_code = $codevalue; // Code
$amount = $DiscountAmount; // Amount
$discount_type = $typeofcode; // Type: fixed_cart, percent, fixed_product, percent_product

$coupon = array(
'post_title' => $coupon_code,
'post_content' => '',
'post_status' => 'publish',
'post_author' => 1,
'post_type' => 'shop_coupon');

$new_coupon_id = wp_insert_post( $coupon );

// Add meta
update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
update_post_meta( $new_coupon_id, 'individual_use', $individualuse );
update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
update_post_meta( $new_coupon_id, 'free_shipping', 'no' );  
  
}
}

echo '</textarea>';

echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';

$AddMoreButtonLink = get_admin_url( null, null, null ) . 'admin.php?page=recover-exit-gen-coupons';

echo '<div class="button-cont">';
echo '<div class="btn-opt1" onclick="CopyText()">COPY CODES</div>';
echo '<a class="btn-opt2" href="'.esc_url($AddMoreButtonLink).'" title=""><< GO BACK</a>';
echo '</div>';

//END OF BULK ADD COUPONS




unset($SkipNextArea);	
}	
	
if (isset($SkipNextArea)){	

echo '<h1 class="recexit-title">RecoverExit Bulk Add Coupons</h1>';
echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';
echo '<p class="backend-recexit-stats">Bulk add coupon codes to your WooCommerce store using the tool below (10x auto generated codes in coupon code box already or you can enter your own).</p>';

// bulk adding tool;
echo '<form id="bulkadder" method="POST" action="">';

echo '<label for="typeofdisc">Choose a discount type:<br></label>
  <select id="typeofdisc" name="typeofdisc">
    <option value="percent">Percentage</option>
    <option value="fixed_cart">Fixed Cart</option>
  </select>';
  
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';

echo '<label for="Amount">Discount Amount:<br></label>';
echo '<input type="text" class="Amount" id="Amount" name="Amount" placeholder="example 10 / 3.99" value="10">';	

echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';


echo '<label for="individualuse">Individual Use Coupon?<br></label>
  <select id="individualuse" name="individualuse">
    <option value="yes">Yes</option>
    <option value="no">No</option>
  </select>';
  
echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';

echo '<label for="codesbox">Coupon Codes to Add:<br></label>';
echo '<textarea id="codesbox" class="codesbox" class="codesbox" name="codesbox" placeholder="Entercode01.." rows="10">'; 


for ($xaa = 0; $xaa <= 10; $xaa++) {//add 10 new random coupon values

if ($xaa == 10){
echo Recovexit_Generate_Random_String(7);//no new line required
}else{
echo Recovexit_Generate_Random_String(7) . "\n";
}

}

echo '</textarea>';

echo '<input type="hidden" id="addcoupons" name="addcoupons" value="yes">';

echo '<div style="height:8px" aria-hidden="true" class="admin-spacer"></div>';
echo  '<div class="gen_button_sign"><button type="submit" class="lookup-tool-search-recexit" id="AddList">ADD COUPONS NOW!</button></div></form>';

echo '<div style="height:22px" aria-hidden="true" class="admin-spacer"></div>';

echo '<p class="backend-font-heavy-big">Video Tutorial</p>';

echo '<p class="backend-recexit-stats"><img src="'.plugin_dir_url(__FILE__).'assets/images/question.png" height="16" width="16"> <a href="https://www.youtube.com/watch?v=wo7Fgo-lE34" target="_blank"><strong>Watch bulk add coupon video tutorial on YouTube (1:36)</strong></a></p>';



}
}


?>