=== Plugin Name ===
Contributors: markusfroehlich
Donate link: https://www.paypal.com/donate?business=DUKJP25LKTX62&currency_code=EUR
Tags: contact form 7, contact, contact form, form, post fields, posts
Requires at least: 4.0
Tested up to: 6.2.2
Stable tag: 2.5.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin provides a dynamic post selection, radio and checkbox field to your CF7 forms.

== Description ==

Contact Form 7 is a fantastic plugin for form. The post-fields extension enables you to create image drop-down-menues, checkboxes and radio-buttons based on posts or other kinds of content (custom post types).

= Features of post fields =

* beautiful drop-down-menues, checkboxes and radio buttons with post image, excerpt and meta data
* selection of the post type (posts, pages, attachments, custom post types)
* selection and limitation of categories (taxonomies)
* customized/individual formatting of the label
* configuring the value attribute
* pretty post hyperlinks in the message body
* customized sorting of the post type
* Display a search box on drop-down-menues
* limitation of the post type based on its particular status (published, draft etc.)
* The default value of the field can easily be selected by using $_GET or $_POST variables (see FAQ).

= Required Plugin =

* [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) by Takayuki Miyoshi - Contact Form 7 can manage multiple contact forms, plus you can customize the form and the mail contents flexibly with simple markup.

== Installation ==

1. Download and install the required Contact Form 7 Plugin available at http://wordpress.org/extend/plugins/contact-form-7/
2. Upload 'contact-form-7-post-fields' to the '/wp-content/plugins/' directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress.
4. You will now have a "posts drop-down-menu", "posts image drop-down-menu", "post checkboxes" and "post radio buttons" tag option in the Contact Form 7 tag generator.

== Frequently Asked Questions ==

= Where can I find the new post fields and how can I use them? =

