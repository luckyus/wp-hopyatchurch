<?php

// testing - create widget (200924)
class WP_Widget_Paster_Hui_Latest extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = array(
			'classname' => 'widget_paster_hui_latest',
			'description' => __("Paster Hui's Lastest Blog", "hopyatchurch"),
		);
		parent::__construct('paster-wu-latest-widget', __("Category 最新文章", "hopyatchurch"), $widget_ops);
	}

	public function form($instance)
	{
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('主任牧師的話', 'hopyatchurch');
		$titleID = esc_attr($this->get_field_id('title'));

		$titleSub = !empty($instance['title-sub']) ? $instance['title-sub'] : esc_html__('許開明牧師', 'hopyatchurch');
		$titleSubID = esc_attr($this->get_field_id('title-sub'));

		$category = !empty($instance['category']) ? $instance['category'] : esc_html__('主任牧師的話', 'hopyatchurch');
		$categoryID = esc_attr($this->get_field_id('category'));

?>
		<p>
			<label for="<?php echo $titleID ?>">
				<?php esc_attr_e('Title Left:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $titleID ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo $titleSubID ?>">
				<?php esc_attr_e('Title Right:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $titleSubID ?>" name="<?php echo esc_attr($this->get_field_name('title-sub')); ?>" type="text" value="<?php echo esc_attr($titleSub); ?>">
		</p>
		<p>
			<label for="<?php echo $categoryID ?>">
				<?php esc_attr_e('Category:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $categoryID ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>" type="text" value="<?php echo esc_attr($category); ?>">
		</p>
<?php
	}

	public function widget($args, $instance)
	{
		echo $args['before_widget'];

		echo $args['before_title'];
		echo '<div>' . apply_filters('widget_title', $instance['title']) . '</div>';
		echo '<div>' . apply_filters('widget_title', $instance['title-sub']) . '</div>';
		echo $args['after_title'];

		echo $args['after_widget'];
	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
		$instance['title-sub'] = (!empty($new_instance['title-sub'])) ? sanitize_text_field($new_instance['title-sub']) : '';
		$instance['category'] = (!empty($new_instance['category'])) ? sanitize_text_field($new_instance['category']) : 'Category 最新文章';

		return $instance;
	}
}


?>