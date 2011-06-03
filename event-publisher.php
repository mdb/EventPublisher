<?php

/*
Plugin Name: Event Publisher
Plugin URI: http://www.mikeball.us
Description: A simple event publisher for wordpress. Event Publisher supports location, start time, end time, as well as the abilityt to flag an event as 'Featured.'
Version: 0.1
Author: Mike Ball
Author URI: http://www.mikeball.us
License: GPL2
*/

/*
TODO:
    - create /php directory inside of which is actions.php, helpers.php, and filters.php
    - figure out how to utilize date picker
*/

// include the file containing most of the necessary functions
require 'php/functions.php';

// Create an 'EventPublisher' class and constructor if one does not already exist
if (!class_exists("EventPublisher")) {
    class EventPublisher {
        function EventPublisher() { //constructor

        }
    }
}

// Instantiate the EventPublisher class
if (class_exists("EventPublisher")) {
    $event_publr = new EventPublisher();
}

// A placeholder for actions and filters   
if (isset($event_publr)) {

    //Actions
    add_action('init', 'ep_register');
    add_action("admin_init", "ep_admin_init");
    add_action('save_post', 'ep_save_details');
    add_action("manage_posts_custom_column",  "ep_events_custom_columns");

    //Filters
    add_filter("manage_edit-event_columns", "ep_events_edit_columns");
}

?>
