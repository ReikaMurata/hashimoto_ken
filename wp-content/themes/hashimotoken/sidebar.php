<aside>
	<div id="sidebar">
		<div class="box profile">
			<p class="ttl">profile</p>
			<div class="box">
                <div class="photo"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/profile.jpg" alt="橋本 健"></div>
                <div class="data">
                    <p class="name">橋本 健<span class="kana">ハシモト ケン</span></p>
                    <p class="job">イラストレーター<br>グラフィックデザイナー</p>
                    <p class="link"><a href="<?php echo esc_url(home_url()); ?>/prodile/">プロフィールの詳細</a></p>
                </div>
            </div>
		</div>
		<div class="box archive">
			<p class="ttl">archive</p>
				<?php
					$year_prev = null;
					$months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month ,
														YEAR( post_date ) AS year,
														COUNT( id ) as post_count FROM $wpdb->posts
														WHERE post_status = 'publish' and post_date <= now( )
														and post_type = 'post'
														GROUP BY month , year
														ORDER BY post_date DESC");
					$count = 1;
					foreach($months as $month) :
					$year_current = $month->year;
					if ($year_current != $year_prev){
					if ($year_prev != null){ ?>
			</ul>
			</div>
			<?php } ?>
			<div class="list"><p class="year<?php if($count == 1){echo ' current';} ?>"><?php echo $month->year; ?>年</p>
				<ul>
				<?php } ?>
				<li>
					<a href="<?php bloginfo('url') ?>/date/<?php echo $month->year; ?>/<?php echo date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>">
						<?php echo date("Y.m", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>
						(<?php echo $month->post_count; ?>)
					</a>
				</li>
				<?php $year_prev = $year_current; $count++;
					endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="box category">
			<p class="ttl">category</p>
			<ul>
				<?php $args = array('title_li'=>''); wp_list_categories($args); ?>
			</ul>
		</div>
		<div class="box new">
			<p class="ttl">new</p>
			<ul class="post-list">
				<?php $args = array('posts_per_page'=>4); $posts = get_posts($args); if($posts): foreach($posts as $post): setup_postdata($post); $ttl = strip_tags(get_the_title()); $link = esc_url(get_permalink()); ?>
				<li>
					<a href="<?php echo $link; ?>">
						<p><?php echo $ttl; ?><time datetime="<?php the_time('Y-m-d'); ?>">(<?php the_time('m.d'); ?>)</time></p>
						<div class="eyecatch">
							<?php if(has_post_thumbnail()): ?>
								<?php the_post_thumbnail('blog_thumb', array('alt'=>$ttl)); ?>
							<?php else: ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/thumb_dummy.jpg" alt="<?php echo $ttl; ?>">
							<?php endif; ?>
						</div>
					</a>
				</li>
				<?php endforeach; endif; reset_postdata; ?>
			</ul>
		</div>
		<div class="box search">
			<dl>
				<dt>ブログ内を検索</dt>
				<dd>
				<form action="<?php echo esc_url(home_url()); ?>" method="get">
					<div class="wrap">
						<div class="cell"><input type="text" name="s"></div>
						<div class="cell">
							<button><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_search.svg" alt="検索" title="このワードで検索"></button>
						</div>
					</div>
				</form>
				</dd>
			</dl>
		</div>
	</div>
</aside>