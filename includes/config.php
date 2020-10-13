<?php
/**
 * Handle all theme configuration here
 **/

define( 'RESEARCH_THEME_URL', get_stylesheet_directory_uri() );
define( 'RESEARCH_THEME_STATIC_URL', RESEARCH_THEME_URL . '/static' );
define( 'RESEARCH_THEME_CSS_URL', RESEARCH_THEME_STATIC_URL . '/css' );
define( 'RESEARCH_THEME_JS_URL', RESEARCH_THEME_STATIC_URL . '/js' );
define( 'RESEARCH_THEME_IMG_URL', RESEARCH_THEME_STATIC_URL . '/img' );
define( 'RESEARCH_THEME_CUSTOMIZER_PREFIX', 'research_' );

/**
 * Defines sections used in the WordPress Customizer.
 */
function research_define_customizer_sections( $wp_customize ) {
	$wp_customize->add_section(
		RESEARCH_THEME_CUSTOMIZER_PREFIX . 'clusters',
		array(
			'title' => 'Clusters Settings'
		)
	);
}

add_action( 'customize_register', 'research_define_customizer_sections' );

/**
 * Defines settings and controls used in the WordPress Customizer.
 */
function research_define_customizer_fields( $wp_customize ) {
	$wp_customize->add_setting(
		'clusters_heading_text'
	);

	$wp_customize->add_control(
		'clusters_heading_text',
		array(
			'type'        => 'text',
			'label'       => 'Clusters Heading Text',
			'description' => 'The text of the link in the research clusters header',
			'section'     => RESEARCH_THEME_CUSTOMIZER_PREFIX . 'clusters'
		)
	);

	$wp_customize->add_setting(
		'clusters_list_page'
	);

	$wp_customize->add_control(
		'clusters_list_page',
		array(
			'type'        => 'dropdown-pages',
			'label'       => 'Cluster Listing Page',
			'description' => 'The page where all faculty cluster pages are listed',
			'section'     => RESEARCH_THEME_CUSTOMIZER_PREFIX . 'clusters'
		)
	);

	$wp_customize->add_setting(
		'cluster_fallback_bg'
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'cluster_fallback_bg',
			array(
				'label'    => __( 'Upload a fallback header image for clusters' ),
				'section'  => RESEARCH_THEME_CUSTOMIZER_PREFIX . 'clusters',
				'height'   => 500,
				'width'    => 1600
			)
		)
	);

	$wp_customize->add_setting(
		'cluster_fallback_bg_xs'
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'cluster_fallback_bg_xs',
			array(
				'label'    => __( 'Upload a fallback header image for the xs breakpoint for clusters' ),
				'section'  => RESEARCH_THEME_CUSTOMIZER_PREFIX . 'clusters',
				'height'   => 575,
				'width'    => 575
			)
		)
	);
}

add_action( 'customize_register', 'research_define_customizer_fields' );
