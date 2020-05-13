<?php
/**
 * Functions related to the cluster template
 */

/**
 * Function that returns an array markup of news
 * stories for a cluster
 */
function research_get_news( $meta ) {
	if ( ! is_array( $meta ) || empty( $meta ) ) return null;

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
			default:
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
					<p class="ucf-news-item-excerpt"><?php echo wp_trim_words( $excerpt, 20 ); ?></p>
				</div>
			</div>
		</a>
	</div>
<?php
	return ob_get_clean();
}

function research_get_thumbnail( $story, $source = 'today' ) {
	switch( $source ) {
		case 'today':
			return $story->thumbnail;
		case 'pegasus':
			$embedded = (array)$story->_embedded;
			$featured_media = $embedded['wp:featuredmedia'];
			return isset( $featured_media[0]->media_details->sizes->thumbnail->source_url ) ?
				$featured_media[0]->media_details->sizes->thumbnail->source_url :
				'';
		default:
			return null;
	}
}

/**
 * Utility function for returning a header image
 * @author Jim Barnes
 * @since 1.0.0
 * @param int $post_id The post ID
 * @param bool $xs True if request the xs image
 * @return string The image path
 */
function research_cluster_get_header_image( $post_id, $xs = false ) {
	$field_name = $xs ? 'page_header_image_xs' : 'page_header_image';
	$img_size   = $xs ? 'header_img_xs' : 'header_img_sm';

	$bg_image_id = get_field( $field_name, $post_id );
	$bg_image    = isset( $bg_image_id ) ? wp_get_attachment_image_src( $bg_image_id, $img_size ) : null;

	if ( $bg_image && is_array( $bg_image ) ) {
		return $bg_image[0];
	}

	// We didn't get a head image back.
	// Try to get a default

	$theme_mod_name = $xs ? 'cluster_fallback_bg_xs' : 'cluster_fallback_bg';

	$default_bg_image = get_theme_mod( $theme_mod_name );

	return $default_bg_image;
}
