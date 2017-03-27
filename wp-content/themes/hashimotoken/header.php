<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes,maximum-scale=1">
<title>無題ドキュメント</title>
<?php wp_head(); ?>
</head>
<body>

<?php if(!wp_is_mobile()): //以下PC版 ?>
<div id="main-container">
	<div class="container">
		<header role="banner">
			<?php if(is_front_page() && (!is_paged())): ?>
			<div id="top-header" class="clearfix">
				<div class="menu">
					<menu role="menu">
						<h1 class="logo"><a href="<?php echo esc_url(home_url()); ?>" class="opacity"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="ken hashimoto"></a></h1>
						<ul>
							<li><a href="<?php echo esc_url(home_url()); ?>/blog/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_menu.png" alt="news">news</a></li>
							<li><a href="<?php echo esc_url(home_url()); ?>/profile/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_profile.png" alt="profile">profile</a></li>
							<li><a href="<?php echo esc_url(home_url()); ?>/contact/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_contact.png" alt="contact">contact</a></li>
							<li><a href="<?php echo esc_url(home_url()); ?>/blog/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_blog.png" alt="blog">blog</a></li>
						</ul>
						<p class="attention"><a href="<?php echo esc_url(home_url()); ?>/attention/">著作権や使用に関するご注意</a></p>
					</menu>
				</div>
				<div class="new">
					<?php $args = array('posts_per_page'=>1, 'post_type'=>'illusts'); $posts = get_posts($args); if($posts): ?>
					<?php foreach($posts as $post): setup_postdata($post); $illust = SCF::get('illust'); $about = SCF::get('about'); $ttl = strip_tags(get_the_title()); $link = wp_get_attachment_image_src($illust, 'illust_large')[0]; ?>
					<a data-featherlight="#illust01" href="#" class="illust-box">
						<div class="thumbnail"><?php if($illust){echo wp_get_attachment_image($illust, 'illust_large', array('alt'=>$ttl));}?></div>
						<p class="ttl"><?php echo $ttl; ?></p>
					</a>
					<div id="illust01" class="hidden">
						<div class="inline-box">
							<div class="thumb"><?php if($illust){echo wp_get_attachment_image($illust, 'illust_large', array('alt'=>$ttl));}?></div>
							<p class="ttl"><?php echo $ttl; ?></p>
							<p class="about"><?php echo $about; ?></p>
						</div>
					</div>
					<?php endforeach; wp_reset_postdata(); ?>
					<?php else: ?>
					<p>イラストが登録されていません。</p>
					<?php endif; ?>
				</div>
			</div>
			<?php else: ?>
			<div id="header" class="clearfix">
				<h1 class="logo"><a href="<?php echo esc_url(home_url()); ?>" class="opacity"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo2.svg" alt="ken hashimoto"></a></h1>
				<menu role="menu">
					<ul>
						<li><a href="<?php echo esc_url(home_url()); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_top.png" alt="top">top</a></li>
						<li><a href="<?php echo esc_url(home_url()); ?>/blog/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_menu.png" alt="news">news</a></li>
						<li><a href="<?php echo esc_url(home_url()); ?>/profile/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_profile.png" alt="profile">profile</a></li>
						<li><a href="<?php echo esc_url(home_url()); ?>/contact/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_contact.png" alt="contact">contact</a></li>
						<li><a href="<?php echo esc_url(home_url()); ?>/blog/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_blog.png" alt="blog">blog</a></li>
					</ul>
				</menu>
			</div>
			<?php endif; ?>
		</header>
		
<?php else: //以下スマホ版 ?>
<div id="sp-main-container">
	<div class="container">
		<header role="banner">
			<div id="header" class="clearfix">
				<h1 class="logo"><a href="<?php echo esc_url(home_url()); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_sp.svg" alt=""></a></h1>
			</div>
			<menu role="menu" id="menu">
				<ul>
					<?php if(!is_front_page() || is_paged()): ?>
					<li><a href="<?php echo esc_url(home_url()); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_top.png" alt="TOP" class="top"><p>top</p></a></li>
					<?php endif; ?>
					<li><a href="<?php echo esc_url(home_url()); ?>/blog/category/news/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_menu.png" alt="NEWS" class="new"><p>news</p></a></li>
					<li><a href="<?php echo esc_url(home_url()); ?>/profile/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_profile.png" alt="profile" class="profile"><p>profile</p></a></li>
					<li><a href="<?php echo esc_url(home_url()); ?>/contact/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_contact.png" alt="contact" class="contact"><p>contact</p></a></li>
					<li><a href="<?php echo esc_url(home_url()); ?>/blog/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_blog.png" alt="blog" class="blog"><p>blog</p></a></li>
				</ul>
			</menu>
		</header>
		<?php if(is_front_page() && (!is_paged())): ?>
		<div id="new">
            <?php $args = array('posts_per_page'=>1, 'post_type'=>'illusts'); $posts = get_posts($args); if($posts): ?>
			<?php foreach($posts as $post): setup_postdata($post); $illust = SCF::get('illust'); $about = SCF::get('about'); $ttl = strip_tags(get_the_title()); $link = wp_get_attachment_image_src($illust, 'illust_large')[0]; ?>
            <a data-featherlight="#illust01" href="#" class="illust-box">
				<div class="thumbnail"><?php if($illust){echo wp_get_attachment_image($illust, 'illust_large', array('alt'=>$ttl));}?></div>
				<p class="ttl"><?php echo $ttl; ?></p>
            </a>
            <div id="illust01" class="hidden">
                <div class="inline-box">
					<div class="thumb"><?php if($illust){echo wp_get_attachment_image($illust, 'illust_large', array('alt'=>$ttl));}?></div>
					<p class="ttl"><?php echo $ttl; ?></p>
					<p class="about"><?php echo $about; ?></p>
				</div>
			</div>
			<?php endforeach; wp_reset_postdata(); ?>
            <?php else: ?>
			<p>イラストが登録されていません。</p>
			<?php endif; ?>
        </div>
        <?php endif; ?>	
<?php endif; ?>

<?php if(function_exists('yoast_breadcrumb') && !is_front_page()){ yoast_breadcrumb('<div id="pankuzu"><div class="container">','</div></div>');} ?>