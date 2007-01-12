<?php
/*
Template Name: Archives Page
*/
?>
<?php get_header() ?>
	
	<div id="container">
		<div id="content" class="hfeed">

<?php the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php plaintxtblog_post_class() ?>">
				<h2 class="entry-title"><?php the_title() ?></h2>
				<div class="entry-content">
<?php the_content(); ?>

				<div class="clearer"></div>
				<div class="content-column">
					<ul class="page-list">
						<li class="category-archives">
							<h3>Category Archives</h3>
							<ul>
								<?php wp_list_cats('sort_column=name&optioncount=1&feed=(RSS)&feed_image='.get_bloginfo('template_url').'/images/feed.png&hierarchical=1'); ?>
							</ul>
						</li>
					</ul>
				</div>

				<div class="content-column">
					<ul class="page-list">
						<li class="monthly-archives">
							<h3>Monthly Archives</h3>
							<ul>
								<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
							</ul>
						</li>
					</ul>

					<ul class="page-list">
						<li class="feed-links">
							<h3>RSS Feeds</h3>
							<ul>
								<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All posts', 'plaintxtblog') ?></a></li>
								<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> Comments RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All comments', 'plaintxtblog') ?></a></li>							
							</ul>
						</li>
					</ul>
				</div>
				<div class="clearer"></div>
<?php edit_post_link(__('Edit this entry.', 'plaintxtblog'),'<p class="entry-edit">','</p>') ?>

				</div>
			</div>
<?php if ( get_post_custom_values('comments') ) comments_template() ?>

		</div>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>