<?php
/*
Plugin Name: Rainbowify
Description: The WordPress user interface needs more rainbows. And Nyan.
Author: Otto
Author URI: http://ottopress.com
Version: 1.0
*/

add_action( 'wp_head', 'rainbowify_admin_bar' );
add_action( 'admin_head', 'rainbowify_admin_bar' );
function rainbowify_admin_bar() {
?>
<style type="text/css">
@-moz-keyframes rainbow1 {
	0% { background-position: 0 0; }
	49.99% { background-position: 0 0; }
	50% { background-position: 0 5px; }
	99.99% { background-position: 0 5px; }
	100% { background-position: 0 0; }
}
@-webkit-keyframes rainbow1 {
	0% { background-position: 0 0; }
	49.99% { background-position: 0 0; }
	50% { background-position: 0 5px; }
	99.99% { background-position: 0 5px; }
	100% { background-position: 0 0; }
}
@keyframes rainbow1 {
	0% { background-position: 0 0; }
	49.99% { background-position: 0 0; }
	50% { background-position: 0 5px; }
	99.99% { background-position: 0 5px; }
	100% { background-position: 0 0; }
}
@-moz-keyframes rainbow2 {
	0% { background-position: 0 5px; }
	49.99% { background-position: 0 5px; }
	50% { background-position: 0 0; }
	99.99% { background-position: 0 0; }
	100% { background-position: 0 5px; }
}
@-webkit-keyframes rainbow2 {
	0% { background-position: 0 5px; }
	49.99% { background-position: 0 5px; }
	50% { background-position: 0 0; }
	99.99% { background-position: 0 0; }
	100% { background-position: 0 5px; }
}
@keyframes rainbow2 {
	0% { background-position: 0 5px; }
	49.99% { background-position: 0 5px; }
	50% { background-position: 0 0; }
	99.99% { background-position: 0 0; }
	100% { background-position: 0 5px; }
}
#wpadminbar, #wpadminbar ul.ab-top-menu>li {
  background-image:-webkit-linear-gradient(top, #d91a12 15%,#e13300 15%,#ff7f14 16%,#f2ab03 32%,#ebc000 32%,#fade00 33%,#efff03 48%,#56fc02 49%,#52ff01 66%,#4ade7e 67%,#3baaf2 67%,#3baaf2 84%,#7337f7 84%,#6b40f2 100%);
  background-image:-moz-linear-gradient(top, #d91a12 15%,#e13300 15%,#ff7f14 16%,#f2ab03 32%,#ebc000 32%,#fade00 33%,#efff03 48%,#56fc02 49%,#52ff01 66%,#4ade7e 67%,#3baaf2 67%,#3baaf2 84%,#7337f7 84%,#6b40f2 100%);
  background-image:linear-gradient(top, #d91a12 15%,#e13300 15%,#ff7f14 16%,#f2ab03 32%,#ebc000 32%,#fade00 33%,#efff03 48%,#56fc02 49%,#52ff01 66%,#4ade7e 67%,#3baaf2 67%,#3baaf2 84%,#7337f7 84%,#6b40f2 100%);
  -moz-animation:rainbow1 0.3s linear 0s infinite;
  -webkit-animation:rainbow1 0.3s linear 0s infinite;
  animation:rainbow1 0.3s linear 0s infinite;
  background-size:100% 32px;
}
#wpadminbar ul.ab-top-menu>li:nth-child(even) {
  -moz-animation:rainbow2 0.3s linear 0s infinite;
  -webkit-animation:rainbow2 0.3s linear 0s infinite;
  animation:rainbow2 0.3s linear 0s infinite;
}
#wpadminbar .quicklinks > ul > li > a ,
#wpadminbar .quicklinks > ul > li,
#wpadminbar .quicklinks > ul > li.opposite,
#wpadminbar .quicklinks > ul > li.opposite a {
border-color:transparent !important;
}
#wpadminbar .ab-top-secondary {
background-color:transparent;
background-image:none;
}
</style>
<?php
}

add_action( 'admin_bar_menu', 'rainbowify_nyan', 1 );
function rainbowify_nyan( $wp_admin_bar ) {
	$wp_admin_bar->add_menu( array(
		'id'    => 'rainbowify',
		'title' => '<img src="'.plugins_url( 'nyancat.gif', __FILE__ ).'" style="height:39px; width:auto "/>',
		'parent' => 'top-secondary',
		'meta'  => array(
		),
	) );
}
