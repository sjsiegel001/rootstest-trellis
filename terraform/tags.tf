locals {
  # Applied to every taggable resource via the provider's default_tags below.
  # Find/clean up the whole stack in AWS Resource Groups or Tag Editor by
  # filtering on Stack = "rootstest-production" (or Project = "rootstest").
  common_tags = {
    Project     = var.project
    Environment = var.environment
    Stack       = "${var.project}-${var.environment}"
    ManagedBy   = "terraform"
    Repository  = "sjsiegel001/rootstest-trellis"
  }
}
