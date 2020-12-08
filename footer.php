<?php
/*
 * footer template (200809)
 */
?>

<footer class="container-xl pb-3 px-2">
	<div class="d-flex align-items-baseline">
		<div>
			<?php bloginfo('name') ?>
		</div>
		<p class="ml-auto">&copy; Hop Yat Church 2020</p>
		<?php
		$dummy = admin_url('/js/widgets/media-image-widget');
		echo '<p>$dummy: ' . $dummy . '</p>';
		?>
	</div>
</footer>

<?php wp_footer(); ?>

</body>


</html>