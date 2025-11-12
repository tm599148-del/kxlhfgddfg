# Deployment Guide - Research360 Bot

## Option 1: Railway (Recommended - Easiest)

1. **Sign up** at [railway.app](https://railway.app)
2. **Create New Project** → "Deploy from GitHub repo"
3. **Connect your GitHub** and select this repository
4. Railway will automatically detect PHP and deploy
5. Your app will be live at `https://your-app-name.railway.app`

**Note:** Railway automatically uses the `Procfile` or `railway.json` config.

---

## Option 2: Render

1. **Sign up** at [render.com](https://render.com)
2. **New** → **Web Service**
3. **Connect GitHub** and select this repository
4. Settings:
   - **Environment:** PHP
   - **Build Command:** (leave empty)
   - **Start Command:** `php -S 0.0.0.0:$PORT research360_web.php`
5. Click **Create Web Service**
6. Your app will be live at `https://your-app-name.onrender.com`

---

## Option 3: InfinityFree (Free PHP Hosting)

1. **Sign up** at [infinityfree.net](https://infinityfree.net)
2. **Create Account** → **Create Website**
3. **Upload files** via FTP or File Manager:
   - Upload `research360_web.php`
   - Upload `.htaccess` (for clean URLs)
4. Access your site at `https://your-site.infinityfreeapp.com/research360_web.php`

**FTP Details:** Provided in InfinityFree control panel

---

## Option 4: 000webhost (Free PHP Hosting)

1. **Sign up** at [000webhost.com](https://000webhost.com)
2. **Create Website**
3. **Upload files** via File Manager:
   - Upload `research360_web.php`
   - Upload `.htaccess`
4. Access at `https://your-site.000webhostapp.com/research360_web.php`

---

## Quick Deploy Buttons

### Railway
[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new)

### Render
[![Deploy to Render](https://render.com/images/deploy-to-render-button.svg)](https://render.com/deploy)

---

## Important Notes

- **File Permissions:** Make sure `research360_logs.json` and `research360_stats.json` have write permissions
- **Environment Variables:** No environment variables needed for this app
- **Port:** Railway and Render use `$PORT` environment variable automatically
- **HTTPS:** All platforms provide free SSL/HTTPS certificates

---

## Troubleshooting

1. **500 Error:** Check file permissions for JSON files
2. **404 Error:** Make sure `research360_web.php` is in the root directory
3. **CORS Issues:** Already handled in the code

---

## Best Option for You

**Railway** is the easiest and most reliable option with:
- ✅ Free tier available
- ✅ Automatic deployments from GitHub
- ✅ Easy setup
- ✅ Good performance

