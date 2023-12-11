<div class="control-box">
<fieldset>
<legend><?php echo $description; ?></legend>

<table class="form-table">
<tbody>
	<tr>
	<th scope="row"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></th>
	<td>
		<fieldset>
		<legend class="screen-reader-text"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></legend>
		<label><input type="checkbox" name="required" /> <?php echo esc_html( __( 'Required field', 'contact-form-7' ) ); ?></label>
		</fieldset>
	</td>
	</tr>

	<tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?></label></th>
        <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
	</tr>

    <?php $this->get_post_generator_template($args); ?>

    <tr>
        <th scope="row"><?php echo esc_html( __( 'Image sizes' ) ); ?></th>
        <td id="<?php echo esc_attr( $args['content'] . '-image-size' ); ?>">
            <input type="hidden" class="option" name="image-size" value="wpcf7-post-image">
            <?php
                foreach($this->get_image_sizes() as $key => $value)
                {
                    $checked = checked('wpcf7-post-image', $key, false);
                    $dimension = $value['width'].' x '.$value['height'];

                    printf('<label><input type="radio" name="size-name" value="%s" %s><b>%s</b> (%s)</label><br>', $key, $checked, $key, $dimension);
                }
            ?>
            <label>
                <input type="radio" name="size-name" value="custom"><b><?php _e('Custom Structure'); ?></b>
            </label>
            <div style="padding-top: 4px;" class="<?php echo esc_attr( $args['content'] . '-custom-image-size' ); ?>">
                <label style="display: inline-block; min-width: 3em;" for="<?php echo esc_attr( $args['content'] . '-image-width' ); ?>"><?php echo esc_html( __('Width') ); ?></label>
                <input type="number" placeholder="80px" name="image-width" min="1" max="1024" class="tg-name" id="<?php echo esc_attr( $args['content'] . '-image-width' ); ?>" />
                <br>
                <label style="display: inline-block; min-width: 3em;" for="<?php echo esc_attr( $args['content'] . '-image-height' ); ?>"><?php echo esc_html( __('Height') ); ?></label>
                <input type="number" placeholder="80px" name="image-height" min="1" max="1024" class="tg-name" id="<?php echo esc_attr( $args['content'] . '-image-height' ); ?>" />
            </div>
        </td>
    </tr>

    <tr>
	    <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-excerpt-lenght' ); ?>"><?php echo esc_html( __( 'Excerpt Lenght', 'cf7-post-fields' ) ); ?></label></th>
	    <td>
            <input type="number" name="excerpt-lenght" placeholder="55" min="0" max="150" class="oneline option" id="<?php echo esc_attr( $args['content'] . '-excerpt-lenght' ); ?>" />
            <br>
            <span class="description">
                <?php _e('Define the number of words for the excerpt. Default "55".', 'cf7-post-fields'); ?>
            </span>
        </td>
	</tr>

    <tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-meta-data' ); ?>"><?php echo esc_html( __( 'Metadata' ) ); ?></label></th>
        <td>
            <input type="text" name="meta-data" class="oneline option" id="<?php echo esc_attr( $args['content'] . '-meta-data' ); ?>" />
            <br>
            <span class="description">
                <?php printf(__('Use pipe-separated post attributes (e.g. %s|meta_key) per field.', 'cf7-post-fields'), implode('|', $this->meta_tags)); ?>
            </span>
        </td>
	</tr>

	<tr>
        <th scope="row"><?php echo esc_html( __( 'Options', 'contact-form-7' ) ); ?></th>
        <td>
            <fieldset>
                <legend class="screen-reader-text"><?php echo esc_html( __( 'Options', 'contact-form-7' ) ); ?></legend>
                <label><input type="checkbox" name="label_first" class="option" /> <?php echo esc_html( __( 'Put a label first, a checkbox last', 'contact-form-7' ) ); ?></label><br>
                <label><input type="checkbox" name="use_label_element" class="option" /> <?php echo esc_html( __( 'Wrap each item with label element', 'contact-form-7' ) ); ?></label>
    <?php if ( 'post_image_checkbox' == $type ) : ?>
            <br><label><input type="checkbox" name="exclusive" class="option" /> <?php echo esc_html( __( 'Make checkboxes exclusive', 'contact-form-7' ) ); ?></label>
    <?php endif; ?>
            </fieldset>
        </td>
	</tr>

	<tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'contact-form-7' ) ); ?></label></th>
        <td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" /></td>
	</tr>

	<tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'contact-form-7' ) ); ?></label></th>
        <td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
	</tr>

</tbody>
</table>
</fieldset>
</div>

<div class="insert-box">
	<input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

	<div class="submitbox">
	<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
	</div>

	<br class="clear" />

	<p class="description mail-tag"><label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'contact-form-7' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?><input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" /></label></p>
</div>