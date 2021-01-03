<?php

/**
 * This is a clone of the WP_Widget_Media_Image class that was introduced
 * in WP version 4.8.0.
 *
 * By cloning this class we can add new fields without modifying the original
 * class.  This means we can extend it to do whatever we want :D
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.8.0
 */


/**
 * How to clone Image class:
 *
 * 1.) Copy the PHP and JS files from this Gist and put them in your theme's directory
 * under /lib/custom_image_widget/.
 * @link https://gist.github.com/StuffieStephie/8dd2d3e5a36b08f0094a33bd70384dd0/ (JS File) 
 *
 * 2.) In your theme's functions.php file paste the following:
 * // Load up a custom image widget class clone
 * include_once __DIR__ . "/lib/custom_image_widget/custom_image_widget.php";
 *
 * That should be it! If you need another copy or want to rename aspects of this class
 * follow the steps below for this file. (Search `Step #` to find where to edit quickly)
 *
 * Step 1:
 *  Rename class (Name here:  `Custom_Widget_Media_Image`)
 *  ---------------------------------------------------------------------
 * Step 2:
 *  In the __construct function change the id_base (Name here: `custom_media_image`)
 *  ---------------------------------------------------------------------
 * Step 3:
 *  Assign $handle.  (Name here: `custom-media-image-widget`)
 *  ---------------------------------------------------------------------
 * Step 4:
 *  Enqueue your modified JS file.
 *  NOTE: This assumes the path is `/yourtheme/lib/custom_image_widget/`
 *  Change if needed.
 *  ---------------------------------------------------------------------
 *  Step 5:
 * Change Fields Template script ID.
 * Name here: `tmpl-custom-media-widget-image-fields`
 * NOTE: Must start with `tmpl`.
 * Step 5a:
 * In JS file, assign the fieldsContainer variable
 * to this ID sans `tmpl-` at the beginning.  It will not work without it.
 * Ex. fieldsTemplate = wp.template( 'custom-media-widget-image-fields' );
 *  ---------------------------------------------------------------------
 *  Step 6:
 * Similar to Step 5 -- Change Preview Template script ID.
 * Name here: `tmpl-custom-media-widget-image-preview`
 * NOTE: Must start with `tmpl`.
 * Step 6a:
 * In JS file, assign the fieldsContainer variable
 * to this ID sans `tmpl-` at the beginning.  It will not work without it.
 * Ex. previewTemplate = wp.template( 'custom-media-widget-image-preview' );
 *  ---------------------------------------------------------------------
 *  Step 7:
 * Register Custom_Widget_Text widget.  (Rename if needed.)
 *  ---------------------------------------------------------------------
 *  Step 8:
 * Call function on widget init (Function name defined in Step 7)
 *  --------------------------- END ------------------------ */



/**
 * Core class that implements an image widget.
 *
 * @since 4.8.0
 *
 * @see WP_Widget_Media & WP_Widget_Media_Image
 */

