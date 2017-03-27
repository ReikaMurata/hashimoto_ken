<?php 
/*===========================================*/
//カスタム投稿タイプ「イラスト」を追加する。
/*===========================================*/
function illusts_custom_post_type(){
	$labels = array(
		'name' => 'イラスト',
		'singular_name' => 'イラスト一覧',
		'add_new_item' => 'イラストを追加',
		'add_new' => '新規追加',
		'new_item' => '新規追加',
		'view_item' => 'イラストを表示',
		'not_found' => 'イラストは未登録です。',
		'not_found_in_trash' => 'ゴミ箱に投稿はありません。',
		'search_items' => '投稿を検索'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'hierarchical' => false,
		'menu_position' => 5,
		'has_archive' => true,
		'supports' => array( 'title' ),
		'rewrite' => true
	);
	register_post_type( 'illusts', $args );
    //カスタム分類「カテゴリー」に追加
	/*register_taxonomy(
		'cat',
		'blog',
		array(
			'hierarchical' => true,
			'update_count_callback' => '_update_post_term_count',
			'label' => 'カテゴリー',
			'singular_label' => 'カテゴリー',
			'public' => true,
			'show_ui' => true
		)
	);*/
}
add_action( 'init', 'illusts_custom_post_type' );
//パーマリンクを記事ID.htmlに変更
add_action('init', 'myposttype_rewrite');
function myposttype_rewrite() {
    global $wp_rewrite;
  
    $queryarg = 'post_type=illusts&p=';
    $wp_rewrite->add_rewrite_tag('%illusts_id%', '([^/]+)',$queryarg);
    $wp_rewrite->add_permastruct('illusts', '/illusts/%illusts_id%.html', false);
  
}
add_filter('post_type_link', 'myposttype_permalink', 1, 3);
function myposttype_permalink($post_link, $id = 0, $leavename) {
    global $wp_rewrite;
    $post = &get_post($id);
    if ( is_wp_error( $post ) )
        return $post;
    $newlink = $wp_rewrite->get_extra_permastruct($post->post_type);
    $newlink = str_replace('%'.$post->post_type.'_id%', $post->ID, $newlink);
    $newlink = home_url(user_trailingslashit($newlink));
    return $newlink;
}
?>