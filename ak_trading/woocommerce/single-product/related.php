<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$args;

$upsells = $product->get_upsells();
if ( sizeof( $upsells ) != 0 ) {

	$terms = wp_get_post_terms( $product->id, 'product_cat', array() );
	$term_id;
	foreach ($terms as $term) {
		if($term->parent == 7){
			$term_id = $term->term_id;
		}
	}
	if( $term_id === NULL ){
		$term_id = $terms[0]->term_id;
	}
	

	$meta_query = WC()->query->get_meta_query();
	$args = array(
		'post_type'           => 'product',
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => 1,
		'posts_per_page'      => $posts_per_page,
		'orderby'             => get_field('is_random') ? $orderby : 'rand',
		'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => /*$new_term*/$term_id
        )),
		//'post__in'            => $upsells,
		'post__not_in'        => array( $product->id ),
		//'meta_query'          => $meta_query
);

} else {
/*
7-Bathroom Vanities
30-Countertops
28-Faucets
37-Jetted Shower Columns
26-Shower Enclosures
27-Showers Doors
*/
	$conformities = array (7=>28, 28=>7, 26=>37, 37=>26, 30=>27, 27=>30);
	$terms = wp_get_post_terms( $product->id, 'product_cat', array() );
	$term_id;
	foreach ($terms as $term) {
		if($term->parent == 7){
			$term_id = $term->term_id;
		}
	}
	if( $term_id === NULL ){
		$term_id = $terms[0]->term_id;
	}
	

	get_terms( $taxonomies, $args );
	$new_term = $conformities[$term_id];
	$args = apply_filters( 'woocommerce_related_products_args', array(
		'post_type'            => 'product',
		'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => /*$new_term*/$term_id
        )),
		'ignore_sticky_posts'  => 1,
		'no_found_rows'        => 1,
		'posts_per_page'       => $posts_per_page,
		'orderby'              => get_field('is_random') ? $orderby : 'rand',
		'post__not_in'         => array( $product->id )
	) );
}
$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) : ?>

	<div class="complementary products">

		<h2><?php _e( 'Related Products', 'woocommerce' ); ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>
			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
