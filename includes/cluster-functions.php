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
	<div class="ucf-news-item media-background-container hover-parent p-3 mb-3" style="margin-left: -1rem; margin-right: -1rem;">
		<div class="media-background hover-child-show fade" style="background-color: rgba(204, 204, 204, .25);"></div>

		<div class="media">
			<?php if ( $thumbnail ) : ?>
			<div class="ucf-news-thumbnail d-flex w-25 mr-3" style="max-width: 150px;">
				<img class="ucf-news-thumbnail-image img-fluid w-100" src="<?php echo $thumbnail; ?>" alt="">
			</div>
			<?php endif; ?>
			<div class="ucf-news-item-content media-body">
				<div class="ucf-news-item-details">
					<a class="ucf-news-item-title d-block stretched-link text-decoration-none h5 mb-2 pb-1" href="<?php echo $permalink; ?>" style="color: inherit;">
						<?php echo $title; ?>
					</a>
					<div class="ucf-news-item-excerpt font-size-sm">
						<?php echo wp_trim_words( $excerpt, 20 ); ?>
					</div>
				</div>
			</div>
		</div>
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

/**
 * Set default header image IDs when custom images aren't set
 * on an object.
 *
 * @since 1.0.0
 * @author Jo Dickson
 * @param array $header_imgs A set of Attachment IDs, one sized for use on -sm+ screens, and another for -xs
 * @param mixed $obj A queried object (e.g. WP_Post, WP_Term), or null
 * @return array Modified set of Attachment IDs
 */
function research_cluster_get_header_images_after( $header_imgs, $obj ) {
	// Return our early if it's not using the right template
	if ( ! is_page_template( 'page-template-cluster.php' ) ) {
		return $header_imgs;
	}

	// Exit early if a header image is defined.
	if ( isset( $header_imgs['header_image'] ) && $header_imgs['header_image'] ) {
		return $header_imgs;
	}

	$default_sm = get_theme_mod( 'cluster_fallback_bg' );
	$default_xs = get_theme_mod( 'cluster_fallback_bg_xs' );

	if ( $default_sm ) {
		$attachment_id = attachment_url_to_postid( $default_sm );
		if ( $attachment_id ) {
			$header_imgs['header_image'] = $attachment_id;
		}
	}

	// Only set `header_image_xs` if the -sm+ image is available
    // AND the -xs image is actually set:
	if ( $default_sm && $default_xs ) {
		$attachment_id_xs = attachment_url_to_postid( $default_xs );
		$header_imgs['header_image_xs'] = $attachment_id_xs;
	}

	return $header_imgs;
}

add_filter( 'ucfwp_get_header_images_after', 'research_cluster_get_header_images_after', 11, 2 );
