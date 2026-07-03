data "aws_caller_identity" "current" {}

# Trust policy: the EC2 instance assumes this role via its instance profile.
data "aws_iam_policy_document" "ec2_assume" {
  statement {
    actions = ["sts:AssumeRole"]
    principals {
      type        = "Service"
      identifiers = ["ec2.amazonaws.com"]
    }
  }
}

resource "aws_iam_role" "wp" {
  name               = "${var.project}-${var.environment}-wp"
  assume_role_policy = data.aws_iam_policy_document.ec2_assume.json
}

# Least-privilege access to the uploads bucket only.
# humanmade/s3-uploads uses these when S3_UPLOADS_USE_INSTANCE_PROFILE is on,
# so no access keys ever live on the server.
data "aws_iam_policy_document" "s3_uploads" {
  statement {
    sid       = "ListBucket"
    actions   = ["s3:ListBucket", "s3:GetBucketLocation"]
    resources = [aws_s3_bucket.uploads.arn]
  }

  statement {
    sid       = "ObjectReadWrite"
    actions   = ["s3:GetObject", "s3:PutObject", "s3:DeleteObject"]
    resources = ["${aws_s3_bucket.uploads.arn}/*"]
  }
}

resource "aws_iam_role_policy" "s3_uploads" {
  name   = "s3-uploads"
  role   = aws_iam_role.wp.id
  policy = data.aws_iam_policy_document.s3_uploads.json
}

resource "aws_iam_instance_profile" "wp" {
  name = "${var.project}-${var.environment}-wp"
  role = aws_iam_role.wp.name
}
