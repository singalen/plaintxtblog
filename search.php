<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="container">
	<div id="content">

		<?php if (have_posts()) : ?>

		<div class="post-header">
			<h2>Search Results</h2>
		</div><!-- END POST-HEADER -->

		<div class="post" id="search-results">
			<ol>
				<?php while (have_posts()) : the_post(); ?>

				<li id="post-<?php the_ID(); ?>" style="margin-bottom:10px;">
					<strong><a href="<?php the_permalink() ?>" rel="bookmark" title="Permalink to <?php the_title(); ?>"><?php the_title(); ?></a></strong>
					posted on <a href="<?php the_permalink() ?>" rel="permalink" title="Permalink to <?php the_title(); ?>"><?php the_time('d-M-y') ?></a> in <?php the_category(', ') ?> and has <?php comments_popup_link('no comments', 'one comment', '% comments'); ?>
					<br/>
					<span class="excerpt"><?php the_excerpt_rss(); ?></span>
				</li>

				<?php endwhile; ?>
			</ol>
		</div><!-- END POST -->

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older posts') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer posts &raquo;') ?></div>
			<div class="middle"><a href="<?php echo get_settings('home'); ?>/" title="Home: <?php bloginfo('name'); ?>">Home</a></div>
		</div><!-- END NAVIGATION -->

		<?php else : ?>

		<div class="post-header">
			<h2>Search Results</h2>
			<h3>Nothing Found</h3>
		</div><!-- END POST-HEADER -->
		<p>Sorry, you search yielded no results. Try a different keyword, and search again.</p>

		<?php endif; ?>

	</div><!-- END CONTENT -->
</div><!-- END CONTAINER -->

<?php get_footer(); ?>