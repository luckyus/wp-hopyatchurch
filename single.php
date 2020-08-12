<?php
/*
 * Hop Yat Church (200813)
 */
?>

<?php get_header() ?>
<main class="container-xl pb-3">
	<div class="row">
		<div class="col-sm-8 order-md-last">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div>
						<h2><?php the_title(); ?></h2>
						<p><?php the_date(); ?> by <a href=""><?php the_author() ?></a></p>
						<div class="pb-2">
							<i class="fas fa-tags"></i>
							<p class="d-inline"><?php the_tags('Tagged: ', ' ~ ') ?></p>
						</div>
						<p><?php the_content() ?></p>
						<?php wp_link_pages(); ?>
					</div>
			<?php endwhile;
			else :
				_e('Sorry, no posts matched your criteria.', 'textdomain');
			endif; ?>
		</div>
		<aside class="col-sm-4 order-md-first">
			<?php get_sidebar(); ?>
		</aside>
	</div>
</main>

<div class="container-xl pb-3 d-flex">
	<nav class="ml-auto">
		<ul class="nav">
			<li><?php next_post_link(); ?></li>&nbsp;
			<li><?php previous_post_link(); ?></li>
		</ul>
	</nav>
</div>
<?php get_footer() ?>