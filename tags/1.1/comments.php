<div id="comments">

	<?php // Do not delete these lines
		if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
			die ('Please do not load this page directly. Thanks!');

			if (!empty($post->post_password)) { 
				if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  
					?>
		<p><em>Password required.</em> Please enter the correct password to view this post.<p>

		<?php return;
				}
			}
	?>

	<?php if ($comments) : ?>

	<h3><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h3>
	
	<ol class="commentlist">
		<?php foreach ($comments as $comment) : ?>
			<li id="comment-<?php comment_ID() ?>">
				<strong><?php comment_author_link() ?></strong> said:
				<?php if ($comment->comment_approved == '0') : ?>
				<em>Your comment is awaiting moderation.</em>
				<?php endif; ?>
				<?php comment_text() ?>
				<span class="comment-metadata">Posted on <?php comment_date('d-M-y') ?> at <?php comment_time('g:i a') ?> | <a href="#comment-<?php comment_ID() ?>" title="Permalink to this comment" rel="permalink">Permalink</a> <?php edit_comment_link('Edit', '| ', ''); ?></span>
			</li>
		<?php endforeach; ?>
	</ol>
	
	<?php else : ?>
	
	<?php if ('open' == $post->comment_status) : ?>
	
	<?php else : ?>
	<p class="nocomments">Comments are closed.</p>
	<?php endif; ?>

	<?php endif; ?>

	<?php if ('open' == $post->comment_status) : ?>
	
	<h3 id="respond">Post a Comment</h3>
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>" title="Log in">logged in</a> to post a comment.</p>
	<?php else : ?>

	<div class="formcontainer">	
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

			<?php if ( $user_ID ) : ?>

			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php" title="Logged in as <?php echo $user_identity; ?>"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log off?</a></p>

			<?php else : ?>

			<div class="formleft"><label for="author">Name:</label></div>
			<div class="formright"><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="20" maxlength="20" tabindex="3" /> <?php if ($req) echo "*Required"; ?></div>

			<div class="formleft"><label for="email">Email:</label></div>
			<div class="formright"><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="20" maxlength="50" tabindex="4" /> <?php if ($req) echo "*Required"; ?> (Not published)</div>

			<div class="formleft"><label for="url">Website:</label></div>
			<div class="formright"><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="20" maxlength="50" tabindex="5" /></div>

			<?php endif; ?>

			<div class="formleft"><label for="comment">Comment:</label></div>
			<div class="formright"><textarea name="comment" id="comment" cols="45" rows="8" tabindex="6"></textarea></div>

			<div class="formleft">&nbsp;</div>
			<div class="formright"><input name="submit" type="submit" id="submit" tabindex="7" value="Post" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></div>

			<?php do_action('comment_form', $post->ID); ?>

		</form>
	</div>

	<?php endif; ?>
	<?php endif; ?>

</div>