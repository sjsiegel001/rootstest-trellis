<?php

/**
 * Configuration overrides for WP_ENV === 'production'
 */

use Roots\WPConfig\Config;

/**
 * Media offload to S3 via humanmade/s3-uploads.
 *
 * Credentials come from the EC2 instance's IAM role (rootstest-production-wp),
 * so no access keys are stored anywhere. Infra is managed in ../terraform.
 */
Config::define('S3_UPLOADS_BUCKET', 'rootstest-production-uploads-263441240688');
Config::define('S3_UPLOADS_REGION', 'us-east-1');
Config::define('S3_UPLOADS_USE_INSTANCE_PROFILE', true);

// Serve media through the CloudFront distribution via the custom CDN domain
// (private bucket, read via OAC). Requires DNS: cdn.rootstest.de CNAME -> the
// distribution domain (d28refu5zcdbcn.cloudfront.net).
Config::define('S3_UPLOADS_BUCKET_URL', 'https://cdn.rootstest.de');

// The bucket has ACLs disabled (BucketOwnerEnforced). 'bucket-owner-full-control'
// is the only canned ACL S3 accepts in that mode; it keeps objects private
// (public reads happen only through CloudFront), unlike the plugin's
// 'public-read' default which would fail with AccessControlListNotSupported.
Config::define('S3_UPLOADS_OBJECT_ACL', 'bucket-owner-full-control');
