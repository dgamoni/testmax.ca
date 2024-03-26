<?php 
/**
 * * Template Name: Full Width
 *
 */
get_header(); ?>
	<div class="navigation-menu">
	<?php while ( have_posts() ) : the_post(); ?>
	  <?php if ( has_post_thumbnail() ) {
	the_post_thumbnail('breadcrumb-image', array('class' => 'menu-bg'));  } ?>
	  <div class="menu-content">
		<h1><?php the_title(); ?></h1>
		<ul class="menu clearfix">
		  <li><a href="<?php echo home_url(); ?>">Home</a></li>
		  <li><?php the_title(); ?></li>
		</ul>
	  </div>
	</div>
	<div>

	  <?php the_content(); ?>
	<?php endwhile; ?>
	</div>
<?php get_footer(); ?>