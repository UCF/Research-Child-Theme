<?php
/**
 * Person functions
 */
function research_get_faculty_list( $faculty ) {
	$args = array(
		'list_title'     => '',
		'display_search' => false
	);

	return UCF_Post_List_Common::display_post_list( $faculty, 'people', $args );
}
