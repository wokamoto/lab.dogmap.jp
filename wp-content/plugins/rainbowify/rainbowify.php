<?php 
/* 
Plugin Name: Rainbowify
Description: The WordPress user interface needs more rainbows.
Author: Otto
Author URI: http://ottopress.com
Version: 0.3
*/

add_action( 'wp_head', 'rainbowify_admin_bar' );
add_action( 'admin_head', 'rainbowify_admin_bar' );
function rainbowify_admin_bar() {
?>
<style type="text/css">
/*
 * CSS animated rainbow dividers of awesome 
 * by Chris Heilmann @codepo8 and Lea Verou @leaverou
 * http://codepo8.github.com/CSS3-Rainbow-Dividers/
 *
 * Modified for WordPress admin bar by Otto 
 * #blamekoop
**/
@-moz-keyframes charlieeee {
  from { background-position:top left; } 
  to {background-position:top right; }
}
@-webkit-keyframes charlieeee { 
  from { background-position:top left; }  
  to { background-position:top right; }  
}
@-o-keyframes charlieeee { 
  from { background-position:top left; }  
  to { background-position:top right; }  
}
@-ms-keyframes charlieeee { 
  from { background-position:top left; }  
  to { background-position:top right; }  
}
@-khtml-keyframes charlieeee { 
  from { background-position:top left; }  
  to { background-position:top right; }  
}
@keyframes charlieeee { 
  from { background-position:top left; }  
  to { background-position:top right; }  
}
#wpadminbar, #comment, #author, #email, #url {
  background-image:-webkit-linear-gradient( left, red, orange, yellow, green,
                                          blue, indigo, violet, indigo, blue,
                                          green, yellow, orange, red );
  background-image:-moz-linear-gradient( left, red, orange, yellow, green,
                                         blue,indigo, violet, indigo, blue,
                                         green, yellow, orange,red );
  background-image:-o-linear-gradient( left, red, orange, yellow, green,
                                         blue,indigo, violet, indigo, blue,
                                         green, yellow, orange,red );
  background-image:-ms-linear-gradient( left, red, orange, yellow, green,
                                         blue,indigo, violet, indigo, blue,
                                         green, yellow, orange,red );
  background-image:-khtml-linear-gradient( left, red, orange, yellow, green,
                                         blue,indigo, violet, indigo, blue,
                                         green, yellow, orange,red );
  background-image:linear-gradient( left, red, orange, yellow, green,
                                         blue,indigo, violet, indigo, blue,
                                         green, yellow, orange,red );
  -moz-animation:charlieeee 2.5s forwards linear infinite;
  -webkit-animation:charlieeee 2.5s forwards linear infinite;
  -o-animation:charlieeee 2.5s forwards linear infinite;
  -khtml-animation:charlieeee 2.5s forwards linear infinite;
  -ms-animation:charlieeee 2.5s forwards linear infinite;
  -lynx-animation:charlieeee 2.5s forwards linear infinite;
  animation:charlieeee 2.5s forwards linear infinite;
  background-size:50% auto;
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
