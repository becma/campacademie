<?php
/*
 * The base class from the modules
 * Author: Markus Froehlich
 */
if(!defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!class_exists('wpcf7_post_fields_module') )
{
    class wpcf7_post_fields_module
    {
        /*
         * Data Fields
         */
        public $plugin_file;
        protected $label_tags = array('%title%', '%date%', '%time%', '%excerpt%', '%slug%', '%author%', '%permalink%','%id%');
        protected $meta_tags  = array('title', 'date', 'time', 'slug', 'author', 'permalink', 'id');
        protected $post_status = array('publish', 'pending', 'draft', 'future');

        /*
         * Constructor
         */
        public function __construct($plugin_file) {
            $this->plugin_file = $plugin_file;
        }

        /*
         * Get Post Values
         */
        protected function get_post_values($tag)
        {
            /*
             * Post Variables from the Field
             */
            $args = array(
                'label'             => (string) reset( $tag->values ),
                'post_type'         => $tag->get_option('post-type', '', true),
                'tax_relation'      => $tag->get_option('tax-relation', '', true),
                'value_field'       => $tag->get_option('value-field', '', true),
                'orderby'           => $tag->get_option('orderby', '', true),
                'order'             => $tag->get_option('order', '', true),
                'meta_key'          => $tag->get_option('meta_key', '', true),
                'meta_type'         => $tag->get_option('meta_type', '', true),
                'posts_per_page'    => $tag->get_option('posts-number', 'int', true)
            );

            // Handle the depricated tax relation parameter
            if($args['tax_relation'] === false) {
                $args['tax_relation'] = $tag->get_option('category-relation', '', true);
            }

            // Init of the return parameters
            $field_post_data = array(
                'ids'       => array(),
                'labels'    => array(),
                'values'    => array()
            );

            // Arguments to retrieve posts
            $post_args = array();

            // Set the post type
            $post_args['post_type'] = post_type_exists($args['post_type']) ? $args['post_type'] : 'post';

            // Set the number of posts
            $post_args['posts_per_page'] = is_numeric($args['posts_per_page']) ? absint($args['posts_per_page']) : -1;

            // Set post_status to WP Query
            foreach($this->post_status as $status) {
                if($tag->has_option($status)) {
                    $post_args['post_status'][] = $status;
                }
            }

            // Get taxonomies from post type
            $post_args['tax_query'] = array();
            $taxonomie_names = get_object_taxonomies($args['post_type'], 'names');

            if(count($taxonomie_names) > 0)
            {
                foreach($taxonomie_names as $taxonomy)
                {
                    // Term slugs from the field
                    $term_slugs = $tag->get_option($taxonomy, '', true);

                    // Term slugs found
                    if($term_slugs !== false)
                    {
                        $term_slug_array = array_map('trim', explode('|', $term_slugs));

                        foreach($term_slug_array as $term_slug)
                        {
                            $negative = false;
                            // Search for negation
                            if (strrpos($term_slug, '!') === 0)
                            {
                                $negative = true;
                                $term_slug = trim(substr($term_slug, 1));
                            }

                            // Get the term object by slug
                            $term_obj = get_term_by('slug', $term_slug, $taxonomy);

                            if($term_obj !== false)
                            {
                                $post_args['tax_query'][] = array(
                                    'taxonomy'          => $term_obj->taxonomy,
                                    'field'             => 'term_id',
                                    'terms'             => $term_obj->term_id,
                                    'operator'          => $negative ? 'NOT IN' : 'IN'
                                );
                            }
                        }
                    }
                }
            }

            // Set the taxonomy relation
            if(count($post_args['tax_query']) > 0) {
                $post_args['tax_query']['relation'] = ($args['tax_relation'] === 'AND') ? 'AND' : 'OR';
            } else {
                unset($post_args['tax_query']); // No tax query set
            }

            // Set orderby to WP Query
            if($args['orderby'] !== false)
            {
                $post_args['orderby'] = $args['orderby'];
                $post_args['order'] = ($args['order'] === 'DESC') ? 'DESC' : 'ASC';
            }

            // WPML Integration
            if(defined( 'ICL_SITEPRESS_VERSION' )) {
                $post_args['suppress_filters'] = false;
            }

            // Field-Filter for custom WP Query
            $post_args = apply_filters('wpcf7_'.$tag->name.'_get_posts', $post_args, $tag, $args);

            // Get all posts from Post Type
            $posts = get_posts($post_args);

            foreach ($posts as $post)
            {
                $field_post_data['ids'][] = $post->ID;
                $field_post_data['labels'][] = $args['label'] ? $this->replace_label_tags($args['label'], $post, $tag->name) : $post->post_title;

                // Set the value Field
                switch ($args['value_field'])
                {
                    case 'title':
                        $field_post_data['values'][] = $post->post_title;
                        break;
                    case 'slug':
                        $field_post_data['values'][] = $post->post_name;
                        break;
                    case 'permalink':
                        $field_post_data['values'][] = sprintf('[permalink-%s]', $post->ID);
                        break;
                    case 'thumbnail':
                        $field_post_data['values'][] = sprintf('[thumbnail-%s]', $post->ID);
                        break;
                    case 'id':
                        $field_post_data['values'][] = $post->ID;
                        break;
                    case 'meta':
                        $meta_key = $tag->get_option('value-field-meta-key', '', true);
                        $field_post_data['values'][] = $this->get_formatted_post_meta($post->ID, $meta_key, $tag->name);
                        break;
                    default:
                        $field_post_data['values'][] = $post->post_title;
                        break;
                }
            }

            return apply_filters('wpcf7_'.$tag->name.'_field_post_data', $field_post_data, $posts, $tag, $args);
        }

        /*
         * Replace post attributes from the label string
         */
        private function replace_label_tags($label, $post, $tag_name)
        {
            // Get the default post attributes
            $default_post_atts = array(
                $post->post_title,                                          // %title%
                get_the_date('',  $post),                                   // %date%
                get_the_time('',  $post),                                   // %time%
                $post->post_excerpt,                                        // %excerpt%
                $post->post_name,                                           // %slug%
                get_the_author_meta('display_name', $post->post_author),    // %author%
                get_the_permalink($post->ID),                               // %permalink%
                $post->ID                                                   // %id%
            );

            // Replace all default post tags in the field label
            $label = str_replace($this->label_tags, $default_post_atts, $label);

            // Search and replace all meta fields
            $label = $this->replace_label_tags_meta_fields($label, $post, $tag_name);

            return apply_filters('wpcf7_'.$tag_name.'_label_tag', $label, $post, $default_post_atts, $this->label_tags);
        }

        /*
         * Replace post meta_key tags from the label string
         */
        private function replace_label_tags_meta_fields($label, $post, $tag_name)
        {
            //process meta tags:
            $match_arr = array();

            preg_match_all("/%[^%]*%/", $label, $match_arr);

            if(is_array($match_arr) && count($match_arr) > 0)
            {
                foreach($match_arr as $matches)
                {
                    if(is_array($matches) && count($matches) > 0)
                    {
                        foreach($matches as $match)
                        {
                            $meta_key = trim(str_replace('%', '', $match));

                            $meta_value = $this->get_formatted_post_meta($post->ID, $meta_key, $tag_name);

                            // Replace the post meta keys in the field label
                            $label = str_replace($match, $meta_value, $label);
                        }
                    }
                }
            }

            return $label;
        }

        /*
         * Retrieve post meta field for a post as a string
         */
        private function get_formatted_post_meta($post_id, $meta_key, $tag_name)
        {
            $meta_values = array();
            $post_meta_raw = array();
            $delimiter = apply_filters('wpcf7_'.$tag_name.'_post_meta_delimiter', ', ', $post_id, $meta_key);

            // ACF Integration
            if( class_exists('acf') )
            {
                $post_meta = get_field( $meta_key, $post_id );
                $post_meta_raw = $this->filter_post_meta_values($post_meta_raw, $post_meta);
            }
            // Default post meta data
            else if( metadata_exists('post', $post_id, $meta_key) )
            {
                // Get default post meta
                $post_metas = get_post_meta($post_id, $meta_key, false);

                // More than 1 values are stored
                if(is_array( $post_metas ) && count($post_metas) > 1)
                {
                    foreach($post_metas as $post_meta) {
                        $post_meta_raw = $this->filter_post_meta_values($post_meta_raw, $post_meta);
                    }
                }
                else if (is_array( $post_metas ) && count($post_metas) === 1)
                {
                    $post_meta_raw = $this->filter_post_meta_values($post_meta_raw, $post_metas[0]);
                }
            }

            // Remove duplicate and empty values
            $post_meta_raw = array_filter(array_unique($post_meta_raw, SORT_REGULAR));

            // Sanitize Meta Values
            foreach($post_meta_raw as $post_meta_value)
            {
                // Strip whitespaces
                $post_meta_value = trim( $post_meta_value );

                // Check if the meta value is a valid date
                if(strtotime(str_replace('/', '-', $post_meta_value)) !== false)
                {
                    $meta_values[] = date_i18n(get_option('date_format'), strtotime(str_replace('/', '-', $post_meta_value)));
                }
                // Check if is an array
                else if(is_array($post_meta_value))
                {
                    $meta_values[] = implode(', ', $post_meta_value);
                }
                else if(is_numeric($post_meta_value))
                {
                    $decimals = strlen($post_meta_value) - strrpos($post_meta_value, '.') - 1;

                    // Pypass correct number of decimals
                    $meta_values[] = number_format_i18n( $post_meta_value, $decimals );
                }
                else
                {
                    $meta_values[] = $post_meta_value;
                }
            }

            $meta_values = apply_filters('wpcf7_'.$tag_name.'_formatted_post_meta', $meta_values, $post_id, $meta_key, $post_meta_raw);

            return implode($delimiter, $meta_values);
        }

        /*
         * Sanitize the post meta values
         */
        private function filter_post_meta_values($post_meta_array, $post_meta)
        {
            if(is_array($post_meta) && !$this->array_is_assoc($post_meta)) {
                $post_meta_array[] = array_merge($post_meta_array, $post_meta);
            } else if(!is_array($post_meta) && !is_bool($post_meta)) {
                $post_meta_array[] = $post_meta;
            }

            return $post_meta_array;
        }

        /*
         * CHeck if an Array is Associative
         */
        private function array_is_assoc($arr)
        {
            if (array() === $arr) {
                return false;
            }

            return array_keys($arr) !== range(0, count($arr) - 1);
        }

        /*
         * Replace post attributes and meta_key tags from the label string
         */
        protected function get_replace_meta_tags($meta_string, $post, $tag)
        {
            $meta_data_array = array();

            if(!is_string($meta_string) && !empty($meta_string)) {
                return $meta_data_array;
            }

            $i = 0;
            foreach(explode('|', $meta_string) as $meta_data)
            {
                switch($meta_data)
                {
                    case 'title':
                       $meta_data_array[$i] = $post->post_title;
                        break;
                    case 'date':
                        $meta_data_array[$i] = get_the_date('',  $post);
                        break;
                    case 'time':
                        $meta_data_array[$i] = get_the_time('',  $post);
                        break;
                    case 'slug':
                        $meta_data_array[$i] = $post->post_name;
                        break;
                    case 'author':
                        $meta_data_array[$i] = get_the_author_meta('display_name', $post->post_author);
                        break;
                    case 'permalink':
                        $meta_data_array[$i] = get_the_permalink($post->ID);
                        break;
                    case 'id':
                        $meta_data_array[$i] = $post->ID;
                        break;
                    default:
                        // Custom post meta
                        $meta_data_array[$i] = $this->get_formatted_post_meta($post->ID, $meta_data, $tag->name);
                        break;
                }

                $i++;
            }

            return $meta_data_array;
        }

        /*
         * Template for the Post Field Selection in the Table
         */
        public function get_post_generator_template($args)
        {
            ?>
            <tr>
                <th scope="row"><?php echo esc_html( __( 'Post type', 'cf7-post-fields' ) ); ?></th>
                <td id="<?php echo esc_attr( $args['content'] . '-post-type' ); ?>">
                    <?php
                        $first_post_type = '';
                        foreach(get_post_types(array('public' => true), 'objects') as $post_type)
                        {
                            if(empty($first_post_type)) {
                                $first_post_type = $post_type->name;
                            }

                            $count_posts = wp_count_posts($post_type->name);

                            $count_info = array();
                            if(absint($count_posts->publish) > 0) {
                                $count_info[] = sprintf('%s: %s', esc_html( _x( 'Published', 'post status' ) ), $count_posts->publish);
                            }
                            if(absint($count_posts->pending) > 0) {
                                $count_info[] = sprintf('%s: %s', esc_html( _x( 'Pending', 'post status' ) ), $count_posts->pending);
                            }
                            if(absint($count_posts->draft) > 0) {
                                $count_info[] = sprintf('%s: %s', esc_html( _x( 'Draft', 'post status' ) ), $count_posts->draft);
                            }
                            if(absint($count_posts->future) > 0) {
                                $count_info[] = sprintf('%s: %s', esc_html( _x( 'Scheduled', 'post status' ) ), $count_posts->future);
                            }
                            if(absint($count_posts->inherit) > 0) {
                                $count_info[] = sprintf('%s: %s', esc_html( _x( 'Inherit', 'post status', 'cf7-post-fields' ) ), $count_posts->inherit);
                            }

                            // Generate the label
                            $label = '<b>'.$post_type->label.'</b>';

                            if(count($count_info) > 0) {
                                $label .= ' ('.trim(implode(' | ', $count_info)).')';
                            }

                            echo '
                                <label>
                                    <input type="radio" name="post-type" class="option" value="'.$post_type->name.'" '.checked('post', $post_type->name, false).'>'.$label.'
                                </label>
                                <br>';
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php echo esc_html(__( 'Categories' ) ); ?></th>
                <td>
                    <fieldset id="<?php echo esc_attr( $args['content'] . '-post-taxonomies' ); ?>">
                        <?php
                        if(!empty($first_post_type))
                        {
                            $object_taxonomies = get_object_taxonomies($first_post_type, 'object');

                            if(count($object_taxonomies) > 0)
                            {
                                foreach($object_taxonomies as $taxonomy) {
                                    echo '<input type="text" value="" class="oneline option code" name="'.$taxonomy->name.'" placeholder="'.$taxonomy->label.'"><br>';
                                }

                                _e('Relationship').':';
                                ?>
                                <label><input type="radio" name="tax-relation" class="option" value="OR" checked /><?php echo esc_html( __('OR') ); ?></label>
                                <label><input type="radio" name="tax-relation" class="option" value="AND" /><?php echo esc_html( __('AND') ); ?></label>
                                <?php
                            }
                            else
                            {
                                _e('No categories found.');
                            }
                        }
                        ?>
                    </fieldset>
                    <span class="description">
                        <?php _e('Use pipe-separated term slugs (e.g. united-states|germany|austria) per field.', 'cf7-post-fields'); ?>
                        <?php _e('Combine with ! operator to exclude a term. (e.g. germany|!austria).', 'cf7-post-fields'); ?>
                    </span>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-label' ); ?>"><?php echo esc_html( __( 'Label format', 'cf7-post-fields' ) ); ?></label></th>
                <td>
                    <input type="text" name="values" value="%title%" class="oneline" id="<?php echo esc_attr( $args['content'] . '-label' ); ?>" />
                    <br>
                    <span class="description">
                        <?php echo __('Attributes').': <code>'.implode('</code> <code>', $this->label_tags).'</code> <code>%meta_key%</code>'; ?>
                    </span>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php echo esc_html( __( 'Value field', 'cf7-post-fields' ) ); ?></th>
                <td>
                    <fieldset id="<?php echo esc_attr( $args['content'] . '-value-field' ); ?>">
                        <label><input type="radio" name="value-field" class="option" value="title" checked /><?php echo esc_html( __('Title') ); ?></label>
                        <label><input type="radio" name="value-field" class="option" value="slug" /><?php echo esc_html( __('Slug') ); ?></label>
                        <label><input type="radio" name="value-field" class="option" value="permalink" /><?php echo esc_html( __('Permalink', 'cf7-post-fields') ); ?></label>
                        <br>
                        <label><input type="radio" name="value-field" class="option" value="thumbnail" /><?php echo esc_html( __('Thumbnail') ); ?></label>
                        <label><input type="radio" name="value-field" class="option" value="id" /><?php echo esc_html( __('ID') ); ?></label>
                        <label><input type="radio" name="value-field" class="option" value="meta" /><?php echo esc_html( __('Metadata') ); ?></label>
                        <br>
                        <input id="<?php echo esc_attr( $args['content'] . '-value-field-meta-key' ); ?>" type="text" style="display: none;" class="oneline option code" name="value-field-meta-key" value=""  placeholder="<?php echo esc_html( __('Meta').' '.__('Key') ); ?>">
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php echo esc_html( __( 'Status' ) ); ?></th>
                <td>
                    <label><input type="checkbox" name="publish" class="option" checked /><?php echo esc_html( _x( 'Published', 'post status' ) ); ?></label>
                    <label><input type="checkbox" name="pending" class="option" /><?php echo esc_html( _x( 'Pending', 'post status' ) ); ?></label>
                    <label><input type="checkbox" name="draft" class="option" /><?php echo esc_html( _x( 'Draft', 'post status' ) ); ?></label>
                    <label><input type="checkbox" name="future" class="option" /><?php echo esc_html( _x( 'Scheduled', 'post status' ) ); ?></label>
                    <label><input type="checkbox" name="inherit" class="option" /><?php echo esc_html( _x( 'Inherit', 'post status', 'cf7-post-fields' ) ); ?></label>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php echo esc_html( __( 'Sort order', 'cf7-post-fields' ) ); ?></th>
                <td>
                    <label><input type="radio" name="orderby" class="option" value="title" checked /><?php echo esc_html( __('Title') ); ?></label><br>
                    <label><input type="radio" name="orderby" class="option" value="date" /><?php echo esc_html( __('Date/Time') ); ?></label><br>
                    <label><input type="radio" name="orderby" class="option" value="author" /><?php echo esc_html(__('Author') ); ?></label><br>
                    <label><input type="radio" name="orderby" class="option" value="rand" /><?php echo esc_html( __('Random') ); ?></label><br>
                    <label><input type="radio" name="orderby" class="option" value="menu_order" /><?php echo esc_html( __('Menu order') ); ?></label><br>
                    <label><input type="radio" name="orderby" class="option" value="none" /><?php echo esc_html( __('None') ); ?></label>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-order' ); ?>"><?php echo esc_html( __( 'Order' ) ); ?></label></th>
                <td>
                    <label><input type="radio" name="order" class="option" value="DESC" checked /><?php echo esc_html( __('Descending') ); ?></label>
                    <label><input type="radio" name="order" class="option" value="ASC" /><?php echo esc_html(__('Ascending') ); ?></label>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-posts-number' ); ?>"><?php echo esc_html( __( 'Number of posts', 'cf7-post-fields' ) ); ?></label></th>
                <td>
                    <input type="number" name="posts-number" value="-1" step="1" min="-1" max="500" class="oneline option" id="<?php echo esc_attr( $args['content'] . '-posts-number' ); ?>" />
                    <br>
                    <span class="description">
                        <?php echo _e('The number of posts to show in the field. Use -1 to show all posts.', 'cf7-post-fields'); ?>
                    </span>
                </td>
            </tr>
            <?php
        }

        /*
         * Javascript for the Post Field Selection in the Table
         */
        protected function enqueue_post_field_javascript($args)
        {
            ?>
            <script type="text/javascript">
                jQuery(function($) {

                    $('#<?php echo esc_attr( $args['content'] . '-post-type' ); ?> input[type=radio][name=post-type]').change(function() {

                        var post_type = $(this).val();

                        var tg_name_field = $('#<?php echo esc_attr( $args['content'] . '-name' ); ?>');
                        var tg_tax_fieldset = $('#<?php echo esc_attr( $args['content'] . '-post-taxonomies' ); ?>');

                        // Empty taxonomy fieldset
                        tg_tax_fieldset.empty();

                        // Trigger the change event
                        tg_name_field.trigger('change');

                        // Show loader
                        tg_tax_fieldset.html('<span class="spinner is-active" style="float:none;"></span>');

                        // Ajax request to get all taxonomies from a post type
                        $.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'wpcf7_post_fields_get_taxonomies',
                                security : '<?php echo wp_create_nonce('wpcf7-post-field-tax-nonce'); ?>',
                                post_type: post_type
                            },
                            success: function(result) {
                                tg_tax_fieldset.empty();

                                if(result.success == true) {
                                    var count_tax = 0;
                                    $.each( result.data, function( key, value ) {

                                        var tax_field = $("<input type='text' value=''>").attr("class", "oneline option").attr("name", key).attr("placeholder", value);

                                        // Append the text field to the taxonomy fieldset
                                        tg_tax_fieldset.append(tax_field).append('<br />');

                                        // Hack to trigger the change event from the contact form 7 base
                                        tax_field.change(function() {
                                            tg_name_field.trigger('change');
                                        });

                                        count_tax++;
                                    });

                                    // Categories found
                                    if(count_tax > 0) {
                                        // Add Relationship radios
                                        tg_tax_fieldset.append('<?php echo __('Relationship').': '; ?>');
                                        tg_tax_fieldset.append($('<label>').append($("<input type='radio'>").attr("name", "tax-relation").attr("class", "option").attr("value", 'OR').attr("checked", 'checked')).append('OR'));
                                        tg_tax_fieldset.append('&nbsp;');
                                        tg_tax_fieldset.append($('<label>').append($("<input type='radio'>").attr("name", "tax-relation").attr("class", "option").attr("value", 'AND')).append('AND'));

                                        // Register the change event
                                        tg_tax_fieldset.find("input[name='tax-relation']").change(function() {
                                            tg_name_field.trigger('change');
                                        });

                                        // Trigger the change event now to set the tax-relation
                                        tg_name_field.trigger('change');
                                    }
                                    else {
                                        tg_tax_fieldset.html('<?php  _e('No categories found.'); ?>');
                                    }
                                } else {
                                    alert(response.data);
                                }
                            },
                            error: function() {
                                tg_tax_fieldset.html('<?php  _e('An unknown error occurred'); ?>');
                            }
                        });
                    });

                    $('#<?php echo esc_attr( $args['content'] . '-value-field' ); ?> input[type=radio][name=value-field]').change(function() {

                        var value_field = $(this).val();
                        var tg_value_field_meta = $('#<?php echo esc_attr( $args['content'] . '-value-field-meta-key' ); ?>');

                        if(value_field === 'meta') {
                            tg_value_field_meta.show();
                        } else {
                            tg_value_field_meta.hide().val('').trigger('change');
                        }
                    });
                });
            </script>
            <?php
        }

        /*
         * Sanitize the image size and return the correct value
         */
        protected function sanitize_image_size($image_size, $default = 'wpcf7-post-image')
        {
            if($image_size === false) {
                return $default;
            }

            // Check if the size is valid
            if(in_array($image_size, get_intermediate_image_sizes())) {
                return $image_size;
            }

            // Check if the size has a width and height
            if(strpos($image_size, 'x') !== false)
            {
                $sizes = explode('x', $image_size, 2);
                $width = absint($sizes[0]);
                $height = absint($sizes[1]);

                if(is_numeric($width) && $width > 0 && is_numeric($height) && $height > 0) {
                     return array($width, $height);
                }
            }

            return $default;
        }

        /*
         * Get the image width from the given image size
         */
        protected function get_image_width($size, $default = 80)
        {
            if(is_array($size) && is_numeric($size[0])) {
                return $size[0];
            }

            $size = $this->get_image_size( $size );

            if (is_array($size) && isset( $size['width'] ) ) {
                return $size['width'];
            }

            return $default;
        }

        /**
         * Get size information for all currently-registered image sizes.
         *
         * @global $_wp_additional_image_sizes
         * @uses   get_intermediate_image_sizes()
         * @return array $sizes Data for all currently-registered image sizes.
         */
        protected function get_image_sizes()
        {
            global $_wp_additional_image_sizes;

            $sizes = array();

            foreach ( get_intermediate_image_sizes() as $_size ) {
                if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
                    $sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
                    $sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
                    $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
                } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
                    $sizes[ $_size ] = array(
                        'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
                        'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                        'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
                    );
                }
            }

            return $sizes;
        }

        /**
         * Get size information for a specific image size.
         *
         * @uses   get_image_sizes()
         * @param  string $size The image size for which to retrieve data.
         * @return bool|array $size Size data about an image size or false if the size doesn't exist.
         */
        protected function get_image_size( $size )
        {
            $sizes = $this->get_image_sizes();

            if ( isset( $sizes[ $size ] ) ) {
                return $sizes[ $size ];
            }

            return false;
        }

        /*
         * Register select2 styles
         */
        protected function wpcf7_select2_register_styles()
        {
            wp_register_style('wpcf7-select2', plugin_dir_url($this->plugin_file).'assets/select2/select2.css', array('dashicons'), '4.0.5');
            wp_register_style('wpcf7-post-select2', plugin_dir_url($this->plugin_file).'assets/css/wpcf7-post-image-select2.css', array('wpcf7-select2'), '1.0');
        }

        /*
         * Register select2 scripts
         */
        protected function wpcf7_select2_register_scripts()
        {
            wp_register_script('wpcf7-select2', plugin_dir_url($this->plugin_file).'assets/select2/select2.min.js', array('jquery'), '4.0.5', true );

            // Localize
            $dependencies = array('wpcf7-select2');
            $locale       = str_replace( '_', '-', get_locale() );
            $locale_short = substr( $locale, 0, 2 );
            $locale = file_exists(plugin_dir_path($this->plugin_file).'assets/select2/i18n/'.$locale.'.js') ? $locale : $locale_short;

            if(file_exists(plugin_dir_path($this->plugin_file).'assets/select2/i18n/'.$locale.'.js'))
            {
                wp_register_script( 'wpcf7-select2-i18n', plugin_dir_url($this->plugin_file).'assets/select2/i18n/'.$locale.'.js', array('jquery'), '4.0.5', true );
                $dependencies[] = 'wpcf7-select2-i18n';
            }

            wp_register_script('wpcf7-post-select2', plugin_dir_url($this->plugin_file).'assets/js/jquery-post-select2.js', $dependencies, 1.0, true);
            wp_localize_script('wpcf7-post-select2', 'wpcf7_post_image_select_obj', array(
                'locale'        => $locale
            ));
        }
    }
}