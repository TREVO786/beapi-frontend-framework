<div class="searchform" id="searchform" tabindex="-1">
	<form role="form" method="get" action="#" >
		<div class="form__row">
			<label for="search" class="visuallyhidden">Recherchez</label>
		</div>
		<div class="form__row">
			<input type="search" class="searchform__field" name="s" id="search" placeholder="Entrez un mot clé" aria-required="true" required="required">
			<button type="submit" class="searchform__submit" name="submit" id="searchsubmit">
				<span class="visuallyhidden">Lancer la recherche</span>
				<?php the_icon('search');?>
			</button>
		</div>
	</form>
</div>