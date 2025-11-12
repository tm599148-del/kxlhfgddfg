# Auto Deploy Script - Run after railway login
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Railway Auto Deployment" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check if logged in
Write-Host "Checking Railway authentication..." -ForegroundColor Yellow
railway whoami
if ($LASTEXITCODE -ne 0) {
    Write-Host ""
    Write-Host "Please login first:" -ForegroundColor Red
    Write-Host "  railway login" -ForegroundColor Cyan
    Write-Host ""
    pause
    exit 1
}

Write-Host "Authenticated!" -ForegroundColor Green
Write-Host ""

# Initialize project if not already done
if (-not (Test-Path ".railway")) {
    Write-Host "Initializing Railway project..." -ForegroundColor Yellow
    railway init --name research360-bot
    Write-Host ""
}

# Deploy
Write-Host "Deploying to Railway..." -ForegroundColor Yellow
railway up

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host "Deployment Successful!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Getting your URL..." -ForegroundColor Yellow
    railway domain
    Write-Host ""
} else {
    Write-Host "Deployment failed." -ForegroundColor Red
}

pause

