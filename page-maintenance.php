<?php
/*
* Template Name: 庶務部
*/

get_header(); ?>

<div class="container-xl pb-3 mt-n1">
	<div class="row">
		<div id="home-main" class="col-md-4 px-0 px-md-2" role="complementary">
			<?php dynamic_sidebar('maintenance_left_sidebar'); ?>
		</div>
		<div id="home-main" class="col-md-8 px-0 px-md-2" role="complementary">
			<?php if (have_posts()) : while (have_posts()) : the_post();
					the_content();
				endwhile;
			else : ?>
				<p><?php _e('Sorry, no pages matched your criteria'); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>