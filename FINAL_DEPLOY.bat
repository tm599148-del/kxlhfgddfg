@echo off
echo ========================================
echo Railway Deployment - Final Solution
echo ========================================
echo.
echo Project ID: d62aa3e0-e3e9-4b44-9450-cbff9a8d8452
echo.

echo Step 1: Opening Railway login page...
start https://railway.app/login
timeout /t 3 /nobreak >nul

echo.
echo Please login in the browser that just opened.
echo Then press any key to continue...
pause >nul

echo.
echo Step 2: Linking to Railway project...
railway link --project d62aa3e0-e3e9-4b44-9450-cbff9a8d8452
if errorlevel 1 (
    echo.
    echo Linking failed. Trying login again...
    railway login
    railway link --project d62aa3e0-e3e9-4b44-9450-cbff9a8d8452
)

echo.
echo Step 3: Deploying to Railway...
railway up

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
railway domain
echo.
pause

