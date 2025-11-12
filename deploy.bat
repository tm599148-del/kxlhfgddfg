@echo off
echo ========================================
echo Railway Deployment
echo ========================================
echo.

echo Step 1: Login to Railway
echo Browser will open - please login
echo.
railway login
if errorlevel 1 (
    echo Login failed. Please run manually: railway login
    pause
    exit /b 1
)

echo.
echo Step 2: Initialize project
railway init
if errorlevel 1 (
    echo Init failed.
    pause
    exit /b 1
)

echo.
echo Step 3: Deploying...
railway up
if errorlevel 1 (
    echo Deployment failed.
    pause
    exit /b 1
)

echo.
echo Step 4: Getting URL...
railway domain

echo.
echo ========================================
echo Deployment Complete!
echo ========================================
pause

