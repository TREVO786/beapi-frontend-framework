<?php

namespace BEA\Theme\Framework\Services;

use BEA\Theme\Framework\Service;
use BEA\Theme\Framework\Service_Container;

/**
 * Class Svg
 *
 * @package BEA\Theme\Framework
 */
class Svg implements Service {

	/**
	 * @param Service_Container $container
	 */
	public function register( Service_Container $container ): void {
		add_filter( 'wp_kses_allowed_html', [ $this, 'allow_svg_tag' ] );
	}

	/**
	 * @param Service_Container $container
	 */
	public function boot( Service_Container $container ): void {
	}

	/**
	 * @return string
	 */
	public function get_service_name(): string {
		return 'svg';
	}

	/**
	 * @param string $icon_class
	 * @param array  $additionnal_classes
	 *
	 * @return string
	 */
	public function get_the_icon( string $icon_class, array $additionnal_classes = [] ): string {
		if ( empty( $icon_class ) ) {
			return '';
		}

		$icon_slug = strpos( $icon_class, 'icon-' ) === 0 ? $icon_class : sprintf( 'icon-%s', $icon_class );
		$classes   = [ 'icon', $icon_slug ];
		$classes   = array_merge( $classes, $additionnal_classes );
		$classes   = array_map( 'sanitize_html_class', $classes );

		return sprintf( '<svg class="%s" aria-hidden="true" focusable="false"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="%s#%s"></use></svg>', implode( ' ', $classes ), \get_theme_file_uri( '/dist/img/icons/icons.svg' ), $icon_slug ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * @param string $icon_class
	 * @param array $additionnal_classes
	 */
	public function the_icon( string $icon_class, array $additionnal_classes = [] ): void {
		echo $this->get_the_icon( $icon_class, $additionnal_classes ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Allow svg tag
	 *
	 * @param $tags
	 *
	 * @return mixed
	 * @author Egidio CORICA
	 */
	public function allow_svg_tag( $tags ) {
		$tags['svg'] = [
			'xmlns'       => [],
			'fill'        => [],
			'viewbox'     => [],
			'role'        => [],
			'aria-hidden' => [],
			'focusable'   => [],
			'class'       => [],
			'style'       => [],
		];

		$tags['path'] = [
			'd'    => [],
			'fill' => [],
		];

		$tags['use'] = [
			'href'        => [],
			'xmlns:xlink' => [],
			'xlink:href'  => [],
		];

		return $tags;
	}
}
