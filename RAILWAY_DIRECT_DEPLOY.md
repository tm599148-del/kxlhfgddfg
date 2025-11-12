# Railway Direct Deploy (Without GitHub)

## Method 1: Railway CLI (Easiest)

### Step 1: Install Railway CLI
```bash
# Windows (PowerShell)
iwr https://railway.app/install.sh | iex

# Or using npm
npm i -g @railway/cli
```

### Step 2: Login to Railway
```bash
railway login
```
Browser khulega, login karo.

### Step 3: Initialize Project
```bash
railway init
```
- Project name enter karo
- "Empty Project" select karo

### Step 4: Deploy
```bash
railway up
```
Yeh automatically:
- PHP detect karega
- Files upload karega
- Deploy kar dega

### Step 5: Get URL
```bash
railway domain
```
Ya Railway dashboard se URL mil jayega.

---

## Method 2: Railway Web Dashboard (Drag & Drop)

1. **railway.app** par login karo
2. **New Project** → **Empty Project**
3. **Settings** → **Source** → **Upload Files**
4. Saari files select karo aur upload karo:
   - `research360_web.php`
   - `Procfile`
   - `railway.json`
5. Railway automatically deploy kar dega

---

## Method 3: Render (Direct Upload)

1. **render.com** par sign up/login
2. **New** → **Web Service**
3. **Manual Deploy** option select karo
4. Files upload karo:
   - `research360_web.php`
   - `render.yaml`
5. **Start Command:** `php -S 0.0.0.0:$PORT research360_web.php`
6. **Deploy** click karo

---

## Method 4: InfinityFree (Free, No CLI Needed)

1. **infinityfree.net** par sign up
2. **Create Website** → Free hosting select karo
3. **File Manager** open karo
4. Files upload karo:
   - `research360_web.php`
   - `.htaccess`
5. Access: `https://your-site.infinityfreeapp.com/research360_web.php`

**FTP Alternative:**
- FTP credentials mil jayenge
- FileZilla ya koi FTP client se connect karo
- Files upload karo

---

## Quick Commands for Railway CLI

```bash
# Login
railway login

# Create new project
railway init

# Deploy current directory
railway up

# View logs
railway logs

# Open in browser
railway open

# Check status
railway status
```

---

## Best Option for Direct Deploy

**Railway CLI** sabse aasaan hai:
- ✅ No GitHub needed
- ✅ Direct upload from your computer
- ✅ Fast deployment
- ✅ Free tier available

