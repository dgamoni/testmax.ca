<?php 
/**
 * * Template Name: Contact Us
 *
 */
get_header(); ?>
	<div class="contact-us-page">
		<div class="navigation-menu">
			<?php if ( has_post_thumbnail() ) {
	the_post_thumbnail('breadcrumb-image', array('class' => 'menu-bg'));  } ?>
			<div class="menu-content">
			<?php while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<ul class="menu clearfix">
					<li><a href="<?php echo home_url(); ?>">Home</a></li>
					<li><?php the_title(); ?></li>
			</ul>
			</div>
		</div>
		
	    <div class="left contact-block" >
			<?php the_field("map_gta_location"); ?>
			<div class="clear"></div>
			<div class="contact-info-zone right">
				<h3><?php the_field('left_location_name','option');?> Location</h3>
				<div class="contact-info">
					<div class="address">
						<?php the_field('left_address','option');?>
					</div>
					<div class="phone-number"><a href="tel:905-738-6645"><?php the_field('left_phone_number','option');?></a></div>
					<div class="email"><?php the_field('left_email','option');?></div>
				</div>
				<div class="service-time">
					<h4>Business Hours</h4>
					<?php the_field('left_business_hours','option');?>
				</div>
			</div>
		</div>
		
		<div class="left contact-block">
			<?php the_field("map_mississauga_location"); ?>
			<div class="clear"></div>
			<div class="contact-info-zone right">
				<h3><?php the_field('center_location_name','option');?> Location</h3>
				<div class="contact-info">
					<div class="address">
						<?php the_field('center_address','option');?>
						</div>
					<div class="phone-number"><a href="tel:905-826-1010"><?php the_field('center_phone_number','option');?></a></div>
					<div class="email"><?php the_field('center_email','option');?></div>
				</div>
				<div class="service-time">
					<h4>Business Hours</h4>
					<?php the_field('center_business_hours','option');?>
				</div>
			</div>
		</div>
		
		<div class="left contact-block">
			<?php the_field("map_newmarket_location"); ?>
			<div class="clear"></div>
			<div class="contact-info-zone right">
				<h3><?php the_field('right_location_name','option');?> Location</h3>
				<div class="contact-info">
					<div class="address">
						<?php the_field('right_address','option');?>
						</div>
					<div class="phone-number"><a href="tel:905-898-4663"><?php the_field('right_phone_number','option');?></a></div>
					<div class="email"><?php the_field('right_email','option');?></div>
				</div>
				<div class="service-time">
					<h4>Business Hours</h4>
					<?php the_field('right_business_hours','option');?>
				</div>
			</div>
		</div>
		
		
		
		<div class="clear"></div>
		<div class="contact-form">
			<h2>Retail Stores Only, Contact Your Local Sales Rep</h2>
			<?php  
				$newmarket_page =  get_permalink(258); 
				$gta_page =  get_permalink(260);
				$mississauga_page =  get_permalink(3000);
			?>
				<div class="email-error-msg"></div>
				<div class="email-succes-msg"></div>
		</div>
		<?php endwhile; ?>
	</div>
	<?php get_footer(); ?>