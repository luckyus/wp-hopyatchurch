<?php
/*
* Template Name: 庶務部
*/

get_header(); ?>

<div class="container-xl pb-3 mt-n1">
	<div class="row">
		<div id="home-main" class="col-md-8 px-0 px-md-2 order-md-last" role="complementary">
			Hello World!
		</div>
		<div id="home-main" class="col-md-4 px-0 px-md-2 order-md-first" role="complementary">
			<?php dynamic_sidebar('maintenance_left_sidebar'); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>