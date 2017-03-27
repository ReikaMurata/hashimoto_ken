<?php get_header(); ?>
	<div id="contents" class="clearfix" role="main">
		<?php if(have_posts()): while(have_posts()): the_post(); ?>
		<p><?php the_title(); ?></p>
		<?php endwhile; endif; ?>
		<?php /*
		<?php $args = array('posts_per_page'=>1, 'post_type'=>'illusts', 'offset'=>1, 'paged'=>$paged); $posts = get_posts($args); if($posts): $count = 2; ?>
		<ul class="illust-list">
			<?php foreach($posts as $post): setup_postdata($post); $illust = SCF::get('illust'); $about = SCF::get('about'); $ttl = strip_tags(get_the_title()); $link = wp_get_attachment_image_src($illust, 'illust_large')[0]; ?>
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
			<?php $count++; endforeach; wp_reset_postdata(); ?>
		</ul>
		<?php wp_pagenavi(); ?>
		<?php else: ?>
		<p>イラストが見つかりません</p>
		<?php endif; ?>
		*/ ?>
	</div>
<?php get_footer(); ?>