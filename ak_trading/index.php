<?php get_header(); ?>
<div class="slider">
		<?php 
			$args = array('post_type' => 'slider', 'orderby' => 'menu_order', 'order' => 'ASC');
			$slider_query = new Wp_Query($args);
			if($slider_query->have_posts()) : ?>
			<div class="contents">

				<?php while($slider_query->have_posts()) : $slider_query->the_post(); ?>
				
				<div class="content">
					<?php the_post_thumbnail('slider-big'); ?>
					<!--<img src="<?php echo get_template_directory_uri(); ?>/img/slider_image.jpg">-->
					<div class="image-text">
						<h1><?php the_title(); ?></h1>
						<div class="descroption"><?php the_content(); ?></div>
					</div>
				</div>				
				<?php endwhile; ?>
				
			<div class="squares clearfix">
			<?php while($slider_query->have_posts()) : $slider_query->the_post(); ?>
			<div class="square"></div>
			<?php endwhile; ?>
			</div>
				
			</div>
			<div class="coins clearfix">
				<?php while($slider_query->have_posts()) : $slider_query->the_post(); ?>
				<div class="coin">

					<?php the_post_thumbnail('slider-thumb'); ?>
					<div class="name"><?php the_title(); ?></div>
				
				</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
</div>		


		<div class="featured-items">
			<h2>Featured Items</h2>
			<?php echo do_shortcode('[featured_products per_page="4" columns="4" orderby="date" order="desc"]'); ?>
		</div>
<?php get_footer(); ?>