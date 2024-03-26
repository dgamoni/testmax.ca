<?php 

get_header(); ?>
	<div class="navigation-menu">
				<img class="menu-bg" src="<?php echo get_template_directory_uri(); ?>/img/nav_menu_img.jpg">
				<div class="menu-content">
					<h1><?php the_title(); ?></h1>	
					<?php woocommerce_breadcrumb();?>
			</div>
	</div>
	<div class="content-page">
		<?php while ( have_posts() ) : the_post(); ?>
		<h3><?php the_title();?></h3>
		  <?php the_content(); ?>
		<?php endwhile; ?>
	</div>
<?php get_footer(); ?>