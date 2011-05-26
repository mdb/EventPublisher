<?php

// Functions for use in theme templates

/* ===========================

    Example Usage:

    <?php $events = ep_upcoming_events(); ?>
    <?php foreach( $events as $post ) : setup_postdata($post); ?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
    <?php endforeach; ?>

   =========================== */

// Returns upcoming events whose start time is after today
// Defaults to 20, pass the # of events you want as an argument
function ep_upcoming_events($num_posts = '20') { 

  $todays_date_iso = date("c");

  $args = array(
    'order' => 'ASC',
    'meta_key' => 'start_date',
    'meta_compare' => '>=',
    'meta_value' => $todays_date_iso,
    'orderby' => 'meta_value',
    'numberposts' => $num_posts,
    'post_type' => 'event',
    'post_status' => 'publish'
  );

  return get_posts($args); 
}

// Returns past events whose start time is prior to today
// Defaults to 20, pass the # of events you want as an argument
function ep_past_events($num_posts = '20') { 

  $todays_date_iso = date("c");

  $args = array(
    'order' => 'ASC',
    'meta_key' => 'start_date',
    'meta_compare' => '<=',
    'meta_value' => $todays_date_iso,
    'orderby' => 'meta_value',
    'numberposts' => $num_posts,
    'post_type' => 'event',
    'post_status' => 'publish'
  );

  return get_posts($args); 
}

// Returns 'Featured' Events, independent of start date 
// Defaults to 1
function ep_featured_events($num_posts = '1') {

  $args = array(
    'order' => 'ASC',
    'meta_key' => 'featured',
    'meta_compare' => '==',
    'meta_value' => 'Featured',
    'numberposts' => $num_posts,
    'post_type' => 'event',
    'post_status' => 'publish'
  );

  return get_posts($args); 
}

?>
