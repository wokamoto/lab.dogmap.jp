<?php
/*
 Plugin Name: Really Static Amazon S3 Plugin
 Plugin URI: http://www.sorben.org/really-static/plugin-amazons3.html
 Description:  adding Amazon S3 functionality to really-static; thanks to Peter van Eijk for support
 Author: Erik Sefkow
 Version: 0.1
 */


add_action("rs-aboutyourplugin",create_function('','echo "<b>Amazon-S3 (v0.1):</b> programmed by Erik Sefkow, thanks to Peter van Eijk<br>";'));

add_filter("rs-transport","amazons3functions");
function amazons3functions($transportfuntions){
$transportfuntions[amazons3]=array("rs_amazons3_connect","rs_amazons3_disconnect",
	"rs_amazons3_writefile","rs_amazons3_deletefile","rs_amazons3_writecontent","rs_amazons3_isconnected","rs_amazons3_saveoptions");
return $transportfuntions;
}
add_filter("rs-adminmenu-transport","amazons3admin");
function amazons3admin($array){
#if (get_option ( "ftpsaveroutine" ) === false)add_option ( "ftpsaveroutine",1, '', 'yes' );

$array[]=array(name=>"amazons3",title=>__('work with Amazon S3', 'reallystatic'),main=>'<div style="margin-left:50px;"><table border="0" width="100%"><tr><td width="350px">'.__('accessKey', 'reallystatic').'</td><td>:<input name="realstaticamazons3accessKey" size="50" type="text" value="' . loaddaten ( "realstaticamazons3accessKey" , 'reallystatic') . '"	/></td></tr>'
. '<tr><td>'.__('SecretKey', 'reallystatic').'</td><td>:<input name="realstaticamazons3secretKey" size="50" type="text" value="' . loaddaten ( "realstaticamazons3secretKey", 'reallystatic' ) . '"	/></td></tr>'
. '<tr><td>'.__('Bucket', 'reallystatic').'</td><td>:<input name="realstaticamazons3bucket" size="50" type="text" value="' . loaddaten ( "realstaticamazons3bucket", 'reallystatic' ) . '"	/>.s3.amazonaws.com</td></tr>'
. '<tr><td valign="top">'.__('path from rootfolder to folder with staticfiles', 'reallystatic').'</td><td>:<input name="realstaticamazons3remotepath" size="50" type="text" value="' . loaddaten ( "realstaticamazons3remotepath" , 'reallystatic') . '"	/> <a style="cursor:pointer;"  onclick="toggleVisibility(\'internalftppfad\');" >[?]</a>
	<div style="max-width:500px; text-align:left; display:none" id="internalftppfad">('.__('the path inside your FTP account e.g. "/path/".If it should saved to maindirectory write "/" ', 'reallystatic').')</div></td></tr>'
. '
</table></div><br>');
return $array;

}

#if($_POST ['strid'] == "rs_destination" and $_POST['realstaticspeicherart']=="amazons3"){
function rs_amazons3_saveoptions(){
	global $rs_messsage;
	update_option ( 'realstaticamazons3bucket', $_POST ['realstaticamazons3bucket'] );
	update_option ( 'realstaticamazons3accessKey', $_POST ['realstaticamazons3accessKey'] );
	update_option ( 'realstaticamazons3secretKey', $_POST ['realstaticamazons3secretKey'] );
	update_option ( 'realstaticamazons3remotepath', $_POST ['realstaticamazons3remotepath'] );
	if(substr ( $_POST ['realstaticamazons3remotepath'], - 1 ) != "/")$rs_messsage[e][]= __("You may forgot a / at the end of the path!", "reallystatic" );
	 
	$rs_messsage[o][]= __("Saved", "reallystatic" );
 
}
register_activation_hook ( __FILE__, 'rs_amazons3_activate' );
function rs_amazons3_activate() {
	$a=RSVERSION;
	$b=RSSUBVERSION;
	if(RSVERSION=="" or RSVERSION=="RSVERSION"){
		deactivate_plugins ( $_GET ['plugin'] );
		die ("Please first install/activate Really-Static");
	}
	if(($a+0.0001*$b)<0.3191 ){
		deactivate_plugins ( $_GET ['plugin'] );
		die ("PLEASE UPDATE REALLY-STATIC!$a$b--".RSVERSION);
	}
	@include_once 'S3.php';
	if (!class_exists('S3')){
		deactivate_plugins ( $_GET ['plugin'] );
		die ("Missing S3.php file! Please read the <a target='_blank' href='http://www.sorben.org/really-static/plugin-amazon-s3.html'>instructions</a>");
	}
 }

function rs_amazons3_connect(){
	require_once 'S3.php';
	global $rs_amazons3_connect;
	$rs_amazons3_connect = new S3(get_option('realstaticamazons3accessKey'), get_option('realstaticamazons3secretKey'));
}
function rs_amazons3_disconnect(){
	global $rs_amazons3_connect;
	unset($rs_amazons3_connect);
}
function rs_amazons3_writefile($ziel, $quelle){
	global $rs_amazons3_connect;
	if (!$rs_amazons3_connect->putObjectFile($quelle, get_option("realstaticamazons3bucket"), substr(get_option('realstaticamazons3remotepath'),1).$ziel, S3::ACL_PUBLIC_READ, array(),amazons3mine($ziel))) {
		echo "<strong>Something went wrong while uploading your file $ziel sorry.</strong>";
	}
	return substr(get_option('realstaticamazons3remotepath'),1).$ziel;
}
function rs_amazons3_deletefile($datei){
	global $rs_amazons3_connect;
	$rs_amazons3_connect->deleteObject( get_option("realstaticamazons3bucket"),  substr(get_option('realstaticamazons3remotepath'),1).$datei);
	return substr(get_option('realstaticamazons3remotepath'),1).$ziel;
}



function rs_amazons3_writecontent($ziel,$content){
	global $rs_amazons3_connect;
	if (!$rs_amazons3_connect->putObjectString($content, get_option("realstaticamazons3bucket"),  substr(get_option('realstaticamazons3remotepath'),1).$ziel, S3::ACL_PUBLIC_READ, array(),amazons3mine($ziel))) {
		echo "<strong>Something went wrong while uploading your file $ziel sorry.</strong>";
	}
	return substr(get_option('realstaticamazons3remotepath'),1).$ziel;
}


function rs_amazons3_isconnected(){
	global $rs_amazons3_connect;
	if(isset($rs_amazons3_connect))return true;
	else return false;
}


















function amazons3mine($fileName){

	$exts= array("xml"=>"text/xml","323" => "text/h323", "acx" => "application/internet-property-stream", "ai" => "application/postscript", "aif" => "audio/x-aiff", "aifc" => "audio/x-aiff", "aiff" => "audio/x-aiff",
        "asf" => "video/x-ms-asf", "asr" => "video/x-ms-asf", "asx" => "video/x-ms-asf", "au" => "audio/basic", "avi" => "video/quicktime", "axs" => "application/olescript", "bas" => "text/plain", "bcpio" => "application/x-bcpio", "bin" => "application/octet-stream", "bmp" => "image/bmp",
        "c" => "text/plain", "cat" => "application/vnd.ms-pkiseccat", "cdf" => "application/x-cdf", "cer" => "application/x-x509-ca-cert", "class" => "application/octet-stream", "clp" => "application/x-msclip", "cmx" => "image/x-cmx", "cod" => "image/cis-cod", "cpio" => "application/x-cpio", "crd" => "application/x-mscardfile",
        "crl" => "application/pkix-crl", "crt" => "application/x-x509-ca-cert", "csh" => "application/x-csh", "css" => "text/css", "dcr" => "application/x-director", "der" => "application/x-x509-ca-cert", "dir" => "application/x-director", "dll" => "application/x-msdownload", "dms" => "application/octet-stream", "doc" => "application/msword",
        "dot" => "application/msword", "dvi" => "application/x-dvi", "dxr" => "application/x-director", "eps" => "application/postscript", "etx" => "text/x-setext", "evy" => "application/envoy", "exe" => "application/octet-stream", "fif" => "application/fractals", "flr" => "x-world/x-vrml", "gif" => "image/gif",
        "gtar" => "application/x-gtar", "gz" => "application/x-gzip", "h" => "text/plain", "hdf" => "application/x-hdf", "hlp" => "application/winhlp", "hqx" => "application/mac-binhex40", "hta" => "application/hta", "htc" => "text/x-component", "htm" => "text/html", "html" => "text/html",
        "htt" => "text/webviewhtml", "ico" => "image/x-icon", "ief" => "image/ief", "iii" => "application/x-iphone", "ins" => "application/x-internet-signup", "isp" => "application/x-internet-signup", "jfif" => "image/pipeg", "jpe" => "image/jpeg", "jpeg" => "image/jpeg", "jpg" => "image/jpeg",
        "js" => "application/x-javascript", "latex" => "application/x-latex", "lha" => "application/octet-stream", "lsf" => "video/x-la-asf", "lsx" => "video/x-la-asf", "lzh" => "application/octet-stream", "m13" => "application/x-msmediaview", "m14" => "application/x-msmediaview", "m3u" => "audio/x-mpegurl", "man" => "application/x-troff-man",
        "mdb" => "application/x-msaccess", "me" => "application/x-troff-me", "mht" => "message/rfc822", "mhtml" => "message/rfc822", "mid" => "audio/mid", "mny" => "application/x-msmoney", "mov" => "video/quicktime", "movie" => "video/x-sgi-movie", "mp2" => "video/mpeg", "mp3" => "audio/mpeg",
        "mpa" => "video/mpeg", "mpe" => "video/mpeg", "mpeg" => "video/mpeg", "mpg" => "video/mpeg", "mpp" => "application/vnd.ms-project", "mpv2" => "video/mpeg", "ms" => "application/x-troff-ms", "mvb" => "application/x-msmediaview", "nws" => "message/rfc822", "oda" => "application/oda",
        "p10" => "application/pkcs10", "p12" => "application/x-pkcs12", "p7b" => "application/x-pkcs7-certificates", "p7c" => "application/x-pkcs7-mime", "p7m" => "application/x-pkcs7-mime", "p7r" => "application/x-pkcs7-certreqresp", "p7s" => "application/x-pkcs7-signature", "pbm" => "image/x-portable-bitmap", "pdf" => "application/pdf", "pfx" => "application/x-pkcs12",
        "pgm" => "image/x-portable-graymap", "pko" => "application/ynd.ms-pkipko", "pma" => "application/x-perfmon", "pmc" => "application/x-perfmon", "pml" => "application/x-perfmon", "pmr" => "application/x-perfmon", "pmw" => "application/x-perfmon", "png" => "image/png", "pnm" => "image/x-portable-anymap", "pot" => "application/vnd.ms-powerpoint", "ppm" => "image/x-portable-pixmap",
        "pps" => "application/vnd.ms-powerpoint", "ppt" => "application/vnd.ms-powerpoint", "prf" => "application/pics-rules", "ps" => "application/postscript", "pub" => "application/x-mspublisher", "qt" => "video/quicktime", "ra" => "audio/x-pn-realaudio", "ram" => "audio/x-pn-realaudio", "ras" => "image/x-cmu-raster", "rgb" => "image/x-rgb",
        "rmi" => "audio/mid", "roff" => "application/x-troff", "rtf" => "application/rtf", "rtx" => "text/richtext", "scd" => "application/x-msschedule", "sct" => "text/scriptlet", "setpay" => "application/set-payment-initiation", "setreg" => "application/set-registration-initiation", "sh" => "application/x-sh", "shar" => "application/x-shar",
        "sit" => "application/x-stuffit", "snd" => "audio/basic", "spc" => "application/x-pkcs7-certificates", "spl" => "application/futuresplash", "src" => "application/x-wais-source", "sst" => "application/vnd.ms-pkicertstore", "stl" => "application/vnd.ms-pkistl", "stm" => "text/html", "svg" => "image/svg+xml", "sv4cpio" => "application/x-sv4cpio",
        "sv4crc" => "application/x-sv4crc", "t" => "application/x-troff", "tar" => "application/x-tar", "tcl" => "application/x-tcl", "tex" => "application/x-tex", "texi" => "application/x-texinfo", "texinfo" => "application/x-texinfo", "tgz" => "application/x-compressed", "tif" => "image/tiff", "tiff" => "image/tiff",
        "tr" => "application/x-troff", "trm" => "application/x-msterminal", "tsv" => "text/tab-separated-values", "txt" => "text/plain", "uls" => "text/iuls", "ustar" => "application/x-ustar", "vcf" => "text/x-vcard", "vrml" => "x-world/x-vrml", "wav" => "audio/x-wav", "wcm" => "application/vnd.ms-works",
        "wdb" => "application/vnd.ms-works", "wks" => "application/vnd.ms-works", "wmf" => "application/x-msmetafile", "wps" => "application/vnd.ms-works", "wri" => "application/x-mswrite", "wrl" => "x-world/x-vrml", "wrz" => "x-world/x-vrml", "xaf" => "x-world/x-vrml", "xbm" => "image/x-xbitmap", "xla" => "application/vnd.ms-excel",
        "xlc" => "application/vnd.ms-excel", "xlm" => "application/vnd.ms-excel", "xls" => "application/vnd.ms-excel", "xlt" => "application/vnd.ms-excel", "xlw" => "application/vnd.ms-excel", "xof" => "x-world/x-vrml", "xpm" => "image/x-xpixmap", "xwd" => "image/x-xwindowdump", "z" => "application/x-compress", "zip" => "application/zip");
		
		$ext = strToLower(pathInfo($fileName, PATHINFO_EXTENSION));
		$mine= isset($exts[$ext]) ? $exts[$ext] : 'application/octet-stream';
return $mine;
}
?>