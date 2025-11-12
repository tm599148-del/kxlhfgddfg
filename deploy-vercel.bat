@echo off
echo ========================================
echo Vercel Deployment - Research360 Bot
echo ========================================
echo.

echo Step 1: Checking Vercel CLI...
vercel --version
if errorlevel 1 (
    echo Installing Vercel CLI...
    call npm install -g vercel
)

echo.
echo Step 2: Login to Vercel
echo Browser will open - please login there
echo.
vercel login
if errorlevel 1 (
    echo.
    echo Login failed. Please try again.
    pause
    exit /b 1
)

echo.
echo Step 3: Deploying to Vercel...
vercel --prod --yes
if errorlevel 1 (
    echo.
    echo Deployment failed.
    pause
    exit /b 1
)

echo.
echo ========================================
echo Deployment Complete!
echo ========================================
echo.
echo Your app is now live on Vercel!
echo.
pause

