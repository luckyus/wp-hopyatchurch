<?php
/*
 * Hop Yat Church main template file
 */
?>

<?php get_header() ?>

<div class="container-xl pb-3 mt-n1">
	<div class="row">
		<?php if (is_active_sidebar('home_main')) : ?>
			<div id="home-main" class="col-md-8 px-0 px-md-2 order-md-last" role="complementary">
				<?php dynamic_sidebar('home_main'); ?>
			</div>
		<?php endif; ?>
		<?php if (is_active_sidebar('home_left_sidebar')) : ?>
			<div id="home-main" class="col-md-4 px-0 px-md-2 order-md-first" role="complementary">
				<?php dynamic_sidebar('home_left_sidebar'); ?>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php get_footer() ?>