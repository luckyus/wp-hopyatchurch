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
						<h4><?php the_title(); ?></h4>
						<div class="text-info mb-3">
							<h5 class='d-inline'><?php echo get_the_category()[0]->cat_name ?></h5>
							<h6 class='d-inline'> • <?php the_date("M j, Y"); ?></h6>
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
			<hr />
			<nav>
				<ul class="nav d-flex">
					<li><?php previous_post_link(); ?></li>
					<li class="ml-auto my-next-post-link"><?php next_post_link(); ?></li>&nbsp;
				</ul>
			</nav>

		</div>
		<aside class="col-sm-4 order-md-first">
			<?php get_sidebar(); ?>
		</aside>
	</div>
</main>

<?php get_footer() ?>