1. Make sure that you have installed and activated the required plugin [Contact Form 7](https://wordpress.org/plugins/contact-form-7/).
2. In the menu, navigate to the item "Contact", create a new or edit an existing form.
3. You can find 4 new fields in the tab "Form" now: "posts image drop-down-menu", "posts drop-down-menu", "post checkboxes" and "post radio buttons".

= Why can't I find my own type of content (custom post type) in the list? =

The only types of content displayed are those declared as public.
See [register post type](https://codex.wordpress.org/Function_Reference/register_post_type).

= How can I make my form in the front end use a standard value automatically? =

This can easily be done by using $_GET or $_POST variables.

1. In the post field shortcode, add the option "default:get" or "default:post" ([instructions](http://contactform7.com/checkboxes-radio-buttons-and-menus/)), e.g. [post_select post_select-1 publish default:get post-type:post value-field:title orderby:title order:DESC "%title%"]
2. On your website, move to the form with the following $_GET parameters: http://www.yourdomain.at/contact/?field_name=post_id

If you have integrated your form into a single post template, you can use "default:current_post" to set the default value equal to the current post.

= What kind of post meta keys can be used for the label?  =

1. Single text meta keys
2. Sequential arrays will be changed in a string list (comma seperated)
3. Associative arrays are no supported

= How can i style the posts image drop-down-menu? =

The posts image drop-down-menu is build with the jQuery [select2](https://select2.github.io/) libary.
You can style with CSS the drop-down-menus using the class "select2" and/or "select2-container".

= How can i print pretty post hyperlinks in the message body =
1. Select the "Permalink" option from the value field in the post field generator.
2. Check the "Use HTML content type" box in the Mail setting.

= I found a bug, what shall I do? =

If you have found a bug in my plugin, please send me an email with a short description.
I will fix the bug as soon as possible.

= You like my plugin and you'd like to support me? =

Thank you very much!
In case you want to show how much you appreciate my work, I'd be very grateful if you could give me positive rating with Wordpress-Page and/or donate a small amount to me.

== Screenshots ==

1. The post image radio buttons with meta data
2. The posts image drop-down-menu
3. The posts drop-down-menu
4. Post select field generator

== Changelog ==
= 2.5.7 =
* Dev - Add new filter for html attributes.
* Dev - Add meta_key and meta_type args to post query preset.
* Fix - Pypass correct number of decimals on numeric meta values.

= 2.5.6 =
* Dev - Add new WP Query args meta_key and meta_type
* Dev - Add filter "wpcf7_'.tag_name.'_'.basetype.'_item_label" to all modules

= 2.5.5 =
* Dev - Add new filter for label, excerpt and item attributes

= 2.5.4 =
* Dev - Add new constant WPCF7_POST_FIELDS_PLUGIN

= 2.5.3 =
* Dev - Add filter "wpcf7_'.tag_name.'_'.basetype.'_item_label" to all modules

= 2.5.2 =
* Dev - Tested up with WordPress 5.4
* Dev - Add filter "wpcf7_mytag_defaults"
* Dev - Code optimizations

= 2.5.1 =
* Dev - Tested up with WordPress 5.2.1
* Dev - Star rating included

= 2.5.0 =
* Dev - Tested up with WordPress 5.2
* Dev - Code optimizations
* Dev - Improvement for better main instance call
* Fix - Missing Field "post_radio*" and "post_image_radio*"

= 2.4.1 =
* Dev - Removed the &nbsp; in the checkbox rendering

= 2.4.0 =
* Feature - Search box option for posts drop-down menus
* Dev - Load select2 libary on posts drop-down menues with the multiple attribute
* Dev - Add placeholder filter for select fields and field post data
* Dev - Add field post data filter
* Dev - Improvement for better scripts and style loading
* Fix - No include blank on on posts drop-down menu with the multiple attribute

= 2.3.2 =
* Image select attachment otimiziation

= 2.3.1 =
* Fix by the ACF Meta Integration

= 2.3.0 =
* Improvement for search, replacing and formatting post meta fields
* Fixed showing correct image on image select field (post type attachment)
* Code optimizations

= 2.2.1 =
* Improvement for search and replacing meta fields in the label

= 2.2 =
* Add support for meta data in value field
* Add support for excluded terms
* Fix by getting the image URL from Post or Attachment
* Renamed Parameter "category-relation" to "tax-relation"

= 2.1 =
* Add support for attachments
* Add new post status "inherit"
* Add new value field "thumbnail"

= 2.0 =
* Add WPML compatibility for getting posts
* Add the post number option to the fields
* Changed the "field_name_get_posts" filter to "wpcf7_field_name_get_posts"
* Code optimization for getting posts

= 1.9 =
* Select2 Libary Update to 4.0.5
* Code and performance optimizations
* Translation fixes

= 1.8 =
* Add new default value option "current_post"

= 1.7.1 =
* Bugfix in posts image fields css file (clearfix)

= 1.7 =
* CSS optimizations in all posts image fields

= 1.6 =
* Code and performance optimizations
* Changed the name of the image size to "wpcf7-post-image"
* Changed the order of the form tags
* Introduction of a new "posts image checkboxes" and "posts image radio buttons" field
* New "Meta Data" feature for all image post fields
* New value field "Permalink", wich prints pretty post hyperlinks on the mail body
* Add new translations

= 1.5 =
* Bugfix in "posts image drop-down-menu" when select multiple and include_blank
* Bugfix in "posts image drop-down-menu" (dashicons) when no thumbnail is available
* Add "permalink" and "author" tags to the label format

= 1.4 =
* Introduction of a new "posts image drop-down-menu" field
* Changed the deprecated class WPCF7_Shortcode to WPCF7_FormTag
* Bugfix when the "posts drop-down-menu" has the option "include_blank"

= 1.3 =
* Post meta keys available in the label formatting

= 1.2 =
* Changed the deprecated function wpcf7_add_shortcode to wpcf7_add_form_tag
* Translation fixes

= 1.1 =
* Translation fixes

= 1.0 =
* Initial Release
* Check compatibility with latest Contact Form 7 and WordPress Version