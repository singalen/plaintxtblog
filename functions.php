<?php
function plaintxtblog_globalnav() {
	echo "<div id=\"globalnav\"><ul id=\"menu\">";
	if ( !is_home() || is_paged() ) { ?><li class="page_item home_page_item"><a href="<?php bloginfo('home') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?>"><?php _e('Home', 'plaintxtblog') ?></a></li><?php }
	$menu = wp_list_pages('title_li=&amp;sort_column=menu_order&echo=0');
	echo str_replace(array("\r", "\n", "\t"), '', $menu);
	echo "</ul></div>\n";
}

function plaintxtblog_admin_hCard() {
	global $wpdb, $user_info;
	$user_info = get_userdata(1);
	echo '<span class="vcard"><a class="url fn n" href="' . $user_info->user_url . '"><span class="given-name">' . $user_info->first_name . '</span> <span class="family-name">' . $user_info->last_name . '</span></a></span>';
}

function plaintxtblog_author_hCard() {
	global $wpdb, $authordata;
	echo '<span class="entry-author author vcard"><a class="url fn" href="' . get_author_link(false, $authordata->ID, $authordata->user_nicename) . '" title="View all posts by ' . $authordata->display_name . '">' . get_the_author() . '</a></span>';
}

function plaintxtblog_body_class( $print = true ) {
	global $wp_query, $current_user;

	$c = array('wordpress');

	plaintxtblog_date_classes(time(), $c);

	is_home()       ? $c[] = 'home'       : null;
	is_archive()    ? $c[] = 'archive'    : null;
	is_date()       ? $c[] = 'date'       : null;
	is_search()     ? $c[] = 'search'     : null;
	is_paged()      ? $c[] = 'paged'      : null;
	is_attachment() ? $c[] = 'attachment' : null;
	is_404()        ? $c[] = 'four04'     : null;

	if ( is_single() ) {
		the_post();
		$c[] = 'single';
		if ( isset($wp_query->post->post_date) )
			plaintxtblog_date_classes(mysql2date('U', $wp_query->post->post_date), $c, 's-');
		foreach ( (array) get_the_category() as $cat )
			$c[] = 's-category-' . $cat->category_nicename;
			$c[] = 's-author-' . get_the_author_login();
		rewind_posts();
	}

	else if ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$c[] = 'author';
		$c[] = 'author-' . $author->user_nicename;
	}

	else if ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$c[] = 'category';
		$c[] = 'category-' . $cat->category_nicename;
	}

	else if ( is_page() ) {
		the_post();
		$c[] = 'page';
		$c[] = 'page-author-' . get_the_author_login();
		rewind_posts();
	}

	if ( $current_user->ID )
		$c[] = 'loggedin';

	$c = join(' ', apply_filters('body_class',  $c));

	return $print ? print($c) : $c;
}

function plaintxtblog_post_class( $print = true ) {
	global $post, $plaintxtblog_post_alt;

	$c = array('hentry', "p$plaintxtblog_post_alt", $post->post_type, $post->post_status);

	$c[] = 'author-' . get_the_author_login();

	foreach ( (array) get_the_category() as $cat )
		$c[] = 'category-' . $cat->category_nicename;

	plaintxtblog_date_classes(mysql2date('U', $post->post_date), $c);

	if ( ++$plaintxtblog_post_alt % 2 )
		$c[] = 'alt';
	
	else if ( $post->post_password )
		$c[] = 'protected';

	$c = join(' ', apply_filters('post_class', $c));

	return $print ? print($c) : $c;
}
$plaintxtblog_post_alt = 1;

function plaintxtblog_comment_class( $print = true ) {
	global $comment, $post, $plaintxtblog_comment_alt;

	$c = array($comment->comment_type);

	if ( $comment->user_id > 0 ) {
		$user = get_userdata($comment->user_id);

		$c[] = "byuser commentauthor-$user->user_login";

		if ( $comment->user_id === $post->post_author )
			$c[] = 'bypostauthor';
	}

	plaintxtblog_date_classes(mysql2date('U', $comment->comment_date), $c, 'c-');
	if ( ++$plaintxtblog_comment_alt % 2 )
		$c[] = 'alt';

	$c[] = "c$plaintxtblog_comment_alt";

	if ( is_trackback() ) {
		$c[] = 'trackback';
	}

	$c = join(' ', apply_filters('comment_class', $c));

	return $print ? print($c) : $c;
}

function plaintxtblog_date_classes($t, &$c, $p = '') {
	$t = $t + (get_settings('gmt_offset') * 3600);
	$c[] = $p . 'y' . gmdate('Y', $t);
	$c[] = $p . 'm' . gmdate('m', $t);
	$c[] = $p . 'd' . gmdate('d', $t);
	$c[] = $p . 'h' . gmdate('h', $t);
}

