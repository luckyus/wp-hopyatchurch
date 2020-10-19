<?php

/**
 * Widget API: WP_Media_Widget class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.8.0
 */

class WP_Widget_Poster extends WP_Widget
{

	/**
	 * Translation labels.
	 *
	 * @since 4.8.0
	 * @var array
	 */
	public $l10n = array(
		'add_to_widget'              => '',
		'replace_media'              => '',
		'edit_media'                 => '',
		'media_library_state_multi'  => '',
		'media_library_state_single' => '',
		'missing_attachment'         => '',
		'no_media_selected'          => '',
		'add_media'                  => '',
	);

	/**
	 * Whether or not the widget has been registered yet.
	 *
	 * @since 4.8.1
	 * @var bool
	 */
	protected $registered = false;

	/**
	 * Constructor.
	 *
	 * @since 4.8.0
	 *
	 * @param string $id_base         Base ID for the widget, lowercase and unique.
	 * @param string $name            Name for the widget displayed on the configuration page.
	 * @param array  $widget_options  Optional. Widget options. See wp_register_sidebar_widget() for
	 *                                information on accepted arguments. Default empty array.
	 * @param array  $control_options Optional. Widget control options. See wp_register_widget_control()
	 *                                for information on accepted arguments. Default empty array.
	 */
	public function __construct()
	{
		$l10n_defaults = array(
			'no_media_selected'          => __('No media selected'),
			'add_media'                  => _x('Add Media', 'label for button in the media widget'),
			'replace_media'              => _x('Replace Media', 'label for button in the media widget; should preferably not be longer than ~13 characters long'),
			'edit_media'                 => _x('Edit Media', 'label for button in the media widget; should preferably not be longer than ~13 characters long'),
			'add_to_widget'              => __('Add to Widget'),
			'missing_attachment'         => sprintf(
				/* translators: %s: URL to media library. */
				__('We can&#8217;t find that file. Check your <a href="%s">media library</a> and make sure it wasn&#8217;t deleted.'),
				esc_url(admin_url('upload.php'))
			),
			/* translators: %d: Widget count. */
			'media_library_state_multi'  => _n_noop('Media Widget (%d)', 'Media Widget (%d)'),
			'media_library_state_single' => __('Media Widget'),
			'unsupported_file_type'      => __('Looks like this isn&#8217;t the correct kind of file. Please link to an appropriate file instead.'),
		);
		$this->l10n    = array_merge($l10n_defaults, array_filter($this->l10n));

		$widget_opts = array(
			'classname' => 'widget_poster',
			'description' => __("Poster", "hopyatchurch"),
			'customize_selective_refresh' => true,
			'mime_type' => '',
		);
		parent::__construct("poster-widget", __("海報", "hopyatchurch"), $widget_opts);
	}

	/**
	 * Add hooks while registering all widget instances of this widget class.
	 *
	 * @since 4.8.0
	 *
	 * @param integer $number Optional. The unique order number of this widget instance
	 *                        compared to other instances of the same class. Default -1.
	 */
	public function _register_one($number = -1)
	{
		parent::_register_one($number);
		if ($this->registered) {
			return;
		}
		$this->registered = true;

		// Note that the widgets component in the customizer will also do
		// the 'admin_print_scripts-widgets.php' action in WP_Customize_Widgets::print_scripts().
		add_action('admin_print_scripts-widgets.php', array($this, 'enqueue_admin_scripts'));

		if ($this->is_preview()) {
			add_action('wp_enqueue_scripts', array($this, 'enqueue_preview_scripts'));
		}

		// Note that the widgets component in the customizer will also do
		// the 'admin_footer-widgets.php' action in WP_Customize_Widgets::print_footer_scripts().
		add_action('admin_footer-widgets.php', array($this, 'render_control_template_scripts'));

		add_filter('display_media_states', array($this, 'display_media_state'), 10, 2);
	}

	/**
	 * Get schema for properties of a widget instance (item).
	 *
	 * @since 4.8.0
	 *
	 * @see WP_REST_Controller::get_item_schema()
	 * @see WP_REST_Controller::get_additional_fields()
	 * @link https://core.trac.wordpress.org/ticket/35574
	 *
	 * @return array Schema for properties.
	 */
	public function get_instance_schema()
	{
		$schema = array(
			'attachment_id' => array(
				'type'        => 'integer',
				'default'     => 0,
				'minimum'     => 0,
				'description' => __('Attachment post ID'),
				'media_prop'  => 'id',
			),
			'url'           => array(
				'type'        => 'string',
				'default'     => '',
				'format'      => 'uri',
				'description' => __('URL to the media file'),
			),
			'title'         => array(
				'type'                  => 'string',
				'default'               => '',
				'sanitize_callback'     => 'sanitize_text_field',
				'description'           => __('Title for the widget'),
				'should_preview_update' => false,
			),
		);

		/**
		 * Filters the media widget instance schema to add additional properties.
		 *
		 * @since 4.9.0
		 *
		 * @param array           $schema Instance schema.
		 * @param WP_Widget_Media $this   Widget object.
		 */
		$schema = apply_filters("widget_{$this->id_base}_instance_schema", $schema, $this);

		return $schema;
	}

