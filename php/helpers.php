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

// Helper: output the timepicker dropdown html
function time_picker_markup() {
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

?>