function plaintxtblog_other_cats($glue) {
	$current_cat = single_cat_title('', false);
	$separator = "\n";
	$cats = explode($separator, get_the_category_list($separator));

	foreach ( $cats as $i => $str ) {
		if ( strstr($str, ">$current_cat<") ) {
			unset($cats[$i]);
			break;
		}
	}

	if ( empty($cats) )
		return false;

	return trim(join($glue, $cats));
}

function widget_plaintxtblog_search($args) {
	extract($args);
?>
		<?php echo $before_widget ?>
			<?php echo $before_title ?><label for="s"><?php _e('Search', 'plaintxtblog') ?></label><?php echo $after_title ?>
			<form id="searchform" method="get" action="<?php bloginfo('home') ?>">
				<div>
					<input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="10" />
					<input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find', 'plaintxtblog') ?>" />
				</div>
			</form>
		<?php echo $after_widget ?>
<?php
}

function widget_plaintxtblog_meta($args) {
	extract($args);
	$options = get_option('widget_meta');
	$title = empty($options['title']) ? __('Meta', 'plaintxtblog') : $options['title'];
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<?php wp_register() ?>
				<li><?php wp_loginout() ?></li>
				<?php wp_meta() ?>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

function widget_plaintxtblog_homelink($args) {
	extract($args);
	$options = get_option('widget_plaintxtblog_homelink');
	$title = empty($options['title']) ? __('Home', 'plaintxtblog') : $options['title'];
?>
<?php if ( !is_home() || is_paged() ) { ?>
		<?php echo $before_widget; ?>
			<?php echo $before_title ?><a href="<?php bloginfo('home') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?>"><?php echo $title ?></a><?php echo $after_title ?>
		<?php echo $after_widget; ?>
<?php } ?>
<?php
}

function widget_plaintxtblog_homelink_control() {
	$options = $newoptions = get_option('widget_plaintxtblog_homelink');
	if ( $_POST["homelink-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["homelink-title"]));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_plaintxtblog_homelink', $options);
	}
	$title = htmlspecialchars($options['title'], ENT_QUOTES);
?>
		<p style="text-align:left;"><?php _e('Adds a link to the home page on every page <em>except</em> the home.', 'plaintxtblog'); ?></p>
		<p><label for="homelink-title"><?php _e('Link Text:'); ?> <input style="width: 175px;" id="homelink-title" name="homelink-title" type="text" value="<?php echo $title; ?>" /></label></p>
		<input type="hidden" id="homelink-submit" name="homelink-submit" value="1" />
<?php
}

function widget_plaintxtblog_rsslinks($args) {
	extract($args);
	$options = get_option('widget_plaintxtblog_rsslinks');
	$title = empty($options['title']) ? __('RSS Links', 'plaintxtblog') : $options['title'];
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All posts', 'plaintxtblog') ?></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> Comments RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All comments', 'plaintxtblog') ?></a></li>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

function widget_plaintxtblog_rsslinks_control() {
	$options = $newoptions = get_option('widget_plaintxtblog_rsslinks');
	if ( $_POST["rsslinks-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["rsslinks-title"]));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_plaintxtblog_rsslinks', $options);
	}
	$title = htmlspecialchars($options['title'], ENT_QUOTES);
?>
			<p><label for="rsslinks-title"><?php _e('Title:'); ?> <input style="width: 250px;" id="rsslinks-title" name="rsslinks-title" type="text" value="<?php echo $title; ?>" /></label></p>
			<input type="hidden" id="rsslinks-submit" name="rsslinks-submit" value="1" />
<?php
}

function widget_plaintxtblog_links() {
	if ( function_exists('wp_list_bookmarks') ) {
		wp_list_bookmarks(array('title_before'=>'<h3>', 'title_after'=>'</h3>', 'show_images'=>true));
	} else {
		global $wpdb;

		$cats = $wpdb->get_results("
			SELECT DISTINCT link_category, cat_name, show_images, 
				show_description, show_rating, show_updated, sort_order, 
				sort_desc, list_limit
			FROM `$wpdb->links` 
			LEFT JOIN `$wpdb->linkcategories` ON (link_category = cat_id)
			WHERE link_visible =  'Y'
				AND list_limit <> 0
			ORDER BY cat_name ASC", ARRAY_A);
	
		if ($cats) {
			foreach ($cats as $cat) {
				$orderby = $cat['sort_order'];
				$orderby = (bool_from_yn($cat['sort_desc'])?'_':'') . $orderby;

				echo '	<li id="linkcat-' . $cat['link_category'] . '" class="linkcat"><h3>' . $cat['cat_name'] . "</h3>\n\t<ul>\n";
				get_links($cat['link_category'],
					'<li>',"</li>","\n",
					bool_from_yn($cat['show_images']),
					$orderby,
					bool_from_yn($cat['show_description']),
					bool_from_yn($cat['show_rating']),
					$cat['list_limit'],
					bool_from_yn($cat['show_updated']));

				echo "\n\t</ul>\n</li>\n";
			}
		}
	}
}

function plaintxtblog_widgets_init() {
	if ( !function_exists('register_sidebars') )
		return;

	$p = array(
		'before_title' => "<h3 class='widgettitle'>",
		'after_title' => "</h3>\n",
	);
	register_sidebars(2, $p);

	register_sidebar_widget(__('Search', 'plaintxtblog'), 'widget_plaintxtblog_search', null, 'search');
	unregister_widget_control('search');
	register_sidebar_widget(__('Meta', 'plaintxtblog'), 'widget_plaintxtblog_meta', null, 'meta');
	unregister_widget_control('meta');
	register_sidebar_widget(__('Links', 'plaintxtblog'), 'widget_plaintxtblog_links', null, 'links');
	unregister_widget_control('links');
	register_sidebar_widget(array('Home Link', 'widgets'), 'widget_plaintxtblog_homelink');
	register_widget_control(array('Home Link', 'widgets'), 'widget_plaintxtblog_homelink_control', 300, 125);
	register_sidebar_widget(array('RSS Links', 'widgets'), 'widget_plaintxtblog_rsslinks');
	register_widget_control(array('RSS Links', 'widgets'), 'widget_plaintxtblog_rsslinks_control', 300, 90);
}

function plaintxtblog_add_admin() {
	if ( $_GET['page'] == basename(__FILE__) ) {
	
		if ( 'save' == $_REQUEST['action'] ) {

			update_option( 'plaintxtblog_basefontsize', $_REQUEST['ptb_basefontsize'] );
			update_option( 'plaintxtblog_basefontfamily', $_REQUEST['ptb_basefontfamily'] );
			update_option( 'plaintxtblog_headingfontfamily', $_REQUEST['ptb_headingfontfamily'] );
			update_option( 'plaintxtblog_posttextalignment', $_REQUEST['ptb_posttextalignment'] );
			update_option( 'plaintxtblog_sidebarposition', $_REQUEST['ptb_sidebarposition'] );
			update_option( 'plaintxtblog_sidebartextalignment', $_REQUEST['ptb_sidebartextalignment'] );
			update_option( 'plaintxtblog_singlelayout', $_REQUEST['ptb_singlelayout'] );

			if( isset( $_REQUEST['ptb_basefontsize'] ) ) { update_option( 'plaintxtblog_basefontsize', $_REQUEST['ptb_basefontsize']  ); } else { delete_option( 'plaintxtblog_basefontsize' ); }
			if( isset( $_REQUEST['ptb_basefontfamily'] ) ) { update_option( 'plaintxtblog_basefontfamily', $_REQUEST['ptb_basefontfamily']  ); } else { delete_option( 'plaintxtblog_basefontfamily' ); }
			if( isset( $_REQUEST['ptb_headingfontfamily'] ) ) { update_option( 'plaintxtblog_headingfontfamily', $_REQUEST['ptb_headingfontfamily']  ); } else { delete_option('plaintxtblog_headingfontfamily'); }
			if( isset( $_REQUEST['ptb_posttextalignment' ] ) ) { update_option( 'plaintxtblog_posttextalignment', $_REQUEST['ptb_posttextalignment']  ); } else { delete_option('plaintxtblog_posttextalignment'); }
			if( isset( $_REQUEST['ptb_sidebarposition' ] ) ) { update_option( 'plaintxtblog_sidebarposition', $_REQUEST['ptb_sidebarposition']  ); } else { delete_option('plaintxtblog_sidebarposition'); }
			if( isset( $_REQUEST['ptb_sidebartextalignment' ] ) ) { update_option( 'plaintxtblog_sidebartextalignment', $_REQUEST['ptb_sidebartextalignment']  ); } else { delete_option('plaintxtblog_sidebartextalignment'); }
			if( isset( $_REQUEST['ptb_singlelayout' ] ) ) { update_option( 'plaintxtblog_singlelayout', $_REQUEST['ptb_singlelayout']  ); } else { delete_option('plaintxtblog_singlelayout'); }

			header("Location: themes.php?page=functions.php&saved=true");
			die;

		} else if( 'reset' == $_REQUEST['action'] ) {
			delete_option('plaintxtblog_basefontsize');
			delete_option('plaintxtblog_basefontfamily');
			delete_option('plaintxtblog_headingfontfamily');
			delete_option('plaintxtblog_posttextalignment');
			delete_option('plaintxtblog_sidebarposition');
			delete_option('plaintxtblog_sidebartextalignment');
			delete_option('plaintxtblog_singlelayout');

			header("Location: themes.php?page=functions.php&reset=true");
			die;
		}
		add_action('admin_head', 'plaintxtblog_admin_head');
	}
    add_theme_page("plaintxtBlog Options", "plaintxtBlog Options", 'edit_themes', basename(__FILE__), 'plaintxtblog_admin');
}

function plaintxtblog_admin_head() {
?>
<meta name="author" content="Scott Allan Wallick" />
<style type="text/css" media="all">
/*<![CDATA[*/
div.wrap table.editform tr td input.radio{background:#fff;border:none;margin-right:3px;}
div.wrap table.editform tr td input.text{text-align:center;width:5em;}
div.wrap table.editform tr td select.dropdown option{margin-right:10px;}
div.wrap table.editform th h3{font:normal 2em/133% georgia,times,serif;margin:1em 0 0.3em;color#222;}
div.wrap table.editform td.important span {background:#f5f5df;padding:0.1em 0.2em;font:85%/175% georgia,times,serif;}
span.info{color:#555;display:block;font-size:90%;margin:3px 0 9px;}
span.info span{font-weight:bold;}
a.xfn-me:hover{background:url(<?php echo get_template_directory_uri(); ?>/images/xfn-me.png) no-repeat top right;padding-right:18px;}
.arial{font-family:arial,helvetica,sans-serif;}
.courier{font-family:'courier new',courier,monospace;}
.georgia{font-family:georgia,times,serif;}
.lucida-console{font-family:'lucida console',monaco,monospace;}
.lucida-unicode{font-family:'lucida sans unicode','lucida grande',sans-serif;}
.tahoma{font-family:tahoma,geneva,sans-serif;}
.times{font-family:'times new roman',times,serif;}
.trebuchet{font-family:'trebuchet ms',helvetica,sans-serif;}
.verdana{font-family:verdana,geneva,sans-serif;}
/*]]>*/
</style>
<?php
}

function plaintxtblog_admin() {
	if ( $_REQUEST['saved'] ) { ?><div id="message1" class="updated fade"><p><strong><?php printf(__('PlaintxtBlog theme options saved. <a href="%s">View site &raquo;</a>', 'plaintxtblog'), get_bloginfo('home') . '/'); ?></strong></p></div><?php }
	if ( $_REQUEST['reset'] ) { ?><div id="message2" class="updated fade"><p><strong><?php _e('PlaintxtBlog theme options reset.', 'plaintxtblog'); ?></strong></p></div><?php } ?>

<div class="wrap">

	<h2><?php _e('Theme Options', 'plaintxtblog'); ?></h2>

	<p><?php _e('Thanks for selecting the <span class="theme-title">plaintxtBlog</span> theme. You can customize this theme with the options below. <strong>You must click on <i><u>S</u>ave Options</i> to save any changes.</strong> You can also discard your changes and reload the default settings by clicking on <i><u>R</u>eset</i>.', 'plaintxtblog'); ?></p>
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">

		<table class="editform" cellspacing="2" cellpadding="5" width="100%" border="0" summary="plaintxtblog theme options">

			<tr valign="top">
				<th scope="row" width="33%"><h3><?php _e('Typography', 'plaintxtblog'); ?></h3></th>
			</tr>

			<tr valign="top">
				<th scope="row" width="33%"><label for="ptb_basefontsize"><?php _e('Base font size', 'plaintxtblog'); ?></label></th> 
				<td>
					<input id="ptb_basefontsize" name="ptb_basefontsize" type="text" class="text" value="<?php if ( get_settings('plaintxtblog_basefontsize') == "" ) { echo "70%"; } else { echo get_settings('plaintxtblog_basefontsize'); } ?>" tabindex="1" size="10" /><br/>
					<span class="info"><?php _e('The base font size globally affects the size of text throughout your blog. This can be in any unit (e.g., px, pt, em), but I suggest using a percentage (%). Default is 70%.', 'plaintxtblog'); ?></span>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row" width="33%"><?php _e('Base font family', 'plaintxtblog'); ?></th> 
				<td>
					<label for="ptb_basefontArial" class="arial"><input id="ptb_basefontArial" name="ptb_basefontfamily" type="radio" class="radio" value="arial, helvetica, sans-serif" <?php if ( get_settings('plaintxtblog_basefontfamily') == "arial, helvetica, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="2" />Arial</label><br/>
					<label for="ptb_basefontCourier" class="courier"><input id="ptb_basefontCourier" name="ptb_basefontfamily" type="radio" class="radio" value="'courier new', courier, monospace" <?php if ( get_settings('plaintxtblog_basefontfamily') == "\'courier new\', courier, monospace" ) { echo 'checked="checked"'; } ?> tabindex="3" />Courier</label><br/>
					<label for="ptb_basefontGeorgia" class="georgia"><input id="ptb_basefontGeorgia" name="ptb_basefontfamily" type="radio" class="radio" value="georgia, times, serif" <?php if ( get_settings('plaintxtblog_basefontfamily') == "georgia, times, serif" ) { echo 'checked="checked"'; } ?> tabindex="4" />Georgia</label><br/>
					<label for="ptb_basefontLucidaConsole" class="lucida-console"><input id="ptb_basefontLucidaConsole" name="ptb_basefontfamily" type="radio" class="radio" value="'lucida console', monaco, monospace" <?php if ( get_settings('plaintxtblog_basefontfamily') == "\'lucida console\', monaco, monospace" ) { echo 'checked="checked"'; } ?> tabindex="5" />Lucida Console</label><br/>
					<label for="ptb_basefontLucidaUnicode" class="lucida-unicode"><input id="ptb_basefontLucidaUnicode" name="ptb_basefontfamily" type="radio" class="radio" value="'lucida sans unicode', 'lucida grande', sans-serif" <?php if ( get_settings('plaintxtblog_basefontfamily') == "\'lucida sans unicode\', \'lucida grande\', sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="6" />Lucida Sans Unicode</label><br/>
					<label for="ptb_basefontTahoma" class="tahoma"><input id="ptb_basefontTahoma" name="ptb_basefontfamily" type="radio" class="radio" value="tahoma, geneva, sans-serif" <?php if ( get_settings('plaintxtblog_basefontfamily') == "tahoma, geneva, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="7" />Tahoma</label><br/>
					<label for="ptb_basefontTimes" class="times"><input id="ptb_basefontTimes" name="ptb_basefontfamily" type="radio" class="radio" value="'times new roman', times, serif" <?php if ( get_settings('plaintxtblog_basefontfamilyfamily') == "\'times new roman\', times, serif" ) { echo 'checked="checked"'; } ?> tabindex="8" />Times</label><br/>
					<label for="ptb_basefontTrebuchetMS" class="trebuchet"><input id="ptb_basefontTrebuchetMS" name="ptb_basefontfamily" type="radio" class="radio" value="'trebuchet ms', helvetica, sans-serif" <?php if ( get_settings('plaintxtblog_basefontfamily') == "\'trebuchet ms\', helvetica, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="9" />Trebuchet MS</label><br/>
					<label for="ptb_basefontVerdana" class="verdana"><input id="ptb_basefontVerdana" name="ptb_basefontfamily" type="radio" class="radio" value="verdana, geneva, sans-serif" <?php if ( ( get_settings('plaintxtblog_basefontfamily') == "") || ( get_settings('plaintxtblog_basefontfamily') == "verdana, geneva, sans-serif") ) { echo 'checked="checked"'; } ?> tabindex="10" />Verdana</label><br/>
					<span class="info"><?php printf(__('The base font family sets the font for everything except content headings. The selection is limited to %1$s fonts, as they will display correctly. Default is <span class="verdana">Verdana</span>.', 'plaintxtblog'), '<cite><a href="http://en.wikipedia.org/wiki/Web_safe_fonts" title="Web safe fonts - Wikipedia">web safe</a></cite>'); ?></span>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row" width="33%"><?php _e('Heading font family', 'plaintxtblog'); ?></th> 
				<td>
					<label for="ptb_headingfontArial" class="arial"><input id="ptb_headingfontArial" name="ptb_headingfontfamily" type="radio" class="radio" value="arial, helvetica, sans-serif" <?php if ( get_settings('plaintxtblog_headingfontfamilyfamily') == "arial, helvetica, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="11" />Arial</label><br/>
					<label for="ptb_headingfontCourier" class="courier"><input id="ptb_headingfontCourier" name="ptb_headingfontfamily" type="radio" class="radio" value="'courier new', courier, monospace" <?php if ( get_settings('plaintxtblog_headingfontfamily') == "\'courier new\', courier, monospace" ) { echo 'checked="checked"'; } ?> tabindex="12" />Courier</label><br/>
					<label for="ptb_headingfontGeorgia" class="georgia"><input id="ptb_headingfontGeorgia" name="ptb_headingfontfamily" type="radio" class="radio" value="georgia, times, serif" <?php if ( get_settings('plaintxtblog_headingfontfamily') == "georgia, times, serif" ) { echo 'checked="checked"'; } ?> tabindex="13" />Georgia</label><br/>
					<label for="ptb_headingfontLucidaConsole" class="lucida-console"><input id="ptb_headingfontLucidaConsole" name="ptb_headingfontfamily" type="radio" class="radio" value="'lucida console', monaco, monospace" <?php if ( get_settings('plaintxtblog_headingfontfamily') == "\'lucida console\', monaco, monospace" ) { echo 'checked="checked"'; } ?> tabindex="14" />Lucida Console</label><br/>
					<label for="ptb_headingfontLucidaUnicode" class="lucida-unicode"><input id="ptb_headingfontLucidaUnicode" name="ptb_headingfontfamily" type="radio" class="radio" value="'lucida sans unicode', 'lucida grande', sans-serif" <?php if ( get_settings('plaintxtblog_headingfontfamily') == "\'lucida sans unicode\', \'lucida grande\', sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="15" />Lucida Sans Unicode</label><br/>
					<label for="ptb_headingfontTahoma" class="tahoma"><input id="ptb_headingfontTahoma" name="ptb_headingfontfamily" type="radio" class="radio" value="tahoma, geneva, sans-serif" <?php if ( get_settings('plaintxtblog_headingfontfamily') == "tahoma, geneva, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="16" />Tahoma</label><br/>
					<label for="ptb_headingfontTimes" class="times"><input id="ptb_headingfontTimes" name="ptb_headingfontfamily" type="radio" class="radio" value="'times new roman', times, serif" <?php if ( get_settings('plaintxtblog_headingfontfamily') == "\'times new roman\', times, serif" ) { echo 'checked="checked"'; } ?> tabindex="17" />Times</label><br/>
					<label for="ptb_headingfontTrebuchetMS" class="trebuchet"><input id="ptb_headingfontTrebuchetMS" name="ptb_headingfontfamily" type="radio" class="radio" value="'trebuchet ms', helvetica, sans-serif" <?php if ( get_settings('plaintxtblog_headingfontfamily') == "\'trebuchet ms\', helvetica, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="18" />Trebuchet MS</label><br/>
					<label for="ptb_headingfontVerdana" class="verdana"><input id="ptb_headingfontVerdana" name="ptb_headingfontfamily" type="radio" class="radio" value="verdana, geneva, sans-serif" <?php if ( ( get_settings('plaintxtblog_headingfontfamily') == "verdana, geneva, sans-serif") || ( get_settings('plaintxtblog_headingfontfamily') == "") ) { echo 'checked="checked"'; } ?> tabindex="19" />Verdana</label><br/>
					<span class="info"><?php printf(__('The heading font family sets the font for all content headings. The selection is limited to %1$s fonts, as they will display correctly. Default is <span class="verdana">Verdana</span>. ', 'plaintxtblog'), '<cite><a href="http://en.wikipedia.org/wiki/Web_safe_fonts" title="Web safe fonts - Wikipedia">web safe</a></cite>'); ?></span>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row" width="33%"><h3><?php _e('Layout', 'plaintxtblog'); ?></h3></th>
			</tr>

			<tr valign="top">
				<th scope="row" width="33%"><label for="ptb_posttextalignment"><?php _e('Post text alignment', 'plaintxtblog'); ?></label></th> 
				<td>
					<select id="ptb_posttextalignment" name="ptb_posttextalignment" tabindex="23" class="dropdown">
						<option value="center" <?php if ( get_settings('plaintxtblog_posttextalignment') == "center" ) { echo 'selected="selected"'; } ?>><?php _e('Centered', 'plaintxtblog'); ?> </option>
						<option value="justify" <?php if ( get_settings('plaintxtblog_posttextalignment') == "justify" ) { echo 'selected="selected"'; } ?>><?php _e('Justified', 'plaintxtblog'); ?> </option>
						<option value="left" <?php if ( ( get_settings('plaintxtblog_posttextalignment') == "") || ( get_settings('plaintxtblog_posttextalignment') == "left") ) { echo 'selected="selected"'; } ?>><?php _e('Left', 'plaintxtblog'); ?> </option>
						<option value="right" <?php if ( get_settings('plaintxtblog_posttextalignment') == "right" ) { echo 'selected="selected"'; } ?>><?php _e('Right', 'plaintxtblog'); ?> </option>
					</select>
					<br/>
					<span class="info"><?php _e('Choose one of the options for the alignment of the post entry text. Default is left.', 'plaintxtblog'); ?></span>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row" width="33%"><label for="ptb_sidebarposition"><?php _e('Sidebar position', 'plaintxtblog'); ?></label></th> 
				<td>
					<select id="ptb_sidebarposition" name="ptb_sidebarposition" tabindex="24" class="dropdown">
						<option value="left" <?php if ( ( get_settings('plaintxtblog_sidebarposition') == "") || ( get_settings('plaintxtblog_sidebarposition') == "left") ) { echo 'selected="selected"'; } ?>><?php _e('Left of content', 'plaintxtblog'); ?> </option>
						<option value="right" <?php if ( get_settings('plaintxtblog_sidebarposition') == "right" ) { echo 'selected="selected"'; } ?>><?php _e('Right of content', 'plaintxtblog'); ?> </option>
					</select>
					<br/>
					<span class="info"><?php _e('The sidebar can be positioned to the left or the right of the main content column. Default is left of content.', 'plaintxtblog'); ?></span>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row" width="33%"><label for="ptb_sidebartextalignment" class="dropdown"><?php _e('Sidebar text alignment', 'plaintxtblog'); ?></label></th> 
				<td>
					<select id="ptb_sidebartextalignment" name="ptb_sidebartextalignment" tabindex="25" class="dropdown">
						<option value="center" <?php if ( get_settings('plaintxtblog_sidebartextalignment') == "center" ) { echo 'selected="selected"'; } ?>><?php _e('Centered', 'plaintxtblog'); ?> </option>
						<option value="left" <?php if ( get_settings('plaintxtblog_sidebartextalignment') == "left" ) { echo 'selected="selected"'; } ?>><?php _e('Left', 'plaintxtblog'); ?> </option>
						<option value="right" <?php if ( ( get_settings('plaintxtblog_sidebartextalignment') == "") || ( get_settings('plaintxtblog_sidebartextalignment') == "right") ) { echo 'selected="selected"'; } ?>><?php _e('Right', 'plaintxtblog'); ?> </option>
					</select>
					<br/>
					<span class="info"><?php _e('Choose one of the options for the alignment of the sidebar text. Default is right.', 'plaintxtblog'); ?></span>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row" width="33%"><label for="ptb_singlelayout"><?php _e('Single post layout', 'plaintxtblog'); ?></label></th> 
				<td>
					<select id="ptb_singlelayout" name="ptb_singlelayout" tabindex="26" class="dropdown">
						<option value="normalsingle" <?php if ( ( get_settings('plaintxtblog_singlelayout') == "") || ( get_settings('plaintxtblog_singlelayout') == "normalsingle") ) { echo 'selected="selected"'; } ?>><?php _e('Normal layout (3 columns)', 'plaintxtblog'); ?> </option>
						<option value="singlesingle" <?php if ( get_settings('plaintxtblog_singlelayout') == "singlesingle" ) { echo 'selected="selected"'; } ?>><?php _e('Minimal layout (1 column)', 'plaintxtblog'); ?> </option>
					</select>
					<br/>
					<span class="info"><?php _e('The single <em>post</em> layout can either be three column (normal) or one column (minimal). Default is normal layout (3 columns). ', 'plaintxtblog'); ?></span>
				</td>
			</tr>

		</table>

		<p class="submit">
			<input name="save" type="submit" value="<?php _e('Save Options &raquo;', 'plaintxtblog'); ?>" tabindex="27" accesskey="S" />  
			<input name="action" type="hidden" value="save" />
		</p>

	</form>

	<h2 id="reset"><?php _e('Reset Options', 'plaintxtblog'); ?></h2>

	<p><?php _e('<strong>Resetting clears all changes to the above options.</strong> After resetting, default options are loaded and this theme will continue to be the active theme. A reset does not affect the actual theme files in any way.', 'plaintxtblog'); ?></p>

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<p class="submit">
			<input name="reset" type="submit" value="<?php _e('Reset', 'plaintxtblog'); ?>" onclick="return confirm('<?php _e('Click OK to reset. Any changes to these theme options will be lost!', 'verylaintxt'); ?>');" tabindex="28" accesskey="R" />
			<input name="action" type="hidden" value="reset" />
		</p>
	</form>

</div>

<div id="theme-information" class="wrap">

	<h2 id="info"><?php _e('Theme Information'); ?></h2>

	<p><?php _e('You are currently using the <a href="http://www.plaintxt.org/themes/plaintxtblog/" title="plaintxtBlog for WordPress"><span class="theme-title">plaintxtBlog</span></a> theme, version 3.0, by <span class="vcard"><a class="url xfn-me" href="http://scottwallick.com/" title="scottwallick.com" rel="me designer"><span class="n"><span class="given-name">Scott</span> <span class="additional-name">Allan</span> <span class="family-name">Wallick</span></span></a></span>.', 'plaintxtblog'); ?></p>

	<p><?php printf(__('Please read the included <a href="%1$s" title="Open the readme.html" rel="enclosure"  tabindex="29">documentation</a> for more information about the <span class="theme-title">plaintxtBlog</span> theme and its advanced features.', 'plaintxtblog'), get_template_directory_uri() . '/readme.html'); ?></p>

	<h3 id="license" style="margin-bottom:-8px;"><?php _e('License', 'plaintxtblog'); ?></h3>

	<p><?php printf(__('The <span class="theme-title">plaintxtBlog</span> theme copyright &copy; %1$s by <span class="vcard"><a class="url xfn-me" href="http://scottwallick.com/" title="scottwallick.com" rel="me designer"><span class="n"><span class="given-name">Scott</span> <span class="additional-name">Allan</span> <span class="family-name">Wallick</span></span></a></span> is distributed with the <cite class="vcard"><a class="fn org url" href="http://www.gnu.org/licenses/gpl.html" title="GNU General Public License" rel="license">GNU General Public License</a></cite>.', 'plaintxtblog'), gmdate('Y') ); ?></p>

</div>

<?php
}

function plaintxtblog_wp_head() {
	if ( get_settings('plaintxtblog_basefontsize') == "" ) {
		$basefontsize = '70%';
		} else {
			$basefontsize = stripslashes( get_settings('plaintxtblog_basefontsize') ); 
	};
	if ( get_settings('plaintxtblog_basefontfamily') == "" ) {
		$basefontfamily = 'verdana, geneva, sans-serif';
		} else {
			$basefontfamily = stripslashes( get_settings('plaintxtblog_basefontfamily') ); 
	};
	if ( get_settings('plaintxtblog_headingfontfamily') == "" ) {
		$headingfontfamily = 'verdana, geneva, sans-serif';
		} else {
			$headingfontfamily = stripslashes( get_settings('plaintxtblog_headingfontfamily') ); 
	};
	if ( get_settings('plaintxtblog_posttextalignment') == "" ) {
		$posttextalignment = 'left';
		} else {
			$posttextalignment = stripslashes( get_settings('plaintxtblog_posttextalignment') ); 
	};
	if ( get_settings('plaintxtblog_sidebarposition') == "" ) {
		$sidebarposition = 'body div#container{float:right;margin:0 0 0 -320px;}
body div#content{margin:0 0 0 320px;}
body div#primary{float:left;}
body div#secondary{float:right;margin-right:20px;}
body div.sidebar{border-right:5px solid #ddd;padding-right:15px;}';
		} else if ( get_settings('plaintxtblog_sidebarposition') =="left" ) {
			$sidebarposition = 'body div#container{float:right;margin:0 0 0 -320px;}
body div#content{margin:0 0 0 320px;}
body div#primary{float:left;}
body div#secondary{float:right;margin-right:20px;}
body div.sidebar{border-right:5px solid #ddd;padding-right:15px;}';
		} else if ( get_settings('plaintxtblog_sidebarposition') =="right" ) {
			$sidebarposition = 'body div#container{float:left;margin:0 -320px 0 0;}
body div#content{margin:0 320px 0 0;}
body div#primary{float:right;}
body div#secondary{float:left;margin-left:20px;}
body div.sidebar{border-left:5px solid #ddd;padding-left:15px;}';
	};
	if ( get_settings('plaintxtblog_sidebartextalignment') == "" ) {
		$sidebartextalignment = 'right';
		} else {
			$sidebartextalignment = stripslashes( get_settings('plaintxtblog_sidebartextalignment') ); 
	};
	if ( get_settings('plaintxtblog_singlelayout') == "" ) {
		$singlelayout = '';
		} else if ( get_settings('plaintxtblog_singlelayout') =="normalsingle" ) {
			$singlelayout = '';
		} else if ( get_settings('plaintxtblog_singlelayout') =="singlesingle" ) {
			$singlelayout = 'body.single div#container{float:none;margin:0 auto;width:75%}
body.single div#content{margin:0;}
body.single div.sidebar{display:none;}
';
	};
?>
<style type="text/css" media="all">
/*<![CDATA[*/
/* CSS inserted by theme options */
body{font-family:<?php echo $basefontfamily; ?>;font-size:<?php echo $basefontsize; ?>;}
body div#content div.hentry{text-align:<?php echo $posttextalignment; ?>;}
body div#content h2,div#content h3,div#content h4,div#content h5,div#content h6{font-family:<?php echo $headingfontfamily; ?>;}
body div.sidebar{text-align:<?php echo $sidebartextalignment; ?>;}
<?php echo $singlelayout; ?>
<?php echo $sidebarposition; ?>

/*]]>*/
</style>
<?php
}
add_action('admin_menu', 'plaintxtblog_add_admin');
add_action('wp_head', 'plaintxtblog_wp_head');

add_action('init', 'plaintxtblog_widgets_init');
add_filter('archive_meta', 'wptexturize');
add_filter('archive_meta', 'convert_smilies');
add_filter('archive_meta', 'convert_chars');
add_filter('archive_meta', 'wpautop');
?>