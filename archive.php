<?php
/*
 * Hop Yat Church achieve pages template file
 */
?>

<?php get_header() ?>

<main class="container-xl pb-3">
	<div class="row">
		<div class="col-sm-8 order-md-last">
			<?php the_archive_title('<h4>', '<hr/></h4>'); ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div>
						<a href="<?php the_permalink() ?>">
							<h3><?php the_title(); ?></h3>
						</a>
						<p><?php the_date(); ?> by <a href=""><?php the_author() ?></a></p>
						<div class="pb-2">
							<i class="fas fa-tags"></i>
							<p class="d-inline"><?php the_tags('Tagged: ') ?></p>
						</div>
						<div class="my-post-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php the_excerpt() ?>
						<div class="mb-3">
							<a href="<?php the_permalink() ?>">
								<?php _e('Read more...') ?>
							</a>
						</div>
						<hr class="my-clearboth" />
					</div>
			<?php endwhile;
			else :
				_e('Sorry, no posts matched your criteria.', 'textdomain');
			endif; ?>
			<div class="d-flex">
				<nav class="ml-auto">
					<ul class="nav">
						<li><?php previous_posts_link(); ?></li>
						<li><?php next_posts_link(); ?></li>&nbsp;
					</ul>
				</nav>
			</div>
		</div>
		<aside class="col-sm-4 order-md-first">
			<?php get_sidebar(); ?>
		</aside>
	</div>
</main>

<?php get_footer() ?>