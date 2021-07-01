<?php

namespace BEA\Theme\Framework\Services;

use BEA\Theme\Framework\Service;
use BEA\Theme\Framework\Service_Container;

/**
 * Class Gutenberg
 *
 * @package BEA\Theme\Framework
 */
class Gutenberg implements Service {

	/**
	 * @param Service_Container $container
	 */
	public function register( Service_Container $container ): void {
	}

	/**
	 * @param Service_Container $container
	 */
	public function boot( Service_Container $container ): void {
		$this->after_setup_theme();
	}

	/**
	 * @return string
	 */
	public function get_service_name(): string {
		return 'gutenberg';
	}

	/**
	 * After setup theme
	 */
	public function after_setup_theme() {
		add_theme_support( 'disable-custom-colors' );
		add_theme_support( 'disable-custom-gradients' );

		add_theme_support(
			'editor-color-palette',
			[
				[
					'name'  => __( 'Light Blue', 'interfel' ),
					'slug'  => 'light-blue',
					'color' => '#f0f6f8',
				],
				[
					'name'  => __( 'Blue', 'interfel' ),
					'slug'  => 'blue',
					'color' => '#13b4e2',
				],
				[
					'name'  => __( 'Dark Blue', 'interfel' ),
					'slug'  => 'dark-blue',
					'color' => '#163467',
				],
			]
		);
	}
}
