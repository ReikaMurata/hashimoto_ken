<?php 
/*===========================================*/
//ファビコン指定
/*===========================================*/
function site_favicon() {//HPのファビコン
  echo '<link rel="icon" type="image/x-icon" href="'.esc_url(home_url('/')).'favicon.ico">'."\n";
}
add_action('wp_head', 'site_favicon');
function admin_favicon() {//管理画面のファビコン
  echo '<link rel="icon" type="image/x-icon" href="'.esc_url(home_url('/')).'favicon.ico">'."\n";
}
add_action('admin_head', 'admin_favicon');

/*===========================================*/
//バージョンアップ通知管理者以外非表示
/*===========================================*/
function update_nag_admin_only() {
    if ( ! current_user_can( 'administrator' ) ) {
        remove_action( 'admin_notices', 'update_nag', 3 );
    }
}
add_action( 'admin_init', 'update_nag_admin_only' );
/*===========================================*/
//管理画面バージョン番号非表示＆フッター文言削除
/*===========================================*/
function remove_footer_version() {
remove_filter( 'update_footer', 'core_update_footer' );
}
add_action( 'admin_menu', 'remove_footer_version' );
add_filter('admin_footer_text', '__return_empty_string');

/*===========================================*/
//ダッシュボードウィジェット非表示
/*===========================================*/
function example_remove_dashboard_widgets() {
    if (!current_user_can('level_10')) {
        global $wp_meta_boxes;
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['wpseo-dashboard-overview']);//YoastSEO
    }
}
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets');
//ダッシュボードの列数を1で固定する
global $wp_version;
if ( version_compare( $wp_version, '3.8', '>=' ) ) {
	function columns_screen_options() {
		add_screen_option(
			'layout_columns',
			array(
				'max' => 1,
				'default' => 1
			)
		);
	}
	add_action( 'admin_head-index.php', 'columns_screen_options' );
}else{
	function my_screen_layout_dashboard( $result, $option, $user ) {
		return 1;
	}
	add_filter( 'get_user_option_screen_layout_dashboard', 'my_screen_layout_dashboard', 10, 3 );
}

/*===========================================*/
//ログイン画面のロゴのリンク先・titleを変更
/*===========================================*/
function change_wp_login_url(){
	return get_bloginfo('url');
}
function change_wp_login_ttl(){
    return get_bloginfo('name');
}
add_filter('login_headerurl', 'change_wp_login_url');
add_filter('login_headertitle','change_wp_login_ttl');

/*===========================================*/
//カテゴリースラッグからカテゴリーIDを返す
/*===========================================*/
function get_category_id_by_slug( $cat_name){
     $cat_data = get_category_by_slug( $cat_name );
     return $cat_data -> term_id;
}

?>