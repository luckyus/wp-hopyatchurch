/* eslint consistent-this: [ "error", "control" ] */

/**
 * Continued from PHP Instructions on renaming / cloning image class.
 * @link https://gist.github.com/StuffieStephie/4f654058545d693787a36e76d3521b1e
 *
 * Step 1:
 * Assign previewTemplate variable to the script template ID defined in the
 * PHP file sans 'tmpl-' (Step 6 of PHP instructions)
 * Name here `custom-media-widget-image-preview`
 *  ---------------------------------------------------------------------
 *  Step 2:
 * Similar to Step 1 -- assign fieldsTemplate variable to the script template ID
 *  defined in the  PHP file sans 'tmpl-' (Step 5 of PHP instructions)
 * Name here `custom-media-widget-image-fields`
 *  ---------------------------------------------------------------------
 * Step 3:
 * Rename Exports. (Name here: `custom_media_image`)
 */
(function (component, $) {
	"use strict";

	console.log("This means that the custom image widget JS file has been loaded.");

	var ImageWidgetModel, ImageWidgetControl;

	/**
	 * Image widget model.
	 *
	 * See WP_Widget_Media_Image::enqueue_admin_scripts() for amending prototype from PHP exports.
	 *
	 * @class ImageWidgetModel
	 * @constructor
	 */
	ImageWidgetModel = component.MediaWidgetModel.extend({
		schema: {
			imageBlah: {
				type: "string",
				default: "Fuck You!",
			},
		},
	});

	/**
	 * Image widget control.
	 *
	 * See WP_Widget_Media_Image::enqueue_admin_scripts() for amending prototype from PHP exports.
	 *
	 * @class ImageWidgetModel
	 * @constructor
	 */
	ImageWidgetControl = component.MediaWidgetControl.extend({
		/**
		 * Render preview.
		 *
		 * @returns {void}
		 */
		renderPreview: function renderPreview() {
			var control = this,
				previewContainer,
				previewTemplate,
				fieldsContainer,
				fieldsTemplate,
				linkInput;
			if (!control.model.get("attachment_id") && !control.model.get("url")) {
				return;
			}

			/* debug */
			console.log("ImageWidgetControl renderPreview()...");

			previewContainer = control.$el.find(".media-widget-preview");
			/*--------------------------------------------------------------
# Step 1:
  * Assign previewTemplate variable to the script template ID defined in the
  * PHP file sans 'tmpl-' (Step 6 of PHP instructions)
  * Name here `custom-media-widget-image-preview`
--------------------------------------------------------------*/
			previewTemplate = wp.template("custom-media-widget-image-preview");
			previewContainer.html(previewTemplate(control.previewTemplateProps.toJSON()));

			linkInput = control.$el.find(".link");
			if (!linkInput.is(document.activeElement)) {
				fieldsContainer = control.$el.find(".media-widget-fields");
				/*--------------------------------------------------------------
# Step 2:
  * Similar to Step 1 -- assign fieldsTemplate variable to the script template ID
  *  defined in the  PHP file sans 'tmpl-' (Step 5 of PHP instructions)
  * Name here `custom-media-widget-image-fields`
--------------------------------------------------------------*/
				fieldsTemplate = wp.template("custom-media-widget-image-fields");
				fieldsContainer.html(fieldsTemplate(control.previewTemplateProps.toJSON()));
			}
		},

		/**
		 * Open the media image-edit frame to modify the selected item.
		 *
		 * @returns {void}
		 */
		editMedia: function editMedia() {
			var control = this,
				mediaFrame,
				updateCallback,
				defaultSync,
				metadata;

			// debug
			console.log("editMedia()...");
			console.log("metadata:", metadata);

			metadata = control.mapModelToMediaFrameProps(control.model.toJSON());

			// Needed or else none will not be selected if linkUrl is not also empty.
			if ("none" === metadata.link) {
				metadata.linkUrl = "";
			}

			// Set up the media frame.
			mediaFrame = wp.media({
				frame: "image",
				state: "image-details",
				metadata: metadata,
			});
			mediaFrame.$el.addClass("media-widget");

			updateCallback = function () {
				var mediaProps, linkType;

				// Update cached attachment object to avoid having to re-fetch. This also triggers re-rendering of preview.
				mediaProps = mediaFrame.state().attributes.image.toJSON();
				linkType = mediaProps.link;
				mediaProps.link = mediaProps.linkUrl;

				control.selectedAttachment.set(mediaProps);
				control.displaySettings.set("link", linkType);

				control.model.set(_.extend(control.mapMediaToModelProps(mediaProps), { error: false }));
			};

			mediaFrame.state("image-details").on("update", updateCallback);
			mediaFrame.state("replace-image").on("replace", updateCallback);

			// Disable syncing of attachment changes back to server. See <https://core.trac.wordpress.org/ticket/40403>.
			defaultSync = wp.media.model.Attachment.prototype.sync;
			wp.media.model.Attachment.prototype.sync = function rejectedSync() {
				return $.Deferred().rejectWith(this).promise();
			};
			mediaFrame.on("close", function onClose() {
				mediaFrame.detach();
				wp.media.model.Attachment.prototype.sync = defaultSync;
			});

			mediaFrame.open();
		},

		/**
		 * Get props which are merged on top of the model when an embed is chosen (as opposed to an attachment).
		 *
		 * @returns {Object} Reset/override props.
		 */
		getEmbedResetProps: function getEmbedResetProps() {
			return _.extend(component.MediaWidgetControl.prototype.getEmbedResetProps.call(this), {
				size: "full",
				width: 0,
				height: 0,
			});
		},

		/**
		 * Get the instance props from the media selection frame.
		 *
		 * Prevent the image_title attribute from being initially set when adding an image from the media library.
		 *
		 * @param {wp.media.view.MediaFrame.Select} mediaFrame - Select frame.
		 * @returns {Object} Props.
		 */
		getModelPropsFromMediaFrame: function getModelPropsFromMediaFrame(mediaFrame) {
			var control = this;
			return _.omit(component.MediaWidgetControl.prototype.getModelPropsFromMediaFrame.call(control, mediaFrame), "image_title");
		},

		/**
		 * Map model props to preview template props.
		 *
		 * @returns {Object} Preview template props.
		 */
		mapModelToPreviewTemplateProps: function mapModelToPreviewTemplateProps() {
			var control = this,
				previewTemplateProps,
				url;
			url = control.model.get("url");
			previewTemplateProps = component.MediaWidgetControl.prototype.mapModelToPreviewTemplateProps.call(control);
			previewTemplateProps.currentFilename = url ? url.replace(/\?.*$/, "").replace(/^.+\//, "") : "";
			previewTemplateProps.link_url = control.model.get("link_url");

			/* debug */
			console.log("previewTemplateProps:", previewTemplateProps);

			return previewTemplateProps;
		},
	});

	// Exports.
	/*--------------------------------------------------------------
# Step 3:
 * Rename Exports. Name here `custom_media_image`
--------------------------------------------------------------*/
	component.controlConstructors.custom_media_image = ImageWidgetControl;
	component.modelConstructors.custom_media_image = ImageWidgetModel;
})(wp.mediaWidgets, jQuery);
