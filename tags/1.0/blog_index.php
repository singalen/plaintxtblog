<?php
/*
Template Name: Blog Index
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="container">
	<div id="content">

	<?php if (have_posts()) : ?>
	<?php query_posts('cat=-0'); ?>
	<?php while (have_posts()) : the_post(); ?>

		<div class="post-header">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permalink to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<h3><?php the_time('d-M-y') ?></h3>
		</div><!-- END POST-HEADER  -->

		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="post-entry" id="post-entry-<?php the_ID(); ?>">
				<?php the_content(); ?>
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
			</div><!-- END POST-ENTRY -->
			<div class="post-footer">
				<p>
					Filed in <?php the_category(', ') ?>
					|
					<a href="<?php the_permalink() ?>" rel="permalink" title="Permalink to <?php the_title(); ?>">Permalink</a>
					|
					<?php comments_popup_link('Comments (0) &raquo;', 'Comments (1) &raquo;', 'Comments (%) &raquo;'); ?>
					<?php edit_post_link('Revise', ' [', ']'); ?>
				</p>
			</div><!-- END POST-FOOTER -->
			<!--<?php trackback_rdf(); ?>-->
		</div><!-- END POST -->	

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older posts') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer posts &raquo;') ?></div>
			<div class="middle"><a href="<?php echo get_settings('home'); ?>/" title="Home: <?php bloginfo('name'); ?>">Home</a></div>
		</div><!-- END NAVIGATION -->

		<?php else : ?>
			<?php /* INCLUDE FOR ERROR TEXT */ include (TEMPLATEPATH . '/errortext.php'); ?>
		<?php endif; ?>

	</div><!-- END CONTENT -->
</div><!-- END CONTAINER -->

<?php get_footer(); ?>