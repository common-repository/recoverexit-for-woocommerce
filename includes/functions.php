<?php


add_action('admin_menu', 'recoverexit_woo_admin_menu');
add_action('admin_head', 'reocverexit_woo_admin_styles');

//register_settings
register_setting( 'RE_Total_Counter', 'RE_Total_Counter' );
register_setting( 'RE_conversion_Counter', 'RE_conversion_Counter' );
register_setting( 'recoverexitvalid', 'recoverexitvalid' );
register_setting( 'randomrecoverexitcheck', 'randomrecoverexitcheck' );
register_setting( 're_lic_setting', 're_lic_setting' );
register_setting( 'recexitexp', 'recexitexp' );
register_setting( 'recexitexpmsg', 'recexitexpmsg' );
register_setting( 'disrecexitexpmsg', 'disrecexitexpmsg' );

// set to 0 if counter does not exist//
if (esc_attr( get_option('RE_Total_Counter') ) == ""){
update_option("RE_Total_Counter", 0);
}

// set to 0 if counter does not exist
if (esc_attr( get_option('RE_conversion_Counter') ) == ""){
update_option("RE_conversion_Counter", 0);
}

function Recovexit_Generate_Random_String($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function recexit_check_status_recoverexit() {

if (esc_attr( get_option('recoverexitvalid') ) == ""){
//nothing
}else{
global $rekx;	
$rekx = get_option('recoverexitvalid');
}	

}//end of function


function recexit_check_re_exp_date() {

if (esc_attr( get_option('recexitexp') ) == ""){
//nothing to do
}else{
	
$expdate = get_option('recexitexp');
$tnow = time();
$theexpdate = strtotime($expdate);
$datediffxx = $theexpdate - $tnow;
$remainingdd = round($datediffxx / (60 * 60 * 24));

if ($remainingdd < 1){
delete_option( 're_lic_setting' );
delete_option( 'recoverexitvalid' );
delete_option( 'recexitexp' );	
}	

if ($remainingdd < 30){

update_option("recexitexpmsg", true);	
	
if (get_option( 'disrecexitexpmsg' ) == 'yes'){	
update_option("recexitexpmsg", false);
}

}else{
delete_option( 'recexitexpmsg' );
delete_option( 'disrecexitexpmsg' );
}

}
}

function random_recoverexit_check() {
	
if (esc_attr( get_option('randomrecoverexitcheck') ) == ""){
update_option("randomrecoverexitcheck", 0);		
}else{
$NewOpt = get_option('randomrecoverexitcheck');	
++$NewOpt;
update_option("randomrecoverexitcheck", $NewOpt);		
}
	
if (get_option('randomrecoverexitcheck') >= 15){
$json_call_recoverexit = json_decode(wp_remote_retrieve_body(wp_remote_get( 'https://www.recoverexit.com/chk/?au=323346343463481&site=' . get_option( 'siteurl' ) . '&lic='.get_option('re_lic_setting'))), true);
if (isset($json_call_recoverexit["returned"])){
if ($json_call_recoverexit["returned"] > 10000){
if (isset($json_call_recoverexit["exp"])){
delete_option( 'recexitexp' );
update_option("recexitexp", $json_call_recoverexit["exp"]);
}		
}else{
delete_option( 're_lic_setting' );
delete_option( 'recoverexitvalid' );
delete_option( 'recexitexp' );
}	
}
update_option("randomrecoverexitcheck", 0);	
	
}
}//end of function


function rec_exit_checker($CheckValue) {

$json_call_recoverexit = json_decode(wp_remote_retrieve_body(wp_remote_get( 'https://www.recoverexit.com/chk/?au=323346343463481&site=' . get_option( 'siteurl' ) . '&lic='.$CheckValue)), true);
if (isset($json_call_recoverexit["returned"])){
if ($json_call_recoverexit["returned"] > 10000){
delete_option( 'recoverexitvalid' );//remove old settings
delete_option( 're_lic_setting' );//remove old settings
update_option("recoverexitvalid", 'yes');	
update_option("re_lic_setting", $CheckValue);
if (isset($json_call_recoverexit["exp"])){
delete_option( 'recexitexp' );//remove old settings
update_option("recexitexp", $json_call_recoverexit["exp"]);
}	
return 'AA';
}else{
return 'Error 1';	
}	
}else{
return 'Error 1';	
}
}//end of function

?>