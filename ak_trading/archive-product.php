<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
<div class="navigation-menu">
<?php global $wp_query;
	    $current_tax = get_term_by('name', single_cat_title( '', false ), 'product_cat');
	    $thumbnail_id = get_woocommerce_term_meta( $current_tax->term_id, 'thumbnail_id', true );
	    $image = wp_get_attachment_image_src( $thumbnail_id, 'breadcrumb-image' )[0];
	    if ( !$image ) {
		   $image = get_template_directory_uri().'/img/nav_menu_img.jpg';
		}
?>
			<img class="menu-bg" src="<?php echo $image; ?>">
			<div class="menu-content">
				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
		<?php endif; ?>
		<?php //woocommerce_breadcrumb();?>
		
		<?php 
		$parent_id = $current_tax->parent;
		$br_name_showing_in_subcategories = get_term($parent_id, 'product_cat');
		$br_term_link = get_term_link( $br_name_showing_in_subcategories );
		?>
		<ul class="menu clearfix">
		  <li><a href="<?php echo home_url(); ?>">Home</a></li>
		  <?php if($br_name_showing_in_subcategories->name!='')
			echo '<li><a href="' . esc_url( $br_term_link ) . '">' . $br_name_showing_in_subcategories->name.'</a></li>';
		  ?>
		  <?php if($current_tax->name!='')
					echo '<li>' . $current_tax->name.'</li>';
				else
					echo '<li>Products</li>';
		  ?>
		</ul>
	
		
		</div>
</div>

<?php woocommerce_output_content_wrapper(); ?>
					<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
	//do_action( 'woocommerce_before_main_content' );
	?>
		<?php //do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>
		
			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			<?php 
        	$current_tax = get_term_by('name', single_cat_title( '', false ), 'product_cat');
        	if ($current_tax) {
            	$current_slug = $current_tax->slug;
            	$parent_id = $current_tax->parent;
            	$search_in_cat_with_id = $current_tax->term_id;
            	$name_showing_in_subcategories = $current_tax->name;
        
            	if($parent_id!=0)
            	{
            		$search_in_cat_with_id = $parent_id;
            		$name_showing_in_subcategories = get_term($parent_id, 'product_cat')->name;
            	}
            	
            	if($current_tax->description) {
            		$name_showing_in_subcategories = $current_tax->description;
            	}
            	$term_children = get_terms( 'product_cat' , array(
            					'parent'    => $search_in_cat_with_id,
            				    'orderby'      => 'name',
            					'hide_empty' => true
            					) );
        	}
        	?> 
	
			<?php $is_sidebar=0; ?>
			<?php if(!empty($term_children) && !empty($current_tax->name)):
			$is_sidebar = 1;
				add_filter('loop_shop_columns', 'loop_columns');
				if (!function_exists('loop_columns')) {
					function loop_columns() {
						return 3; // 3 products per row
					}
				}
			?>
<div class="left archive-with-sub">
	<div class="subcategory-menu">
	<h2><?php echo $name_showing_in_subcategories ?></h2>
	<ul>
	<?php 
	$all_categories = $term_children;
	foreach ($all_categories as $cat) {
			$category_name = $cat->name;
			$category_link = get_term_link( $cat, 'product_cat' );
			echo '<li><a href="'.$category_link.'">'.$category_name.'</a></li>' ;
	}
	?>
	</ul>
	
	</div> 
</div>
<div class="right archive-with-sub">
		<?php endif; ?>
			<?php woocommerce_product_loop_start(); ?>
	
				<?php woocommerce_product_subcategories(); ?>
		
				<?php while ( have_posts() ) : the_post(); ?>
					
					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>
		<?php if($is_sidebar == 1) echo "</div>";?>
			<?php woocommerce_product_loop_end(); ?>
			<br class="clear">
			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
	
	
<?php get_footer('shop'); ?>
