<?php

class My_Walker_Comment extends Walker_Comment
{
	public function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0)
	{
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment']       = $comment;

		if (!empty($args['callback'])) {
			ob_start();
			call_user_func($args['callback'], $comment, $args, $depth);
			$output .= ob_get_clean();
			return;
		}

		if ('comment' === $comment->comment_type) {
			add_filter('comment_text', array($this, 'filter_comment_text'), 40, 2);
		}

		if (('pingback' === $comment->comment_type || 'trackback' === $comment->comment_type) && $args['short_ping']) {
			ob_start();
			$this->ping($comment, $depth, $args);
			$output .= ob_get_clean();
		} elseif ('html5' === $args['format']) {
			ob_start();
			$this->html5_comment($comment, $depth, $args);
			$output .= ob_get_clean();
		} else {
			ob_start();
			$this->comment($comment, $depth, $args);
			$output .= ob_get_clean();
		}

		if ('comment' === $comment->comment_type) {
			remove_filter('comment_text', array($this, 'filter_comment_text'), 40, 2);
		}
	}

	protected function comment($comment, $depth, $args)
	{
		if ('div' === $args['style']) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}

		$commenter          = wp_get_current_commenter();
		$show_pending_links = isset($commenter['comment_author']) && $commenter['comment_author'];

		if ($commenter['comment_author_email']) {
			$moderation_note = __('Your comment is awaiting moderation.');
		} else {
			$moderation_note = __('Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.');
		}
?>
		<<?php echo $tag; ?> <?php comment_class($this->has_children ? 'parent' : '', $comment); ?> id="comment-<?php comment_ID(); ?>">
			<?php if ('div' !== $args['style']) : ?>
				<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<?php endif; ?>
				<div class="comment-author vcard">
					<div>
						<?php
						if (0 != $args['avatar_size']) {
							echo get_avatar($comment, $args['avatar_size']);
						}
						?>
					</div>
					<div>
						<?php
						$comment_author = get_comment_author_link($comment);
						$comment_date = strtolower(get_comment_date('jS M, Y', $comment));
						$comment_edit_link = get_edit_comment_link();

						if ('0' == $comment->comment_approved && !$show_pending_links) {
							$comment_author = get_comment_author($comment);
						}

						echo '
							<div class="comment-user-row">' . $comment_author . '
								<span class="bullet" aria-hidden="true">•</span>' .
							'<span class="comment-date">' . $comment_date . '</span>' . '
								<a class="comment-edit-link" href="' . $comment_edit_link . '">(edit 更改)</a>
							</div>								
						';

						// printf(
						// 	/* translators: %s: Comment author link. */
						// 	__('%s <span class="says">&nbsp;留言：</span>'),
						// 	sprintf('<cite class="fn">%s</cite>', $comment_author)
						// );
						?>

						<?php if ('0' == $comment->comment_approved) : ?>
							<em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
							<br />
						<?php endif; ?>

						<?php
						comment_text(
							$comment,
							array_merge(
								$args,
								array(
									'add_below' => $add_below,
									'depth'     => $depth,
									'max_depth' => $args['max_depth'],
								)
							)
						);
						?>
						<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'add_below' => $add_below,
									'depth'     => $depth,
									'max_depth' => $args['max_depth'],
									'before'    => '<div class="reply">',
									'after'     => '</div>',
									'reply_text' => '回應',
								)
							)
						);
						?>
						<?php if ('div' !== $args['style']) : ?>
					</div>
				</div>
			<?php endif; ?>
	<?php
	}
}
