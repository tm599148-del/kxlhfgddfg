@echo off
echo ========================================
echo Railway Deployment Script
echo ========================================
echo.

echo Step 1: Checking Railway CLI...
railway --version
if %errorlevel% neq 0 (
    echo Railway CLI not found. Installing...
    npm install -g @railway/cli
)

echo.
echo Step 2: Please login to Railway (browser will open)...
railway login
if %errorlevel% neq 0 (
    echo Login failed. Please run 'railway login' manually.
    pause
    exit /b 1
)

echo.
echo Step 3: Initializing Railway project...
railway init
if %errorlevel% neq 0 (
    echo Init failed. Please run 'railway init' manually.
    pause
    exit /b 1
)

echo.
echo Step 4: Deploying to Railway...
railway up
if %errorlevel% neq 0 (
    echo Deployment failed.
    pause
    exit /b 1
)

echo.
echo ========================================
echo Deployment Complete!
echo ========================================
echo.
echo To get your URL, run: railway domain
echo.
pause

