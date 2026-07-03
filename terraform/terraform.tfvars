# Non-secret configuration. Override any default here.
region              = "us-east-1"
project             = "rootstest"
environment         = "production"
instance_type       = "t3.small"
root_volume_size    = 20
ssh_public_key_path = "~/.ssh/id_ed25519.pub"

# Recommended: replace with "<your.ip>/32" so only you can SSH.
ssh_ingress_cidr = "0.0.0.0/0"

site_domains = ["rootstest.de", "www.rootstest.de"]
