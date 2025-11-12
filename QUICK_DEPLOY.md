# Quick Railway Deploy

## Method 1: Using Token (Non-Interactive)

1. **Get Railway Token:**
   - Go to https://railway.app/account/tokens
   - Click "New Token"
   - Copy the token

2. **Set Token and Deploy:**
```bash
# Windows PowerShell
$env:RAILWAY_TOKEN="f153ee6c-5adf-44ae-b01d-39f74b2b5715"
railway init
railway up
railway domain
```

## Method 2: Manual Login (Easiest)

Just run these commands in your terminal:

```bash
railway login
railway init
railway up
railway domain
```

The `railway login` will open browser - just login there!

