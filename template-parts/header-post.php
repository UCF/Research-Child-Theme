<?php
$obj         = ucfwp_get_queried_object();
$author      = get_the_author_meta( 'display_name', get_post_field( 'post_author', $obj->ID ) );
$exclude_nav = get_field( 'page_header_exclude_nav', $obj );
?>

<?php if ( ! $exclude_nav ) { echo ucfwp_get_nav_markup( false ); } ?>

<div class="container">
	<h1 class="mt-3 mb-2"><?php echo $obj->post_title; ?></h1>
	<div class="row mb-4 pt-1">
		<div class="col-5 my-1">
		<?php
		$selected_categories = wp_get_post_categories( get_the_ID() );
		$count = count( $selected_categories );
			if ( $selected_categories ) {
				foreach ( $selected_categories as $index => $selected_category ) {
					$category = get_category( $selected_category );
					?>
					<a href="<?php echo esc_url( get_category_link( $selected_category ) ); ?>" class="my-3 p-1"><?php echo esc_html( $category->name ); ?></a><?php echo $index < $count - 1 ? ' |' : ''; ?>
					<?php
				}
			}
		?>
	</div>
		<div class="col-1"></div>
		<div class="col-6 text-right my-1">
			<span class="mb-2 p-1">Author: <?php echo $author; ?></span>
		</div>
	</div>
</div>
