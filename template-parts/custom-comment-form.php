<?php
/*
* Template part for displaying our custom comment form
*/
?>

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
