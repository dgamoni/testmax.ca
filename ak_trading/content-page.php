<?php 
/**
 * * Template Name: Content
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
		  <li><?php if(get_field('breadcrumb_name')) echo get_field('breadcrumb_name'); else the_title(); ?></li>
		</ul>
	  </div>
	</div>
	<div class="content-page">

	  <?php the_content(); ?>
	<?php endwhile; ?>
	</div>
<?php get_footer(); ?>