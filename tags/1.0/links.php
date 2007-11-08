<?php
/*
Template Name: Links
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
				<ul class="list">
					<?php
						$link_cats = $wpdb->get_results("SELECT cat_id, cat_name FROM $wpdb->linkcategories");
						foreach ($link_cats as $link_cat) {
					 ?>
					<li id="linkcat-<?php echo $link_cat->cat_id; ?>"><h2><?php echo $link_cat->cat_name; ?></h2>
						<ul>
							<?php wp_get_links($link_cat->cat_id); ?>
						</ul>
					</li>
					<?php } ?>
				</ul>
			</div><!-- END POST-ENTRY -->
			<!--<?php trackback_rdf(); ?>-->
		</div><!-- END POST -->

		<?php endwhile; endif; ?>

	</div><!-- END CONTENT -->
</div><!-- END CONTAINER -->

<?php get_footer(); ?>