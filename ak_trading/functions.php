<?php

function aktrading_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	register_nav_menus( array('top_nav' => 'Main Navigation') );
	register_nav_menus( array('footer_nav' => 'Footer Navigation') );
	register_nav_menus( array('sitemap_nav' => 'Sitemap Navigation') );
	register_nav_menus( array('sitemap_nav_mobile' => 'Sitemap Navigation For Mobile') );

	add_image_size( 'content-page-image', 800, 400, true);
	add_image_size( 'breadcrumb-image', 1170, 200, true);
	add_image_size( 'slider-big', 1170, 500, true);
	add_image_size( 'slider-thumb', 384, 180, true);
	
}
add_action( 'after_setup_theme', 'aktrading_theme_setup' );


add_action( 'wp_enqueue_scripts', 'theme_files' );
function theme_files() {
	?>
	<script type="text/javascript">/* <![CDATA[ */
	var aktradingAjaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	/* ]]> */</script>
	<?php
}
/* Adding Defer */
/*function defer_parsing_of_js ( $url ) {
	if ( false === strpos( $url, '.js' ) ) return $url;
	return "$url' defer ";
}
add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
*/

add_action( 'init', 'create_post_type' );
	function create_post_type() {
		register_post_type( 'slider',
			array(
				'labels' => array(
					'name' => __( 'Slider' ),
					'singular_name' => __( 'Slider' )
				),
			'public' => true,
			'supports' => array( 'title', 'editor',  'thumbnail', 'excerpt', 'page-attributes' ),
			)
		);
	}
	
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => '',
            'wrap_before' => '<nav class="woocommerce-breadcrumb menu clearfix" >',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );
}

add_filter('woocommerce_sale_flash', 'my_custom_sale_flash', 10, 3);
function my_custom_sale_flash($text, $post, $_product) {
  return '<span class="onsale">Sale</span>';  
}

//Option page
function my_acf_options_page_settings( $settings ) {
	  $settings['title'] = 'Aktrading';
	  $settings['pages'] = array('Header', 'Footer', 'Contact Info');
	  return $settings;
	}
add_filter('acf/options_page/settings', 'my_acf_options_page_settings');

//Widgets

function aktrading_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'aktrading' ),
		'id' => 'sidebar-1',
		'description' => __( 'Main Sidebar' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer #1', 'aktrading' ),
		'id' => 'footer-sidebar-1',
		'description' => __('Footer Sidebar'),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer #2', 'aktrading' ),
		'id' => 'footer-sidebar-2',
		'description' => __('Footer Sidebar'),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer #3', 'aktrading' ),
		'id' => 'footer-sidebar-3',
		'description' => __('Footer Sidebar'),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer #4', 'aktrading' ),
		'id' => 'footer-sidebar-4',
		'description' => __('Footer Sidebar'),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	
}
add_action( 'widgets_init', 'aktrading_widgets_init' );

add_action('wp_ajax_nopriv_send_email_action', 'send_email');
add_action('wp_ajax_send_email_action', 'send_email');

//send Email Function
function send_email(){
    $mail_text =isset($_POST['msgtext']) ? $_POST['msgtext']: '' ;
	$mail_subject =isset($_POST['msgsubject']) ? $_POST['msgsubject']: '' ;
	$mail_to =isset($_POST['msgreciever']) ? $_POST['msgreciever']: '' ;
	if(mail( $mail_to, $mail_subject, $mail_text)){
		echo '1';
	}
	exit();
}

add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	//unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	//unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}


add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 4; // arranged in 4 columns
	return $args;
}


