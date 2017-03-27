<?php if(is_category() || is_home() || is_tag() || (is_date() && !is_post_type_archive())): ?>
	<div id="blog-archive">
		<div class="list">
			<?php if(have_posts()): while(have_posts()): the_post(); $ttl = strip_tags(get_the_title()); $link = esc_url(get_permalink()); ?>
			<div class="post">
				<article>
					<div class="thumb"><a href="<?php echo $link; ?>" class="opacity"><?php if(has_post_thumbnail()){the_post_thumbnail('blog_thumb', array('alt'=>$ttl));}else{echo '<img src="'.get_template_directory_uri().'/assets/img/thumb_dummy.jpg" alt="'.$ttl.'">';} ?></a></div>
					<header>
						<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time>
						<div class="categories">Category | <?php the_category(', '); ?></div>
					</header>
					<p class="ttl"><a href="<?php echo $link; ?>"><?php echo $ttl; ?></a></p>
				</article>
			</div>
			<?php endwhile; else: ?>
			<p>記事が登録されていません。</p>
			<?php endif; ?>
		</div>
		<div class="paging">
			
		</div>
	</div>
<?php else: ?>
	<div id="blog-detail">
	<?php if(have_posts()): while(have_posts()): the_post(); ?>
		<article>
			<header>
				<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time>
				<div class="categories">Category | <?php the_category(', '); ?></div>
				<h2 class="ttl"><?php echo strip_tags(get_the_title()); ?></h2>
			</header>
			<div class="editor clearfix">
				<?php if(has_post_thumbnail()): ?>
				<div class="thumb"><?php the_post_thumbnail('full', array('alt'=>$ttl)); ?></div>
				<?php endif; ?>
				<section>
					<?php the_content(); ?>
				</section>
			</div>
			<div class="sns">
				
			</div>
		</article>
	<?php endwhile; endif; ?>
	</div>
<?php endif; ?>