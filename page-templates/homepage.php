<?php
/**
 * Template Name: Home Page
 *
 **/

get_header();
if(is_user_logged_in()){
	$current_user = wp_get_current_user();
/*	echo 'User ID: ' . $current_user->ID . */
}
?>
	<div id="main-home-content" class="home-content home-page container" role="main">
		<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();
			the_content();
		endwhile;
		?>
	</div><!-- #main-content -->
<?php get_footer();
