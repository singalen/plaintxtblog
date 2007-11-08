<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="container">
	<div id="content">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="post-header">
			<h2><?php the_title(); ?></h2>
		</div><!-- END POST-HEADER  -->

		<div class="post" id="post-<?php the_ID(); ?>">	
			<div class="post-entry" id="post-entry-<?php the_ID(); ?>">
				<?php the_content(); ?>
				<div class="clearer"></div>
				<div class="content-column" id="archives-page">
					<ul class="list">
						<li>
							<h2>Monthly Archives</h2>
							<ul>
								<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
							</ul>
						</li>
						<li>
							<h2>Category Archives</h2>
							<ul>
								<?php wp_list_cats('sort_column=name&optioncount=1&feed=(RSS)&feed_image='.get_bloginfo('template_url').'/feed.png&hierarchical=1'); ?>
							</ul>
						</li>
					</ul>
				</div><!-- END CONTENT-COLUMN -->
				<div class="content-column" id="category-archives">
					<ul class="list">
						<li id="recent-posts">
							<h2>Recent Posts</h2>
							<ul>
								<?php get_archives('postbypost', '10', 'custom', '<li>', '</li>'); ?>
							</ul>
						</li>
						<li id="all-xml-feeds">
							<h2>XML Feeds</h2>
							<ul>
								<li>Atom 1.0 <a href="<?php bloginfo('atom_url'); ?>" title="<?php bloginfo('name'); ?> Atom (XML) Feed" rel="alternate" type="application/atom+xml"><img src="<?php bloginfo('stylesheet_directory'); ?>/feed.png" alt="Atom XML Feed" /></a></li>
								<li>RSS 2.0 <a href="<?php bloginfo('rss2_url'); ?>" title="<?php bloginfo('name'); ?> RSS 2.0 (XML) Feed" rel="alternate" type="application/rss+xml"><img src="<?php bloginfo('stylesheet_directory'); ?>/feed.png" alt="RSS 2.0 XML Feed" /></a></li>
								<li>Comments RSS 2.0 <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php bloginfo('name'); ?> Comments RSS 2.0 (XML) Feed" rel="alternate" type="application/rss+xml"><img src="<?php bloginfo('stylesheet_directory'); ?>/feed.png" alt="Comments RSS 2.0 XML Feed" /></a></li>
								<li>RDF/RSS 1.0 <a href="<?php bloginfo('rdf_url'); ?>" title="<?php bloginfo('name'); ?> RDF/RSS 1.0 (XML) Feed" rel="alternate" type="application/rdf+xml"><img src="<?php bloginfo('stylesheet_directory'); ?>/feed.png" alt="RDF/RSS 1.0 XML Feed" /></a></li>
								<li>RSS 0.92 <a href="<?php bloginfo('rss_url'); ?>" title="<?php bloginfo('name'); ?> RSS 0.92 (XML) Feed" rel="alternate" type="text/xml"><img src="<?php bloginfo('stylesheet_directory'); ?>/feed.png" alt="RSS 0.92 XML Feed" /></a></li>
							</ul>
						</li>
					</ul>
				</div><!-- END CCONTENT-COLUMN -->
			</div><!-- END POST-ENTRY -->
			<!--<?php trackback_rdf(); ?>-->
		</div><!-- END POST -->

		<?php endwhile; endif; ?>

	</div><!-- END CONTENT -->
</div><!-- END CONTAINER -->

<?php get_footer(); ?>