<?php
/**
 * Autoload all the things \o/
 */
require_once 'autoload.php';

/**
 * Load all services
 */
add_action( 'after_setup_theme', function () {
	// Yoast custom separator Test
	add_filter( 'wpseo_breadcrumb_separator', function( $separator ){
		return '<svg class="icon icon-right" focusable="false" aria-hidden="true" role="img"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-right"></use></svg>';
	} );
	// Boot the service, at after_setup_theme.
	\BEA\Theme\Framework\Framework::get_container()->boot_services();
} );
