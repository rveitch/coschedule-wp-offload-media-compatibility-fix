<?php
/*
Plugin Name: CoSchedule -> WP Offload Media Compatibility Fix
Plugin URI: https://github.com/rveitch/coschedule-wp-offload-media-compatibility-fix
Description: Fixes a CoSchedule syncing compatibility issue with CoSchedule when using the WP Offload Media plugin
Author: Ryan Veitch
Version: 1.0
Author URI: http://veitchdigital.com/
*/

if ( class_exists( 'TM_CoSchedule' ) ) {
    add_filter( 'tm_coschedule_get_attachments_content', 'make_wp_offload_media_compatible_with_coschedule' );
}

/*
 * Fixes an data sync issue where CoSchedule post sync receives incorrect post content image urls
 * that occurs when using the WP Offload Media plugin with the 'Remove Files From Server' option enabled.
 * The WordPress content still references the local file storage url, however the image will not be accessible
 * as WP Offload Media has deleted the local file. It appears to leave the db references intact due to an option
 * that allows the files to be pulled back down from S3 and replaced back into local storage.
 *
 * This fix works by applying the `the_content` filter to the post content, which allows the
 * WP Offload Media plugin filters to 'properly' rewrite the image urls to their S3 addresses.
 * This is necessary since they do not have any content filters on `get_post()`.
*/
function make_wp_offload_media_compatible_with_coschedule( $post_content ) {
    return apply_filters( 'the_content', $post_content );
}
