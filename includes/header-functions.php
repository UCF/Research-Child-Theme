<?php
/**
 * Functions for general header elements
 */

/**
 * Returns backlink markup where applicable
 * @author Jim Barnes
 * @since 1.0.0
 * @param object $obj Most of the time a WP_Post, but can be other things
 * @return string The markup
 */
function research_get_backlink_markup( $obj ) {
	$heading_text = null;
	$heading_link = null;

	if ( is_page_template( 'page-template-cluster.php' ) ) {
		$heading_text  = get_theme_mod( 'clusters_heading_text' ) ?: 'Faculty Research Clusters';
		$heading_link = get_theme_mod( 'clusters_list_page' ) ? get_permalink( get_theme_mod( 'clusters_list_page' ) ) : null;
	}

	// Check for override
	$group_nav_text = get_field( 'group_navigation_text' ) ?: null;
	$group_nav_link = get_field( 'group_navigation_page' ) ?: null;

	if ( $group_nav_text && $group_nav_link ) {
		$heading_text = $group_nav_text;
		$heading_link = $group_nav_link;
	}

	ob_start();

	if ( $heading_text && $heading_link ) :
?>
	<div class="d-inline-block bg-inverse-t-2 p-3 mb-1">
		<a class="text-inverse text-uppercase letter-spacing-3 font-weight-light" href="<?php echo $heading_link; ?>"><?php echo $heading_text; ?></a>
	</div>
	<div class="clearfix"></div>
<?php
	endif;

	return ob_get_clean();
}

/**
 * Overrides the default header type for posts
 * @author Jim Barnes
 * @since 1.2.0
 *
 * @param string $header_type The default header_type
 * @param object|null $object The currently queried object
 * @return string
 */
function research_get_header_type( $header_type, $object ) {
	if ( $header_type === "" && $object instanceof WP_Post && $object->post_type === 'post' ) {
		$header_type = 'post';
	}

	return $header_type;
}

add_filter( 'ucfwp_get_header_type', 'research_get_header_type', 10, 2 );
