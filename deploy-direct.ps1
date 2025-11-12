# Direct Railway Deployment Script
$projectId = "d62aa3e0-e3e9-4b44-9450-cbff9a8d8452"
$token = "f153ee6c-5adf-44ae-b01d-39f74b2b5715"

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Railway Direct Deployment" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Create Railway config
Write-Host "Creating Railway configuration..." -ForegroundColor Yellow
New-Item -ItemType Directory -Force -Path .railway | Out-Null
@"
{
  "project": "$projectId"
}
"@ | Out-File -FilePath .railway\config.json -Encoding utf8

# Try to authenticate and deploy
Write-Host "Attempting to deploy..." -ForegroundColor Yellow
Write-Host ""

# Set token
$env:RAILWAY_TOKEN = $token

# Try railway commands
Write-Host "Linking to project..." -ForegroundColor Yellow
railway link --project $projectId 2>&1

Write-Host ""
Write-Host "Deploying..." -ForegroundColor Yellow
railway up 2>&1

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host "Deployment Successful!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host ""
    railway domain
} else {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Red
    Write-Host "Deployment Failed" -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Please run manually:" -ForegroundColor Yellow
    Write-Host "  1. railway login" -ForegroundColor Cyan
    Write-Host "  2. railway link --project $projectId" -ForegroundColor Cyan
    Write-Host "  3. railway up" -ForegroundColor Cyan
}

Write-Host ""
pause

