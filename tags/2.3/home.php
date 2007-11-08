<?php 
	get_header();
	get_sidebar();
?>

<div id="content" class="narrowcolumn">

<?php /* OPTION VARIABLE FOR DISPLAYING BLOG.TXT HOME: IF IS CUSTOM, THEN... */ global $plaintxtblog; if ($plaintxtblog->option['summaryhome'] == 'index') { ?>
 
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" class="post">
		<div class="post-header">
			<h2 class="post-title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<h3 class="post-date"><?php the_time('d-M-y') ?></h3>
		</div><!-- END POST-HEADER  -->
		<div class="post-entry">
			<?php the_content(); ?>
			<?php link_pages('<p style="font-weight:bold;">Pages: ', '</p>', 'number'); ?>
		</div><!-- END POST-ENTRY -->
		<div class="post-metadata">
			<p class="post-footer">Filed in <?php the_category(', ') ?> | <a href="<?php the_permalink() ?>" rel="permalink" title="Permalink to <?php the_title(); ?>">Permalink</a> | <?php comments_popup_link('Comments (0) &raquo;', 'Comments (1) &raquo;', 'Comments (%) &raquo;'); ?> <?php edit_post_link('Revise', ' | ', ''); ?></p>
		</div><!-- END POST-METADATA -->
		<!-- <?php trackback_rdf(); ?> -->
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

<?php } else { /* END OF 'INDEX' OR NOT, BEING SUMMARY_HOME STUFF */ ?>

	<div id="post-summary" class="post">
		<div class="post-header">
			<h2 class="post-title">Recent Posts</h2>
		</div><!-- END POST-HEADER  -->
		<div id="post-entry-summary" class="post-entry">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
			<div id="post-excerpt-<?php the_ID(); ?>" class="post-excerpt">
				<h3 class="excerpt-title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
				<p class="excerpt-entry"><?php the_content_rss('', FALSE, '', 50, 0); ?></p>
				<p class="excerpt-footer">Posted on <?php the_time('d-M-y') ?> | Filed in <?php the_category(', ') ?> | <a href="<?php the_permalink() ?>" rel="permalink" title="Permalink to <?php the_title(); ?>">Permalink</a> | <?php comments_popup_link('Comments (0) &raquo;', 'Comments (1) &raquo;', 'Comments (%) &raquo;'); ?> <?php edit_post_link('Revise', ' | ', ''); ?></p>
				<!-- <?php trackback_rdf(); ?> -->
			</div><!-- END POST-EXCERPT -->
<?php endwhile; ?>
			<h4 class="post-navigation alignleft"><?php next_posts_link('&laquo; Older posts') ?></h4>
			<h4 class="post-navigation alignright"><?php previous_posts_link('Newer posts &raquo;') ?></h4>
		</div><!-- END POST-ENTRY -->
	</div><!-- END POST -->
	
	<div id="other-summary" class="post" style="clear:both;">
		<div class="post-header" style="margin:0;">
			<h2 class="post-title">Recent Miscellaneous</h2>
		</div><!-- END POST-HEADER  -->
		<div class="content-column post-entry">
			<ul class="list" id="recent-comments">
				<?php plaintxtblog_src(7, 75, '<li><h2>Recently Commented</h2>', '</li>'); ?>
				<?php /* YOU CAN CHANGE VARIABLES FOR THE RECENT COMMENTS. (X, Y, 'BEFORE', 'AFTER') WHERE X=NUMBER OF COMMENTS, Y=COMMENT LENGTH, BEFORE=TEXT BEFORE, AND AFTER=TEXT AFTER */ ?>
			</ul>
		</div><!-- END CONTENT COLUMN -->
		<div class="content-column post-entry">
			<ul class="list" id="recent-links">
				<li>
					<h2>Recently Linked</h2>
					<ul>
						<?php get_links('-1', '<li>', '</li>', ' &mdash; ', FALSE, '_id', TRUE, FALSE, 7, FALSE); ?>
					</ul>
				</li>
			</ul>
		</div><!-- END CONTENT COLUMN  -->
	</div><!-- END POST -->

<?php else : ?>
<?php /* INCLUDE FOR ERROR TEXT */ include (TEMPLATEPATH . '/errortext.php'); ?>
<?php endif; ?>


<?php } /* FINISHED ASKING IF INDEX OR SUMMARY FROM THEME OPTIONS */  ?>

</div><!-- END CONTENT -->

<?php get_footer(); ?>