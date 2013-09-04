<?php
/*
Plugin Name: Hacks
Plugin URI: 
Description: 
Version: 0.1
Author: 
Author URI: 
*/
$hack_dir = trailingslashit(dirname(__FILE__)) . 'hacks/';
opendir($hack_dir);
while(($ent = readdir()) !== false) {
	if(!is_dir($ent) && strtolower(substr($ent,-4)) == ".php") {
		include_once($hack_dir.$ent);
	}
}
closedir();

/*
add_filter('crazy_bone::admin_menu_capability', 'crazy_bone_capability');
function crazy_bone_capability(){
	return 'edit_users';
}
*/

add_filter('views_edit-post', 'add_export_link');
function add_export_link( $views ){
	$views[] = sprintf(
		'<a href="%s">エクスポート</a>',
		esc_attr(site_url('/wp-admin/export.php?download=true&content=posts'))
		);
	return $views;
}

function wp_embed_handler_image( $matches, $attr, $url, $rawattr ) {
    $embed = sprintf(
            '<img src="%1$s" />',
            esc_attr($matches[0])
            );
    return apply_filters( 'embed_image', $embed, $matches, $attr, $url, $rawattr );
}
wp_embed_register_handler( 'image', '/^https?(:\/\/[-_\.!~*\'()a-zA-Z0-9;\/:\@=+\$,%#]+)(\.jpe?g|\.gif|\.png)$/', 'wp_embed_handler_image' );

add_action('wp_enqueue_scripts', function(){
	wp_dequeue_style('twentytwelve-fonts');
	}, 11);

function nginx_flush_cache( $url ) {
	if ( !$url )
		return;
	$log_file = dirname(__FILE__) . '/nginx_flush_cache.log';
	$response = wp_remote_get('http://175.41.250.186/purge/?url=' . rawurlencode($url));
	if( !is_wp_error( $response ) && $response["response"]["code"] === 200 ) {
		file_put_contents($log_file, $url.' : '.$response["body"]."\n", FILE_APPEND);
	} else {
		file_put_contents($log_file, $url."\n", FILE_APPEND);
	}
}
add_action('nginxchampuru_flush_cache', 'nginx_flush_cache');

//**********************************************************************************
//  applied to the comment author's IP address prior to saving the comment in the database.
//**********************************************************************************
function auto_reverse_proxy_pre_comment_user_ip() {
	if ( isset($_SERVER['X_FORWARDED_FOR']) && !empty($_SERVER['X_FORWARDED_FOR']) ) {
		$X_FORWARDED_FOR = (array)explode(",", $_SERVER['X_FORWARDED_FOR']);
		$REMOTE_ADDR = trim($X_FORWARDED_FOR[0]); //take the last
	} else {
		$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
	}
	return $REMOTE_ADDR;
}
add_filter('pre_comment_user_ip','auto_reverse_proxy_pre_comment_user_ip');

add_filter('got_rewrite','__return_true');
add_action('init', function(){
	if ( function_exists('is_user_logged_in') && is_user_logged_in() ) {
		nocache_headers();
	}
});

//**********************************************************************************
// ウィジェットでショートコードを使用可能に
//**********************************************************************************
add_filter('widget_text', 'do_shortcode');

//**********************************************************************************
// ヘッダーで読み込む JavaScript を登録する
//**********************************************************************************
function add_print_scripts() {
	// jQuery
	wp_enqueue_script('jquery');

	// Gravater
	if( is_singular() )
		wp_enqueue_script( 'gprofiles', 'http://s.gravatar.com/js/gprofiles.js', array( 'jquery' ), 'e', true);
}
add_action('wp_print_scripts', 'add_print_scripts');

//**********************************************************************************
// ヘッダーの link を削除
//**********************************************************************************
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

function my_style_loader_tag($tag, $handle){
	$tag = trim(preg_replace('/id=["\'][^"\']*["\'] /i', '', $tag)) . "\n";
	return $tag;
}
add_filter('style_loader_tag', 'my_style_loader_tag', 10, 2);

//**********************************************************************************
// コメント欄の > を <blockquote> に変換
//**********************************************************************************
function comment_content_edit($comment_content) {
	$comment_content = preg_replace("/^\s*(&gt;|>|＞)(.*)$/im", "<blockquote>$2</blockquote>", $comment_content);
	$comment_content = str_replace("</blockquote>\n<blockquote>", "\n", $comment_content);
	$comment_content = preg_replace("/^<blockquote>/i", "<blockquote style=\"margin:0;\">", $comment_content);
	return $comment_content;
}
add_filter('get_comment_text', 'comment_content_edit',99);

//**********************************************************************************
// コメント欄の内部リンクを変換
//**********************************************************************************
function convert_internal_link($html_text) {
	$pattern = '/' . preg_quote(get_bloginfo('wpurl'), '/') . '/i';
	if (preg_match($pattern, $html_text)) {
		$base_url = untrailingslashit(preg_replace('/^(https?:\/\/[^\/]*\/).*$/i', '$1', get_bloginfo('wpurl')));
		$pattern = '/(["\'])' . preg_quote($base_url, '/') . '(\/[^"\']*[^"\'])/i';
		$html_text = preg_replace($pattern, '$1$2', $html_text);
	}
	return ($html_text);
}
add_filter('comment_text', 'convert_internal_link', 99);

//**********************************************************************************
// wp-mail.php 無効
//**********************************************************************************
if (preg_match('/\/wp-mail\.php(\?.*)?$/i', $_SERVER['REQUEST_URI'])) {
	header('HTTP/1.0 403 Forbidden');
	wp_die(__("You don't have permission to access the URL on this server."));
}

//**********************************************************************************
// Add Scroll to Top
//**********************************************************************************
add_action('wp_head', 'add_scroll_to_top_style');
function add_scroll_to_top_style() {
    ?>
<style type="text/css">
#pagetop { display:none;position:fixed;right:10px;bottom:10px;z-index:100; }
#pagetop a { padding:5px;background:#ccc;color:#fff;display:block;font-size:20px;font-weight:bold;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;text-decoration:none; }
</style>
    <?php
}

add_action('wp_footer', 'add_scroll_to_top');
function add_scroll_to_top() {
    ?>
<script type="text/javascript">
jQuery(function($){
    $('body').append(
        $('<div id="pagetop">')
        .append(
            $('<a href="#">↑</a>')
            .click(function(){$('html,body').animate({scrollTop:0}, 800, 'swing')})
            )
        );
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#pagetop').fadeIn();
        } else {
            $('#pagetop').fadeOut();
        }
    });
});
</script>
    <?php
}

/*
class relative_URI {
    private $top_url;
    public function __construct() {
        add_action('get_header', array(&$this, 'get_header'), 1);
        add_action('wp_footer', array(&$this, 'wp_footer'), 99999);
        $home_url = trailingslashit(get_home_url('/'));
        $this->top_url = preg_replace( '/^(https?:\/\/.+?)\/(.*)$/', '$1', $home_url );
    }
    protected function replace_relative_URI($content) {
        $pattern = '#(<[^>]+)(' . $this->top_url . ')#i';
        return preg_replace( $pattern, '$1', $content );
    }
    private function replace($matches) {
    	if ( strpos(strtolower($matches[0]), 'meta') === FALSE ) {
    		return str_replace($this->top_url, '', $matches[0] );
    	} else {
    		return $matches[0];
    	}
    }
    public function get_header(){
        ob_start(array(&$this, 'replace_relative_URI'));
    }
    public function wp_footer(){
        ob_end_flush();
    }
}
$relative_URI = new relative_URI();
*/
