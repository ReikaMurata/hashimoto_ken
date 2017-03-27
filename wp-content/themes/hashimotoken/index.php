<?php get_header();
if(is_page()){
    $page = get_post(get_the_ID());
    $slug = $page->post_name;
}
//ブログ関連
elseif(is_category() || is_singular('post') || is_home() || is_tag() || (is_date() && !is_post_type_archive())){
    $slug = 'blog';
}
?>
	<div id="contents" class="clearfix" role="main">
		<?php get_template_part($slug); ?>
		<?php if($slug == 'blog'){ get_sidebar();} ?>
	</div>

<?php get_footer(); ?>