/*--------------------------------------------------------------
# Step 1: Rename class (I've named it `Custom_Widget_Media_Image`)
--------------------------------------------------------------*/
class Custom_Widget_Media_Image extends WP_Widget_Media
{
	/**
	 * Constructor.
	 *
	 * @since  4.8.0
	 */
	public function __construct()
	{
		/*--------------------------------------------------------------
# Step 2:
*  In the __construct function change the id_base (Name here: `custom_media_image`)
--------------------------------------------------------------*/
		parent::__construct('custom_media_image', __('Custom Image'), array(
			'description' => __('Custom: Displays an image.'),
			'mime_type'   => 'image',
		));
		$this->l10n = array_merge($this->l10n, array(
			'no_media_selected' => __('No image selected'),
			'add_media' => _x('Add Image', 'label for button in the image widget'),
			'replace_media' => _x('Replace Image', 'label for button in the image widget; should preferably not be longer than ~13 characters long'),
			'edit_media' => _x('Edit Image', 'label for button in the image widget; should preferably not be longer than ~13 characters long'),
			'missing_attachment' => sprintf(
				/* translators: placeholder is URL to media library */
				__('We can&#8217;t find that image. Check your <a href="%s">media library</a> and make sure it wasn&#8217;t deleted.'),
				esc_url(admin_url('upload.php'))
			),
			/* translators: %d is widget count */
			'media_library_state_multi' => _n_noop('Image Widget (%d)', 'Image Widget (%d)'),
			'media_library_state_single' => __('Image Widget'),
		));
	}
	/**
	 * Get schema for properties of a widget instance (item).
	 *
	 * @since  4.8.0
	 *
	 * @see WP_REST_Controller::get_item_schema()
	 * @see WP_REST_Controller::get_additional_fields()
	 * @link https://core.trac.wordpress.org/ticket/35574
	 * @return array Schema for properties.
	 */
	public function get_instance_schema()
	{
		return array_merge(
			parent::get_instance_schema(),
			array(
				'size' => array(
					'type' => 'string',
					'enum' => array_merge(get_intermediate_image_sizes(), array('full', 'custom')),
					'default' => 'medium',
					'description' => __('Size'),
				),
				'width' => array( // Via 'customWidth', only when size=custom; otherwise via 'width'.
					'type' => 'integer',
					'minimum' => 0,
					'default' => 0,
					'description' => __('Width'),
				),
				'height' => array( // Via 'customHeight', only when size=custom; otherwise via 'height'.
					'type' => 'integer',
					'minimum' => 0,
					'default' => 0,
					'description' => __('Height'),
				),
				'caption' => array(
					'type' => 'string',
					'default' => '',
					'sanitize_callback' => 'wp_kses_post',
					'description' => __('Caption'),
					'should_preview_update' => false,
				),
				'alt' => array(
					'type' => 'string',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'description' => __('Alternative Text'),
				),
				'link_type' => array(
					'type' => 'string',
					'enum' => array('none', 'file', 'post', 'custom'),
					'default' => 'none',
					'media_prop' => 'link',
					'description' => __('Link To'),
					'should_preview_update' => true,
				),
				'link_url' => array(
					'type' => 'string',
					'default' => '',
					'format' => 'uri',
					'media_prop' => 'linkUrl',
					'description' => __('URL'),
					'should_preview_update' => true,
				),
				'image_classes' => array(
					'type' => 'string',
					'default' => '',
					'sanitize_callback' => array($this, 'sanitize_token_list'),
					'media_prop' => 'extraClasses',
					'description' => __('Image CSS Class'),
					'should_preview_update' => false,
				),
				'link_classes' => array(
					'type' => 'string',
					'default' => '',
					'sanitize_callback' => array($this, 'sanitize_token_list'),
					'media_prop' => 'linkClassName',
					'should_preview_update' => false,
					'description' => __('Link CSS Class'),
				),
				'link_rel' => array(
					'type' => 'string',
					'default' => '',
					'sanitize_callback' => array($this, 'sanitize_token_list'),
					'media_prop' => 'linkRel',
					'description' => __('Link Rel'),
					'should_preview_update' => false,
				),
				'link_target_blank' => array(
					'type' => 'boolean',
					'default' => false,
					'media_prop' => 'linkTargetBlank',
					'description' => __('Open link in a new tab'),
					'should_preview_update' => false,
				),
				'image_title' => array(
					'type' => 'string',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
					'media_prop' => 'title',
					'description' => __('Image Title Attribute'),
					'should_preview_update' => false,
				),
				'image_blah'       => array(
					'type'                  => 'string',
					'default'               => '',
					'sanitize_callback'     => 'sanitize_text_field',
					'media_prop'            => 'imageBlah',
					'description'           => __('Image Blah'),
					'should_preview_update' => true,
				),

				/*
				 * There are two additional properties exposed by the PostImage modal
				 * that don't seem to be relevant, as they may only be derived read-only
				 * values:
				 * - originalUrl
				 * - aspectRatio
				 * - height (redundant when size is not custom)
				 * - width (redundant when size is not custom)
				 */
			)
		);
	}
	/**
	 * Render the media on the frontend.
	 *
	 * @since  4.8.0
	 *
	 * @param array $instance Widget instance props.
	 * @return void
	 */
	public function render_media($instance)
	{
		$instance = array_merge(wp_list_pluck($this->get_instance_schema(), 'default'), $instance);
		$instance = wp_parse_args($instance, array(
			'size' => 'thumbnail',
		));
		$attachment = null;
		if ($this->is_attachment_with_mime_type($instance['attachment_id'], $this->widget_options['mime_type'])) {
			$attachment = get_post($instance['attachment_id']);
		}
		if ($attachment) {
			$caption = $attachment->post_excerpt;
			if ($instance['caption']) {
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
				$size = array($instance['width'], $instance['height']);
			}
			$image_attributes['class'] .= sprintf(' attachment-%1$s size-%1$s', is_array($size) ? join('x', $size) : $size);
			$image = wp_get_attachment_image($attachment->ID, $size, false, $image_attributes);
			$caption_size = _wp_get_image_size_from_meta($instance['size'], wp_get_attachment_metadata($attachment->ID));
			$width = empty($caption_size[0]) ? 0 : $caption_size[0];
		} else {
			if (empty($instance['url'])) {
				return;
			}
			$instance['size'] = 'custom';
			$caption = $instance['caption'];
			$width   = $instance['width'];
			$classes = 'image ' . $instance['image_classes'];
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
			$image = sprintf(
				'<a href="%1$s" class="%2$s" rel="%3$s" target="%4$s">%5$s</a>',
				esc_url($url),
				esc_attr($instance['link_classes']),
				esc_attr($instance['link_rel']),
				!empty($instance['link_target_blank']) ? '_blank' : '',
				$image
			);
		}
		if ($caption) {
			$image = img_caption_shortcode(array(
				'width' => $width,
				'caption' => $caption,
			), $image);
		}
		echo $image;
		echo 'TP#01 <br />';
		foreach ($instance as $x => $val) {
			echo "$x = $val<br>";
			error_log("$x = $val");
		}
	}

