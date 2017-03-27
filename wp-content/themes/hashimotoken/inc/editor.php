<?php 
/*===========================================*/
//投稿画面 エディターカスタマイズ
/*===========================================*/
function custom_editor_settings( $initArray ){
	//独自スタイル適用のためbodyにclass付与
    $initArray['body_class'] = 'editor-area';
	//「段落」のh1を削除
	$initArray['block_formats'] = "見出し1=h1; 見出し2=h2; 見出し3=h3; 見出し4=h4; 段落=p;";
	//iframeを削除させない
	$initArray['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
    return $initArray;
}
add_editor_style(get_stylesheet_directory_uri().'/editor-style.css?date='.date('YmdHis'));//独自css読み込み
add_filter( 'tiny_mce_before_init', 'custom_editor_settings', 1000 );

//子カテゴリーチェックで自動的に親カテゴリーにもチェック
function category_parent_linkage_script() {
    wp_enqueue_script( 'category-parent-linkage', get_template_directory_uri().'/category-parent-linkage.js', array( 'jquery' ) );
}
add_action( 'admin_print_scripts-post.php', 'category_parent_linkage_script' );
add_action( 'admin_print_scripts-post-new.php', 'category_parent_linkage_script' );

/*===========================================*/
//埋め込みYoutubeのレスポンシブ対応
/*===========================================*/
function tdd_oembed_filter($html, $url, $attr, $post_ID) {
  if( strstr( $url,'youtu' ) ) {
    $return = '<div class="iframe-wrap">'.$html.'</div>';
  }else{
    $return = $html;
  }
  return $return;
}
add_filter( 'embed_oembed_html', 'tdd_oembed_filter', 10, 4 );

/*===========================================*/
//メディアのリンク先から「添付ファイルのページ」を削除
/*===========================================*/
function media_script_buffer_start() {
    ob_start();
}
add_action( 'post-upload-ui', 'media_script_buffer_start' );
function media_script_buffer_get() {
    $scripts = ob_get_clean();
    $scripts = preg_replace( '#<option value="post">.*?</option>#s', '', $scripts );
    echo $scripts;
}
add_action( 'print_media_templates', 'media_script_buffer_get' );

/*===========================================*/
//ギャラリーのリンク先のデフォルトを「メディアファイル」に変更
/*===========================================*/
function image_gallery_default_link( $settings ) {
    $settings['galleryDefaults']['link'] = 'file';
    return $settings;
}
add_filter( 'media_view_settings', 'image_gallery_default_link');

/*===========================================*/
//ブログ本文内の画像に対するlightbox処理
/*===========================================*/
add_filter('the_content', 'rellightbox_replace');
function rellightbox_replace ($content){
    global $post;
    $pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
    $replacement = '<a$1href=$2$3.$4$5 data-lightbox="lightbox"$6>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}

/*===========================================*/
//投稿画面でのカテゴリーツリー維持
/*===========================================*/
function solecolor_wp_terms_checklist_args( $args, $post_id ){
   $args['checked_ontop'] = false;
   return $args;
}
add_filter('wp_terms_checklist_args', 'solecolor_wp_terms_checklist_args',10,2);

/*===========================================*/
//投稿画面のアイキャッチボックスに注釈文を追加
/*===========================================*/
add_filter( 'admin_post_thumbnail_html', 'add_featured_image_instruction');
function add_featured_image_instruction( $content ) {
    return $content .= '<p>サイズは<span style="color:red;">横1200×高さ630px 推奨</span></p>';
}

/*===========================================*/
//本文内　画像張り付けで「キャプション」ありの場合の出力内容をカスタマイズ
/*===========================================*/
add_shortcode('caption', 'my_img_caption_shortcode');

function my_img_caption_shortcode($attr, $content = null) {
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>s*)?<img [^>]+>(?:s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}

	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr, 'caption'));

	if ( 1 > (int) $width || empty($caption) )
		return $content;

	if ( $id ) $id = 'id="'.esc_attr($id).'" ';

	return '<div '.$id.'class="wp-caption '.esc_attr($align).'">'.do_shortcode($content).'<p class="wp-caption-text">'.$caption.'</p></div>';
}

