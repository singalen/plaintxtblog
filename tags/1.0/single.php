<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="container">
	<div id="content">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="post-header">
			<h2><?php the_title(); ?></h2>
		</div><!-- END POST-HEADER -->

		<div class="post" id="post-<?php the_ID(); ?>">

			<div class="post-entry" id="post-entry-<?php the_ID(); ?>">
				<?php the_content(); ?>
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
			</div><!-- END POST-ENTRY -->

			<div id="metadata">
				<p>
					This entry was posted on <?php the_time('l, F jS, Y') ?> at <?php the_time('g:i A') ?> and filed in <?php the_category(', ') ?>.
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permalink to <?php the_title(); ?>">Bookmark</a> this entry.
					Follow the comments here with the <?php comments_rss_link('RSS 2.0'); ?> feed. 
					<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) { ?>You can <a href="#respond" title="Post a comment">leave a response</a> or <a href="<?php trackback_url(true); ?>" rel="trackback" title="Trackback URI">trackback</a>.
					<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) { ?>Comments are closed, but you can leave a <a href="<?php trackback_url(true); ?> " rel="trackback" title="Trackback URI">trackback</a>.
					<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) { ?>Skip to the end of this entry and leave a response. Trackbacks are closed.
					<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) { ?>Apologies. Comments and trackbacks are both currently closed.
					<?php } edit_post_link(); ?>
				</p>
			</div><!-- END SINGLE-METADATA -->

			<!-- <?php trackback_rdf(); ?> -->

		</div><!-- END POST -->

		<?php comments_template(); ?>

		<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
			<div class="middle"><a href="<?php echo get_settings('home'); ?>/" title="Home: <?php bloginfo('name'); ?>">Home</a></div>
		</div><!-- END NAVIGATION -->

		<?php endwhile; else: ?>
			<?php /* INCLUDE FOR ERROR TEXT */ include (TEMPLATEPATH . '/errortext.php'); ?>
		<?php endif; ?>

	</div><!-- END CONTENT -->
</div><!-- END CONTAINER -->

<?php get_footer(); ?>