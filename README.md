# EventPublisher #

EventPublisher is simple Wordpress plugin that enables the publication of events via the Wordpress admin. It utilizes the jQuery UI datepicker and leverages Wordpress's custom post type features to create an Event post type in addition to Wordpress's built-in Posts and Pages.

## Features ##

EventPublisher offers the following:

- Creates an "Event" custom post type alongside Wordpress's "Posts" and "Pages."
- Fields to house event title, event description, event location, event start date/time, and event end date/time. Users can assign a "Featured" event, in effect flagging the event for more prominent promotion on the front end.
- Basic template tags for calling and displaying Events in your Wordpress theme templates.

## Installation ##

- Put the EventPublisher folder in your Wordpress site's wp-content/plugins/ directory.
- Visit your site's Plugins manager page within the Wordpress admin (wp-admin/plugins.php)
- Locate "Event Publisher" amongst the list of available plugins and click "Activate."

## How to publish an event ##

- Log in to your Wordpress site's admin (http://yoursite.com/wp-admin).
- Locate and click "Events" in the menu within the left column.
- Click "Add new."
- Enter a title, description, event location, event start date/time, and event end date/time.
- If you'd like to flag your event as "Featured," tick the Featured Event checkbox in the right column.
- Click "Publish," just as you would with an normal Wordpress blog post.

## How to display your events in your Wordpress theme templates ##

### Upcoming Events

A basic example of how to call the list of upcoming events, which defaults to displaying the next 20 events:

    <ul class="upcoming-events">
    <?php $events = ep_upcoming_events(); ?>
    <?php foreach( $events as $post ) : setup_postdata($post); ?>
        <?php
            $event_location = get_post_meta($post->ID, 'event_location', true);
            $start_date = get_post_meta($post->ID, 'start_date', true);
            $end_date = get_post_meta($post->ID, 'end_date', true);
        ?>
        <li>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <dl class="event-dates">
                <dt>Start Date:</dt>
                <dd><?php echo date('m/j/Y', strtotime($start_date)); ?></dd>
                <dt>End Date:</dt>
                <dd><?php echo date('m/j/Y', strtotime($end_date)); ?></dd>
            </dl>
            <address class="location"><?php echo $event_location; ?></address>
            <?php the_content(); ?>
        </li>
    <?php endforeach; ?>
    </ul>

Alternatively, you can do the same thing as the above code, but only display the next 3 events like so:

    <?php $events = ep_upcoming_events(3); ?>

### Past Events

    <?php $past_events = ep_past_events(); ?>

Or, to limit the display to the last 3 events:

    <?php $past_events = ep_past_events(3); ?>

### Featured Events

Calling the Featured events defaults to displaying the next upcoming Featured event:

    <?php $featured_events = ep_featured_events(); ?>
