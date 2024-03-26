<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>
<style>
.loop-stock-status {
	color:#32B8DB;
	padding-left:5px;
	font-weight: bold;
	font-family: 'latobold';
}
</style>
<?php
	$availability = $product->get_availability();
	if ($availability['availability'] == "Out of stock") :
		$stock_status = "Out of Stock";
	else:
		$stock_status = "In Stock";
	endif;
?>	
<?php if ( $price_html = $product->get_price_html() ) : ?>
	<span class="product-price"><?php echo $price_html; ?></span>
	<span class="loop-stock-status"> (<?php echo $stock_status; ?>)</span>
	
<?php endif; ?>
