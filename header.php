<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us" lang="en-us">
<head profile="http://gmpg.org/xfn/11">
	<title><?php bloginfo('name') ?><?php if ( is_404() ) : ?> / <?php _e('Page not found', 'plaintxtblog') ?><?php elseif ( is_home() ) : ?> / <?php bloginfo('description') ?><?php elseif ( is_category() ) : ?> / <?php echo single_cat_title(); ?><?php elseif ( is_date() ) : ?> / Blog Archives<?php elseif ( is_search() ) : ?> / Search Results<?php else : ?> / <?php the_title() ?><?php endif ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version') ?>" /><!-- LEAVE FOR STATS -->
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php bloginfo('name') ?> RSS 2.0 Feed" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php bloginfo('name') ?> Comments RSS 2.0 Feed" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	<link rel="start" href="<?php echo get_settings('home') ?>/" title="<?php bloginfo('name') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" title="plaintxtBlog" media="all" />
<?php wp_head() ?>

</head>

<body class="<?php plaintxtblog_body_class() ?>">

<div id="wrapper">

	<div id="header">
		<h1 id="blog-title"><a href="<?php echo get_settings('home') ?>/" title="<?php bloginfo('name') ?>"><?php bloginfo('name') ?></a></h1>
		<div id="blog-description"><?php bloginfo('description') ?></div>
	</div>
	
	<p class="access"><a href="#content" title="<?php _e('Skip navigation to the content', 'plaintxtblog'); ?>"><?php _e('Skip navigation', 'plaintxtblog'); ?></a></p>

<?php plaintxtblog_globalnav() ?>