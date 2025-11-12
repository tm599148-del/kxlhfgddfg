# Railway Deployment with Token
# Note: Railway CLI requires interactive login first time
# After that, you can use this script

$token = "f153ee6c-5adf-44ae-b01d-39f74b2b5715"

Write-Host "Setting Railway Token..." -ForegroundColor Yellow
$env:RAILWAY_TOKEN = $token
[Environment]::SetEnvironmentVariable("RAILWAY_TOKEN", $token, "User")

Write-Host ""
Write-Host "Note: Railway CLI may still require interactive login." -ForegroundColor Gray
Write-Host "If authentication fails, please run: railway login" -ForegroundColor Gray
Write-Host ""

Write-Host "Step 1: Checking authentication..." -ForegroundColor Yellow
railway whoami
if ($LASTEXITCODE -ne 0) {
    Write-Host ""
    Write-Host "Authentication required. Please run:" -ForegroundColor Red
    Write-Host "  railway login" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "After login, run this script again." -ForegroundColor Yellow
    pause
    exit 1
}

Write-Host "✓ Authenticated!" -ForegroundColor Green
Write-Host ""

Write-Host "Step 2: Initializing Railway project..." -ForegroundColor Yellow
railway init --name research360-bot
if ($LASTEXITCODE -ne 0) {
    Write-Host "Init failed. Trying without name..." -ForegroundColor Yellow
    railway init
}

Write-Host ""
Write-Host "Step 3: Deploying to Railway..." -ForegroundColor Yellow
railway up

if ($LASTEXITCODE -ne 0) {
    Write-Host "✗ Deployment failed." -ForegroundColor Red
    pause
    exit 1
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "✓ Deployment Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

Write-Host "Getting your deployment URL..." -ForegroundColor Yellow
railway domain

Write-Host ""
Write-Host "Your app is now live!" -ForegroundColor Green
Write-Host ""
pause