//add_action('woocommerce_after_single_product_summary', 'add_form_on_products_page', 16);
function add_form_on_products_page () {
	$thank_you =  get_permalink(70); 
	$content ='<div class="product-contact-form">
			<h2>Inquire About the Product</h2>
				<form id="aktrading-contact-form">
					<input type="text" id="ak-name" placeholder="Name *">
					<input type="text" id="ak-phone" placeholder="Phone">
					<input type="email" id="ak-email" placeholder="Email *">
					<input type="hidden" id="newmarket-loacation" value=""/>
					<input type="hidden" id="gta-loacation" value="" />
					<input type="hidden" id="mississauga-loacation" value="" />
					<input type="hidden" id="product-loacation" value="'.$thank_you.'" />
					
					<input type="hidden" id="page-status" value="0" />
					<input type="hidden" id="email-title" value="'.get_the_title().'" />
					<input type="hidden" id="email-sku" value="'.get_field('_sku').'" />
					<input type="hidden" id="email-permalink" value="'.get_permalink().'" />
					
					<textarea placeholder="Message" id="ak-msg"></textarea>
					<input type="submit" value="Send Inquiry">
				</form>
				<div class="email-error-msg"></div>
				<div class="email-succes-msg"></div>
		</div>';
	echo $content;
}


/* Add a new tab */

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
    if(!empty(get_field( 'tab_features' )) ){
	// Adds the new tab
	$tabs['features-tab'] = array(
		'title' 	=> __( 'Features', 'woocommerce' ),
		'priority' 	=> 25,
		'callback' 	=> 'woo_new_product_tab_content'
	);
    }
	return $tabs;

}
function woo_new_product_tab_content() {
	// The new tab content
	echo '<h2>Features</h2>';
	the_field("tab_features");
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 7 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15 );


remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

/* Custom Product Fields */

add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_fields' );
add_action( 'woocommerce_process_product_meta', 'woo_save_custom_fields' );

