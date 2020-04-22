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
	$args = array(
		'list_title'     => '',
		'display_search' => false
	);

	return UCF_Post_List_Common::display_post_list( $faculty, 'people', $args );
}
