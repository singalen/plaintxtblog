<div id="footer">
	<p id="blog-footer">
		<a href="<?php echo get_settings('home'); ?>/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> &copy; <?php echo(date('Y')); ?> <?php the_author('nickname'); ?>
		|
		Powered by <a href="http://wordpress.org/" title="WordPress">WordPress</a>
		|
		<a href="http://www.plaintxt.org/themes/plaintxtblog/" title="plaintxtBlog" rel="follow">plaintxtBlog</a> theme by <a href="http://scottwallick.com/" title="scottwallick.com" rel="follow">Scott</a> 
		|
		Valid <a href="http://validator.w3.org/check/referer" title="Valid XHTML 1.0 Strict" rel="nofollow">XHTML</a> &amp; <a href="http://jigsaw.w3.org/css-validator/validator?profile=css2&amp;warning=2&amp;uri=<?php bloginfo('stylesheet_url'); ?>" title="Valid CSS" rel="nofollow">CSS</a>
		|
		<a href="<?php bloginfo('rss2_url'); ?>" title="<?php bloginfo('name'); ?> RSS 2.0 (XML) Feed" rel="alternate" type="application/rss+xml">Posts RSS</a> &amp;  <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php bloginfo('name'); ?> Comments RSS 2.0 (XML) Feed" rel="alternate" type="application/rss+xml">Comments RSS</a>
		<?php do_action('wp_footer'); ?> 
	</p>
</div><!-- END FOOTER -->
	<!-- Somehow <?php echo $wpdb->num_queries; ?> queries occured in <?php timer_stop(1); ?> seconds. Magic! -->
	<!-- The "plaintxtBlog" theme v2.0 copyright (c) 2006 Scott Allan Wallick - http://www.plaintxt.org/themes/ -->
</body>
</html>