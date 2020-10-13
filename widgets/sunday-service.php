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
		<p>
			<label for="<?php echo $date ?>">
				<?php esc_attr_e('日期:', 'hopyatchurch'); ?>
			</label>
			<input class="widefat datepicker" id="<?php echo $dateID ?>" name="<?php echo esc_attr($this->get_field_name('date')); ?>" type="text" value="<?php echo esc_attr($date); ?>">
		</p>
	<?php
	}

	public function widget($args, $instance)
	{
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('主日崇拜', 'hopyatchurch');
		$theme = !empty($instance['theme']) ? $instance['theme'] : esc_html__('崇拜', 'hopyatchurch');

		echo $args['before_widget'];

		echo $args['before_title'];
		echo $title;
		echo $args['after_title'];

	?>
		<div class='card-body'>
			<h5 class="card-title"><?php echo $theme ?></h5>
			<p class="card-text">
				日期：<?php the_field('service_date') ?><br />
				時間：<?php the_field('service_time') ?>
				<p>
					<h5>[ 講 道 ]</h5>
				</p>
				題旨：<?php the_field('service_title') ?><br />講員：<?php the_field('service_speaker') ?><br />
				經文：<?php the_field("service_scripture") ?>
			</p>

			<div class="input-group date" id="datepicker">
				<input type="text" class="form-control" value="12-02-2012" />
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-th"></span>
				</div>
			</div>

			<div>
				<input data-provide="datepicker">
			</div>

			<div class="input-group date" data-provide="datepicker">
				<input type="text" class="form-control">
				<div class="input-group-addon">
				</div>
			</div>
		</div>
<?php

		echo $args['after_widget'];
	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
		$instance['theme'] = (!empty($new_instance['theme'])) ? sanitize_text_field($new_instance['theme']) : '';

		return $instance;
	}
}



?>