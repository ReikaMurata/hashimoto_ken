<?php 
/*===========================================*/
//head内不要なタグ削除
/*===========================================*/
//EditURIのタグを削除
remove_action('wp_head', 'rsd_link');
//wlwmanifestのタグを削除
remove_action('wp_head', 'wlwmanifest_link');
//generatorのタグを削除
remove_action('wp_head', 'wp_generator');
//shortlinkのタグを削除
remove_action('wp_head', 'wp_shortlink_wp_head');
//絵文字の削除
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
//「rel="https://api.w.org/"」を削除
remove_action('wp_head','rest_output_link_wp_head');
//alternateのタグを削除
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');

/*===========================================*/
//投稿画面からエディターを削除
/*===========================================*/
function remove_post_supports() {
    //固定ページから本文削除
    remove_post_type_support( 'page', 'editor' );
}
add_action( 'init', 'remove_post_supports' );

/*===========================================*/
//WP付属jQueryを除く
/*===========================================*/
function load_script(){
    if (! is_admin()){
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', array(), '1.10.1');
    }
}
add_action('init', 'load_script');

/*===========================================*/
//YARPPプラグインのCSSを除外
/*===========================================*/
function dequeue_yarpp_footer_styles(){
    wp_dequeue_style('yarppRelatedCss');
}
add_action('get_footer','dequeue_yarpp_footer_styles');
function dequeue_yarpp_header_styles(){
    wp_dequeue_style('yarppWidgetCss');
}
add_action('get_header','dequeue_yarpp_header_styles');

/*===========================================*/
//Contact Form7プラグインのjsとcssを特定のページのみ読み込ませる
/*===========================================*/
function wpcf7_file_control() {
    add_filter("wpcf7_load_js", "__return_false");
    add_filter("wpcf7_load_css", "__return_false");
    if( is_page("contact")){
        if( function_exists("wpcf7_enqueue_scripts") ) wpcf7_enqueue_scripts();
        if( function_exists("wpcf7_enqueue_styles") ) wpcf7_enqueue_styles();
    }
}
add_action("template_redirect", "wpcf7_file_control");
?>