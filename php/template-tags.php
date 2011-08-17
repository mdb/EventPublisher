<?php

// Functions for use in theme templates

/* ===========================

    Example Usage:

    <?php $events = ep_upcoming_events(); ?>
    <?php foreach( $events->posts as $post ) : setup_postdata($post); ?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
    <?php endforeach; ?>

   =========================== */

// Returns upcoming events whose start time is after today
// Defaults to 20, pass the # of events you want as an argument
function ep_upcoming_events() { 

  $todays_date_iso = date("c");
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $ppp = get_option('posts_per_page');

  if (!is_paged()) {
    $custom_offset = 0;
  } else {
    $custom_offset = $ppp * ($paged - 1);
  }

  $args = array(
    'order' => 'ASC',
    'meta_key' => 'start_date',
    'meta_compare' => '>=',
    'meta_value' => $todays_date_iso,
    'orderby' => 'meta_value',
    'numberposts' => $ppp,
    'post_type' => 'event',
    'offset' => $custom_offset,
    'post_status' => 'publish',
    'paged' => $paged
  );

  return new WP_Query($args); 
}

// Returns past events whose start time is prior to today
// Defaults to 20, pass the # of events you want as an argument
function ep_past_events() { 

  $todays_date_iso = date("c");
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $ppp = get_option('posts_per_page');

  if (!is_paged()) {
    $custom_offset = 0;
  } else {
    $custom_offset = $ppp * ($paged - 1);
  }

  $args = array(
    'order' => 'ASC',
    'meta_key' => 'start_date',
    'meta_compare' => '<=',
    'meta_value' => $todays_date_iso,
    'orderby' => 'meta_value',
    'numberposts' => $ppp,
    'post_type' => 'event',
    'offset' => $custom_offset,
    'post_status' => 'publish',
    'paged' => $paged
  );

  return new WP_Query($args);
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

function ep_get_events($upcoming_or_past = 'upcoming', $num_posts = '10') { 

  $todays_date_iso = date("c");

  if ($upcoming_or_past == 'past') {
    $meta_compare = '<=';
  } else if ($upcoming_or_past == 'upcoming') {
    $meta_compare = '>=';
  } else {
    $meta_compare = '==';
  }

  $args = array(
    'order' => 'ASC',
    'meta_key' => 'start_date',
    'meta_compare' => $meta_compare,
    'meta_value' => $todays_date_iso,
    'orderby' => 'meta_value',
    'numberposts' => $num_posts,
    'post_type' => 'event',
    'post_status' => 'publish'
  );

  return get_posts($args); 
}

?>
