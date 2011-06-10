<?php

// Helper Functions

// Helper: gets 'Sunday, May 1, 2011, 2:30 pm' style date from ISO-8601
function format_display_date($string) {
    if ($string != '') {
        return date('m/j/Y', strtotime($string));
    } else {
        return $string;
    }
}

// Helper: returns ISSO style date if a date has been entered, otherwise returns empty string
function format_saved_date($post_meta_field) {
    if ($post_meta_field != '') {
        return date('c', strtotime($post_meta_field));
    } else {
        return $post_meta_field;
    }
}

// Helper: returns time from date to display in input.ep-timepicker 
function get_time($date) {
    if ($date != '') {
        return strftime("%I:%M %p", strtotime($date));
    }
}

// Helper: merges time to be saved in db
function set_iso_date($date_str, $time_str) {
    $date_time = $date_str . ' ' . $time_str;
    return date('c', strtotime($date_time));
}

?>
