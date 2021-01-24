<?php
/*
* Template part for displaying our custom comment form
*/
?>

<?php

$login_url = wp_login_url(get_permalink());
$args = array(
	'title_reply' => '<h5 class="py-1">回應 / 留言</h5>',
	'comment_field' => '
		<div class="form-group">
			<textarea id="comment" name="comment" class="form-control" style="height: 150px;"></textarea>
		</div>
	',
	'submit_button' => '
		<button type="submit" id="my-submit-button" class="btn btn-primary">提交</button>
	',
	'must_log_in' => '
		<p class="must-log-in">若留言回應請先<a href="' . $login_url . '" title="Login">登入</a>..</p>
	',
	'logged_in_as' => '',
	'cancel_reply_link' => '
		取消
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
