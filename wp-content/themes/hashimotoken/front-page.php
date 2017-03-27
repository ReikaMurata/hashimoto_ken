<?php get_header(); ?>
	<div id="contents" class="clearfix" role="main">
		<?php $paged = get_query_var('page') ? get_query_var('page') : 1 ; $perpage = 2; $offset = ($paged-1)*$perpage+1; $args = array('post_type'=>'illusts', 'posts_per_page'=>$perpage, 'offset'=>$offset, 'paged'=>$paged); $myquery = new WP_Query($args); if($myquery->have_posts()): $count = 2; ?>
		<ul class="illust-list">
			<?php while($myquery->have_posts()): $myquery->the_post(); $illust = SCF::get('illust'); $about = SCF::get('about'); $ttl = strip_tags(get_the_title()); $link = wp_get_attachment_image_src($illust, 'illust_large')[0]; ?>
			<li>
				<a data-featherlight="#illust<?php echo $count; ?>" href="#" class="illust-box">
					<div class="thumbnail"><?php if($illust){echo wp_get_attachment_image($illust, 'illust_thumb', array('alt'=>$ttl));}?></div>
					<p class="ttl"><?php echo $ttl; ?></p>
				</a>
				<div id="illust<?php echo $count; ?>" class="hidden">
					<div class="inline-box">
						<div class="thumb"><?php if($illust){echo wp_get_attachment_image($illust, 'illust_large', array('alt'=>$ttl));}?></div>
						<p class="ttl"><?php echo $ttl; ?></p>
						<p class="about"><?php echo $about; ?></p>
					</div>
				</div>
			</li>
			<?php $count++; endwhile; ?>
		</ul>
		<?php if (function_exists('wp_pagenavi')){wp_pagenavi(array('query'=>$myquery));} ?>
		<?php else: ?>
		<p>イラストが見つかりません</p>
		<?php endif; wp_reset_query(); ?>
	</div>
<?php get_footer(); ?>