<?php

// Main Plugin Functions

// include the helpers
require 'helpers.php';

// Register 'Event' post type
function ep_register() {

    $labels = array(
        'name' => _x('Events', 'post type general name'),
        'singular_name' => _x('Event', 'post type singular name'),
        'add_new' => _x('Add New', 'Event'),
        'add_new_item' => __('Add New Event'),
        'edit_item' => __('Edit Event'),
        'new_item' => __('New Event'),
        'view_item' => __('View Event'),
        'search_items' => __('Search Events'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','editor','thumbnail')
    );
  
    register_post_type('event', $args);
}

// Set up the meta fields on the post page of the admin
function ep_admin_init() {
    add_meta_box("event_location_meta", "Event Location", "ep_event_location", "event", "normal", "low");
    add_meta_box("start_date_meta", "Event Start Date/Time", "ep_start_date", "event", "normal", "low");
    add_meta_box("end_date_meta", "Event End Date/Time", "ep_end_date", "event", "normal", "low");
    add_meta_box("featured_meta", "Featured Event?", "ep_featured", "event", "side", "low");
    ep_print_js();
    ep_print_css();
}

// Event location admin form
function ep_event_location() {
    global $post;
    $custom = get_post_custom($post->ID);
    $event_location = $custom["event_location"][0];
    ?>
    <p>Enter the event's location. For example:</p>
    <p>333 Street Name<br />
    Philadelphia, PA 19143</p>
    <textarea cols="50" rows="5" name="event_location"><?php echo $event_location; ?></textarea>
    <?php
}

// Start date admin form
function ep_start_date() {
    global $post;
    $custom = get_post_custom($post->ID);
    $start_date = $custom["start_date"][0];
    ?>
    <label class="ep">Start Date</label>
    <input type="text" name="event_start_date" class="ep ep-datepicker" value="<?php echo format_display_date($start_date); ?>" /> <!--TODO: why doesn't this validate with type="date" -->
    <label class="ep">Start Time</label>
    <input class="ep ep-timepicker" type="text" name="event_start_time" value="<?php echo get_time($start_date); ?>" />
    <ol class="ep ep-timepicker">
        <li>12:00 am</li>
        <li>12:30 am</li>
        <li>1:00 am</li>
        <li>1:30 am</li>
        <li>2:00 am</li>
        <li>2:30 am</li>
        <li>3:00 am</li>
        <li>3:30 am</li>
        <li>4:00 am</li>
        <li>4:30 am</li>
        <li>5:00 am</li>
        <li>5:30 am</li>
        <li>6:00 am</li>
        <li>6:30 am</li>
        <li>7:00 am</li>
        <li>7:30 am</li>
        <li>8:00 am</li>
        <li>8:30 am</li>
        <li>9:00 am</li>
        <li>9:30 am</li>
        <li>10:00 am</li>
        <li>10:30 am</li>
        <li>11:00 am</li>
        <li>11:30 am</li>
        <li>12:00 pm</li>
        <li>12:30 pm</li>
        <li>1:00 pm</li>
        <li>1:30 pm</li>
        <li>2:00 pm</li>
        <li>2:30 pm</li>
        <li>3:00 pm</li>
        <li>3:30 pm</li>
        <li>4:00 pm</li>
        <li>4:30 pm</li>
        <li>5:00 pm</li>
        <li>5:30 pm</li>
        <li>6:00 pm</li>
        <li>6:30 pm</li>
        <li>7:00 pm</li>
        <li>7:30 pm</li>
        <li>8:00 pm</li>
        <li>8:30 pm</li>
        <li>9:00 pm</li>
        <li>9:30 pm</li>
        <li>10:00 pm</li>
        <li>10:30 pm</li>
        <li>11:00 pm</li>
        <li>11:30 pm</li>
    </ol>
    <?php
}

// End date admin form
function ep_end_date() {
    global $post;
    $custom = get_post_custom($post->ID);
    $end_date = $custom['end_date'][0];
    ?>
    <label>End Date</label>
    <input type="text" name="event_end_date" class="ep ep-datepicker" value="<?php echo format_display_date($end_date); ?>" />  
    <label class="ep">End Time</label>
    <input class="ep ep-timepicker" type="text" name="event_end_time" value="<?php echo get_time($end_date); ?>" />
    <ol class="ep ep-timepicker">
        <li>12:00 am</li>
        <li>12:30 am</li>
        <li>1:00 am</li>
        <li>1:30 am</li>
        <li>2:00 am</li>
        <li>2:30 am</li>
        <li>3:00 am</li>
        <li>3:30 am</li>
        <li>4:00 am</li>
        <li>4:30 am</li>
        <li>5:00 am</li>
        <li>5:30 am</li>
        <li>6:00 am</li>
        <li>6:30 am</li>
        <li>7:00 am</li>
        <li>7:30 am</li>
        <li>8:00 am</li>
        <li>8:30 am</li>
        <li>9:00 am</li>
        <li>9:30 am</li>
        <li>10:00 am</li>
        <li>10:30 am</li>
        <li>11:00 am</li>
        <li>11:30 am</li>
        <li>12:00 pm</li>
        <li>12:30 pm</li>
        <li>1:00 pm</li>
        <li>1:30 pm</li>
        <li>2:00 pm</li>
        <li>2:30 pm</li>
        <li>3:00 pm</li>
        <li>3:30 pm</li>
        <li>4:00 pm</li>
        <li>4:30 pm</li>
        <li>5:00 pm</li>
        <li>5:30 pm</li>
        <li>6:00 pm</li>
        <li>6:30 pm</li>
        <li>7:00 pm</li>
        <li>7:30 pm</li>
        <li>8:00 pm</li>
        <li>8:30 pm</li>
        <li>9:00 pm</li>
        <li>9:30 pm</li>
        <li>10:00 pm</li>
        <li>10:30 pm</li>
        <li>11:00 pm</li>
        <li>11:30 pm</li>
    </ol>
    <?php
}

// A checkbox to make an event 'Featured' 
function ep_featured() {
    global $post;
    $custom = get_post_custom($post->ID);
    $featured = $custom['featured'][0];
    ?>
    <p>Do you want to make this event the featured Save the Date on the homepage?</p>
    <p>Note that only one event may be 'Featured' at a time.</p>
    <label>Yes, feature this event:</label>
    <input type="checkbox" name="featured" value="Featured" <?php if( $featured == 'Featured' ) { echo 'checked="checked"'; } ?> /> 
    <?php
}

// Save the details appropriately
function ep_save_details() {
    global $post;
 
    update_post_meta($post->ID, "event_location", $_POST["event_location"]);
    update_post_meta($post->ID, "start_date", set_iso_date($_POST["event_start_date"], $_POST['event_start_time']));
    update_post_meta($post->ID, "end_date", set_iso_date($_POST["event_end_date"], $_POST['event_end_time']));
    update_post_meta($post->ID, "featured", $_POST["featured"]);
}

// Tweak the layout of the 'Events' page to include event list
function ep_events_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Event",
        "description" => "Description",
        "start_date" => "Start Date",
        "end_date" => "End Date",
        "featured" => "Featured",
    );
 
    return $columns;
}

