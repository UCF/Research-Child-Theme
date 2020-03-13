<?php
/**
 * Functions related to the cluster template
 */

/**
 * Function that returns an array markup of news
 * stories for a cluster
 */
function research_get_news( $meta ) {
	$items = array();

	foreach( $meta as $story ) {
		switch( $story['story_source'] ) {
			case 'today':
				$item = research_get_today_markup( $story );
				if ( $item ) $items[] = $item;
				break;
			case 'pegasus':
				$item = research_get_pegasus_markup( $story );
				if ( $item ) $items[] = $item;
				break;
			case 'research':
				$item = research_get_research_story( $story );
				if ( $item ) $items[] = $item;
				break;
			default:
				$item = research_get_external_story( $story );
				if ( $item ) $items[] = $item;
				break;
		}
	}

	return $items;
}

/**
 * Returns the markup for a today story
 * @author Jim Barnes
 * @since 1.0.0
 * @param array $story The story meta
 * @return string
 */
function research_get_today_markup( $story ) {
	$retval = false;

	$parsed_url = parse_url( $story['today_url'] );
	$path = $parsed_url['path'];

	preg_match( '/\/news\/(?P<slug>[a-zA-Z\-]+)/', $path, $matches );

	if ( isset( $matches['slug'] ) && ! empty( $matches['slug'] ) ) {
		$slug = $matches['slug'];

		$url = 'https://www.ucf.edu/news/wp-json/wp/v2/posts/';

		$param_string = http_build_query( array(
			'limit' => 1,
			'slug' => $slug
		) );

		$item = research_fetch_cache_json( "$url?$param_string", 'research_cluster_news_item_' );

		$retval = isset( $item[0] ) && ! empty( $item[0] ) ? $item[0] : false;
	}

	return $retval;
}

/**
 * Returns the markup for a pegasus story
 * @author Jim Barnes
 * @since 1.0.0
 * @param array $story The story meta
 * @return string
 */
function research_get_pegasus_markup( $story ) {
	$retval = false;

	$parsed_url = parse_url( $story['pegasus_url'] );
	$path = $parsed_url['path'];

	preg_match( '/\/pegasus\/(?P<slug>[a-zA-Z\-]+)/', $path, $matches );

	if ( isset( $matches['slug'] ) && ! empty( $matches['slug'] ) ) {
		$slug = $matches['slug'];

		$url = 'https://www.ucf.edu/pegasus/wp-json/wp/v2/story/';

		$param_string = http_build_query( array(
			'limit' => 1,
			'slug' => $slug
		) );

		$item = research_fetch_cache_json( "$url?$param_string", 'research_cluster_news_item_' );

		$retval = isset( $item[0] ) && ! empty( $item[0] ) ? $item[0] : false;
	}

	return $retval;
}

/**
 * Returns the markup for a research story
 * @author Jim Barnes
 * @since 1.0.0
 * @param array $story The story meta
 * @return string
 */
function research_get_research_story( $story ) {
	return false;
}

/**
 * Returns the markup for an external story
 * @author Jim Barnes
 * @since 1.0.0
 * @param array $story The story meta
 * @return string
 */
function research_get_external_story( $story ) {
	return false;
}

