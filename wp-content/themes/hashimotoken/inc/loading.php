<?php 
/*===========================================*/
//ページごとの読込外部ファイル振り分け
/*===========================================*/
function fileDistribution(){
	global $post;
	if( !is_admin() ){
		//共通
        wp_enqueue_style( 'style', get_template_directory_uri().'/assets/css/style.css' );
		if(!wp_is_mobile()){
			//PC版
        	wp_enqueue_style( 'base', get_template_directory_uri().'/assets/css/base.css' );
		}else{
			//スマホ版
			wp_enqueue_style( 'base', get_template_directory_uri().'/assets/css/base_sp.css' );
		}
        wp_enqueue_script( 'commonJs', get_template_directory_uri().'/assets/js/common.min.js', array('jquery'), false, true );
    }
    //TOPページ（実際にはイラストのアーカイブページ）
    if(is_front_page()){
		if(!wp_is_mobile()){
			//PC版
			wp_enqueue_style( 'top_style', get_template_directory_uri().'/assets/css/top.css' );
		}else{
			//スマホ版
			wp_enqueue_style( 'top_style', get_template_directory_uri().'/assets/css/top_sp.css' );
		}
        wp_enqueue_style( 'lightbox_style', get_template_directory_uri().'/assets/css/featherlight.min.css' );
        wp_enqueue_style( 'lightbox_gallery_style', get_template_directory_uri().'/assets/css/featherlight.gallery.min.css' );
        wp_enqueue_script( 'lightbox_script', get_template_directory_uri().'/assets/js/featherlight.min.js', array('jquery'), false, true );
        wp_enqueue_script( 'lightbox_gallery_script', get_template_directory_uri().'/assets/js/featherlight.gallery.min.js', array('jquery'), false, true );
        wp_enqueue_script( 'gallery_script', get_template_directory_uri().'/assets/js/gallery.js', array('jquery'), false, true );
    }
    //固定ページ
    elseif(is_page()){
        $page = get_page( get_the_ID() );
        $slug = $page -> post_name;
        if(wp_is_mobile()) $slug .= '_sp'; 
        if(file_exists(ABSPATH.'/wp-content/themes/hashimotoken/assets/css/'.$slug.'.css')){wp_enqueue_style( $slug.'_style', get_template_directory_uri().'/assets/css/'.$slug.'.css' );}
        if(file_exists(ABSPATH.'/wp-content/themes/hashimotoken/assets/js/'.$slug.'.js')){wp_enqueue_script( $slug.'_script', get_template_directory_uri().'/assets/js/'.$slug.'.js', array('jquery'), false, true );}
    }
    //記事詳細ページ
    elseif(is_single()){
        $slug = "blog";
        if(wp_is_mobile()) $slug .= '_sp';
        wp_enqueue_style( 'blog_style', get_template_directory_uri().'/assets/css/'.$slug.'.css' );
        wp_enqueue_style( 'lightbox_style', get_template_directory_uri().'/assets/css/lightbox.min.css' );
        wp_enqueue_script( 'lightbox', get_template_directory_uri().'/assets/js/lightbox.min.js', array('jquery'), false, true );
    }
    //投稿関連
    elseif(is_archive() || is_category() || is_search() || is_tax() || is_date() || is_home()){
        if(is_category() || is_singular('post') || is_home() || is_tag() || (is_date() && !is_post_type_archive())){
            $slug = "blog";
        }
        if(wp_is_mobile()){
			if(file_exists(ABSPATH.'/wp-content/themes/hashimotoken/assets/css/blog_sp.css')){wp_enqueue_style( $slug.'_style', get_template_directory_uri().'/assets/css/blog_sp.css' );}
		}else{
			if(file_exists(ABSPATH.'/wp-content/themes/hashimotoken/assets/css/blog.css')){wp_enqueue_style( $slug.'_style', get_template_directory_uri().'/assets/css/blog.css' );}
		}
        if(file_exists(ABSPATH.'/wp-content/themes/hashimotoken/assets/js/'.$slug.'.js')){wp_enqueue_script( $slug.'_script', get_template_directory_uri().'/assets/js/'.$slug.'.js', array('jquery'), false, true );}
    }
}
add_action('wp_enqueue_scripts', 'fileDistribution');
?>