<?php
class formed_Widget extends WP_Widget
{
  function formed_Widget()
  {
      $widget_ops = array('classname' => 'formed_Widget', 'description' => 'Use a form');
      $this->WP_Widget('formed_Widget', 'Form', $widget_ops);
  }

  function form($instance)
  {
  	global $wpdb;
    $instance = wp_parse_args((array) $instance, array( 'id' => '', ));
    $text = stripslashes($instance['text']);
    $table_builder = $wpdb->prefix . "formed_builder";
	$myforms = $wpdb->get_results( "SELECT id,name,description FROM $table_builder ORDER BY id" );	
    global $wpdb, $table_subs, $table_builder;
    ?>
    <select id="<?= $this->get_field_id('id');?>" name="<?= $this->get_field_name('id'); ?>">
    	<option value="" <?php selected($instance['id'],'');?>>Select a Form</option>
    <?php foreach ($myforms as $row) { ?>
		<option value="<?= $row->id; ?>" <?php selected( $instance['id'],"$row->id");?>><?= $row->name; ?> - <?= $row->description; ?> </option>
	<?php } ?>
	</select>
    <?php
}

function update($new_instance, $old_instance)
{
    $instance = $old_instance;
    $instance['id'] = $new_instance['id'];
    return $instance;
}

function widget($args, $instance)
{
    formed($instance['id']);
}
}

add_action( 'widgets_init', create_function('', 'return register_widget("formed_Widget");') );