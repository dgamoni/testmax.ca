<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/share.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<?php //do_action( 'woocommerce_share' ); // Sharing plugins can hook into here ?>
<?php $current_url = get_permalink(); ?>
<div class="social-icons"> 
	<div class="title">Share on:</div>
				  <a href="https://www.facebook.com/sharer.php?u=<?php echo $current_url ?>" onclick="window.open(this.href, 'mywin', 'left=50,top=50,width=600,height=350,toolbar=0'); return false;"><img src="<?php echo get_template_directory_uri(); ?>/img/social/fb.png" alt="facebook" /></a>
				  <a href="https://twitter.com/home?status=<?php echo $current_url ?>" onclick="window.open(this.href, 'mywin', 'left=50,top=50,width=600,height=350,toolbar=0'); return false;"><img src="<?php echo get_template_directory_uri(); ?>/img/social/tw.png" alt="twitter" /></a>
				  <a href="https://plus.google.com/share?url=<?php echo $current_url ?>" onclick="window.open(this.href, 'mywin', 'left=50,top=50,width=600,height=350,toolbar=0'); return false;"><img src="<?php echo get_template_directory_uri(); ?>/img/social/gplus.png" alt="gplus" /></a>
				  
				  <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); ?>
				  <?php $pint_title = get_the_title(); ?>
				  <a href="https://www.pinterest.com/pin/create/button/?url=<?php echo $current_url ?>&media=<?php echo $feat_image; ?>&description=<?php echo $pint_title; ?>" data-pin-do="buttonPin" data-pin-config="above"  onclick="window.open(this.href, 'mywin', 'left=50,top=50,width=600,height=350,toolbar=0'); return false;"><img src="<?php echo get_template_directory_uri(); ?>/img/social/pinterest.png" alt="pinterest" /></a>

				  
				  <a class="secondary-elements" id="ak-email-product" href="mailto:?subject=<?php echo get_the_title(); ?>&body=<?php echo get_the_content().'%0D%0A'.$current_url; ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/social/email.png" alt="email" /> Email a Friend</a>			  
				  <a class="secondary-elements" href="#" id="ak-print-product" ><img src="<?php echo get_template_directory_uri(); ?>/img/social/print.png" alt="email" /> Print Page</a>			  
					
	
</div>
