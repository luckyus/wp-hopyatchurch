<?php
/*
 * Hop Yat Church main template file
 */
?>

<?php get_header() ?>

<main class="container-xl pb-3">
	<div class="row">
		<div class="col-sm-8 order-md-last">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div <?php post_class() ?>>
						<a href="<?php the_permalink() ?>">
							<h4><?php the_title(); ?></h4>
						</a>
						<div class="text-info mb-3">
							<h5 class='d-inline'><?php echo get_the_category()[0]->cat_name ?></h5>
							<h6 class='d-inline'> • <?php the_date("M j, Y"); ?></h6>
						</div>
						<!-- <div class="pb-2">
							<i class="fas fa-tags"></i>
							<p class="d-inline"><?php the_tags('Tagged: ') ?></p>
						</div> -->
						<div class="my-post-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php the_excerpt() ?>
						<div class="mb-3">
							<a href="<?php the_permalink() ?>">
								<?php _e('閱讀全文...') ?>
							</a>
						</div>
						<hr class="my-clearboth" />
					</div>
			<?php endwhile;
			else :
				_e('Sorry, no posts matched your criteria.', 'textdomain');
			endif; ?>

			<nav>
				<ul class="nav d-flex">
					<li><?php previous_posts_link("« 上一頁"); ?></li>
					<li class="ml-auto"><?php next_posts_link("下一頁 »"); ?></li>&nbsp;
				</ul>
			</nav>
		</div>
		<aside class="col-sm-4 order-md-first">
			<?php get_sidebar(); ?>
		</aside>
	</div>
</main>

<?php get_footer() ?>