<?php
/**
 * Person functions
 */

/**
 * Handles output for the people list
 * @author Jim Barnes
 * @since 1.0.0
 * @param array $faculty An array of faculty posts
 * @return string
 */
function research_get_faculty_list( $faculty ) {
	$layout = 'people';
	$args = array(
		'list_title'     => '',
		'display_search' => false
	);
	$args = shortcode_atts( UCF_Post_List_Config::get_shortcode_atts( $layout ), $args, 'ucf-post-list' );

	return UCF_Post_List_Common::display_post_list( $faculty, $layout, $args );
}

/**
 * Handles output for the people list
 * @author Jim Barnes
 * @since 1.0.0
 * @param array $faculty An array of post doc posts
 * @return string
 */
function research_get_postdoc_list( $post_docs ) {
	$layout = 'people';
	$args = array(
		'list_title'     => '',
		'display_search' => false
	);
	$args = shortcode_atts( UCF_Post_List_Config::get_shortcode_atts( $layout ), $args, 'ucf-post-list' );

	return UCF_Post_List_Common::display_post_list( $post_docs, $layout, $args );
}
