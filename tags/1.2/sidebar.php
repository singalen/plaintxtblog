<div id="col1" class="sidebar">
	<ul>
	<?php /* IF THIS IS THE HOME PAGE, DISPLAYS ALL PAGES. IF NOT, THEN JUST THE PARENT PAGES  */ if(is_home()) {
		wp_list_pages('depth=0&sort_column=menu_order&title_li=<h2>Contents</h2>' );
		echo '<li id="meta"><h2>Meta</h2><ul>';
		wp_register();
		echo '<li>';
		wp_loginout();
		echo '</li></ul></li>';
		wp_meta();
	} else {
		wp_list_pages('depth=1&sort_column=menu_order&title_li=<h2>Contents</h2>' );
	} ?> 
		<li id="xml-feeds">
			<h2>XML Feeds</h2>
			<ul>
				<li>Posts RSS <a href="<?php bloginfo('rss2_url'); ?>" title="<?php bloginfo('name'); ?> RSS 2.0 (XML) Feed" rel="alternate" type="application/rss+xml"><img src="<?php bloginfo('stylesheet_directory'); ?>/feed.png" alt="RSS 2.0 XML Feed" /></a></li>
				<li>Comments RSS <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php bloginfo('name'); ?> Comments RSS 2.0 (XML) Feed" rel="alternate" type="application/rss+xml"><img src="<?php bloginfo('stylesheet_directory'); ?>/feed.png" alt="Comments RSS 2.0 XML Feed" /></a></li>
			</ul>
		</li>
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
	<?php /* IF THIS IS A PAGE */ if (is_page()) {
		$current_page = $post->ID;
	while($current_page) {
		$page_query = $wpdb->get_row("SELECT ID, post_name, post_parent FROM $wpdb->posts WHERE ID = '$current_page'");
		$current_page = $page_query->post_parent;
	}
		$parent_id = $page_query->ID;
		$parent_name = $page_query->post_name;
		$test_for_child = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id'");
	if($test_for_child) { ?>
		<li>
			<h2 style="text-transform:capitalize;"><a href=><?php echo $parent_name; ?></a></h2>
			<ul>
				<?php wp_list_pages('sort_column=post_name&title_li=&child_of='. $parent_id); ?> 
			</ul>
		</li>
	<?php } } ?>
		<li id="categories">
			<h2>Categories</h2>
			<ul>
				<?php wp_list_cats('sort_column=name&hierarchical=0'); ?>
			</ul>
		</li>
	<?php if ( is_home() ) { ?>
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