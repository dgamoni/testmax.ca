<?php 
/**
 * * Template Name: Gallery
 *
 */
get_header(); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<div class="navigation-menu">
	  <?php if ( has_post_thumbnail() ) { the_post_thumbnail('breadcrumb-image', array('class' => 'menu-bg'));  } ?>
	  <div class="menu-content">
		<h1><?php the_title(); ?></h1>
		<ul class="menu clearfix">
		  <li><a href="<?php echo home_url(); ?>">Home</a></li>
		  <li><?php if(get_field('breadcrumb_name')) echo get_field('breadcrumb_name'); else the_title(); ?></li>
		</ul>
	  </div>
	</div>
	<div class="content-page">
		<div class="photo-gallery">
		<?php 
			$images = get_field('gallery');
			
			if( $images ): ?>
					<?php foreach( $images as $image ): ?>
							<a class="main" href="<?php echo $image['url']; ?>">
								 <img  src="<?php echo $image['sizes']['shop_catalog']; ?>" alt="<?php echo $image['alt']; ?>" />
							</a>
					<?php endforeach; ?>
				
			<?php endif; ?>
		</div>
	</div>
	
	

	
	<?php endwhile; ?>
	
<?php get_footer(); ?>