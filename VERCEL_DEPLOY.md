# Vercel Deployment Guide

## Quick Deploy to Vercel

### Method 1: Vercel CLI (Recommended)

1. **Install Vercel CLI:**
```bash
npm install -g vercel
```

2. **Login to Vercel:**
```bash
vercel login
```

3. **Deploy:**
```bash
vercel
```

4. **Production Deploy:**
```bash
vercel --prod
```

---

### Method 2: Vercel Dashboard (Easiest)

1. **Go to:** https://vercel.com/dashboard
2. **Click:** "Add New Project"
3. **Import Git Repository** (if you have GitHub repo)
   - OR **Upload Files** directly
4. **Select:** Your project folder
5. **Framework Preset:** Other (Vercel will auto-detect PHP)
6. **Click:** Deploy

---

### Method 3: GitHub Integration (Auto-Deploy)

1. **Push to GitHub:**
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin YOUR_GITHUB_REPO_URL
git push -u origin main
```

2. **In Vercel Dashboard:**
   - Import Git Repository
   - Select your repo
   - Auto-deploy on every push!

---

## Files Created for Vercel

- `vercel.json` - Vercel configuration
- `.vercelignore` - Files to ignore during deployment
- Updated `research360_web.php` - Uses `/tmp` for writable files on Vercel

---

## Important Notes

- **File Storage:** Logs are stored in `/tmp` on Vercel (temporary, resets on each deployment)
- **For Persistent Storage:** Consider using a database (MongoDB, PostgreSQL) or Vercel KV
- **Environment Variables:** Can be set in Vercel Dashboard → Settings → Environment Variables

---

## Quick Commands

```bash
# Deploy to preview
vercel

# Deploy to production
vercel --prod

# View logs
vercel logs

# Open dashboard
vercel dashboard
```