	/**
	 * Determine if the supplied attachment is for a valid attachment post with the specified MIME type.
	 *
	 * @since 4.8.0
	 *
	 * @param int|WP_Post $attachment Attachment post ID or object.
	 * @param string      $mime_type  MIME type.
	 * @return bool Is matching MIME type.
	 */
	public function is_attachment_with_mime_type($attachment, $mime_type)
	{
		if (empty($attachment)) {
			return false;
		}
		$attachment = get_post($attachment);
		if (!$attachment) {
			return false;
		}
		if ('attachment' !== $attachment->post_type) {
			return false;
		}
		return wp_attachment_is($mime_type, $attachment);
	}

	/**
	 * Sanitize a token list string, such as used in HTML rel and class attributes.
	 *
	 * @since 4.8.0
	 *
	 * @link http://w3c.github.io/html/infrastructure.html#space-separated-tokens
	 * @link https://developer.mozilla.org/en-US/docs/Web/API/DOMTokenList
	 * @param string|array $tokens List of tokens separated by spaces, or an array of tokens.
	 * @return string Sanitized token string list.
	 */
	public function sanitize_token_list($tokens)
	{
		if (is_string($tokens)) {
			$tokens = preg_split('/\s+/', trim($tokens));
		}
		$tokens = array_map('sanitize_html_class', $tokens);
		$tokens = array_filter($tokens);
		return join(' ', $tokens);
	}

	/**
	 * Displays the widget on the front-end.
	 *
	 * @since 4.8.0
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance Saved setting from the database.
	 */
	public function widget($args, $instance)
	{
		$instance = wp_parse_args($instance, wp_list_pluck($this->get_instance_schema(), 'default'));

		// Short-circuit if no media is selected.
		if (!$this->has_content($instance)) {
			return;
		}

		echo $args['before_widget'];

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		if ($title) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		/**
		 * Filters the media widget instance prior to rendering the media.
		 *
		 * @since 4.8.0
		 *
		 * @param array           $instance Instance data.
		 * @param array           $args     Widget args.
		 * @param WP_Widget_Media $this     Widget object.
		 */
		$instance = apply_filters("widget_{$this->id_base}_instance", $instance, $args, $this);

		$this->render_media($instance);

		echo $args['after_widget'];
	}

	/**
	 * Sanitizes the widget form values as they are saved.
	 *
	 * @since 4.8.0
	 *
	 * @see WP_Widget::update()
	 * @see WP_REST_Request::has_valid_params()
	 * @see WP_REST_Request::sanitize_params()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $instance     Previously saved values from database.
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $instance)
	{

		$schema = $this->get_instance_schema();
		foreach ($schema as $field => $field_schema) {
			if (!array_key_exists($field, $new_instance)) {
				continue;
			}
			$value = $new_instance[$field];

			/*
			 * Workaround for rest_validate_value_from_schema() due to the fact that
			 * rest_is_boolean( '' ) === false, while rest_is_boolean( '1' ) is true.
			 */
			if ('boolean' === $field_schema['type'] && '' === $value) {
				$value = false;
			}

			if (true !== rest_validate_value_from_schema($value, $field_schema, $field)) {
				continue;
			}

			$value = rest_sanitize_value_from_schema($value, $field_schema);

			// @codeCoverageIgnoreStart
			if (is_wp_error($value)) {
				continue; // Handle case when rest_sanitize_value_from_schema() ever returns WP_Error as its phpdoc @return tag indicates.
			}

