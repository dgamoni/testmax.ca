<?php get_header(); 
/**
 * * Template Name: Thank You
 *
 */
?>
<div class="thank-you-page">
		<?php while ( have_posts() ) : the_post(); ?>
		<?php if ( has_post_thumbnail() ) {
	the_post_thumbnail('slider-big');  } ?>
		<div class="image-text">
			<?php the_content(); ?>
			<a href="<?php echo home_url(); ?>">Return Home</a>
		</div>
	<?php endwhile; ?>
</div>				
<?php get_footer(); ?>