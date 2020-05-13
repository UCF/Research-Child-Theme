<?php
/**
 * Custom post list layouts
 */

if ( ! function_exists( 'research_clusters_layout_content' ) ) {
	/**
	 * Displays a list of faculty clusters
	 * @author Jim Barnes
	 * @since 1.0.0
	 * @param string $retval The default markup
	 * @param array $posts The array of posts
	 * @param array $atts The shortcode attributes
	 * @return string The modified markup
	 */
	function research_clusters_layout_content( $retval, $posts, $atts ) {
		ob_start();

		foreach( $posts as $idx => $post ) :

		$bg_image_sm_id = get_field( 'page_header_image', $post->ID );
		$bg_image_sm    = isset( $bg_image_sm_id ) ? wp_get_attachment_image_src( $bg_image_sm_id, 'header_img_sm' ) : null;
		$bg_image_xs_id = get_field( 'page_header_image_xs', $post->ID );
		$bg_image_xs    = isset( $bg_image_xs_id ) ? wp_get_attachment_image_src( $bg_image_xs_id, 'header_img_xs' ) : null;

		$short_desc  = get_field( 'cluster_short_desc', $post->ID ) ?: null;

		$push = $idx % 2 === 0 ? false : true;

	?>
		<section id="<?php echo $post->post_name; ?>" aria-labelledby="<?php echo $post->post_name ?>-heading">
			<div class="jumbotron jumbotron-fluid co-jumbotron-wrap media-background-container bg-inverse d-flex flex-column justify-content-end justify-content-md-center mb-0 p-0 p-sm-5">
				<?php if ( $bg_image_sm && $bg_image_xs ) : ?>
				<picture>
					<source media="(min-width: 767px)" srcset="<?php echo $bg_image_sm[0]; ?>">
					<img src="<?php echo $bg_image_xs[0]; ?>" alt="" class="co-jumbotron-bg media-background object-fit-cover">
				</picture>
				<?php endif; ?>
				<div class="container">
					<div class="row p-lg-5">
						<div class="col-12 col-md-8<?php echo $push ? ' offset-md-4' : ''?>">
							<div class="bg-inverse-t-3 p-5">
								<h2 class="display-5 font-condensed text-uppercase mt-0 mb-4" id="<?php echo $post->post_name; ?>-heading" aria-label="<?php echo $post->post_title; ?>"><?php echo $post->post_title; ?></h2>
								<?php if ( $short_desc ) : ?>
								<?php echo $short_desc; ?>
								<?php endif; ?>
								<a class="btn btn-primary mt-4 d-inline-block" href="<?php echo get_permalink( $post->ID ); ?>">Learn More about <?php echo $post->post_title; ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php
		endforeach;

		return ob_get_clean();
	}

	add_filter( 'ucf_post_list_display_research_clusters_before', '__return_false' );
	add_filter( 'ucf_post_list_display_research_clusters_title', '__return_false' );
	add_filter( 'ucf_post_list_display_research_clusters', 'research_clusters_layout_content', 10, 3 );
	add_filter( 'ucf_post_list_display_research_clusters_after', '__return_false' );

}
