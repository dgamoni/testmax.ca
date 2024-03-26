<?php 
/**
 * * Template Name: Sitemap
 *
 */
get_header(); ?>
<div class="sitemap-page clearfix">
<?php
	echo '<div class="main-size">';
	wp_nav_menu( array('theme_location'  => 'sitemap_nav', 'depth' => 1, 'container' => false ) );
	echo "<div class='sitemap-border first'></div><ul>";
	$args = array(
	  'taxonomy'     =>'product_cat',
	  'orderby'      => 'name'
	);
	$all_categories = get_categories( $args );
	foreach ($all_categories as $cat) {
		if($cat->category_parent == 0)
		{
			$category_name = $cat->name;
			$category_link = get_term_link( $cat, 'product_cat' );
			echo '<li><a href="'.$category_link.'">'.$category_name.'</a></li>' ;
		}
	}
	echo "</ul><div class='sitemap-border'></div>";
	wp_nav_menu( array('theme_location'  => 'sitemap_nav', 'container'=> false , 'submenu' => 'Products') );
	echo '</div>';
	
	
	//Mobile Size
	echo '<div class="mobile-size">';
	wp_nav_menu( array('theme_location'  => 'sitemap_nav_mobile', 'container' => false) );
	echo '</div>';
	
	
?>
</div>
<?php get_footer(); ?>