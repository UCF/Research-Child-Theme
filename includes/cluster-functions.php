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

	preg_match( '/\/news\/(?P<slug>[a-zA-Z0-9\-\_]*)/', $path, $matches );

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

	return ! empty( $retval ) ? research_format_story( $retval, 'today' ) : '';
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

	preg_match( '/\/pegasus\/(?P<slug>[a-zA-Z\-\_]+)/', $path, $matches );

	if ( isset( $matches['slug'] ) && ! empty( $matches['slug'] ) ) {
		$slug = $matches['slug'];

		$url = 'https://www.ucf.edu/pegasus/wp-json/wp/v2/story/';

		$param_string = http_build_query( array(
			'limit'  => 1,
			'slug'   => $slug,
			'_embed' => true
		) );

		$item = research_fetch_cache_json( "$url?$param_string", 'research_cluster_news_item_' );

		$retval = isset( $item[0] ) && ! empty( $item[0] ) ? $item[0] : false;
	}

	return ! empty( $retval ) ? research_format_story( $retval, 'pegasus' ) : '';
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

/**
 * Formats the story and return the HTML markup
 * @author Jim Barnes
 * @since 1.0.0
 * @param WP_Post $story The story post
 * @return string
 */
function research_format_story( $story, $source = 'external' ) {
	$thumbnail = research_get_thumbnail( $story, $source );

	if ( in_array( $source, array( 'today', 'pegasus' ) ) ) {
		$permalink = $story->link;
		$title = $story->title->rendered;
		$excerpt = $source === 'today' ? $story->excerpt->rendered : $story->story_description;
		$source = $source === 'today' ? 'UCF Today' : 'Pegasus Magazine';
	} else if ( $source = 'research' ) {
		$permalink = get_permalink( $story->ID );
		$title = $story->post_title;
		$excerpt = $story->post_excerpt;
		$source = 'UCF Research';
	} else {
		$permalink = $story['story_url'];
		$title     = $story['story_title'];
		$excerpt   = $story['story_excerpt'];
		$source    = $story['story_source'];
	}

	ob_start();
?>
	<div class="ucf-news-item">
		<a href="<?php echo $permalink; ?>">
			<div class="ucf-news-thumbnail">
				<img class="ucf-news-thumbnail-image image" src="<?php echo $thumbnail; ?>" alt>
			</div>
			<div class="ucf-news-item-content">
				<div class="ucf-news-item-details">
					<p class="ucf-news-item-title"><?php echo $title; ?></p>
					<p class="ucf-news-item-excerpt"><?php echo $excerpt; ?></p>
				</div>
			</div>
		</a>
	</div>
<?php
	return ob_get_clean();
}

function research_get_thumbnail( $story, $source = 'external' ) {
	switch( $source ) {
		case 'today':
			return $story->thumbnail;
		case 'pegasus':
			$embedded = (array)$story->_embedded;
			$featured_media = $embedded['wp:featuredmedia'];
			return isset( $featured_media[0]->media_details->sizes->thumbnail->source_url ) ?
				$featured_media[0]->media_details->sizes->thumbnail->source_url :
				'';
		case 'research':
			return get_the_post_thumbnail_url( $story->ID );
		default:
			return $story['story_thumbnail'];
	}
}

