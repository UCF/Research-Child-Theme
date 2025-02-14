<?php
$obj         = ucfwp_get_queried_object();
$author      = get_the_author_meta( 'display_name', get_post_field( 'post_author', $obj->ID ) );
$exclude_nav = get_field( 'page_header_exclude_nav', $obj );

$template = get_page_template_slug();
?>

<?php if ( ! $exclude_nav ) { echo ucfwp_get_nav_markup( false ); } ?>

<div class="container">
	<?php if ( $template === 'template-narrow.php' ) : ?>
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
	<?php endif; ?>
			<h1 class="mt-3 mb-2"><?php echo $obj->post_title; ?></h1>
			<span class="d-block text-muted"><?php echo get_the_date(); ?></span>
	<?php if ( $template === 'template-narrow.php' ) : ?>
			</div>
		</div>
	<?php endif; ?>
</div>
