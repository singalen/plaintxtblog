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
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
				<?php edit_post_link('Revise this page.', '<p>', '</p>'); ?>
			</div><!-- END POST-ENTRY -->
			<!--<?php trackback_rdf(); ?>-->
		</div><!-- END POST -->

		<?php endwhile; endif; ?>

	</div><!-- END CONTENT -->
</div><!-- END CONTAINER -->

<?php get_footer(); ?>