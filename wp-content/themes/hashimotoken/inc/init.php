<?php 
/*===========================================*/
//アイキャッチの有効化
/*===========================================*/
add_theme_support( 'post-thumbnails' );

/*===========================================*/
//画像出力サイズを追加
/*===========================================*/
add_image_size( 'blog_thumb', 245, 170, true );
add_image_size( 'illust_large', 600, 9999, false );
add_image_size( 'illust_thumb', 480, 480, true );

/*===========================================*/
//現在のページの最上位親のIDを取得
/*===========================================*/
function most_ancestors_id($id){
    $parents = get_post_ancestors($id);
    if($parents){
        $parent = array_reverse($parents);
        $parentID = $parent[0];
    }else{
        $parentID = $id;
    }
    return $parentID;
}

/*===========================================*/
//ウィジェット
/*===========================================*/
if(function_exists('register_sidebar')){
    register_sidebar(array(
        'name' => 'フッター',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'id' => 'footer_widget'
    ));
}

/*===========================================*/
//Yoast SEOのメタボックスを管理者のみ表示＆表示位置を強制的に下部に変更
/*===========================================*/
function yoast_is_toast(){
    if (!current_user_can('activate_plugins')) {
        remove_meta_box('wpseo_meta', 'course', 'normal');
        remove_meta_box('wpseo_meta', 'driving', 'normal');
        remove_meta_box('wpseo_meta', 'post', 'normal');
    }
}
add_action('add_meta_boxes', 'yoast_is_toast', 100000);

function jw_filter_yoast_seo_metabox() {
    return 'low';
}
add_filter('wpseo_metabox_prio', 'jw_filter_yoast_seo_metabox');


/*===========================================*/
//管理バーメニュー改変
/*===========================================*/
function remove_bar_menus( $wp_admin_bar ) {
    if(current_user_can('driving_author')){
        $wp_admin_bar->remove_menu( 'wp-logo' );
        $wp_admin_bar->remove_menu( 'new-content' );
    }
}
add_action('admin_bar_menu', 'remove_bar_menus', 201);

/*===========================================*/
//ダッシュボード改変
/*===========================================*/
if (!current_user_can('level_10')) {
    function my_custom_dashboard_widgets() {
        global $wp_meta_boxes;
        wp_add_dashboard_widget('custom_help_widget', 'メニュー', 'dashboard_text');
    }
    function dashboard_text() {
        locate_template('inc/dashboard_text.php', true);
    }
    add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
}

/*===========================================*/
//管理画面メニュー改変
/*===========================================*/
function change_menus(){
    global $menu;
    global $submenu;
    $menu[5][0] = 'ブログ';//「投稿」を「ブログ」に名前変更
}
add_action('admin_menu', 'change_menus');

/*===========================================*/
//画像のsrcsetを無効化
/*===========================================*/
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );

/*===========================================*/
//抜粋のカスタマイズ
/*===========================================*/
//抜粋文字数の変更
function custom_excerpt_length( $length ) {
     return 90;	
}	
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

//末尾省略文字の変更
function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/*===========================================*/
//年別アーカイブに「年」表記
/*===========================================*/
function custom_archives_link($html){
    if(preg_match('/[0-9]+?<\/a>/', $html))
    $html = preg_replace('/([0-9]+?)<\/a>/', '$1年</a>', $html);
    if(preg_match('/title=[\'\"][0-9]+?[\'\"]/', $html))
    $html = preg_replace('/(title=[\'\"][0-9]+?)([\'\"])/', '$1年$2', $html);
    return $html;
}
add_filter('get_archives_link', 'custom_archives_link', 10);

/*===========================================*/
//ブログのコメントを名前のみ必須にする
/*===========================================*/
function preprocess_comment_author( $commentdata ) {
    if ("" === trim( $commentdata['comment_author'] ))
    wp_die('名前を入力して下さい。');
    return $commentdata;
}
add_filter('preprocess_comment', 'preprocess_comment_author', 2, 1);

/*===========================================*/
//各ページメインクエリ設定
/*===========================================*/
function setQuery( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;
	/*if(is_front_page()){
		$query->set( 'post_type', 'illusts' );
		$query->set( 'offset', 1 );
		$query->set( 'posts_per_page', 10 );
	}*/
}
add_action( 'pre_get_posts', 'setQuery', 1 );

?>