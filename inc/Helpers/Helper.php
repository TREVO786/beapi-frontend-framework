<?php

namespace BEA\Theme\Framework\Helpers\Helper;

/**
 * @usage BEA\Theme\Framework\Helpers\Helper\get_custom_link( ['field' => ..., 'class' => ...], [ 'before' => '<p>%s', 'after' => '</p>' ] );
 *
 * @param array $acf_options
 * @param array $wrapper
 *
 * @return string
 */
function get_acf_link( array $acf_options, array $wrapper = [] ): string {
	if ( empty( $acf_options['field']['url'] ) || empty( $acf_options['field']['title'] ) ) {
		return '';
	}

	$settings = wp_parse_args(
		$acf_options,
		[
			'href'  => $acf_options['field']['url'],
			'title' => $acf_options['field']['title'],
		],
	);

	$settings = apply_filters( 'bea_acf_link_setting', $settings );

	$wrapper = wp_parse_args(
		$wrapper,
		[
			'before' => '',
			'after'  => '',
		],
	);

	$wrapper = apply_filters( 'bea_acf_link_wrapper', $wrapper );

	// Set rel attribute if target is _blank
	$target = $acf_options['field']['target'];
	if ( '_blank' === $target ) {
		$settings['target'] = $target;
		$settings['rel']    = 'noopener';
	}

	// Unset unused field params
	unset( $settings['field'] );

	/**************************************** START MARKUP LINK ****************************************/
	$link_markup = '<a ';

	foreach ( $settings as $attribute_name => $attribute_value ) {

		// Escape URL
		if ( 'href' === $attribute_name ) {
			$attribute_value = esc_url( $attribute_value );
		} else {
			$attribute_value = esc_attr( $attribute_value );
		}

		$link_markup .= sprintf( '%s="%s"', $attribute_name, $attribute_value );
	}

	$link_markup .= sprintf( '>%s</a>', $settings['title'] );

	/**************************************** END MARKUP LINK ****************************************/

	$link_markup = apply_filters( 'bea_acf_link_markup', $link_markup );

	return $wrapper['before'] . $link_markup . $wrapper['after'];
}

/**
 * @usage BEA\Theme\Framework\Helpers\Helper\the_custom_link( ['url' => ..., 'title' => ...], [ 'wrapper' => '<p></p>' ] );
 *
 * @param array $acf_field or array like
 * @param array $options
 *
 * @return void
 */
function the_acf_link( array $acf_field, array $options = [] ): void {
	echo get_acf_link( $acf_field, $options );
}

/**
 * @usage BEA\Theme\Framework\Helpers\Helper\get_custom_link( ['href' => ..., 'title' => ...], [ 'wrapper' => '<p>%s</p>' ] );
 *
 * @param array $options
 * @param array $wrapper
 *
 * @return string
 */
function get_custom_link( array $options, array $wrapper = [] ): string {
	if ( empty( $options['href'] ) ) {
		return '';
	}

	$settings = wp_parse_args(
		$options,
		[
			'title'           => '',
			'data-seo-target' => false,
		],
	);

	$settings = apply_filters( 'bea_custom_link_setting', $settings );

	$wrapper = wp_parse_args(
		$wrapper,
		[
			'before' => '',
			'after'  => '',
		],
	);

	$wrapper = apply_filters( 'bea_custom_link_wrapper', $wrapper );

	// Set rel attribute if target is _blank
	$target = $options['target'];
	if ( '_blank' === $target ) {
		$settings['target'] = $target;
		$settings['rel']    = 'noopener';
	}

	/**************************************** START MARKUP LINK ****************************************/
	$link_markup = '<a ';

	foreach ( $settings as $attribute_name => $attribute_value ) {

		// Escape URL
		if ( 'href' === $attribute_name ) {
			$attribute_value = esc_url( $attribute_value );
		} else {
			$attribute_value = esc_attr( $attribute_value );
		}

		$link_markup .= sprintf( '%s="%s"', $attribute_name, $attribute_value );
	}

	$link_markup .= sprintf( '>%s</a>', $settings['title'] );

	/**************************************** END MARKUP LINK ****************************************/

	$link_markup = apply_filters( 'bea_custom_link_markup', $link_markup );

	return $wrapper['before'] . $link_markup . $wrapper['after'];
}

/**
 * @usage BEA\Theme\Framework\Helpers\Helper\the_custom_link( ['url' => ..., 'title' => ...], [ 'wrapper' => '<p></p>' ] );
 *
 * @param array $acf_field
 * @param array $options
 *
 * @return void
 */
function the_custom_link( array $acf_field, array $options = [] ): void {
	echo get_custom_link( $acf_field, $options );
}

/**
 * @usage BEA\Theme\Framework\Helpers\Helper\the_text( 'text' => 'Lorem ipsum', 'esc' => 'html', [ 'before' => '<p>', 'after' => '</p>' ] );
 *
 * @param array $options
 * @param array $wrapper
 *
 * @return void
 */
