<?php
/*
* Template Name: Contact Us
*/

get_header();
?>
<div class="container-xl">
	<h1>Andre Yu Is My Wife!!!</h1>
</div>

<div class="container-xl pb-3">
	<div class="row">
		<div class="col-md-6 offset-md-3 text-center">
			<h3><?php the_title(); ?></h3>
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/divider.png" alt="divider" class="w-25">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<form class="text-left">
				<div class="form-group">
					<label for="name">Your Name</label>
					<input type="text" class="form-control" id="name" placeholder="Enter your name...">
				</div>
				<div class="form-group">
					<label for="email">Your Email</label>
					<input type="email" class="form-control" id="email" placeholder="Enter your email...">
				</div>
				<div class="form-group">
					<label for="message">Your Message</label>
					<textarea id="message" rows="3" class="form-control"></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Send message ...</button>
			</form>
		</div>
	</div>
</div>



<?php get_footer(); ?>