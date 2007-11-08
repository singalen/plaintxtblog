<div id="col1" class="sidebar">
	<ul>
		<?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>
		<li id="xml-feeds">
			<h2>XML Feeds</h2>
			<ul>
				<li>Posts RSS <a href="<?php bloginfo('rss2_url'); ?>" title="<?php bloginfo('name'); ?> RSS 2.0 (XML) Feed" rel="alternate" type="application/rss+xml"><img src="<?php bloginfo('stylesheet_directory'); ?>/feed.png" alt="RSS 2.0 XML Feed" /></a></li>
				<li>Comments RSS <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php bloginfo('name'); ?> Comments RSS 2.0 (XML) Feed" rel="alternate" type="application/rss+xml"><img src="<?php bloginfo('stylesheet_directory'); ?>/feed.png" alt="Comments RSS 2.0 XML Feed" /></a></li>
			</ul>
		</li>
		<?php if ( is_home() || is_page() ) { ?>
		<li id="meta">
			<h2>Meta</h2>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://wordpress.org/" title="Powered by WordPress">WordPress</a></li>
				<?php wp_meta(); ?>
			</ul>
		</li>
		<?php } ?>
		<li id="blog-search">
			<h2><label for="s">Search</label></h2>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</li>
	</ul>
</div><!-- END COL1 SIDEBAR -->

<div id="col2" class="sidebar">
	<ul>
	<?php /* IF THIS USER JUST SEARCHED THE BLOG */ if ( is_search() ) { ?>
		<li>You just search the contents:</li>
		<li><strong><?php echo wp_specialchars($s); ?></strong></li>
	<?php } ?>
		<li id="categories">
			<h2>Categories</h2>
			<ul>
				<?php wp_list_cats('sort_column=name&hierarchical=0'); ?>
			</ul>
		</li>
		<li id="archives">
			<h2>Archives</h2>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</li>
	<?php if ( is_home() || is_page() ) { ?>
	<?php
		$link_cats = $wpdb->get_results("SELECT cat_id, cat_name FROM $wpdb->linkcategories");
		foreach ($link_cats as $link_cat) {
	?>
	<li id="linkcat-<?php echo $link_cat->cat_id; ?>"><h2><?php echo $link_cat->cat_name; ?></h2>
		<ul>
			<?php get_links($link_cat->cat_id, '<li>', '</li>', '', FALSE, 'id', FALSE, FALSE); ?>
		</ul>
	</li>
	<?php } ?>
	<?php } ?>
	</ul>
</div><!-- END COL2 SIDEBAR -->