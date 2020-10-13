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

		<div class="col-md-4 px-0 px-md-2 order-md-first">
			<div class="card mb-3">
				<h5 class="card-header">主日祟拜</h5>
				<div class="card-body">
					<h5 class="card-title"><?php the_field('service_type') ?></h5>
					<p class="card-text">日期：<?php the_field('service_date') ?><br />時間：<?php the_field('service_time') ?>
						<p>
							<h5>[ 講 道 ]</h5>
						</p>
						題旨：<?php the_field('service_title') ?><br />講員：<?php the_field('service_speaker') ?><br />
						經文：<?php the_field("service_scripture") ?>
					</p>

					<div class="input-group date" id="datepicker">
						<input type="text" class="form-control" value="12-02-2012" />
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-th"></span>
						</div>
					</div>

					<div>
						<input data-provide="datepicker">
					</div>

					<div class="input-group date" data-provide="datepicker">
						<input type="text" class="form-control">
						<div class="input-group-addon">
						</div>
					</div>
				</div>
			</div>
			<div class="my-poster border rounded-lg mb-3">
				<img src="<?php echo esc_url(get_template_directory_uri()) ?>/images/200702 sunday school woman's role.jpg">
			</div>
			<div class="my-poster border rounded-lg mb-3">
				<img src="<?php echo esc_url(get_template_directory_uri()) ?>/images/200727 sunday school exodus.jpg">
			</div>
			<div class="card mb-3">
				<h5 class="card-header">Featured</h5>
				<div class="card-body">
					<h5 class="card-title"></h5>
					<p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias consequatur animi beatae asperiores
						laborum pariatur nam? Delectus enim nostrum rerum voluptatibus itaque qui eveniet fugiat, soluta dicta? Pariatur,
						voluptates eligendi.</p>
					<a href="#" class="btn btn-primary">Go somewhere</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer() ?>