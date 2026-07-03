terraform {
  required_version = ">= 1.6"

  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 5.60"
    }
  }
}

provider "aws" {
  region = var.region

  # Tags every taggable resource in the stack (default_tags propagates to all
  # resources that support tags). Child resources that can't be tagged
  # (route-table associations, inline IAM policies, S3 sub-configs, the
  # CloudFront OAC) hang off a tagged parent, so nothing is orphaned.
  default_tags {
    tags = local.common_tags
  }
}
