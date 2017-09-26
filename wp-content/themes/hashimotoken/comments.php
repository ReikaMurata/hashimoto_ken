<aside>
    <h2>Comment</h2>
    <?php if( have_comments() ): ?>
    	<ul class="commentList">
        	<?php wp_list_comments(); ?>
        </ul>
    <?php endif; ?>
    <?php 
    if (comments_open()) { //コメントの許可の有無
        $post_id = get_the_ID();
        $commenter = wp_get_current_commenter();
        $user = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';
        if ( get_option('require_name_email') ) {
            $span_req = '<span class="required">※</span> ';
            $input_req = ' required aria-required="true"';
        } else {
            $span_req = '';
            $input_req = '';
        }
        do_action( 'comment_form_before' ); ?>
        
        <div id="respond" class="comment-respond">
            <?php 
            //ログインユーザーのみコメント可＆ログインしていない状態
            if( get_option('comment_registration') && ! is_user_logged_in() ) { ?>
            <p class="must-log-in">コメントするには<a href="<?php echo wp_login_url(apply_filters('the_permalink', get_permalink($post_id)).'#respond'); ?>">ログイン</a>が必要です</p>
            <?php 
            //ログインユーザーのみコメント可＆ログインしている状態
            } else { ?>
            <form action="<?php echo site_url('/wp-comments-post.php'); ?>" method="post" id="commentform" class="comment-form" novalidate>
            <?php do_action( 'comment_form_top' );
            if (is_user_logged_in()) { ?>
            <div class="comment-form-author logged-in-as">
                <p class="account"><span class="comment-form-account">[ <a href="<?php echo admin_url('profile.php'); ?>" target="_blank">アカウント設定</a> - <a href="<?php echo wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)).'#respond'); ?>">ログアウト</a> ]</span></p>
                <p><label for="author2">お名前</label></p>
                <input id="author2" type="text" value="<?php echo esc_attr($user_identity); ?>" title="<?php echo esc_attr($user_identity); ?> としてログイン中" disabled></div>
            <?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
            }
            else
            { // 非ログインユーザー ?>
        <p class="comment-notes"><span class="required">※</span>…必須項目</p>
<?php do_action( 'comment_form_before_fields' ); ?>
        <div class="comment-form-author">
			<p><span class="required">※</span><label for="author">お名前（任意のお名前）</label></p>
			<input id="author" required name="author" type="text" value="<?php echo esc_attr($commenter['comment_author']); ?>"<?php echo $input_req; ?>>
      	</div>
        <div class="comment-form-email">
        	<p><label for="email">メールアドレス</label></p>
        	<input id="email" name="email" type="email" value="<?php echo esc_attr($commenter['comment_author_email']); ?>" size="60">
        </div>
        <div class="comment-form-url">
			<p><label for="url">URL</label></p>
       		<input id="url" name="url" type="url" value="<?php echo esc_attr($commenter['comment_author_url']); ?>" size="60">
        </div>
<?php } // END ELSE (is_user_logged_in()) ?>
        <div class="comment-form-comment">
			<p><span class="required">※</span><label for="comment">コメント</label></p>
       		<textarea id="comment" name="comment" cols="50" rows="8" aria-required="true" required></textarea>
       	</div>
        <?php do_action( 'comment_form_after_fields' ); ?>
        <p class="comment-form-submit"><input id="submit" name="submit" type="submit" value="コメントする"></p>
        <!--<p class="form-allowed-tags">コメントに使用できるHTMLタグ：....</p>-->
<?php echo "\t\t\t".get_comment_id_fields()."\n"; 
if (current_user_can('unfiltered_html')) {
    echo "\t\t\t";
    wp_nonce_field( 'unfiltered-html-comment_'.$post_id, '_wp_unfiltered_html_comment_disabled', false );
    echo '<script>(function(){if(window===window.parent){document.getElementById(\'_wp_unfiltered_html_comment_disabled\').name=\'_wp_unfiltered_html_comment\';}})();</script>'."\n";
}
remove_action( 'comment_form', 'wp_comment_form_unfiltered_html_nonce' );
do_action( 'comment_form', $post_id ); ?>
    </form>
<?php } // END ELSE ( get_option('comment_registration') && ! is_user_logged_in() )
do_action( 'comment_form_after' ); ?>
<!-- / #respond --></div>

<?php } else { // ELSE (comments_open())
    do_action( 'comment_form_comments_closed' );
} ?>
</aside>