// Tweak the layout of the 'Events' page to include event list
function ep_events_custom_columns($column) {
    global $post;
 
    switch ($column) {
        case "description":
            //the_excerpt(); // TODO: figure out why this displays the excerpt twice
            break;
        case "start_date":
            $custom = get_post_custom();
            echo format_display_date($custom["start_date"][0]);
            break;
        case "end_date":
            $custom = get_post_custom();
            echo format_display_date($custom["end_date"][0]);
            break;
        case "featured":
            $custom = get_post_custom();
            echo $custom["featured"][0];
            break;
      }
}

// check to see if we're on the event post editor page in the admin
function ep_is_event_editor() {
    global $pagenow, $typenow;
 
    // Sometimes $typenow is not available, so check and get it if needed.
    if (empty($typenow) && !empty($_GET['post'])) {
        $post = get_post($_GET['post']);
        $typenow = $post->post_type;
    }   

    if (($pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow == 'event') {
        return true;
    } else {
        return false;
    }
}

// include javascript
function ep_print_js() {
    
    if (ep_is_event_editor() == true) {
        wp_enqueue_script('ep_js', plugins_url('js/script.js', dirname(__FILE__)), array('jquery'));
        wp_enqueue_script('ep_jq_ui', plugins_url('js/jquery-ui-1.8.13.custom.min.js', dirname(__FILE__)), array('jquery'));
    }
}

// include css
function ep_print_css() {

    if (ep_is_event_editor() == true) {
        wp_enqueue_style('ep-jquery-ui', plugins_url('css/ui-lightness/jquery-ui-1.8.13.custom.css', dirname(__FILE__)));
        wp_enqueue_style('ep-core', plugins_url('css/event-publisher.css', dirname(__FILE__)));
    }
}
?>
