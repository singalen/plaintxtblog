<?php get_header() ?>

	<div id="container">
		<div id="content" class="hfeed">

<?php the_post() ?>

<?php if ( is_day() ) : ?>
			<h2 class="page-title"><?php printf(__('Daily Archives: <span>%s</span>', 'plaintxtblog'), get_the_time(__('F jS, Y', 'plaintxtblog'))) ?></h2>
<?php elseif ( is_month() ) : ?>
			<h2 class="page-title"><?php printf(__('Monthly Archives: <span>%s</span>', 'plaintxtblog'), get_the_time(__('F Y', 'plaintxtblog'))) ?></h2>
<?php elseif ( is_year() ) : ?>
			<h2 class="page-title"><?php printf(__('Yearly Archives: <span>%s</span>', 'plaintxtblog'), get_the_time(__('Y', 'plaintxtblog'))) ?></h2>
<?php elseif ( is_author() ) : ?>
			<h2 class="page-title"><?php $curauth = plaintxtblog_get_author(); printf(__('Author Archives: <span class="vcard"><span class="fn n">%s</span></span>', 'plaintxtblog'),  $curauth->display_name) ?></h2>
<?php elseif ( is_category() ) : ?>
			<h2 class="page-title"><?php _e('Category Archives:', 'plaintxtblog') ?> <span class="page-cat"><?php echo single_cat_title(); ?></span></h2>
			<div class="archive-meta"><?php echo apply_filters('archive_meta', category_description()); ?></div>
<?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
			<h2 class="page-title"><?php _e('Blog Archives', 'plaintxtblog') ?></h2>
<?php endif; ?>

<?php rewind_posts() ?>

<?php while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID() ?>" class="<?php plaintxtblog_post_class() ?>">
				<div class="entry-header">
					<h3 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'plaintxtblog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h3>
					<abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php unset($previousday); printf(__('%1$s', 'plaintxtblog'), the_date('d-M-y', false)) ?></abbr>
				</div>
				<div class="entry-content">
<?php the_excerpt('<span class="more-link">'.__('More&hellip;', 'plaintxtblog').'</span>') ?>

				</div>
				<div class="entry-meta">
					<span class="entry-category"><?php printf(__('Filed in %s', 'plaintxtblog'), get_the_category_list(', ')) ?></span>
					<span class="metasep">|</span>
<?php edit_post_link(__('Edit', 'plaintxtblog'), "\t\t\t\t\t<span class='entry-edit'>", "</span>\n\t\t\t\t\t<span class='metasep'>|</span>\n"); ?>
					<span class="entry-comments"><?php comments_popup_link(__('Comments (0) &raquo;', 'plaintxtblog'), __('Comments (1) &raquo;', 'plaintxtblog'), __('Comments (%) &raquo;', 'plaintxtblog')) ?></span>
				</div>
			</div>

<?php endwhile ?>

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('&laquo; Older posts', 'plaintxtblog')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts &raquo;', 'plaintxtblog')) ?></div>
				<div class="nav-home"><a href="<?php echo get_settings('home') ?>/" title="<?php bloginfo('name') ?>"><?php _e('Home', 'plaintxtblog'); ?></a></div>
			</div>

		</div>
	</div>

<?php get_sidebar() ?>
<?php get_footer() ?>