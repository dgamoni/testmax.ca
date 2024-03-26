</div>
	<footer>
		<div class="top clearfix">
		<div class="textwidget">
		<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
		</div>
		<?php dynamic_sidebar( 'footer-sidebar-2' ); ?>
		<?php dynamic_sidebar( 'footer-sidebar-3' ); ?>
		<?php dynamic_sidebar( 'footer-sidebar-4' ); ?>
		</div>
		<div class="bottom clearfix">
			<div class="left">
			<?php wp_nav_menu(array("theme_location" => 'footer_nav','items_wrap'=> '<ul id="%1$s" class="%2$s clearfix">%3$s</ul>','container' => false, 'menu_class'  => false )); ?>
				<p>© Bath Wholesalers. All rights reserved.</p>
			</div>
			<div class="right clearfix">
				<a class="facebook" href="<?php the_field('footer_facebook_link','option');?>"></a>
				<a class="twitter" href="<?php the_field('footer_twitter_link','option');?>"></a>
				<a class="google" href="<?php the_field('footer_google_link','option');?>"></a>
				<div class="grey"></div>
			</div>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
<?php if ( function_exists( 'is_product' ) && is_product() ) :
	global $post;
	$product = get_product( $post->ID );
	if ( $product->is_in_stock() ) {
		$price = $product->get_price();

	}
	?>
	<script type="text/javascript">
		var google_tag_params = {
			ecomm_prodid: '<?php echo esc_js( '' . $product->get_sku() ); ?>',
			ecomm_pagetype: 'product',
			ecomm_totalvalue: parseFloat('<?php echo esc_js( number_format( $price, 2, '.', '') ); ?>')
		};
	</script>
	<?php elseif ( function_exists( 'is_cart' ) && is_cart() ) :
		global $woocommerce;
	$products = $woocommerce->cart->get_cart();
?>
<Script>

var id = new Array();
</script>
<?php
$product_ids = array();

			foreach( $products as $oneproduct ) {
$pro = wc_get_product($oneproduct['product_id']);
$sku = $pro->get_sku(); 
?>
<script>
id.push(<?php echo "'" . str_replace( "'", "\\'", $sku ) . "'"; ?>);
</script>
<?php
				$product_ids[] = "'" . str_replace( "'", "\\'", $oneproduct['product_id'] ) . "'";

			}
	?>
	<script type="text/javascript">
		var google_tag_params = {
			ecomm_prodid: id,
			ecomm_pagetype: 'cart',
			ecomm_totalvalue: parseFloat('<?php echo $woocommerce->cart->cart_contents_total; ?>')
		};
	</script>
	
	
	<?php elseif ( function_exists('is_order_received_page') && is_order_received_page() ) :
		
		
		$order_id  = apply_filters( 'woocommerce_thankyou_order_id', empty( $_GET['order'] ) ? ($GLOBALS["wp"]->query_vars["order-received"] ? $GLOBALS["wp"]->query_vars["order-received"] : 0) : absint( $_GET['order'] ) );
		$order_key = apply_filters( 'woocommerce_thankyou_order_key', empty( $_GET['key'] ) ? '' : woocommerce_clean( $_GET['key'] ) );



		if ( $order_id > 0 ) {
			$order = new WC_Order( $order_id );
			if ( $order->order_key != $order_key )
				unset( $order );
		}

		if ( 1 == get_post_meta( $order_id, '_ga_tracked', true ) ) {
			unset( $order );
		}

		if ( isset( $order ) ) {
			$_products = array();
			$_sumprice = 0;
			$_product_ids = array();

			if ( $order->get_items() ) {
				foreach ( $order->get_items() as $item ) {
					$_product = $order->get_product_from_item( $item );

          $variation_data = null;

          if (get_class($_product) == "WC_Product_Variation") {
            $variation_data = $_product->get_variation_attributes();
          }

          if ( isset( $variation_data ) ) {
						$_category = woocommerce_get_formatted_variation( $_product->variation_data, true );

					} else {
						$out = array();
						$categories = get_the_terms( $_product->id, 'product_cat' );
						if ( $categories ) {
							foreach ( $categories as $category ) {
								$out[] = $category->name;
							}
						}

						$_category = implode( " / ", $out );
					}

					$_prodprice = $order->get_item_total( $item );

     $_products[] = array(
	"id"       => $_product->id,
	"name"     => $item['name'],
	"sku"      => $_product->get_sku() ? __( 'SKU:', GTM4WP_TEXTDOMAIN ) . ' ' . $_product->get_sku() : $_product->id,
	"category" => $_category,
	"price"    => $_prodprice,
	"currency" => get_woocommerce_currency(),
	"quantity" => $item['qty']
	);
			

					$_sumprice += $_prodprice;
					$_product_ids[] = "'" . $_product->sku . "'";

				}

			}


		}
	?>
	<script type="text/javascript">
		var google_tag_params = {
			ecomm_prodid: <?php echo implode( " ", $_product_ids ); ?>,
			ecomm_pagetype: 'purchase',
			ecomm_totalvalue: <?php echo $_sumprice; ?>
		};
	</script>	
		
		
		
<?php else: ?>

	<script type="text/javascript">
if(window.location.pathname =='/')
{
		var google_tag_params = {
			ecomm_prodid: '',
			ecomm_pagetype: 'home',
			ecomm_totalvalue: 0
		};
}
if(window.location.href.indexOf('products') != -1)
{
var google_tag_params = {
			ecomm_prodid: '',
			ecomm_pagetype: 'category',
			ecomm_totalvalue: 0
		};
}
	</script>
<?php endif; ?>


</body>
</html>