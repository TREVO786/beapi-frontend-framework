<?php get_header(); ?>
<div class="container">
	<?php
	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb( '<section class="breadcrumb">','</section>' );
	}
	?>
	<div class="wysiwyg">
		<?php while ( have_posts() ) {
			the_post();
			the_content();
		} ?>
	</div>
</div>
<?php get_footer(); ?>
