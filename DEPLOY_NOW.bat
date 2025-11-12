@echo off
chcp 65001 >nul
echo ========================================
echo Railway Deployment - Research360 Bot
echo ========================================
echo.

echo Checking Railway CLI...
railway --version
if errorlevel 1 (
    echo Installing Railway CLI...
    call npm install -g @railway/cli
)

echo.
echo ========================================
echo IMPORTANT: Login Required
echo ========================================
echo.
echo Step 1: Login to Railway
echo Browser will open - please login there
echo.
pause
railway login
if errorlevel 1 (
    echo.
    echo Login failed. Please try again.
    echo Or open browser manually: https://railway.app/login
    pause
    exit /b 1
)

echo.
echo Login successful!
echo.

echo ========================================
echo Step 2: Creating Railway Project
echo ========================================
railway init --name research360-bot
if errorlevel 1 (
    echo.
    echo Project might already exist. Continuing...
)

echo.
echo ========================================
echo Step 3: Deploying to Railway
echo ========================================
railway up
if errorlevel 1 (
    echo.
    echo Deployment failed. Please check errors above.
    pause
    exit /b 1
)

echo.
echo ========================================
echo Deployment Complete!
echo ========================================
echo.

echo Getting your deployment URL...
railway domain

echo.
echo ========================================
echo Your app is now live!
echo ========================================
echo.
pause

