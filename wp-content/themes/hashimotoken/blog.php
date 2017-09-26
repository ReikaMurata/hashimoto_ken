<?php if(is_category() || is_home() || is_search() || is_tag() || (is_date() && !is_post_type_archive())): ?>
	<div id="blog-archive">
		<?php 
		if(is_category() || is_search() || is_date()){
			if(is_category()) $txt = single_cat_title('',false);
			if(is_search()) $txt = '検索：'.get_search_query();
			if(is_date()) $txt = get_query_var('year').'年'.get_query_var('monthnum').'月';
            echo '<p class="archive-ttl">'.$txt.'</p>';
		}
		?>
		<div class="list">
			<?php if(have_posts()): while(have_posts()): the_post(); $ttl = strip_tags(get_the_title()); $link = esc_url(get_permalink()); ?>
			<div class="post">
				<article>
					<div class="thumb"><a href="<?php echo $link; ?>" class="opacity"><?php if(has_post_thumbnail()){the_post_thumbnail('blog_thumb', array('alt'=>$ttl));}else{echo '<img src="'.get_template_directory_uri().'/assets/img/thumb_dummy.jpg" alt="'.$ttl.'">';} ?></a></div>
					<div class="data">
                        <header>
                            <time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time>
                            <div class="categories">Category | <?php the_category(', '); ?></div>
                        </header>
                        <p class="ttl"><a href="<?php echo $link; ?>"><?php echo $ttl; ?></a></p>
                    </div>
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
				<ul>
                    <?php 
                    //パーマリンクを取得
                    $share_link = get_permalink();
                    //タイトルを取得。ページタイトルの後にサイト名やキャッチコピーも入れています
                    $share_ttl = get_the_title().'｜'.get_bloginfo( 'name' ).' - '.get_bloginfo( 'description' );
                    //記事の抜粋を取得
                    $share_excerpt = get_the_excerpt();
                    //記事のサムネイルURLを取得
                    $share_img_id = get_post_thumbnail_id();
                    $share_img_url = wp_get_attachment_image_src($share_img_id, true);
                    ?>
				    <li><a href="http://twitter.com/share?url=<?php echo $share_link; ?>&text=<?php echo $share_ttl; ?>" onclick="window.open(this.href, 'TWwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_tw.svg" alt="Twitter"></a></li>
				    <li><a href="http://www.facebook.com/share.php?u=<?php echo $share_link; ?>" onclick="window.open(this.href, 'FBwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_fb.svg" alt="Facebook"></a></li>
				    <li><a href="https://plusone.google.com/_/+1/confirm?hl=ja&url=<?php echo esc_url(get_permalink()); ?>" target="_blank" onclick="window.open(this.href, 'GPwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_gp.svg" alt="Google+"></a></li>
				    <li><a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo $share_link; ?>&title=<?php echo strip_tags($share_ttl); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_ht.svg" alt="はてな"></a></li>
				    <li><a href="http://getpocket.com/edit?url=<?php echo $share_link; ?>&title=<?php echo $share_ttl; ?>" onclick="window.open(this.href, 'PCwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_pk.svg" alt="pocket"></a></li>
				</ul>
			</div>
			<div id="post-comments">
                <?php if(comments_open() || get_comments_number()){ comments_template( );}?>
            </div>
		</article>
	<?php endwhile; endif; ?>
	</div>
<?php endif; ?>