<?php

/*
Plugin Name: Event Publisher
Plugin URI: http://www.mikeball.us
Description: A simple event publisher for Wordpress. Event Publisher supports location, start time, end time, as well as the ability to flag an event as 'Featured.'
Version: 0.1
Author: Mike Ball
Author URI: http://www.mikeball.us
License: GPL2
*/

/*
TODO:
    - make timepicker aware of viewport and display dropdown above input if close to viewport bottom edge
    - update jquery ui theme
    - Areas to test
        - display on user front end
        - template logic
        - admin views
*/

// include the file containing most of the necessary functions
//require 'php/functions.php';

// load the template tags
//require 'php/template-tags.php';

// Create an 'EventPublisher' class and constructor if one does not already exist
if (!class_exists('EventPublisher')) {
    class EventPublisher {
        function EventPublisher() { //constructor

            //Actions
            add_action('init', array(&$this, 'register'));
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('save_post', array(&$this, 'save_details'));
            add_action('manage_posts_custom_column', array(&$this, 'events_custom_columns'));

            //Filters
            add_filter('manage_edit-event_columns', array(&$this, 'events_edit_columns'));
        }

        // register 'Event' post type
        public function register() {
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
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title','editor')
            );
          
            register_post_type('event', $args);
        }

        // Set up the meta fields on the post page of the admin
        public function admin_init() {
            add_meta_box('event_location_meta', 'Event Location', array(&$this, 'event_location'), 'event', 'normal', 'low');
            add_meta_box('start_date_meta', 'Event Start Date/Time', array(&$this, 'start_date'), 'event', 'normal', 'low');
            add_meta_box('end_date_meta', 'Event End Date/Time', array(&$this, 'end_date'), 'event', 'normal', 'low');
            add_meta_box('featured_meta', 'Featured Event?', array(&$this, 'featured'), 'event', 'side', 'low');
            $this->print_js();
            $this->print_css();
        }

        // Event location admin form
        public function event_location() {
            global $post;
            $custom = get_post_custom($post->ID);
            $event_location = $custom['event_location'][0];
            ?>
            <p>Enter the event's location. For example:</p>
            <p>333 Street Name<br />
            Philadelphia, PA 19143</p>
            <textarea cols="50" rows="5" name="event_location"><?php echo $event_location; ?></textarea>
            <?php
        }

        // Start date admin form
        public function start_date() {
            global $post;
            $custom = get_post_custom($post->ID);
            $start_date = $custom['start_date'][0];
            ?>
            <label class="ep">Start Date</label>
            <input type="text" name="event_start_date" class="ep ep-datepicker" value="<?php echo $this->format_display_date($start_date); ?>" /> <!--TODO: why doesn't this validate with type="date" -->
            <label class="ep">Start Time</label>
            <input class="ep ep-timepicker" type="text" name="event_start_time" value="<?php echo $this->get_time($start_date); ?>" />
            <?php
            $this->time_picker_markup();
        }

        // End date admin form
        public function end_date() {
            global $post;
            $custom = get_post_custom($post->ID);
            $end_date = $custom['end_date'][0];
            ?>
            <label>End Date</label>
            <input type="text" name="event_end_date" class="ep ep-datepicker" value="<?php echo $this->format_display_date($end_date); ?>" />  
            <label class="ep">End Time</label>
            <input class="ep ep-timepicker" type="text" name="event_end_time" value="<?php echo $this->get_time($end_date); ?>" />
            <?php
            $this->time_picker_markup();
        }

        // A checkbox to make an event 'Featured' 
        public function featured() {
            global $post;
            $custom = get_post_custom($post->ID);
            $featured = $custom['featured'][0];
            ?>
            <label>Flag this event as featured:</label>
            <input type="checkbox" name="featured" value="Featured" <?php if( $featured == 'Featured' ) { echo 'checked="checked"'; } ?> /> 
            <?php
        }

        // Save the details appropriately
        public function save_details() {
            global $post;
         
            update_post_meta($post->ID, 'event_location', $_POST['event_location']);
            update_post_meta($post->ID, 'start_date', $this->set_iso_date($_POST['event_start_date'], $_POST['event_start_time']));
            update_post_meta($post->ID, 'end_date', $this->set_iso_date($_POST['event_end_date'], $_POST['event_end_time']));
            update_post_meta($post->ID, 'featured', $_POST['featured']);
        }

        // Tweak the layout of the 'Events' page to include event list
        public function events_edit_columns($columns) {
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'title' => 'Event',
                'description' => 'Description',
                'start_date' => 'Start Date',
                'end_date' => 'End Date',
                'featured' => 'Featured',
            );
         
            return $columns;
        }

        // Tweak the layout of the 'Events' page to include event list
        public function events_custom_columns($column) {
            global $post;
         
            switch ($column) {
                case 'description':
                    //the_excerpt(); // TODO: figure out why this displays the excerpt twice
                    break;
                case 'start_date':
                    $custom = get_post_custom();
                    echo $this->format_display_date($custom['start_date'][0]);
                    break;
                case 'end_date':
                    $custom = get_post_custom();
                    echo $this->format_display_date($custom['end_date'][0]);
                    break;
                case 'featured':
                    $custom = get_post_custom();
                    echo $custom['featured'][0];
                    break;
              }
        }

        // check to see if we're on the event post editor page in the admin
        private function is_event_editor() {
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
        private function print_js() {
            
            if ($this->is_event_editor() == true) {
                wp_enqueue_script('ep_js', plugins_url('EventPublisher/js/script.js', dirname(__FILE__)), array('jquery'));
                wp_enqueue_script('ep_jq_ui', plugins_url('EventPublisher/js/jquery-ui-1.8.13.custom.min.js', dirname(__FILE__)), array('jquery'));
            }
        }

        // include css
        private function print_css() {

            if ($this->is_event_editor() == true) {
                wp_enqueue_style('ep-jquery-ui', plugins_url('EventPublisher/css/ui-lightness/jquery-ui-1.8.13.custom.css', dirname(__FILE__)));
                wp_enqueue_style('ep-core', plugins_url('EventPublisher/css/event-publisher.css', dirname(__FILE__)));
            }
        }

        // Helper: gets 'Sunday, May 1, 2011, 2:30 pm' style date from ISO-8601
        private function format_display_date($string) {
            if ($string != '') {
                return date('m/j/Y', strtotime($string));
            } else {
                return $string;
            }
        }

        // Helper: returns ISSO style date if a date has been entered, otherwise returns empty string
        private function format_saved_date($post_meta_field) {
            if ($post_meta_field != '') {
                return date('c', strtotime($post_meta_field));
            } else {
                return $post_meta_field;
            }
        }

        // Helper: returns time from date to display in input.ep-timepicker 
        private function get_time($date) {
            if ($date != '') {
                return strftime("%I:%M %p", strtotime($date));
            }
        }

        // Helper: merges time to be saved in db
        private function set_iso_date($date_str, $time_str) {
            $date_time = $date_str . ' ' . $time_str;
            return date('c', strtotime($date_time));
        }

        // Helper: output the timepicker dropdown html
        private function time_picker_markup() {
            echo '
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
                </ol>';
        }
    }
}

$event_publr = new EventPublisher();

?>
