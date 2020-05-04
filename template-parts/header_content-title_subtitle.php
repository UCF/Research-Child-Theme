<?php
$obj           = ucfwp_get_queried_object();
$title         = ucfwp_get_header_title( $obj );
$subtitle      = ucfwp_get_header_subtitle( $obj );
$h1            = ucfwp_get_header_h1_option( $obj );
$h1_elem       = ucfwp_get_header_h1_elem( $obj );
$title_elem    = ( $h1 === 'title' ) ? $h1_elem : 'span';
$subtitle_elem = ( $h1 === 'subtitle' ) ? $h1_elem : 'span';

$clusters_link = get_theme_mod( 'clusters_list_page' ) ? get_permalink( get_theme_mod( 'clusters_list_page' ) ) : null;
?>

<?php if ( $title ): ?>
	<div class="header-content-inner align-self-start pt-4 pt-sm-0 align-self-sm-center">
		<div class="container">
			<?php if ( $clusters_link ) : ?>
			<div class="d-inline-block bg-inverse-t-1 py-3 px-2 mb-3">
				<a class="text-primary text-uppercase letter-spacing-3 font-weight-black" href="<?php echo $clusters_link; ?>">UCF Faculty Clusters</a>
			</div>
			<div class="clearfix"></div>
			<?php endif; ?>
			<div class="d-inline-block bg-primary-t-1">
				<<?php echo $title_elem; ?> class="header-title"><?php echo $title; ?></<?php echo $title_elem; ?>>
			</div>
			<?php if ( $subtitle ) : ?>
			<div class="clearfix"></div>
			<div class="d-inline-block bg-inverse">
				<<?php echo $subtitle_elem; ?> class="header-subtitle"><?php echo $subtitle; ?></<?php echo $subtitle_elem; ?>>
			</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
