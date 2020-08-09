<?php
/*
 * The header (200809)
 */
?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<!-- Required meta tags -->
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php wp_head() ?>
</head>

<body <?php body_class('bg-light'); ?>>
	<header class="pb-3">
		<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
			<div class="container-xl px-0 px-xl-3">
				<span class="navbar-brand mb-0 h1"><?php echo get_bloginfo('name') ?></span>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
					<span class="navbar-toggler-icon"></span>
				</button>

					<!-- <ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="index.html">頁首</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="about.html">有關本堂</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="blog.html">教牧同工</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="schedule.html">崇拜主席宣道表</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="others.html">其他</a>
						</li>
					</ul> -->
					<?php wp_nav_menu(array(
    'theme_location' => 'primary',
    'depth' => 2, // 1 = no dropdowns, 2 = with dropdowns.
     'container' => 'div',
    'container_class' => 'collapse navbar-collapse justify-content-end',
    'container_id' => 'navbarNav',
    'menu_class' => 'navbar-nav',
    'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
    'walker' => new WP_Bootstrap_Navwalker(),
)); ?>

			</div>
		</nav>
		<section class="container-xl px-0 px-md-3">
			<div class="position-relative d-flex justify-content-center align-items-center text-center">
				<img src="images/churchBanner01.jpg" alt="church banner" class="my-banner">
				<div class="position-absolute my-feature-bg d-none d-lg-block py-3">
					<div class="my-feature-text">中華基督教會<br />合一堂九龍堂</div>
				</div>
			</div>
		</section>
	</header>
