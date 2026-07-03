# SES for transactional mail (contact form, WordPress notifications). Trellis's
# msmtp relays through the SES SMTP endpoint using the IAM user credentials below.

variable "mail_domain" {
  description = "Domain to send mail from (must be SES-verified)"
  type        = string
  default     = "rootstest.de"
}

resource "aws_ses_domain_identity" "main" {
  domain = var.mail_domain
}

resource "aws_ses_domain_dkim" "main" {
  domain = aws_ses_domain_identity.main.domain
}

# IAM user whose access key doubles as the SES SMTP username/password.
resource "aws_iam_user" "ses_smtp" {
  name = "${var.project}-${var.environment}-ses-smtp"
}

data "aws_iam_policy_document" "ses_send" {
  statement {
    actions   = ["ses:SendRawEmail", "ses:SendEmail"]
    resources = ["*"]
  }
}

resource "aws_iam_user_policy" "ses_send" {
  name   = "ses-send"
  user   = aws_iam_user.ses_smtp.name
  policy = data.aws_iam_policy_document.ses_send.json
}

resource "aws_iam_access_key" "ses_smtp" {
  user = aws_iam_user.ses_smtp.name
}

# --- DNS records to add (your side), and the SMTP creds for Trellis ----------

output "ses_domain_verification" {
  description = "TXT record: _amazonses.<domain> = this value"
  value       = aws_ses_domain_identity.main.verification_token
}

output "ses_dkim_cnames" {
  description = "3 CNAMEs: <token>._domainkey.<domain> -> <token>.dkim.amazonses.com"
  value       = aws_ses_domain_dkim.main.dkim_tokens
}

output "ses_smtp_username" {
  description = "Set as mail_user in group_vars/all/mail.yml"
  value       = aws_iam_access_key.ses_smtp.id
}

output "ses_smtp_password" {
  description = "Set as vault_mail_password (trellis vault edit group_vars/all/vault.yml)"
  value       = aws_iam_access_key.ses_smtp.ses_smtp_password_v4
  sensitive   = true
}