	/* debug */
	public function Update($new, $old)
	{
		error_log("My Update()...");

		error_log("new...");
		foreach ($new as $x => $val) {
			echo "$x = $val<br>";
			error_log("$x = $val");
		}

		error_log("old...");
		foreach ($old as $x => $val) {
			echo "$x = $val<br>";
			error_log("$x = $val");
		}

		error_log("Done My Update()!!!");

		// Saves your data, called via AJAX. But your saving logic here.
		return parent::Update($new, $old);
	}

	/**
	 * Loads the required media files for the media manager and scripts for media widgets.
	 *
	 * @since 4.8.0
	 */
	public function enqueue_admin_scripts()
	{
		parent::enqueue_admin_scripts();
		/*--------------------------------------------------------------
# Step 3:
 *  Assign $handle.  Name here: `custom-media-image-widget`
--------------------------------------------------------------*/
		$handle = 'custom-media-image-widget';
		/*--------------------------------------------------------------
# Step 4:
 *  Enqueue your modified JS file.
 *  NOTE: This assumes the path is `/yourtheme/lib/custom_image_widget/`
 *  Change if needed.
--------------------------------------------------------------*/

		$path_to_JS = '/lib/custom_image_widget/custom-media-image-widget.js';

		wp_enqueue_script(
			$handle,  // Unique ID
			get_template_directory_uri() . $path_to_JS,  //Filepath
			array('jquery'), // Dependencies
			'1.0.0', //Version number
			true //load in footer
		);
		$exported_schema = array();
		foreach ($this->get_instance_schema() as $field => $field_schema) {
			$exported_schema[$field] = wp_array_slice_assoc($field_schema, array('type', 'default', 'enum', 'minimum', 'format', 'media_prop', 'should_preview_update'));
		}
		wp_add_inline_script(
			$handle,
			sprintf(
				'wp.mediaWidgets.modelConstructors[ %s ].prototype.schema = %s;',
				wp_json_encode($this->id_base),
				wp_json_encode($exported_schema)
			)
		);
		wp_add_inline_script(
			$handle,
			sprintf(
				'
					wp.mediaWidgets.controlConstructors[ %1$s ].prototype.mime_type = %2$s;
					wp.mediaWidgets.controlConstructors[ %1$s ].prototype.l10n = _.extend( {}, wp.mediaWidgets.controlConstructors[ %1$s ].prototype.l10n, %3$s );
				',
				wp_json_encode($this->id_base),
				wp_json_encode($this->widget_options['mime_type']),
				wp_json_encode($this->l10n)
			)
		);
	}
	/**
	 * Render form template scripts.
	 *
	 * @since 4.8.0
	 */
	public function render_control_template_scripts()
	{
		parent::render_control_template_scripts();
		/*--------------------------------------------------------------
# Step 5:
 * Change Fields Template script ID.
 * Name here: `tmpl-custom-media-widget-image-fields`
 * NOTE: Must start with `tmpl`.
 * Step 5a:
   * In JS file, assign the fieldsTemplate variable
   * to this ID sans `tmpl-` at the beginning.  It will not work without it.
   * Ex. fieldsTemplate = wp.template( 'custom-media-widget-image-fields' );
--------------------------------------------------------------*/
?>
		<script type="text/html" id="tmpl-custom-media-widget-image-fields">
			<# var elementIdPrefix='el' + String( Math.random() ) + '_' ; #>
				<# if ( data.url ) { #>
					<p>
						<label for="{{ elementIdPrefix }}imageBlah"><?php esc_html_e('Image Blah 05:'); ?></label>
						<input id="{{ elementIdPrefix }}imageBlah" type="text" class="widefat imageBlah" value="{{ data.image_blah }}">
					</p>
					<p class="media-widget-image-link">
						<label for="{{ elementIdPrefix }}linkUrl"><?php esc_html_e('Link to:'); ?></label>
						<input id="{{ elementIdPrefix }}linkUrl" type="url" class="widefat link" value="{{ data.link_url }}" placeholder="http://">
					</p>

					<# } #>
		</script>
		<?php
		/*--------------------------------------------------------------
# Step 6:
 * Similar to Step 5 -- Change Preview Template script ID.
 * Name here: `tmpl-custom-media-widget-image-preview`
 * NOTE: Must start with `tmpl`.
 * Step 6a:
   * In JS file, assign the previewTemplate variable
   * to this ID sans `tmpl-` at the beginning.  It will not work without it.
   * Ex. previewTemplate = wp.template( 'custom-media-widget-image-preview' );
--------------------------------------------------------------*/
		?>
		<script type="text/html" id="tmpl-custom-media-widget-image-preview">
			<# var describedById='describedBy-' + String( Math.random() ); #>
				<# if ( data.error && 'missing_attachment'===data.error ) { #>
					<div class="notice notice-error notice-alt notice-missing-attachment">
						<p><?php echo $this->l10n['missing_attachment']; ?></p>
					</div>
					<# } else if ( data.error ) { #>
						<div class="notice notice-error notice-alt">
							<p><?php _e('Unable to preview media due to an unknown error.'); ?></p>
						</div>
						<# } else if ( data.url ) { #>
							<img class="attachment-thumb" src="{{ data.url }}" draggable="false" alt="{{ data.alt }}" <# if ( ! data.alt && data.currentFilename ) { #> aria-describedby="{{ describedById }}" <# } #> />
								<# if ( ! data.alt && data.currentFilename ) { #>
									<p class="hidden" id="{{ describedById }}"><?php
																				/* translators: placeholder is image filename */
																				echo sprintf(__('Current image: %s'), '{{ data.currentFilename }}');
																				?></p>
									<# } #>
										<# } #>
		</script>
<?php
	}
}

/*--------------------------------------------------------------
# Step 7:
 * Register Custom_Widget_Text widget.  (Rename if needed.)
--------------------------------------------------------------*/
function register_custom_image_widget()
{
	register_widget(
		'Custom_Widget_Media_Image' //Name of new class
	);
}

/*--------------------------------------------------------------
# Step 8:
 * Call function on widget init (Function name defined in Step 7)
--------------------------------------------------------------*/
add_action(
	'widgets_init',
	'register_custom_image_widget' // Function name defined in Step 7
);
