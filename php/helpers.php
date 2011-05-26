<?php

// Helper Functions

// Helper: gets 'Sunday, May 1, 2011, 2:30 pm' style date from ISO-8601
function format_display_date($string) {
    if ($string != '') {
        return date('l, F j, Y, g:i a', strtotime($string));
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

?>
