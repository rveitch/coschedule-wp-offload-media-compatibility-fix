## CoSchedule -> WP Offload Media Compatibility Fix

Fixes a data sync issue where CoSchedule post sync receives incorrect post content image urls that occurs when using the WP Offload Media plugin with the "Remove Files From Server" option enabled.

The WordPress content still references the local file storage url, however the image will not be accessible as WP Offload Media has deleted the local file. It appears to leave the db references intact due to an option that allows the files to be pulled back down from S3 and replaced back into local storage.

This fix works by applying the `the_content` filter to the post content, which allows the WP Offload Media plugin filters to 'properly' rewrite the image urls to their S3 addresses. This is necessary since they do not have any content filters on `get_post()`.

> Note: Requires CoSchedule plugin version 3.2.3 or greater
