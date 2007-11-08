<?php get_header() ?>

	<div id="container">
		<div id="content" class="hfeed">

<?php the_post() ?>

			<div id="post-<?php the_ID(); ?>" class="<?php plaintxtblog_post_class() ?>">
				<h2 class="entry-title"><?php the_title(); ?></h2>
				<div class="entry-content">
<?php the_content() ?>

<?php link_pages('<div class="page-link">'.__('Pages: ', 'plaintxtblog'), '</div>', 'number'); ?>

<?php edit_post_link(__('Edit this entry.', 'plaintxtblog'),'<p class="entry-edit">','</p>') ?>

				</div>
			</div>

<?php if ( get_post_custom_values('comments') ) comments_template() ?>

		</div>
	</div>

<?php get_sidebar() ?>
<?php get_footer() ?>