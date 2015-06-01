	<div id="footer">
		<span id="copyright">&copy; <?php echo( date('Y') ); ?> <?php plaintxtblog_admin_hCard(); ?></span>
		<span class="meta-sep">|</span>
		<span id="`footer-rss"><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('Posts RSS', 'plaintxtblog') ?></a> &amp; <a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> Comments RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('Comments RSS', 'plaintxtblog') ?></a></span>
	</div><!-- #footer -->

</div><!-- #wrapper -->

<?php wp_footer() // Do not remove; helps plugins work ?>

</body><!-- end transmission -->
</html>