function woo_add_custom_fields() {
	woocommerce_wp_checkbox( 
		array( 
			'id'            => 'clearance', 
			'wrapper_class' => '', 
			'label'         => __('Clearance', 'woocommerce' ), 
			'description'   => __( 'Check, if is true', 'woocommerce' ) 
			)
	);
}
function woo_save_custom_fields($post_id) {
	$woocommerce_checkbox = isset( $_POST['clearance'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, 'clearance', $woocommerce_checkbox );
}

add_filter( 'wp_nav_menu_objects', 'submenu_limit', 10, 2 );


/* Thumbnails per columns */

add_filter ( 'woocommerce_product_thumbnails_columns', 'xx_thumb_cols' );
 function xx_thumb_cols() {
     return 5; 
 }

function submenu_limit( $items, $args ) {

    if ( empty($args->submenu) )
        return $items;

    $parent_id = array_pop( wp_filter_object_list( $items, array( 'title' => $args->submenu ), 'and', 'ID' ) );
    $children  = submenu_get_children_ids( $parent_id, $items );

    foreach ( $items as $key => $item ) {

        if ( ! in_array( $item->ID, $children ) )
            unset($items[$key]);
    }

    return $items;
}

function submenu_get_children_ids( $id, $items ) {

    $ids = wp_filter_object_list( $items, array( 'menu_item_parent' => $id ), 'and', 'ID' );

    foreach ( $ids as $id ) {

        $ids = array_merge( $ids, submenu_get_children_ids( $id, $items ) );
    }

    return $ids;
}


/* Adding new tab in Woocommerce admin section with custom Google fields */

function google_tab_options_tab() {
	?>
		<li class="google_tab"><a href="#google_tab_data"><?php _e('Google Tab', 'woothemes'); ?></a></li>
	<?php
}
add_action('woocommerce_product_write_panel_tabs', 'google_tab_options_tab'); 


/* Google custom fields */

function google_tab_options() {
	global $post;
	$google_tab_options = array(
		'gtin' => get_post_meta($post->ID, 'google_tab_gtin', true),
		'mpn' => get_post_meta($post->ID, 'google_tab_mpn', true),
		'brand' => get_post_meta($post->ID, 'google_tab_brand', true),
		'color' => get_post_meta($post->ID, 'google_tab_color', true),
		'material' => get_post_meta($post->ID, 'google_tab_material', true),
		'adwords_grouping' => get_post_meta($post->ID, 'google_tab_adwords_grouping', true),
		'adwords_labels' => get_post_meta($post->ID, 'google_tab_adwords_labels', true),
		'adwords_redirect' => get_post_meta($post->ID, 'google_tab_adwords_redirect', true),
		'custom_label_0' => get_post_meta($post->ID, 'google_tab_custom_label_0', true),
		'custom_label_1' => get_post_meta($post->ID, 'google_tab_custom_label_1', true),
		'custom_label_2' => get_post_meta($post->ID, 'google_tab_custom_label_2', true),
		'custom_label_3' => get_post_meta($post->ID, 'google_tab_custom_label_3', true),
		'custom_label_4' => get_post_meta($post->ID, 'google_tab_custom_label_4', true)
	);
	?>
		<div id="google_tab_data" class="panel woocommerce_options_panel">
			<div class="options_group">
				<?php
				// Select
				woocommerce_wp_select( 
				array( 
					'id'      => 'google_tab_condition', 
					'label'   => __( 'Condition', 'woocommerce' ), 
					'options' => array(
						'new'   => __( 'New', 'woocommerce' ),
						'refurbished'   => __( 'Refurbished', 'woocommerce' ),
						'used' => __( 'Used', 'woocommerce' )
						)
					)
				);
				?>
			</div>
		
			<div class="options_group">
				<p class="form-field">
					<label>Gtin</label>
					<input type="text" size="10" name="google_tab_gtin" value="<?php echo @$google_tab_options['gtin']; ?>"  />		
				</p>
				<p class="form-field">
					<label>Mpn</label>
					<input type="text" size="10" name="google_tab_mpn" value="<?php echo @$google_tab_options['mpn']; ?>"  />		
				</p>
				<p class="form-field">
					<label>Brand</label>
					<input type="text" size="10" name="google_tab_brand" value="<?php echo @$google_tab_options['brand']; ?>"  />		
				</p>
			</div>
			
			<div class="options_group">
				<?php
				woocommerce_wp_checkbox(array( 
					'id'            => 'google_tab_identified_exists', 
					'wrapper_class' => '', 
					'label'         => __('Identified Exists', 'woocommerce' )
					)
				);
				?>
			</div>
			
			<div class="options_group">
				<p class="form-field">
					<label>Color</label>
					<input type="text" size="10" name="google_tab_color" value="<?php echo @$google_tab_options['color']; ?>"  />		
				</p>
				<p class="form-field">
					<label>Material</label>
					<input type="text" size="10" name="google_tab_material" value="<?php echo @$google_tab_options['material']; ?>"  />		
				</p>
			</div>
			
			<div class="options_group">
				<p class="form-field">
					<label>Adwords Grouping</label>
					<input type="text" size="10" name="google_tab_adwords_grouping" value="<?php echo @$google_tab_options['adwords_grouping']; ?>" />		
				</p>
				<p class="form-field">
					<label>Adwords Labels</label>
					<input type="text" size="10" name="google_tab_adwords_labels" value="<?php echo @$google_tab_options['adwords_labels']; ?>"  />		
				</p>
				<p class="form-field">
					<label>Adwords Redirect</label>
					<input type="text" size="10" name="google_tab_adwords_redirect" value="<?php echo @$google_tab_options['adwords_redirect']; ?>"  />		
				</p>
			</div>
			
			<div class="options_group">
				<p class="form-field">
					<label>Custom Label 0</label>
					<input type="text" size="10" name="google_tab_custom_label_0" value="<?php echo @$google_tab_options['custom_label_0']; ?>" />		
				</p>
				<p class="form-field">
					<label>Custom Label 1</label>
					<input type="text" size="10" name="google_tab_custom_label_1" value="<?php echo @$google_tab_options['custom_label_1']; ?>" />		
				</p>
				<p class="form-field">
					<label>Custom Label 2</label>
					<input type="text" size="10" name="google_tab_custom_label_2" value="<?php echo @$google_tab_options['custom_label_2']; ?>" />		
				</p>
				<p class="form-field">
					<label>Custom Label 3</label>
					<input type="text" size="10" name="google_tab_custom_label_3" value="<?php echo @$google_tab_options['custom_label_3']; ?>" />		
				</p>
				<p class="form-field">
					<label>Custom Label 4</label>
					<input type="text" size="10" name="google_tab_custom_label_4" value="<?php echo @$google_tab_options['custom_label_4']; ?>" />		
				</p>
			</div>
		</div>
	<?php
}

add_action('woocommerce_product_write_panels', 'google_tab_options');

/* Save Google Fields Values */

function process_product_meta_google_tab( $post_id ) {
	
	update_post_meta( $post_id, 'google_tab_condition',$_POST['google_tab_condition'] );
	update_post_meta( $post_id, 'google_tab_gtin', $_POST['google_tab_gtin']);
	update_post_meta( $post_id, 'google_tab_mpn', $_POST['google_tab_mpn']);
	update_post_meta( $post_id, 'google_tab_brand', $_POST['google_tab_brand']);
	update_post_meta( $post_id, 'google_tab_color', $_POST['google_tab_color']);
	update_post_meta( $post_id, 'google_tab_material', $_POST['google_tab_material']);
	update_post_meta( $post_id, 'google_tab_adwords_grouping', $_POST['google_tab_adwords_grouping']);
	update_post_meta( $post_id, 'google_tab_adwords_labels', $_POST['google_tab_adwords_labels']);
	update_post_meta( $post_id, 'google_tab_adwords_redirect', $_POST['google_tab_adwords_redirect']);
	update_post_meta( $post_id, 'google_tab_custom_label_0', $_POST['google_tab_custom_label_0']);
	update_post_meta( $post_id, 'google_tab_custom_label_1', $_POST['google_tab_custom_label_1']);
	update_post_meta( $post_id, 'google_tab_custom_label_2', $_POST['google_tab_custom_label_2']);
	update_post_meta( $post_id, 'google_tab_custom_label_3', $_POST['google_tab_custom_label_3']);
	update_post_meta( $post_id, 'google_tab_custom_label_4', $_POST['google_tab_custom_label_4']);
	$identified_exists  = isset( $_POST['google_tab_identified_exists'] ) ? 'true' : 'false';
	update_post_meta( $post_id, 'google_tab_identified_exists', $identified_exists );
}

add_action('woocommerce_process_product_meta', 'process_product_meta_google_tab');

/**
 * Override theme default specification for product # per row
 */
function loop_columns() {
	if(is_page('19-depth-under'))
	{
		return 4; // 4 products per row
	}
	else
	{
		return 3; // 3 products per row
	}
}
add_filter('loop_shop_columns', 'loop_columns', 999);



// dgamoni

add_action( 'after_setup_theme', 'layerswoo_theme_setup' );
function layerswoo_theme_setup() {
   add_theme_support( 'wc-product-gallery-zoom' );
   add_theme_support( 'wc-product-gallery-lightbox' );
   add_theme_support( 'wc-product-gallery-slider' );
}

add_filter( 'woocommerce_get_image_size_gallery_image', function( $size ) {
return array(
	'width' => 560,
	'height' => 560,
	'crop' => 1,
	);
} );

add_action('wp_footer', 'add_custom_css');
function add_custom_css() { ?>
	<script>
		jQuery(document).ready(function($) {

		});
	</script>
	<style>
		.woocommerce-main-image {
		    cursor: inherit;
		    cursor: inherit;
		}
		.woocommerce img.size-shop_single,
		.woocommerce-page img.size-shop_single {
		    height: 560px;
		    object-fit: cover;
		}
		#wooswipe .thumbnails li {
		    margin-right: 10px;
		    margin-left: 0;
		}
		#wooswipe .slick-list {
		    margin-left: 0px;
		    margin-right: 0px;
		}
	</style>
	<?php
}