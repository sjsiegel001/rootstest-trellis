output "ec2_public_ip" {
  description = "Elastic IP — put this in trellis/hosts/production and your DNS A record"
  value       = aws_eip.web.public_ip
}

output "ec2_public_dns" {
  description = "Public DNS name of the instance"
  value       = aws_instance.web.public_dns
}

output "s3_uploads_bucket" {
  description = "S3_UPLOADS_BUCKET for humanmade/s3-uploads"
  value       = aws_s3_bucket.uploads.bucket
}

output "s3_uploads_region" {
  description = "S3_UPLOADS_REGION"
  value       = var.region
}

output "cloudfront_domain" {
  description = "S3_UPLOADS_BUCKET_URL — serve media through this CDN URL"
  value       = "https://${aws_cloudfront_distribution.uploads.domain_name}"
}

output "acm_validation_record" {
  description = "Add this CNAME to DNS to validate the CDN certificate"
  value = [for o in aws_acm_certificate.cdn.domain_validation_options : {
    name  = o.resource_record_name
    type  = o.resource_record_type
    value = o.resource_record_value
  }]
}

output "cdn_cname_target" {
  description = "Point cdn.rootstest.de (CNAME) at this once the cert is issued"
  value       = aws_cloudfront_distribution.uploads.domain_name
}

output "iam_role_name" {
  description = "Instance-profile role backing S3 access (no static keys)"
  value       = aws_iam_role.wp.name
}
