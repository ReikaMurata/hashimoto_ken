<?php 
/*
使っているアイコンフォントについては下記参照
https://developer.wordpress.org/resource/dashicons/
*/
?>
<div id="org_dashboard">
<?php $user = wp_get_current_user(); if (current_user_can('driving_author')): ?>
    <?php $args = array('post_type'=>'driving-range', 'author'=>$user->ID); $posts = get_posts($args); if($posts): foreach($posts as $post): setup_postdata($post); ?>
    <ul>
    	<li><span class="dashicons dashicons-desktop"></span> <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo $user->display_name; ?>のページを確認する</a></li>
    	<li><span class="dashicons dashicons-edit"></span> <a href="<?php echo esc_url(get_edit_post_link()); ?>"><?php echo $user->display_name; ?>の情報を修正する</a></li>
    </ul>
    <?php endforeach; else: ?>
    <p>まだページを作成されていません、ページが作成されるまで今しばらくお待ちください。</p>
    <?php endif; wp_reset_postdata(); ?>
<?php elseif(current_user_can('course_author')): ?>
    <p class="midashi"><span class="dashicons dashicons-warning"></span> <?php echo $user->display_name; ?>の最近の新着情報</p>
    <?php $args = array('post_type'=>'post', 'author'=>$user->ID, 'posts_per_page'=>4); $posts = get_posts($args); if($posts): ?>
        <ul class="post-list">
            <?php foreach($posts as $post): setup_postdata($post); ?>
        	<li><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
    <p>まだ新着情報の投稿はありません。</p>
    <?php endif; wp_reset_postdata(); ?>
    <?php $args = array('post_type'=>'course', 'author'=>$user->ID); $posts = get_posts($args); if($posts): foreach($posts as $post): setup_postdata($post); ?>
    <ul>
    	<li><span class="dashicons dashicons-desktop"></span> <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo $user->display_name; ?>のページを確認する</a></li>
    	<li><span class="dashicons dashicons-edit"></span> <a href="<?php echo esc_url(get_edit_post_link()); ?>"><?php echo $user->display_name; ?>の情報を修正する</a></li>
    </ul>
    <?php endforeach; else: ?>
    <p>まだページを作成されていません、ページが作成されるまで今しばらくお待ちください。</p>
    <?php endif; wp_reset_postdata(); ?>
<?php endif; ?>
</div>
<style type="text/css">
#org_dashboard .dashicons{
    vertical-align: middle;
}
#org_dashboard .midashi{
    font-size: 18px;
    font-weight: bold;
}
#org_dashboard .post-list{
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 30px;
}
#org_dashboard .post-list li:last-child{
    margin-bottom: 0;
}
</style>