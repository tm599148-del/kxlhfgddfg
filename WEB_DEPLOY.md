# Railway Web Dashboard Deployment (No CLI Needed!)

## Method 1: Railway Web Dashboard (Easiest - No Browser Issues)

1. **Go to Railway Dashboard:**
   - Open: https://railway.app/dashboard
   - Login with your account

2. **Create New Project:**
   - Click **"New Project"**
   - Select **"Deploy from GitHub repo"** (if you have GitHub)
   - OR Select **"Empty Project"**

3. **If Empty Project:**
   - Click on your project
   - Go to **Settings** → **Source**
   - Click **"Upload Files"** or **"Connect GitHub"**
   - Upload these files:
     - `research360_web.php`
     - `Procfile`
     - `railway.json`

4. **Configure Service:**
   - Railway will auto-detect PHP
   - Start Command: `php -S 0.0.0.0:$PORT research360_web.php`
   - Click **Deploy**

5. **Get URL:**
   - Go to **Settings** → **Domains**
   - Your app URL will be shown there

---

## Method 2: Fix Browser Issue for CLI

If browser is not opening, try:

### Option A: Manual Browser Login
1. Open browser manually: https://railway.app/login
2. Login there
3. Then in terminal run:
```bash
railway login
```
It might detect you're already logged in.

### Option B: Use Railway Token in Browser
1. Go to: https://railway.app/account/tokens
2. Create a token
3. Copy the token
4. In terminal:
```bash
railway login --browserless
```
Then paste the token when asked.

---

## Method 3: GitHub Integration (Recommended)

1. **Push code to GitHub:**
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin YOUR_GITHUB_REPO_URL
git push -u origin main
```

2. **In Railway Dashboard:**
   - New Project → Deploy from GitHub
   - Select your repo
   - Auto-deploy!

---

## Quick Fix for Browser Issue

Try these in PowerShell:

```powershell
# Set browser manually
$env:BROWSER = "chrome"
railway login

# Or use default browser
Start-Process "https://railway.app/login"
# Then in another terminal:
railway login
```

