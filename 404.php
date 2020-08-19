<?php
/*
 * Hop Yat Church 404 template file
 */
?>

<?php get_header() ?>

<main class="container-xl pb-3">
	<p>
		<h3>對不起，網頁不存在。。。</h3>
	</p>
	<div class="row my-widget-area">
		<div class="col-md-3"><?php the_widget('WP_Widget_Pages') ?></div>
		<div class="col-md-3"><?php the_widget('WP_Widget_Categories') ?></div>
		<div class="col-md-3"><?php the_widget('WP_Widget_Recent_Posts') ?></div>
		<div class="col-md-3"><?php the_widget('WP_Widget_Tag_Cloud') ?></div>
	</div>
</main>
<?php get_footer() ?>