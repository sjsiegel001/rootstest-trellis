# Nightly MySQL backups bucket. Gzipped dumps land under mysql/, transition to a
# cheaper storage tier after 30 days, and expire after a year.

resource "aws_s3_bucket" "backups" {
  bucket = "${var.project}-${var.environment}-backups-${data.aws_caller_identity.current.account_id}"
}

resource "aws_s3_bucket_ownership_controls" "backups" {
  bucket = aws_s3_bucket.backups.id

  rule {
    object_ownership = "BucketOwnerEnforced"
  }
}

resource "aws_s3_bucket_public_access_block" "backups" {
  bucket                  = aws_s3_bucket.backups.id
  block_public_acls       = true
  block_public_policy     = true
  ignore_public_acls      = true
  restrict_public_buckets = true
}

resource "aws_s3_bucket_lifecycle_configuration" "backups" {
  bucket = aws_s3_bucket.backups.id

  rule {
    id     = "tier-and-expire"
    status = "Enabled"

    filter {
      prefix = "mysql/"
    }

    # Move to Infrequent Access (cheaper, still instant retrieval) after 30 days.
    transition {
      days          = 30
      storage_class = "STANDARD_IA"
    }

    expiration {
      days = 365
    }
  }
}

# Allow the EC2 instance role to write backups (no static keys on the server).
data "aws_iam_policy_document" "s3_backups" {
  statement {
    sid       = "WriteBackups"
    actions   = ["s3:PutObject"]
    resources = ["${aws_s3_bucket.backups.arn}/*"]
  }

  statement {
    sid       = "ListBackups"
    actions   = ["s3:ListBucket"]
    resources = [aws_s3_bucket.backups.arn]
  }
}

resource "aws_iam_role_policy" "s3_backups" {
  name   = "s3-backups"
  role   = aws_iam_role.wp.id
  policy = data.aws_iam_policy_document.s3_backups.json
}

output "backups_bucket" {
  description = "MySQL backups bucket — set as mysql_backup_bucket in Trellis"
  value       = aws_s3_bucket.backups.bucket
}
