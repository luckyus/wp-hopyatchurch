<?php

// testing - create widget (200924)
class WP_Widget_Latest_Blog extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = array(
			'classname' => 'widget_latest_blog',
			'description' => __("Lastest Blog by Category", "hopyatchurch"),
		);
		parent::__construct('latest-blog-widget', __("Category 最新文章", "hopyatchurch"), $widget_ops);
	}

	public function form($instance)
	{
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('主任牧師的話', 'hopyatchurch');
		$titleID = esc_attr($this->get_field_id('title'));

		$titleSub = $instance['title-sub'];
		$titleSubID = esc_attr($this->get_field_id('title-sub'));

		$category = !empty($instance['category']) ? $instance['category'] : esc_html__('主任牧師的話', 'hopyatchurch');
		$categoryID = esc_attr($this->get_field_id('category'));

		$excerpt = isset($instance['excerpt']) ? (bool) $instance['excerpt'] : false;
?>
		<p>
			<label for="<?php echo $titleID ?>">
				<?php esc_attr_e('Title:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $titleID ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo $titleSubID ?>">
				<?php esc_attr_e('Title right:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $titleSubID ?>" name="<?php echo esc_attr($this->get_field_name('title-sub')); ?>" type="text" value="<?php echo esc_attr($titleSub); ?>">
		</p>
		<p>
			<label for="<?php echo $categoryID ?>">
				<?php esc_attr_e('Category:', 'hopyatchurch'); ?>
			</label>
			<?php
			$cat_args = array(
				'selected' => $category,
				'id' => $categoryID,
				'orderby' => 'name',
				'name' => esc_attr($this->get_field_name('category')),
				'class' => 'widefat',
				'show_count' => 1,
			);
			wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args, $instance));
			?>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" <?php checked($excerpt); ?> />
			<label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('只顯示撮要'); ?></label>
		</p>
	<?php
	}

	public function widget($args, $instance)
	{
		$excerpt = !empty($instance['excerpt']) ? '1' : '0';

		echo $args['before_widget'];

		echo $args['before_title'];
		echo '<div>' . apply_filters('widget_title', $instance['title']) . '</div>';
		echo '<div>' . apply_filters('widget_title', $instance['title-sub']) . '</div>';
		echo $args['after_title'];
	?>
		<div class='card-body'>
			<?php
			$catquery = new WP_Query('cat=' . $instance['category'] . '&posts_per_page=1'); ?>
			<?php while ($catquery->have_posts()) : $catquery->the_post(); ?>
				<div class="text-primary mb-2">
					<h4 class='d-inline'><?php the_title(); ?></h4>
					<h6 class='d-inline'>• <?php echo get_the_date("M j, Y"); ?></h6>
				</div>
				<?php if ($excerpt) { ?>
					<?php the_excerpt()	?>
					<a href="<?php the_permalink() ?>">
						<?php _e('閱讀全文。。。') ?>
					</a>
				<?php } else {
				?>
					<div class="my-post-thumbnail">
						<?php the_post_thumbnail(); ?>
					</div>
					<?php
					the_content();
					?>
				<?php } ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata();	?>
		</div>
<?php
		echo $args['after_widget'];
	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
		$instance['title-sub'] = (!empty($new_instance['title-sub'])) ? sanitize_text_field($new_instance['title-sub']) : '';
		$instance['category'] = (!empty($new_instance['category'])) ? sanitize_text_field($new_instance['category']) : 'Category 最新文章';
		$instance['excerpt'] = !empty($new_instance['excerpt']) ? 1 : 0;

		return $instance;
	}
}



?>