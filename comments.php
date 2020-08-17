<?php
/*
* hopyatchurch blog comments template (200814)
*/
?>

<?php

if (post_password_required()) {
	return;
}
?>
<section>
	<?php if (have_comments()) : ?>
		<h3 class="pb-1">
			<?php
			$number_of_comments = get_comments_number();
			if ($number_of_comments === 1) {
				printf(
					_x(
						'One comment on &ldquo;%s&rdquo;',
						'comments title'
					),
					get_the_title()
				);
			} else {
				printf(
					_nx(
						'%1$s comment on &ldquo;%2$s&rdquo;',
						'%1$s comments on &ldquo;%2$s&rdquo;',
						$number_of_comments,
						'comments title'
					),
					number_format_i18n($number_of_comments),
					get_the_title()
				);
			}
			?>
		</h3>
		<ol>
			<?php
			wp_list_comments(array(
				'style' => '0l'
				// 'style' => 'ol',
				// 'avatar_size' => 70
			))
			?>
		</ol>
	<?php endif ?>
	<?php
	the_comments_navigation();
	if (!comments_open()) : ?>
		<p><?php esc_html_e('Comments are closed for this post'); ?></p>
	<?php endif; ?>
</section>
<?php

$args = array(
	'title_reply' => '<div class="py-1" style="font-size: 0.9em;">回應 / 留言</div>',
	'comment_field' => '
		<div class="form-group">
			<label for="comment">留言*</label>
			<br />
			<textarea id="comment" name="comment" class="form-control" style="height: 150px;"></textarea>
		</div>
	',
	'submit_button' => '
		<button type="submit" class="btn btn-primary">提交</button>
	',
	'fields' => apply_filters('comment_form_defaults', array(
		'author' => '
			<div class="form-group">
				<label for="author">名稱*</label>
				<input id="author" name="author" type="text" class="form-control">
			</div>
		',
		'email' => '
			<div class="form-group">
				<label for="email">Email*</label>
				<input id="email" name="author" type="email" class="form-control">
			</div>
		',
	))
);

comment_form($args);

?>