/*===========================================*/
//本文内「ギャラリー」タグのカスタマイズ
/*===========================================*/
remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'custom_gallery_shortcode');
function custom_gallery_shortcode($attr) {
  $post = get_post();
 
  static $instance = 0;
  $instance++;
 
  if ( ! empty( $attr['ids'] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty( $attr['orderby'] ) )
      $attr['orderby'] = 'post__in';
    $attr['include'] = $attr['ids'];
  }
 
  // Allow plugins/themes to override the default gallery template.
  $output = apply_filters('post_gallery', '', $attr);
  if ( $output != '' )
    return $output;
 
  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }
 
  extract(shortcode_atts(array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post->ID,
    'itemtag'    => 'li',    //オリジナルは「dl」
    'icontag'    => 'div',    //オリジナルは「dt」
    'captiontag' => 'p',    //オリジナルは「dd」
    'columns'    => 3,
    'size'       => 'thumbnail',
    'include'    => '',
    'exclude'    => ''
  ), $attr));
 
  $attr['link'] = 'file';    //サムネイルのリンク先は元の画像にするため追加。
 
  $id = intval($id);
  if ( 'RAND' == $order )
    $orderby = 'none';
 
  if ( !empty($include) ) {
    $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
 
    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif ( !empty($exclude) ) {
    $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  } else {
    $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  }
 
  if ( empty($attachments) )
    return '';
 
  if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment )
      $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    return $output;
  }
 
  $itemtag = tag_escape($itemtag);
  $captiontag = tag_escape($captiontag);
  $icontag = tag_escape($icontag);
  $valid_tags = wp_kses_allowed_html( 'post' );
  if ( ! isset( $valid_tags[ $itemtag ] ) )
    $itemtag = 'li';    //オリジナルは「dl」
  if ( ! isset( $valid_tags[ $captiontag ] ) )
    $captiontag = 'p';    //オリジナルは「dd」
  if ( ! isset( $valid_tags[ $icontag ] ) )
    $icontag = 'p';    //オリジナルは「dt」
 
  $columns = intval($columns);
  $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
  $float = is_rtl() ? 'right' : 'left';
 
  $selector = "gallery-{$instance}";
 
  $gallery_style = $gallery_div = '';    
  //オリジナルではこの部分にスタイルシートの指定があるので削除
 
  $size_class = sanitize_html_class( $size );
  $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'><ul class='clearfix'>";    //ul タグを追加（必要であればクラス名の追加や変更が可能）
  $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
 
  $i = 0;
  foreach ( $attachments as $id => $attachment ) {
    $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
    //42行目の $attr['link'] = 'file';を追加せずに上記を $link = wp_get_attachment_link($id, $size, false, false);としても、サムネイルのリンクを元画像にできる。
    //<{$itemtag}> は <li>
    $output .= "<{$itemtag} class='gallery-item'>";    //必要であればクラス名の追加や変更が可能）
    //<{$icontag}>は<p>。$attachment->post_excerpt や post_content、post_title などを「wptexturize」を用いて追加記述も可能
    $output .= "    
      <{$icontag} class='gallery-icon'>
        $link
      </{$icontag}>";
    if ( $captiontag && trim($attachment->post_excerpt) ) {
      $output .= "
        <{$captiontag} class='wp-caption-text gallery-caption'>
        " . wptexturize($attachment->post_excerpt) . "
        </{$captiontag}>";
    }
    $output .= "</{$itemtag}>";
  //ここの記述 if ( $columns > 0 && ++$i % $columns == 0 ) $output .= '<br style="clear: both" />';も不要なので削除
  }
  $output .= "
    </ul></div>\n";    //ul の閉じタグを追加
  return $output;
}
//wp_get_attachment_linkで出力されるaタグをカスタマイズ
add_filter('wp_get_attachment_link','my_add_class_attachment_link',10,1);
function my_add_class_attachment_link($html){
    return str_replace('<a','<a data-lightbox="lightbox"',$html);
}
?>