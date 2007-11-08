<?php header("HTTP/1.1 404 Not Found"); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="container">
	<div id="content">
		<?php /* INCLUDE FOR ERROR TEXT */ include (TEMPLATEPATH . '/errortext.php'); ?>
	</div><!-- END CONTENT -->
</div><!-- END CONTAINER -->

<?php get_footer(); ?>