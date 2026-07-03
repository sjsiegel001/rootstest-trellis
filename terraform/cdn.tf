# Custom domain (cdn.rootstest.de) for the media CloudFront distribution.
#
# CloudFront certs must live in us-east-1 — which is already our provider region,
# so no aliased provider is needed. DNS is managed manually (not Route 53), so
# the validation record has to be added by hand; see the two-step apply in the
# terraform README.

resource "aws_acm_certificate" "cdn" {
  domain_name       = var.cdn_domain
  validation_method = "DNS"

  lifecycle {
    create_before_destroy = true
  }
}

# Gate: blocks until ACM reports the cert as issued (i.e. once you've added the
# validation CNAME from the `acm_validation_record` output to your DNS).
resource "aws_acm_certificate_validation" "cdn" {
  certificate_arn         = aws_acm_certificate.cdn.arn
  validation_record_fqdns = [for o in aws_acm_certificate.cdn.domain_validation_options : o.resource_record_name]
}
