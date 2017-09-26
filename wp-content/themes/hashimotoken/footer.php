	<footer role="contentinfo">
		<div id="footer">
			<small>&copy;2017 Ken Hashimoto</small>
			<?php if(wp_is_mobile() || !is_front_page()): ?><p class="attention"><a href="<?php echo esc_url(home_url()); ?>/attention/">著作権や使用に関するご注意</a></p><?php endif; ?>
		</div>
	</footer>
	<a href="#header" id="pagetop"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_arrow_up.svg" alt="Pagetop"></a>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>