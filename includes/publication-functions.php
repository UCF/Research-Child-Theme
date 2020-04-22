<?php
/**
 * Handles publication layouts
 */

/**
 * Functions that handles markup for
 * book publications
 * @author Jim Barnes
 * @since 1.0.0
 * @param string $markup The content passed into the filter
 * @param WP_Post $publication The publication post
 * @return string
 */
function research_book_markup( $markup, $publication ) {
	$authors = get_field( 'publication_authors', $publication->ID );
	$author_string = implode( ', ', array_column( $authors, 'post_title' ) );
	$publisher = get_field( 'publication_publisher', $publication->ID );
	$advanced = get_field( 'publication_advanced_info', $publication->ID );
	$published_year = get_field( 'publication_year', $publication->ID );

	$details = $advanced;
	$details .= ! empty( $publisher ) ? ' ' . $publisher : '';
	$details .= ! empty( $published_year ) ? ', ' . $published_year : '';

	ob_start();
?>
	<span class="font-weight-bold font-italic"><?php echo $publication->post_title; ?></span>, <?php echo $author_string; ?>: <?php echo $details; ?>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_research_book_markup', 'research_book_markup', 10, 2 );

/**
 * Functions that handles markup for
 * journal publications
 * @author Jim Barnes
 * @since 1.0.0
 * @param string $markup The content passed into the filter
 * @param WP_Post $publication The publication post
 * @return string
 */
function research_journal_markup( $markup, $publication ) {
	$authors = get_field( 'publication_authors', $publication->ID );
	$author_string = implode( ', ', array_column( $authors, 'post_title' ) );
	$journal = get_field( 'journal_title', $publication->ID );
	$advanced = get_field( 'publication_advanced_info', $publication->ID );
	$published_date = get_field( 'publication_date', $publication->ID );

	$details = '<span class="publication-journal font-italic">' . $journal . '</span>';
	$details .= ! empty( $advanced ) ? ' ' . $advanced : '';
	$details .= ! empty( $published_date ) ? ': ' . $published_date : '';

	ob_start();
?>
	<span class="font-weight-bold">&ldquo;<?php echo $publication->post_title; ?>&rdquo;</span>, <?php echo $author_string; ?>, <?php echo $details; ?>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_research_journal_markup', 'research_journal_markup', 10, 2 );

/**
 * Functions that handles markup for
 * digital publications
 * @author Jim Barnes
 * @since 1.0.0
 * @param string $markup The content passed into the filter
 * @param WP_Post $publication The publication post
 * @return string
 */
function research_digital_markup( $markup, $publication ) {
	$authors = get_field( 'publication_authors', $publication->ID );
	$author_string = implode( ', ', array_column( $authors, 'post_title' ) );
	$website = get_field( 'website_name', $publication->ID );
	$url = get_field( 'publication_url', $publication->ID );
	$published_date = get_field( 'publication_date', $publication->ID );

	$details = "$website, $published_date";

	ob_start();
?>
	<a href="<?php echo $url; ?>" target="_blank"><span class="font-weight-bold">&ldquo;<?php echo $publication->post_title; ?>&rdquo;</span></a>, <?php echo $author_string; ?>, <?php echo $details; ?>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_research_digital_markup', 'research_digital_markup', 10, 2 );
