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
			if( $categories_obj = get_categories() ) {
				foreach ($categories_obj as $each) {
					?><span class="small my-3 mr-2 p-1 bg-faded"><?php echo $each->name; ?></span><?php
				}
			}
			?>
		</div>
		<div class="col-1"></div>
		<div class="col-6 text-right my-1">
			<span class="small mb-2 p-1 bg-faded">Author: <?php echo $author; ?></span>
		</div>
	</div>
</div>