			// @codeCoverageIgnoreEnd
			if (isset($field_schema['sanitize_callback'])) {
				$value = call_user_func($field_schema['sanitize_callback'], $value);
			}
			if (is_wp_error($value)) {
				continue;
			}
			$instance[$field] = $value;
		}

		return $instance;
	}

	/**
	 * Render the media on the frontend.
	 *
	 * @since 4.8.0
	 *
	 * @param array $instance Widget instance props.
	 * @return string
	 */
	// abstract public function render_media($instance);

	/**
	 * Outputs the settings update form.
	 *
	 * Note that the widget UI itself is rendered with JavaScript via `MediaWidgetControl#render()`.
	 *
	 * @since 4.8.0
	 *
	 * @see \WP_Widget_Media::render_control_template_scripts() Where the JS template is located.
	 *
	 * @param array $instance Current settings.
	 */
	final public function form($instance)
	{
		$instance_schema = $this->get_instance_schema();
		$instance        = wp_array_slice_assoc(
			wp_parse_args((array) $instance, wp_list_pluck($instance_schema, 'default')),
			array_keys($instance_schema)
		);

		foreach ($instance as $name => $value) : ?>
			<input type="hidden" data-property="<?php echo esc_attr($name); ?>" class="media-widget-instance-property" name="<?php echo esc_attr($this->get_field_name($name)); ?>" id="<?php echo esc_attr($this->get_field_id($name)); // Needed specifically by wpWidgets.appendTitle(). 
																																														?>" value="<?php echo esc_attr(is_array($value) ? join(',', $value) : strval($value)); ?>" />
		<?php
		endforeach;
	}

	/**
	 * Filters the default media display states for items in the Media list table.
	 *
	 * @since 4.8.0
	 *
	 * @param array   $states An array of media states.
	 * @param WP_Post $post   The current attachment object.
	 * @return array
	 */
	public function display_media_state($states, $post = null)
	{
		if (!$post) {
			$post = get_post();
		}

		// Count how many times this attachment is used in widgets.
		$use_count = 0;
		foreach ($this->get_settings() as $instance) {
			if (isset($instance['attachment_id']) && $instance['attachment_id'] === $post->ID) {
				$use_count++;
			}
		}

		if (1 === $use_count) {
			$states[] = $this->l10n['media_library_state_single'];
		} elseif ($use_count > 0) {
			$states[] = sprintf(translate_nooped_plural($this->l10n['media_library_state_multi'], $use_count), number_format_i18n($use_count));
		}

		return $states;
	}

	/**
	 * Enqueue preview scripts.
	 *
	 * These scripts normally are enqueued just-in-time when a widget is rendered.
	 * In the customizer, however, widgets can be dynamically added and rendered via
	 * selective refresh, and so it is important to unconditionally enqueue them in
	 * case a widget does get added.
	 *
	 * @since 4.8.0
	 */
	public function enqueue_preview_scripts()
	{
	}

	/**
	 * Loads the required scripts and styles for the widget control.
	 *
	 * @since 4.8.0
	 */
	public function enqueue_admin_scripts()
	{
		wp_enqueue_media();
		wp_enqueue_script('media-widgets');
	}

	/**
	 * Render form template scripts.
	 *
	 * @since 4.8.0
	 */
	public function render_control_template_scripts()
	{
		?>
		<script type="text/html" id="tmpl-widget-media-<?php echo esc_attr($this->id_base); ?>-control">
			<# var elementIdPrefix='el' + String( Math.random() ) + '_' #>
				<p>
					<label for="{{ elementIdPrefix }}title"><?php esc_html_e('Title:'); ?></label>
					<input id="{{ elementIdPrefix }}title" type="text" class="widefat title">
				</p>
				<div class="media-widget-preview <?php echo esc_attr($this->id_base); ?>">
					<div class="attachment-media-view">
						<button type="button" class="select-media button-add-media not-selected">
							<?php echo esc_html($this->l10n['add_media']); ?>
						</button>
					</div>
				</div>
				<p class="media-widget-buttons">
					<button type="button" class="button edit-media selected">
						<?php echo esc_html($this->l10n['edit_media']); ?>
					</button>
					<?php if (!empty($this->l10n['replace_media'])) : ?>
						<button type="button" class="button change-media select-media selected">
							<?php echo esc_html($this->l10n['replace_media']); ?>
						</button>
					<?php endif; ?>
				</p>
				<div class="media-widget-fields">
				</div>
		</script>

		<script type="text/html" id="tmpl-wp-media-widget-image-fields">
			<# var elementIdPrefix='el' + String( Math.random() ) + '_' ; #>
				<# if ( data.url ) { #>
					<p class="media-widget-image-link">
						<label for="{{ elementIdPrefix }}linkUrl"><?php esc_html_e('Link to:'); ?></label>
						<input id="{{ elementIdPrefix }}linkUrl" type="text" class="widefat link" value="{{ data.link_url }}" placeholder="https://" pattern="((\w+:)?\/\/\w.*|\w+:(?!\/\/$)|\/|\?|#).*">
					</p>
					<# } #>
		</script>
		<script type="text/html" id="tmpl-wp-media-widget-image-preview">
			<# if ( data.error && 'missing_attachment'===data.error ) { #>
				<div class="notice notice-error notice-alt notice-missing-attachment">
					<p><?php echo $this->l10n['missing_attachment']; ?></p>
				</div>
				<# } else if ( data.error ) { #>
					<div class="notice notice-error notice-alt">
						<p><?php _e('Unable to preview media due to an unknown error.'); ?></p>
					</div>
					<# } else if ( data.url ) { #>
						<img class="attachment-thumb" src="{{ data.url }}" draggable="false" alt="{{ data.alt }}" <# if ( ! data.alt && data.currentFilename ) { #>
						aria-label="
						<?php
						echo esc_attr(
							sprintf(
								/* translators: %s: The image file name. */
								__('The current image has no alternative text. The file name is: %s'),
								'{{ data.currentFilename }}'
							)
						);
						?>
						"
						<# } #>
							/>
							<# } #>
		</script>

<?php
	}

	/**
	 * Whether the widget has content to show.
	 *
	 * @since 4.8.0
	 *
	 * @param array $instance Widget instance props.
	 * @return bool Whether widget has content.
	 */
	protected function has_content($instance)
	{
		return ($instance['attachment_id'] && 'attachment' === get_post_type($instance['attachment_id'])) || $instance['url'];
	}

	/**
	 * Render the media on the frontend.
	 *
	 * @since 4.8.0
	 *
	 * @param array $instance Widget instance props.
	 */
	public function render_media($instance)
	{
		$instance = array_merge(wp_list_pluck($this->get_instance_schema(), 'default'), $instance);
		$instance = wp_parse_args(
			$instance,
			array(
				'size' => 'thumbnail',
			)
		);

		$attachment = null;

		if ($this->is_attachment_with_mime_type($instance['attachment_id'], $this->widget_options['mime_type'])) {
			$attachment = get_post($instance['attachment_id']);
		}

		if ($attachment) {
			$caption = '';
			if (!isset($instance['caption'])) {
				$caption = $attachment->post_excerpt;
			} elseif (trim($instance['caption'])) {
				$caption = $instance['caption'];
			}

			$image_attributes = array(
				'class' => sprintf('image wp-image-%d %s', $attachment->ID, $instance['image_classes']),
				'style' => 'max-width: 100%; height: auto;',
			);
			if (!empty($instance['image_title'])) {
				$image_attributes['title'] = $instance['image_title'];
			}

			if ($instance['alt']) {
				$image_attributes['alt'] = $instance['alt'];
			}

			$size = $instance['size'];

			if ('custom' === $size || !in_array($size, array_merge(get_intermediate_image_sizes(), array('full')), true)) {
				$size  = array($instance['width'], $instance['height']);
				$width = $instance['width'];
			} else {
				$caption_size = _wp_get_image_size_from_meta($instance['size'], wp_get_attachment_metadata($attachment->ID));
				$width        = empty($caption_size[0]) ? 0 : $caption_size[0];
			}

			$image_attributes['class'] .= sprintf(' attachment-%1$s size-%1$s', is_array($size) ? join('x', $size) : $size);

			$image = wp_get_attachment_image($attachment->ID, $size, false, $image_attributes);
		} else {
			if (empty($instance['url'])) {
				return;
			}

			$instance['size'] = 'custom';
			$caption          = $instance['caption'];
			$width            = $instance['width'];
			$classes          = 'image ' . $instance['image_classes'];
			if (0 === $instance['width']) {
				$instance['width'] = '';
			}
			if (0 === $instance['height']) {
				$instance['height'] = '';
			}

			$image = sprintf(
				'<img class="%1$s" src="%2$s" alt="%3$s" width="%4$s" height="%5$s" />',
				esc_attr($classes),
				esc_url($instance['url']),
				esc_attr($instance['alt']),
				esc_attr($instance['width']),
				esc_attr($instance['height'])
			);
		} // End if().

		$url = '';
		if ('file' === $instance['link_type']) {
			$url = $attachment ? wp_get_attachment_url($attachment->ID) : $instance['url'];
		} elseif ($attachment && 'post' === $instance['link_type']) {
			$url = get_attachment_link($attachment->ID);
		} elseif ('custom' === $instance['link_type'] && !empty($instance['link_url'])) {
			$url = $instance['link_url'];
		}

		if ($url) {
			$link = sprintf('<a href="%s"', esc_url($url));
			if (!empty($instance['link_classes'])) {
				$link .= sprintf(' class="%s"', esc_attr($instance['link_classes']));
			}
			if (!empty($instance['link_rel'])) {
				$link .= sprintf(' rel="%s"', esc_attr($instance['link_rel']));
			}
			if (!empty($instance['link_target_blank'])) {
				$link .= ' target="_blank"';
			}
			$link .= '>';
			$link .= $image;
			$link .= '</a>';
			$image = wp_targeted_link_rel($link);
		}

		if ($caption) {
			$image = img_caption_shortcode(
				array(
					'width'   => $width,
					'caption' => $caption,
				),
				$image
			);
		}

		echo $image;
	}
}
