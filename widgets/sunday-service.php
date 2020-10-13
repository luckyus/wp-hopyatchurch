<?php


class WP_Widget_Sunday_Service extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = array(
			'classname' => 'widget_sunday_service',
			'description' => __("Sunday Service Details", "hopyatchurch"),
		);
		parent::__construct('sunday-service-widget', __("主日崇拜", "hopyatchurch"), $widget_ops);
	}

	public function form($instance)
	{
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('主日祟拜', 'hopyatchurch');
		$titleID = esc_attr($this->get_field_id('title'));

		$theme = $instance['theme'];
		$themeID = esc_attr($this->get_field_id('theme'));

		$date = $instance['date'];
		$dateID = esc_attr($this->get_field_id('date'));

		$message = $instance['message'];
		$messageID = esc_attr($this->get_field_id('message'));

		$speaker = $instance['speaker'];
		$speakerID = esc_attr($this->get_field_id('speaker'));

		$scripture = $instance['scripture'];
		$scriptureID = esc_attr($this->get_field_id('scripture'));
?>
		<p>
			<label for="<?php echo $titleID ?>">
				<?php esc_attr_e('Title:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $titleID ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo $theme ?>">
				<?php esc_attr_e('崇拜:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $themeID ?>" name="<?php echo esc_attr($this->get_field_name('theme')); ?>" type="text" value="<?php echo esc_attr($theme); ?>">
		</p>
<?php
	}

	public function widget($args, $instance)
	{
		echo $args['before_widget'];

		echo $args['before_title'];
		echo '<div>Hello World!</div>';
		echo $args['after_title'];

		echo $args['after_widget'];
	}

	public function update($new_instance, $old_instance)
	{
	}
}



?>