<form action="<?php echo esc_url(home_url('/')) ?>" method="GET">

	<div class="form-group">

		<label for="search" class="h4 font-italic">Search</label>
		<div class="d-flex">
			<input type="text" name="s" id="search" value="<?php the_search_query(); ?>" class="form-control">
			<button class="btn btn-primary ml-2">submit</button>
		</div>
	</div>

</form>