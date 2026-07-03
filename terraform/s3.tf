locals {
  # Bucket names are globally unique; suffixing with the account id avoids collisions.
  uploads_bucket = "${var.project}-${var.environment}-uploads-${data.aws_caller_identity.current.account_id}"
}

resource "aws_s3_bucket" "uploads" {
  bucket = local.uploads_bucket
}

# Disable ACLs entirely (modern best practice). Access is granted by bucket policy.
resource "aws_s3_bucket_ownership_controls" "uploads" {
  bucket = aws_s3_bucket.uploads.id

  rule {
    object_ownership = "BucketOwnerEnforced"
  }
}

# Bucket stays fully private; CloudFront (OAC) is the only public reader.
resource "aws_s3_bucket_public_access_block" "uploads" {
  bucket                  = aws_s3_bucket.uploads.id
  block_public_acls       = true
  block_public_policy     = true
  ignore_public_acls      = true
  restrict_public_buckets = true
}

resource "aws_s3_bucket_cors_configuration" "uploads" {
  bucket = aws_s3_bucket.uploads.id

  cors_rule {
    allowed_methods = ["GET", "HEAD"]
    allowed_origins = [for d in var.site_domains : "https://${d}"]
    allowed_headers = ["*"]
    max_age_seconds = 3000
  }
}
