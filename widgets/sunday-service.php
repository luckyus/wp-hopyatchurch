<?php

class WP_Widget_Sunday_Service extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = array(
			'classname' => 'widget_sunday_service',
			'description' => __("Sunday Service Details", "hopyatchurch"),
		);
		parent::__construct('sunday-service-widget', __("崇拜內容", "hopyatchurch"), $widget_ops);
	}

	public function form($instance)
	{
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('主日祟拜', 'hopyatchurch');
		$titleID = esc_attr($this->get_field_id('title'));

		$theme = $instance['theme'];
		$themeID = esc_attr($this->get_field_id('theme'));

		$date = $instance['date'];
		$dateID = esc_attr($this->get_field_id('date'));

		$time = !empty($instance['time']) ? $instance['time'] : esc_html__('上午 11:00', 'hopyatchurch');
		$timeID = esc_attr($this->get_field_id('time'));

		$sermon = $instance['sermon'];
		$sermonID = esc_attr($this->get_field_id('sermon'));

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
			<label for="<?php echo $themeID ?>">
				<?php esc_attr_e('崇拜:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $themeID ?>" name="<?php echo esc_attr($this->get_field_name('theme')); ?>" type="text" value="<?php echo esc_attr($theme); ?>">
		</p>
		<p>
			<label for="<?php echo $dateID ?>">
				<?php esc_attr_e('日期:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat datepicker" id="<?php echo $dateID ?>" name="<?php echo esc_attr($this->get_field_name('date')); ?>" type="text" value="<?php echo esc_attr($date); ?>">
		</p>
		<p>
			<label for="<?php echo $timeID ?>">
				<?php esc_attr_e('時間:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $timeID ?>" name="<?php echo esc_attr($this->get_field_name('time')); ?>" type="text" value="<?php echo esc_attr($time); ?>">
		</p>
		<p>
			<label for="<?php echo $sermonID ?>">
				<?php esc_attr_e('題旨:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $sermonID ?>" name="<?php echo esc_attr($this->get_field_name('sermon')); ?>" type="text" value="<?php echo esc_attr($sermon); ?>">
		</p>
		<p>
			<label for="<?php echo $speakerID ?>">
				<?php esc_attr_e('講員:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $speaker ?>" name="<?php echo esc_attr($this->get_field_name('speaker')); ?>" type="text" value="<?php echo esc_attr($speaker); ?>">
		</p>
		<p>
			<label for="<?php echo $scriptureID ?>">
				<?php esc_attr_e('經文:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat" id="<?php echo $scripture ?>" name="<?php echo esc_attr($this->get_field_name('scripture')); ?>" type="text" value="<?php echo esc_attr($scripture); ?>">
		</p>
	<?php
	}

	public function widget($args, $instance)
	{
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('主日崇拜', 'hopyatchurch');
		$theme = !empty($instance['theme']) ? $instance['theme'] : esc_html__('崇拜', 'hopyatchurch');
		$sermon = !empty($instance['sermon']) ? $instance['sermon'] : esc_html__('本主日宣道題旨', 'hopyatchurch');
		$scripture = !empty($instance['scripture']) ? $instance['scripture'] : esc_html__('本主日經文', 'hopyatchurch');

		echo $args['before_widget'];
		echo $args['before_title'];
		echo $title;
		echo $args['after_title'];
	?>
		<div class='card-body'>
			<h5 class="card-title"><?php echo $theme ?></h5>
			<p class="card-text">
				日期：<?php echo $instance['date'] ?><br />
				時間：<?php echo $instance['time'] ?>
				<p>
					<h5>[ 講 道 ]</h5>
				</p>
				題旨：<?php echo $sermon ?><br />
				講員：<?php echo $instance['speaker'] ?><br />
				經文：<?php echo $scripture ?>
			</p>
		</div>
<?php
		echo $args['after_widget'];
	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
		$instance['theme'] = (!empty($new_instance['theme'])) ? sanitize_text_field($new_instance['theme']) : '';
		$instance['date'] = (!empty($new_instance['date'])) ? sanitize_text_field($new_instance['date']) : '';
		$instance['time'] = (!empty($new_instance['time'])) ? sanitize_text_field($new_instance['time']) : '';
		$instance['sermon'] = (!empty($new_instance['sermon'])) ? sanitize_text_field($new_instance['sermon']) : '';
		$instance['speaker'] = (!empty($new_instance['speaker'])) ? sanitize_text_field($new_instance['speaker']) : '';
		$instance['scripture'] = (!empty($new_instance['scripture'])) ? sanitize_text_field($new_instance['scripture']) : '';
		return $instance;
	}
}



?>