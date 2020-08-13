<?php
/*
* 
*/
?>

<?php
$args = array(
	'title_reply' => '<div class="py-1" style="0.8rem;">回應 / 留言</div>',
	'comment_field' => '
		<div class="form-group">
			<label for="comment">留言</label>
			<br />
			<textarea id="comment" name="comment" class="form-control"></textarea>
		</div>
	',
	'submit_button' => '
		<button type="submit" class="btn btn-primary">提交</button>
	',
);

comment_form($args);

?>