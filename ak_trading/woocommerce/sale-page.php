<?php get_header(); 
/**
 * * Template Name: Sale Page
 *
 */
 global $wp_query;
?>
<div class="navigation-menu">	<?php while ( have_posts() ) : the_post(); ?>
	  <?php if ( has_post_thumbnail() ) {
	the_post_thumbnail('breadcrumb-image', array('class' => 'menu-bg'));  } ?>
	  <div class="menu-content">
		<h1><?php the_title(); ?></h1>
		<ul class="menu clearfix">
		  <li><a href="<?php echo home_url(); ?>">Home</a></li>
		  <li><?php the_title(); ?></li>
		  <?php endwhile; // end of the loop. ?>
		</ul>
	  </div>
	</div>
	
<div class="woocommerce">
		<?php woocommerce_output_content_wrapper(); ?>
			<?php woocommerce_product_loop_start(); ?>
				<?php woocommerce_product_subcategories(); ?>
				
				
				<?php
				$orderby  = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
				$show_default_orderby  = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
				
				switch ($orderby) {
					case 'price' :
					$arg_orderby = 'meta_value_num';
					$arg_order = 'asc';
					$arg_meta_key = '';
					break;

					case 'price-desc' :
					$arg_orderby = 'meta_value_num';
					$arg_order = 'desc';
					$arg_meta_key = '_price';
					break;
					
					case 'date' :
					$arg_orderby = 'date';
					$arg_order = 'desc';
					$arg_meta_key = '';
					break;

					case 'title' :
					$arg_orderby = 'title';
					$arg_order = 'asc';
					$arg_meta_key = '';
					break;
					
					case 'menu_order' :
					$arg_orderby = 'menu_order title';
					$arg_order = 'DESC';
					$arg_meta_key = '';
					break;

				}
				
				$args = array(
				'post_type'      => 'product',
				'posts_per_page' => 8,
				'columns' => '4',
				'orderby' => $arg_orderby,
				'order' => $arg_order,
				'paged' => $paged,
				'meta_key' =>$arg_meta_key,
				'meta_query'     => array(
					'relation' => 'OR',
					array( // Simple products type
						'key'           => '_sale_price',
						'value'         => 0,
						'compare'       => '<',
						'type'          => 'numeric'
					),
					array(  // Variable products type
						'key'           => 'clearance',
						'value'         => 'yes',
						'compare'       => '='
					
					)
				)
			);
			global $wp_query;
			$wp_query = new WP_Query;
			$myposts = $wp_query->query( $args );
			    $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array( 
        'menu_order' => __( 'Default sorting', 'woocommerce' ),  
        'popularity' => __( 'Sort by popularity', 'woocommerce' ),  
        'rating' => __( 'Sort by average rating', 'woocommerce' ),  
        'date' => __( 'Sort by newness', 'woocommerce' ),  
        'price' => __( 'Sort by price: low to high', 'woocommerce' ),  
        'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),  
 ) ); 
				?>
				<p class="woocommerce-result-count">
					<?php
					$paged    = max( 1, $wp_query->get( 'paged' ) );
					$per_page = $wp_query->get( 'posts_per_page' );
					$total    = $wp_query->found_posts;
					$first    = ( $per_page * $paged ) - $per_page + 1;
					$last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );

					if ( 1 == $total ) {
						_e( 'Showing the single result', 'woocommerce' );
					} elseif ( $total <= $per_page || -1 == $per_page ) {
						printf( __( 'Products (Total items: %d)', 'woocommerce' ), $total );
					} else {
						printf( _x( 'Showing %1$d&ndash;%2$d of %3$d results', '%1$d = first, %2$d = last, %3$d = total', 'woocommerce' ), $first, $last, $total );
					}
					?>
				</p>
				<form class="woocommerce-ordering" method="get">
					<label>Sort by</label><select name="orderby" class="orderby">
						<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
							<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
						<?php endforeach; ?>
					</select>
					<?php
						// Keep query string vars intact
						foreach ( $_GET as $key => $val ) {
							if ( 'orderby' === $key || 'submit' === $key ) {
								continue;
							}
							if ( is_array( $val ) ) {
								foreach( $val as $innerVal ) {
									echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
								}
							} else {
								echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
							}
						}
					?>
				</form>
				<ul class="products">
					<?php while ( have_posts() ) : the_post(); ?>
						
						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>
				</ul>

			<?php woocommerce_product_loop_end(); ?>
			<br class="clear">
			<?php
			if ( $wp_query->max_num_pages <= 1 ) {
				return;
			}
			?>
			<nav class="woocommerce-pagination">
				<?php
					echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
						'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
						'format'       => '',
						'add_args'     => false,
						'current'      => max( 1, get_query_var( 'paged' ) ),
						'total'        => $wp_query->max_num_pages,
						'prev_text'    => '&larr;',
						'next_text'    => '&rarr;',
						'type'         => 'list',
						'end_size'     => 3,
						'mid_size'     => 3
					) ) );
				?>
			</nav>
		<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
</div>
<?php get_footer(); ?>