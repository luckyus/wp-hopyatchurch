<div class="pb-3">
	<h4 class="font-italic">About</h4>
	<p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas nam dolorum ullam aut eius alias libero
		doloribus dicta omnis earum eligendi architecto delectus natus veniam, voluptatem eaque aliquam neque atque.</p>
	<hr />
</div>
<div class="pb-3">
	<h4 class="font-italic">Archives</h4>
	<ol class="list-unstyled mb-0">
		<?php wp_get_archives(); ?>
	</ol>
</div>
<div class="pb-3">
	<h4 class="font-italic">Categories</h4>
	<ol class="list-unstyled mb-0">
		<?php wp_list_categories("title_li="); ?>
	</ol>
</div>
<div class="pb-3">
	<h4 class="font-italic">Follow Us</h4>
	<a href="https://www.facebook.com/hkcccc.org" target="_blank">
		<i class="fab fa-facebook-square fa-2x"></i>
	</a>
	<i class="fab fa-twitter-square fa-2x"></i>
	<i class="fab fa-instagram-square fa-2x"></i>
	<i class="fab fa-pinterest-square fa-2x"></i>
</div>