variable "region" {
  description = "AWS region for all resources"
  type        = string
  default     = "us-east-1"
}

variable "project" {
  description = "Short project slug, used in resource names"
  type        = string
  default     = "rootstest"
}

variable "environment" {
  description = "Deployment environment (matches the Trellis environment)"
  type        = string
  default     = "production"
}

variable "instance_type" {
  description = "EC2 instance type for the WordPress web server"
  type        = string
  default     = "t3.small"
}

variable "root_volume_size" {
  description = "Root EBS volume size in GiB"
  type        = number
  default     = 20
}

variable "ssh_public_key_path" {
  description = "Path to the SSH public key installed on the instance (used by Trellis to connect)"
  type        = string
  default     = "~/.ssh/id_ed25519.pub"
}

variable "ssh_ingress_cidr" {
  description = "CIDR allowed to reach SSH (port 22). Lock this to your IP for production."
  type        = string
  default     = "0.0.0.0/0"
}

variable "vpc_cidr" {
  description = "CIDR block for the dedicated VPC"
  type        = string
  default     = "10.0.0.0/16"
}

variable "subnet_cidr" {
  description = "CIDR block for the public subnet"
  type        = string
  default     = "10.0.1.0/24"
}

variable "site_domains" {
  description = "Site domains used to build S3 CORS allowed origins"
  type        = list(string)
  default     = ["rootstest.de", "www.rootstest.de"]
}
