<?php
    if (!defined('ABSPATH')) exit;
    // Script for front end

	function recover_exit ($atts) {
	
	$OptionsArray = get_option( 'RecoverExitSettings' );
	
	//handle user-feedback
	if (isset($_POST["feedbackbox"])){

	//save user feedback
	if (isset($OptionsArray["feedback_log"])){
	$UploadsDir = wp_upload_dir();
	$MasterDirectory = $UploadsDir["basedir"] . '/RecoverExit';//master folder
	$masternfeedbacklogs = $MasterDirectory . '/masterfeedback/';//user feedback & master logs
	
	$LogFileFeed = $masternfeedbacklogs.$OptionsArray["feedback_log"].'.txt';

	$StoreFeedback = date("d-M-Y @ H:i") . ' | ' . sanitize_text_field($_POST["feedbackbox"]);

	file_put_contents($LogFileFeed, $StoreFeedback.PHP_EOL , FILE_APPEND);
	}
	
	//die();	
	$SkipTheRest = 'yes';
	}
	
	if (!isset($SkipTheRest)){
	
	//handle user hitting discount button	
	if (isset($_POST["discount"])){
	global $woocommerce;
	
	$UploadsDir = wp_upload_dir();
	$MasterDirectory = $UploadsDir["basedir"] . '/RecoverExit';//master folder
	$UserEditedTemplatesDir = $MasterDirectory . '/templates/';//for user edited templates
	$masternfeedbacklogs = $MasterDirectory . '/masterfeedback/';//user feedback & master logs
	$TemplateLogsDir = $MasterDirectory . '/logs/';//for template stats
	
	if (isset($_POST["tpf"])){
	include ($UserEditedTemplatesDir.$_POST["tpf"].'.php');	
	$DiscoCode = $CheckOutCode;	
	}else{
	$DiscoCode = 'bestoffer';	
	}
	
	//raw log;
	$LogFile = $masternfeedbacklogs . 'log.txt';
	$LocalLog = date("d M Y") . ' @ ' . date("H:i:s") . ',DISCOUNT-BUTTON-CLICKED,' . sanitize_text_field($_POST["tpf"]);
	file_put_contents($LogFile, $LocalLog.PHP_EOL , FILE_APPEND);
	
	//convert template log - >

	//check folder exists, if not create it:
	if (!file_exists($TemplateLogsDir.$_POST['tpf'])) {
	wp_mkdir_p($TemplateLogsDir.sanitize_text_field($_POST['tpf']), 0777, true);
	}
	
	$convertlogdata = sanitize_text_field($_POST['uid1']).','.date("d M Y") . ' @ ' . date("H:i:s");
	$convertlogfile = $TemplateLogsDir.sanitize_text_field($_POST['tpf']).'/convert.txt';
	
	//to avoid anti dupe CTR recording
	$laststoredUID = $TemplateLogsDir.sanitize_text_field($_POST['tpf']).'/lastuid.txt';
	
	if (file_exists($laststoredUID)){
	//check for anti-dupe
	$fch = fopen($laststoredUID, 'r');
	$lineread = fgets($fch);
	fclose($fch);
		
	if ($_POST['uid1'] == $lineread){
	// double click duplicate, do not store.	
	}else{
	$StoreCTR = 'yes';//not a duplicate, store for stats	
	}

	}else{
	$StoreCTR = 'yes';	
	}


	if (isset($StoreCTR)){
	//store CTR data
	file_put_contents($convertlogfile, $convertlogdata.PHP_EOL , FILE_APPEND);
	
	//save button click counter;
	$ClickedX = get_option('RE_conversion_Counter');
	$ClickedX++;
	update_option("RE_conversion_Counter", $ClickedX);
	}
	
	//store anti-dupe file
	if (file_exists($laststoredUID)){
	unlink($laststoredUID);	
	}
	file_put_contents($laststoredUID, sanitize_text_field($_POST['uid1']));
	

	
	//remove any existing coupons to avoid error
	WC()->cart->remove_coupons();
	
	// apply coupon
	if (!$woocommerce->cart->add_discount( sanitize_text_field( $DiscoCode ))) {
	}	
	}else{
		
	
	if (isset($OptionsArray['selected_template'])){
	
	$selecttemparray = ($OptionsArray['selected_template']);
	
	$ValuesSelected = count($selecttemparray);
	
	if ($ValuesSelected == 1){//only 1 template set
	$TempToUse = $selecttemparray[0];
	//$TempToUse = str_replace("template","",$TempToUse);
	}else{//more than 1 template set [pick at random]
	$k1 = array_rand($selecttemparray);
	$v1 = $selecttemparray[$k1];
	$TempToUse = $v1;
	}

	}else{
	// failsafe if array not set	
	//$TempToUse = 'SkyBlue [Free]';	
	die();
	}
	
	//dark background checkout/cart overlay
	if (isset($OptionsArray["background_setting"])){
	if ($OptionsArray["background_setting"] == 'Yes'){
	echo wp_kses_post('<div id="overlaybox" class="overlay-box">');
	}
	}

	$UploadsDir = wp_upload_dir();
	$MasterDirectory = $UploadsDir["basedir"] . '/RecoverExit';//master folder
	
	$UserEditedTemplatesDir = $MasterDirectory . '/templates/';//for user edited templates

	
	$TemplateFile = $UserEditedTemplatesDir.$TempToUse.'.php';

	if (file_exists($TemplateFile)){
	include ($UserEditedTemplatesDir.$TempToUse.'.php');
	
	if (isset($BackgroundType)){
		
	if ($BackgroundType == 1){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="display: none; background-color: <?php echo esc_html($BackgroundColor) ?>!important; border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">	
	<?php	
	}
	if ($BackgroundType == 2){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="display: none; background-color: <?php echo esc_html($BackgroundColor) ?>!important; background-image: linear-gradient(180deg, <?php echo esc_html($BackGroundGradCol1) ?> 0%, <?php echo esc_html($BackGroundGradCol2) ?> 100%); border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">
	<?php	
	}
	if ($BackgroundType == 3){
	?>
	<div id="lcwindow" class="checkout-spec-oo" style="display: none; background: repeating-linear-gradient( 45deg, <?php echo esc_html($BackGroundGradCol1) ?>, <?php echo esc_html($BackGroundGradCol1) ?> 10px, <?php echo esc_html($BackGroundGradCol2) ?> 20px, <?php echo esc_html($BackGroundGradCol2) ?> 40px)!important; border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">
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
		<button type="submit" id="applyofferbutton" onclick="applyingtext()" class="buttoncostyle" style="background-color: <?php echo esc_html($ButtonBackgroundColor) ?>!important; color: <?php echo esc_html($ButtonTextColor) ?>!important; margin-top: 10px!important; margin-bottom: 10px!important; border-radius: 5px!important; font-size: <?php echo esc_html($ButtonFont) ?>!important; margin-top: 20px!important; margin-bottom: 18px!important;"><b><?php echo esc_html($ButtonText) ?></b></button>
		</form>
       	<div id="close" style="color: <?php echo esc_html($CloseTextCol) ?>!important; text-align: <?php echo esc_html($CloseTextAlign) ?>!important; z-index: 1004!important; padding-left: <?php echo esc_html($ClosePaddingLeft) ?>!important; padding-right: <?php echo esc_html($ClosePaddingRight) ?>!important; font-size: 16px!important; font-weight: 600!important; margin-top: 15px!important; margin-bottom:25px!important; text-decoration: underline!important;" onclick="closebox()"><?php echo esc_html($CloseText) ?></div>
    </div>
</div>
	
	
	<?php
	}
	//echo $Template;

	
	echo wp_kses_post('</div>');
	
	
	//no thanks feedback window
	if (isset($OptionsArray["feedback_setting"])){
	if ($OptionsArray["feedback_setting"] == 'Yes'){
	// 	return feedback template
	include (plugin_dir_path(__FILE__) . 'assets/feedbacktemplate/feedback.php');
	//echo $FeedBackTemplate;
	
	?>
	
<div id="lcwindowfb" class="checkout-spec-oofb" style="display: none; background-color: <?php echo esc_html($BackgroundColor) ?>!important; background-image: linear-gradient(180deg, <?php echo esc_html($BackGroundGradCol1) ?> 0%, <?php echo esc_html($BackGroundGradCol2) ?> 100%); border-style: <?php echo esc_html($BorderStyle) ?>!important; border-color: <?php echo esc_html($Bordercolour) ?>!important; border-radius: <?php echo esc_html($BorderRadius) ?>!important;">
<div class="inner-window-checkout">
<p style="margin-top:25px!important; font-size: <?php echo esc_html($SubHeaderFontSize) ?>; font-weight: <?php echo esc_html($SubHeaderWeight) ?>; color: <?php echo esc_html($SubHeaderColour) ?>; text-align: center; margin-bottom: <?php echo esc_html($SubHeaderMarginBottom) ?>!important;"><?php echo esc_html($SubHeaderText) ?></p>
<form id="userfeedback" method="POST" action="">
<textarea id="feedbackbox" name="feedbackbox" style="background-color: #fff!important; font-size:18px!important; width:85%!important;" rows="5" placeholder="Tell us how to improve.."></textarea>
<input name="userfeedback" type="hidden" value="<?php echo esc_attr(true) ?>">
<button type="submit" class="buttoncostyle" style="background-color: <?php echo esc_html($ButtonBackgroundColor) ?>!important; color: <?php echo esc_html($ButtonTextColor) ?>!important; margin-top: 10px!important; margin-bottom: 10px!important; border-radius: 5px!important; font-size: <?php echo esc_html($ButtonFont) ?>!important; margin-top: 20px!important; margin-bottom: 18px!important;"><b><?php echo esc_html($ButtonText) ?></b></button>
</form>
<div id="close" style="color: <?php echo esc_html($CloseTextCol) ?>!important; text-align: <?php echo esc_html($CloseTextAlign) ?>!important; z-index: 1003!important; padding-left: <?php echo esc_html($ClosePaddingLeft) ?>!important; padding-right: <?php echo esc_html($ClosePaddingRight) ?>!important; font-size: 16px!important; font-weight: 600!important; margin-top: 15px!important; margin-bottom:25px!important; text-decoration: underline!important;" onclick="closefbox()"><?php echo esc_html($CloseText) ?></div></div></div>
	
	
	<?php
	
	
	
	}
	}
	
	//dark background checkout/cart overlay
	if (isset($OptionsArray["background_setting"])){
	if ($OptionsArray["background_setting"] == 'Yes'){
	echo wp_kses_post('</div>');
	}
	}	
	

	//enque styles and scripts
	wp_enqueue_style( 'recoverexitstyle', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
	wp_enqueue_script( 'recoverexitscripts', plugin_dir_url( __FILE__ ) . 'assets/js/CartExit.js' );
    
		
	$scriptData = array(
        'time_length' => $OptionsArray['time_length'],
		'scroll_speed' => $OptionsArray['scroll_speed'],
		'overall_sc' => get_option('RE_Total_Counter'),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'uid' => $TemplateID,
		'fbt' => $OptionsArray["feedback_setting"],
		'bgover' => $OptionsArray["background_setting"],
    );	
	wp_localize_script('recoverexitscripts', 'my_options', $scriptData);
		
	
	}//end of if template file exists.
			}
		
	}

	}

?>