function the_text( array $options, array $wrapper = [] ): void {
	$text = get_the_text( $options['text'], $wrapper );

	if ( empty( $text ) ) {
		return;
	}

	$escape = $options['esc'] ?? 'html';

	switch ( $escape ) {
		case 'attr':
			$text = esc_attr( $text );
			break;
		case 'url':
			$text = esc_url( $text );
			break;
		case 'js':
			$text = esc_js( $text );
			break;
		case 'textarea':
			$text = esc_textarea( $text );
			break;
		case 'kses':
			$text = wp_kses_post( $text );
			break;
		default:
			$text = esc_html( $text );
			break;
	}

	$text = apply_filters( 'bea_the_text', $text );

	// phpcs:ignore
	echo $text;
}

/**
 * Get the text
 * @usage BEA\Theme\Framework\Helpers\Helper\get_the_text( 'Lorem ipsum', [ 'before' => '<p>', 'after' => '</p>' ] );
 *
 * @param string $text
 * @param array $wrapper
 *
 * @return string
 */
function get_the_text( string $text, array $wrapper = [] ): string {
	if ( empty( $text ) ) {
		return '';
	}

	$wrapper = wp_parse_args(
		$wrapper,
		[
			'before' => '',
			'after'  => '',
		],
	);

	$text    = apply_filters( 'bea_get_text', $text );
	$wrapper = apply_filters( 'bea_get_text_wrapper', $wrapper );

	// phpcs:ignore
	return $wrapper['before'] . $text . $wrapper['after'];
}


/**
 * @usage BEA\Theme\Framework\Helpers\Helper\the_image( 1, [  'data-location' => 'image-size' ] );
 *
 * @param int $image_id
 * @param array $options
 *
 * @return void
 */
function the_image( int $image_id, array $options = [] ): void {
	if ( $image_id <= 0 ) {
		return;
	}

	$settings = wp_parse_args(
		$options,
		[
			'before'        => '',
			'after'         => '',
			'data-location' => '',
			'class'         => '',
		]
	);

	$settings = apply_filters( 'bea_the_image_settings', $settings );

	$image = \wp_get_attachment_image(
		$image_id,
		'thumbnail',
		false,
		[
			'data-location' => $settings['data-location'],
			'class'         => $settings['class'],
		]
	);


	$image = apply_filters( 'bea_the_image_markup', $image );

	// phpcs:ignore
	echo $settings['before'] . $image . $settings['after'];
}

/**
 * @usage BEA\Theme\Framework\Helpers\Helper\get_share_link( ['name' => facebook'], [ 'u' => 'https://...'] );
 *
 * @param array $option_field
 * @param array $url_params
 *
 * @return string
 */
function get_share_link( array $option_field, array $url_params = [] ): string {
	if ( empty( $option_field['name'] ) ) {
		return '';
	}

	$networks = [
		'facebook' => [
			'title'         => 'Partager sur Facebook',
			'href'          => 'http://www.facebook.com/sharer.php',
			'default_param' => 'u',
		],
		'twitter'  => [
			'title'         => 'Partager sur Twitter',
			'href'          => 'https://twitter.com/intent/tweet',
			'default_param' => 'url',
		],
		'linkedin' => [
			'title'         => 'Partager sur Linkedin',
			'href'          => 'https://www.linkedin.com/shareArticle',
			'default_param' => 'url',
		],
		'email'    => [
			'title'         => 'Partager par email',
			'href'          => 'mailto:',
			'default_param' => 'body',
		],
	];

	$networks = apply_filters( 'bea_networks', $networks );
	$network  = $networks[ $option_field['name'] ] ?? false;

	if ( empty( $network ) ) {
		return '';
	}

	$network_data = [
		'title'      => $option_field['title'] ?? $network['title'],
		'class'      => $option_field['class'] ?? 'share__link',
		'url_params' => empty( $url_params ) ? [ $network['default_param'] => get_permalink() ] : $url_params,
	];

	$network_data = apply_filters( 'bea_networks_data', $network_data );

	return sprintf(
		'<a href="%1$s" target="_blank" rel="noopener" title="%2$s" tabindex="-1" class="%3$s">%4$s</a>',
		esc_url( add_query_arg( [ $network_data['url_params'] ], $network['href'] ) ),
		esc_attr( $network_data['title'] ),
		esc_attr( $network_data['class'] ),
		get_the_icon( $option_field['name'] )
	);
}

/**
 * @usage BEA\Theme\Framework\Helpers\Helper\the_share_link( ['name' => 'facebook' ], [ 'u' => 'https://...'] );
 *
 * @param array $options
 * @param array $url_params
 * @param array $wrapper
 *
 * @return void
 */
function the_share_link( array $options, array $url_params = [], array $wrapper = [] ): void {
	$share_link_markup = get_share_link( $options, $url_params );

	if ( empty( $share_link_markup ) ) {
		echo '';
	}

	if ( empty( $wrapper ) ) {
		$wrapper = [
			'before' => '<li>',
			'after'  => '</li>',
		];
	}

	$wrapper = apply_filters( 'bea_networks_wrapper', $wrapper );

	echo $wrapper['before'] . $share_link_markup . $wrapper['after']; //phpcs:ignore
}
