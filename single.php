<?php
/*
 * Hop Yat Church (200813)
 */
?>

<?php get_header() ?>
<main class="container-xl pb-3">
	<div class="d-flex">
		<h6 class="ml-auto">** single.php **</h6>
	</div>
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
						<div class="my-post-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php
						the_content();
						wp_link_pages(array(
							'before' => '<div class="d-flex"><p class="post-nav-links ml-auto">' . __('Pages:'),
							'after' => '</p></div>',
						));
						?>
					</div>
			<?php endwhile;
			else :
				_e('Sorry, no posts matched your criteria.', 'textdomain');
			endif; ?>

			<?php
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;
			?>

			<nav class="ml-auto">
				<ul class="nav">
					<li><?php next_post_link(); ?></li>&nbsp;
					<li><?php previous_post_link(); ?></li>
				</ul>
			</nav>

		</div>
		<aside class="col-sm-4 order-md-first">
			<?php get_sidebar(); ?>
		</aside>
	</div>
</main>

<?php get_footer() ?>