<!DOCTYPE html>
<html <?php language_attributes(); ?>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php bloginfo('title'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.css" type="text/css" media="all" />
<script src="<?php echo get_template_directory_uri(); ?>/js/theme-functions.js" defer ></script>
<?php if(is_page_template('gallery.php')) {?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/colorbox.css" type="text/css" media="screen" />
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.colorbox-min.js" defer></script>
<?php } ?>
<?php wp_head(); ?>
<?php the_field('header_scripts', 'option'); ?>
</head>
<body <?php body_class(); ?> 
<!-- Google Tag Manager -->

<!-- End Google Tag Manager -->
<?php
 
 $img = get_field('background_image','option'); 
 $color = get_field('under_background_color','option');
	if($img || $color)
	{
		echo 'style="';
		if($img)
			echo 'background-image:url('.$img['url'].');';
		if($color)
			echo 'background-color:'.$color.";";
		echo '"';
	}

?>
<div class="wrapper">
	<header>
		<a class="logo left" href="<?php echo home_url(); ?>">
			<?php $img = get_field('logo_url','option'); ?>
			<img class="left" src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>">
			<div class="logo-texts right">
				<h1><?php the_field('logo_title_1','option'); ?></h1>
				<h2><?php the_field('logo_title_2','option'); ?></h2>
			</div>
		</a>
		<div class="right">
			<div class="number-box">
				<div class="name"><?php the_field('left_location_name','option');?></div>
				<a href="tel:905-738-6645"><div class="number"><?php the_field('left_phone_number','option');?></div></a>
			</div>
			<div class="number-box">
				<div class="name"><?php the_field('center_location_name','option');?></div>
				<a href="tel:905-826-1010"><div class="number"><?php the_field('center_phone_number','option');?></div></a>
			</div>
			<div class="number-box">
				<div class="name"><?php the_field('right_location_name','option');?></div>
				<a href="tel:905-898-4663"><div class="number"><?php the_field('right_phone_number','option');?></div></a>
			</div>
			<div class="search-box">
				<?php global $woocommerce; ?>
				<?php if ( is_user_logged_in() ) { ?>
					<a class="temphide" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','woothemes'); ?>"><?php _e('My Account','woothemes'); ?></a>
				 <?php } 
				 else { ?>
					<a class="temphide" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Login / Register','woothemes'); ?></a>
				 <?php } ?>
				 <?php 
				 $cart_count = $woocommerce->cart->cart_contents_count;
				 $cart_empty = ($cart_count==0);
				 ?>
				<a class="temphide" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>" <?php if(!$cart_empty) { echo 'class="cart-active"'; } ?>>View Cart<span>(<?php echo $woocommerce->cart->cart_contents_count; ?>)</span></a>
				<?php echo get_product_search_form(); ?>
			</div>
		</div>
		<div class="clear"></div>
		<div class="menu clearfix">
		<div class="mobile-menu clearfix">
			<div class="mobile-menu-text">Menu</div>
			<div class="menu-hamburger">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		 <?php wp_nav_menu(array("theme_location" => 'top_nav','container' => false, 'menu_class'  => false )); ?>
		<div class="dropdown-menu clearfix">
			<div class="triangle"></div>
			
			<div class="contact-info-zone left" style="width:350px; margin-left:0px; margin-bottom:20px;">
				<h3><?php the_field('left_location_name','option');?> Location</h3>
				<div class="contact-info">
					<div class="address">
						<?php the_field('left_address','option');?>
					</div>
					<div class="phone-number"><?php the_field('left_phone_number','option');?></div>
					<div class="email"><?php the_field('left_email','option');?></div>
				</div>
				<div class="service-time">
					<h4>Business Hours</h4>
					<?php the_field('left_business_hours','option');?>
				</div>
			</div>
			
			<div class="contact-info-zone left" style="width:350px; margin-left:0px; margin-bottom:20px;">
				<h3><?php the_field('center_location_name','option');?> Location</h3>
				<div class="contact-info">
					<div class="address">
						<?php the_field('center_address','option');?>
					</div>
					<div class="phone-number"><?php the_field('center_phone_number','option');?></div>
					<div class="email"><?php the_field('center_email','option');?></div>
				</div>
				<div class="service-time">
					<h4>Business Hours</h4>
					<?php the_field('center_business_hours','option');?>
				</div>
			</div>
			
			<div class="contact-info-zone left" style="width:350px; margin-left:0px; margin-bottom:20px;">
				<h3><?php the_field('right_location_name','option');?> Location</h3>
				<div class="contact-info">
					<div class="address"><?php the_field('right_address','option');?></div>
					<div class="phone-number"><?php the_field('right_phone_number','option');?></div>
					<div class="email"><?php the_field('right_email','option');?></div>
				</div>
				<div class="service-time">
					<h4>Business Hours</h4>
					<?php the_field('right_business_hours','option');?>
				</div>
			</div>
			
			
			
			
		</div>
		</div>
	</header>
	<div id="main-content" class="clearfix">