<?php $bodyClass = 'page icons'; ?>
<?php include 'partials/header.php'; ?>
	<article class="article">
		<div class="container">

				<h2>Icons</h2>
				<hr>

				<p>
				<?php the_icon('youtube');?> first occurence</p>
				</p>

				<p>
				<?php the_icon('youtube');?> second occurence</p>
				</p>

				<h2>Buttons icons</h2>
				<hr>
				<p>
					<button type="button" class="button button--primary">Primary Button <?php the_icon('close');?></button>
				</p>
				<p>
					<button type="button" class="button button--error">Primary Button <?php the_icon('close');?></button>
				</p>

				<h2>Buttons circle</h2>
				<hr>
				<p>
					<button type="button" class="button button--circle button--primary"><?php the_icon('logo-beapi');?></button>
					<button type="button" class="button button--circle button--error"><?php the_icon('logo-beapi');?></button>
				</p>

		</div>
	</article>

<?php include 'partials/footer.php'; ?>
