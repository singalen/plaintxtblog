<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="container">
	<div id="content">

		<div class="post-header">
			<h2>Recent Posts</h2>
		</div><!-- END POST-HEADER  -->

		<div class="post" id="recent-posts">
				<?php if (have_posts()) : ?>
				<?php query_posts('cat=-0'); ?>
				<?php while (have_posts()) : the_post(); ?>
			<ul class="list" id="post-excerpt-<?php the_ID(); ?>">
				<li>
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permalink to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<ul>
						<li>
							Posted <?php the_time('d-M-y') ?> in <?php the_category(', ') ?> and has <?php comments_popup_link('no comments', 'one comment', '% comments'); ?> <?php edit_post_link('Revise', '[', ']'); ?>
							<br/>
							<span class="excerpt"><?php the_content_rss('Continued', FALSE, '', 50, 0); ?></span>
						</li>
					</ul>
				</li>
			</ul>
			<!--<?php trackback_rdf(); ?>-->
			<?php endwhile; ?>
		</div><!-- END POST -->

		<div class="post-header" style="margin-top:20px;">
			<h2>Recent Miscellaneous</h2>
		</div><!-- END POST-HEADER  -->
		<div class="clearer"></div>

		<?php /* SIMPLE RECENT COMMENTS PLUGIN 0.1  USED BY PERMISSION OF RAOUL http://www.raoul.shacknet.nu/ */
		function src_simple_recent_comments($src_count=7, $src_length=60, $pre_HTML='<li><h2>Recent Comments</h2>', $post_HTML='</li>') {
			global $wpdb;
			$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, 
					SUBSTRING(comment_content,1,$src_length) AS com_excerpt 
				FROM wp_comments 
				LEFT OUTER JOIN wp_posts ON (wp_comments.comment_post_ID = wp_posts.ID) 
				WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' 
				ORDER BY comment_date_gmt DESC 
				LIMIT $src_count";
			$comments = $wpdb->get_results($sql);
			$output = $pre_HTML;
			$output .= "\n<ul>";
			foreach ($comments as $comment) {
				$output .= "\n\t<li><a href=\"" . get_permalink($comment->ID) . "#comment-" . $comment->comment_ID  . "\" title=\"on " . $comment->post_title . "\">" . $comment->comment_author . "</a>: " . strip_tags($comment->com_excerpt) . "...</li>";
			}
			$output .= "\n</ul>";
			$output .= $post_HTML;
			echo $output;
		}
		?>

			<div class="content-column post">
				<ul class="list" id="recent-comments">
					<?php /*FIRST NUMBER IS COMMENT COUNT. SECOND IS TOTAL CHARACTER COUNT */ src_simple_recent_comments(5, 125) ?>
				</ul>
			</div><!-- END CONTENT COLUMN -->
			<div class="content-column post">
				<ul class="list" id="recent-links">
					<li>
						<h2>Recent Links</h2>
						<ul>
							<?php get_links('-1', '<li>', '</li>', '<br/>&mdash; ', FALSE, '_id', TRUE, FALSE, 5, FALSE); ?>
						</ul>
					</li>
				</ul>
			</div><!-- END CONTENT COLUMN / POST -->

		<?php else : ?>
			<?php /* INCLUDE FOR ERROR TEXT */ include (TEMPLATEPATH . '/errortext.php'); ?>
		<?php endif; ?>

	</div><!-- END CONTENT -->
</div><!-- END CONTAINER -->

<?php get_footer(); ?>