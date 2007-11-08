<div id="footer">
	<p>
		<a href="<?php echo get_settings('home'); ?>/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> &copy; <?php echo(date('Y')); ?> <?php the_author('nickname'); ?>
		|
		Powered by <a href="http://wordpress.org/" title="WordPress">WordPress</a>
		|
		<a href="http://www.plaintxt.org/themes/plaintxtblog/" rel="follow" title="plaintxtBlog">plaintxtBlog</a> theme by <a href="http://scottwallick.com/" rel="follow" title="scottwallick.com">Scott</a>
		|
		Valid <a href="http://validator.w3.org/check/referer" rel="nofollow" title="Valid XHTML 1.0 Strict">XHTML</a> and <a href="http://jigsaw.w3.org/css-validator/validator?profile=css2&amp;warning=2&amp;uri=<?php bloginfo('stylesheet_url'); ?>" rel="nofollow" title="Valid CSS">CSS</a>
		<?php do_action('wp_footer'); ?>
	</p>
</div><!-- END FOOTER -->
	<!-- Somehow <?php echo $wpdb->num_queries; ?> queries occured in <?php timer_stop(1); ?> seconds. Magic! -->
	<!-- The "plaintxtBlog" theme v1.1 copyright (c) 2006 Scott Allan Wallick - http://www.plaintxt.org/themes/ -->
</body>
</html>