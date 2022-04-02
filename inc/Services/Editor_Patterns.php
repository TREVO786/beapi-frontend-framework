<?php


namespace BEA\Theme\Framework\Services;

use BEA\Theme\Framework\Service;
use BEA\Theme\Framework\Service_Container;

class Editor_Patterns implements Service {
	/**
	 * @param Service_Container $container
	 */
	public function register( Service_Container $container ): void {}

	/**
	 * @return string
	 */
	public function get_service_name(): string {
		return 'editor-patterns';
	}

	/**
	 * @param Service_Container $container
	 */
	public function boot( Service_Container $container ): void {
		\add_action( 'init', [ $this, 'register_categories' ], 10 );
		\add_action( 'init', [ $this, 'register_patterns' ], 11 );
	}

	/**
	 * Register the patterns categories
	 *
	 */
	public function register_categories(): void {

		$block_pattern_categories = array(
			'common' => array( 'label' => __( 'Common', 'beapi-frontend-framework' ) ),
		);

		foreach ( $block_pattern_categories as $name => $properties ) {
			if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
				register_block_pattern_category( $name, $properties );
			}
		}
	}

	/**
	 * Register the patterns
	 *
	 */
	public function register_patterns(): void {
		$block_patterns = [
			'media-text',
		];

		foreach ( $block_patterns as $block_pattern ) {
			$pattern_file = get_theme_file_path( '/assets/patterns/' . $block_pattern . '.php' );

			register_block_pattern(
				'project/' . $block_pattern,
				require $pattern_file
			);
		}
	}

	/**
	 * Get pattern content from designated folder
	 *
	 * @param string $pattern_file : .html file to get content from.
	 *
	 * @return false|string
	 * @author Nicolas JUEN
	 */
	protected function get_pattern_content( string $pattern_file ) {
		$file = locate_template( $pattern_file, false, false );
		if ( ! \is_readable( $file ) ) {
			return '';
		}
		ob_start();
		load_template( $file, false );
		return ob_get_clean();
	}
}
