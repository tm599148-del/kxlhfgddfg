<?php
session_start();

// Database file for storing logs
// Use /tmp for Vercel (writable) or current directory for local
$logsFile = (is_writable('/tmp')) ? '/tmp/research360_logs.json' : 'research360_logs.json';
$statsFile = (is_writable('/tmp')) ? '/tmp/research360_stats.json' : 'research360_stats.json';

// Initialize files if they don't exist
if (!file_exists($logsFile)) {
    file_put_contents($logsFile, json_encode([]));
}
if (!file_exists($statsFile)) {
    file_put_contents($statsFile, json_encode(['total_success' => 0]));
}

// Color codes for terminal output
class Colors {
    const RED = "\033[31m";
    const GREEN = "\033[32m";
    const YELLOW = "\033[33m";
    const BLUE = "\033[34m";
    const MAGENTA = "\033[35m";
    const CYAN = "\033[36m";
    const WHITE = "\033[37m";
    const BOLD = "\033[1m";
    const RESET = "\033[0m";
}

function HttpCallnohead($url, $data = null, $headers = [], $method = "GET", $returnHeaders = false, $proxy = false, $ip = null, $auth = null) {
    if (empty($headers)) {
        $ip = long2ip(mt_rand());
        $headers[] = "X-Forwarded-For: $ip";
        $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36";
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, $method === "POST");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, $returnHeaders);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

// Function to generate random mobile number
function generateRandomMobile() {
    $prefixes = ['6', '7', '8', '9'];
    $prefix = $prefixes[array_rand($prefixes)];
    $number = '';
    for ($i = 0; $i < 9; $i++) {
        $number .= rand(0, 9);
    }
    return $prefix . $number;
}

// Function to generate random device ID (UUID format)
function generateRandomDeviceId() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

// API 1: Branch.io Install
function callBranchAPI($referralLink) {
    $hardwareId = generateRandomDeviceId();
    $anonId = generateRandomDeviceId();
    $aaid = generateRandomDeviceId();
    
    $payload = [
        "hardware_id" => $hardwareId,
        "is_hardware_id_real" => false,
        "anon_id" => $anonId,
        "brand" => "Xiaomi",
        "model" => "POCO F1",
        "screen_dpi" => 440,
        "screen_height" => 2027,
        "screen_width" => 1080,
        "wifi" => true,
        "ui_mode" => "UI_MODE_TYPE_NORMAL",
        "os" => "Android",
        "os_version" => 29,
        "plugin_name" => "Flutter",
        "plugin_version" => "8.10.0",
        "country" => "IN",
        "language" => "en",
        "local_ip" => "169.254.61.43",
        "cpu_type" => "aarch64",
        "build" => "QKQ1.190828.002 test-keys",
        "locale" => "en_IN",
        "connection_type" => "wifi",
        "device_carrier" => "JIO 4G",
        "os_version_android" => "10",
        "debug" => false,
        "partner_data" => new stdClass(),
        "app_version" => "2.0.2",
        "update" => 0,
        "latest_install_time" => time() * 1000,
        "latest_update_time" => time() * 1000,
        "first_install_time" => time() * 1000,
        "previous_update_time" => 0,
        "environment" => "FULL_APP",
        "android_app_link_url" => $referralLink,
        "external_intent_uri" => $referralLink,
        "initial_referrer" => "android-app://org.thunderdog.challegram",
        "clicked_referrer_ts" => (time() - 35) * 1000,
        "install_begin_ts" => (time() - 32) * 1000,
        "link_click_id" => "1516807724392993390",
        "clicked_referrer_server_ts" => (time() - 34) * 1000,
        "install_begin_server_ts" => (time() - 31) * 1000,
        "operational_metrics" => [
            "expectDelayedSessionInitialization" => true,
            "testMode" => false,
            "instantDeepLinkingEnabled" => false,
            "deferInitForPluginRuntime" => false,
            "branch_key_source" => "manifest",
            "branch_key_fallback_used" => false
        ],
        "metadata" => new stdClass(),
        "branch_sdk_request_timestamp" => time() * 1000,
        "branch_sdk_request_unique_id" => generateRandomDeviceId() . "-" . date('YmdHis'),
        "link_identifier" => "1516807724392993390",
        "install_referrer_extras" => "link_click_id=1516807724392993390&utm_source=Branch",
        "app_store" => "PlayStore",
        "advertising_ids" => [
            "aaid" => $aaid
        ],
        "lat_val" => 0,
        "google_advertising_id" => $aaid,
        "sdk" => "android5.20.3",
        "branch_key" => "key_live_expU23OIiGt2bhd9TwmtOcmiyydC58SL",
        "retryNumber" => 0
    ];
    
    $headers = [
        "Content-Type: application/json",
        "Accept: application/json",
        "User-Agent: Dalvik/2.1.0 (Linux; U; Android 10; POCO F1 MIUI/V12.0.3.0.QEJMIXM)",
        "Host: api2.branch.io",
        "Connection: Keep-Alive",
        "Accept-Encoding: gzip"
    ];
    
    $response = HttpCallnohead(
        "https://api2.branch.io/v1/install",
        json_encode($payload),
        $headers,
        "POST"
    );
    
    return json_decode($response, true);
}

// API 2: Create User Profile
function createUserProfile($mobileNumber) {
    $deviceId = "QKQ1.190828.002";
    
    $payload = [
        "mobile_no" => $mobileNumber,
        "email_id" => "",
        "client_id" => "",
        "user_name" => "",
        "user_type_id" => "2",
        "device_id" => $deviceId,
        "notification_id" => "",
        "source" => "",
        "software_version" => "2.0.2",
        "model_no" => "POCO F1",
        "token" => "",
        "gmail_verified" => "N",
        "mosl_verified" => "N",
        "subsription_type" => "free",
        "user_soruce" => "App",
        "step_one" => "Mobile",
        "step_two" => "Email"
    ];
    
    $headers = [
        "User-Agent: Dart/3.9 (dart:io)",
        "Host: cmots.motilaloswal.cloud",
        "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpIjoiNjAiLCJtIjoiTHxTfEl8Q3xOfFJ8RnxEfEJ8VXxXfEEiLCJhIjoiMjAwIiwiZXhwIjoxNzYyOTIyMDQ5LCJpc3MiOiJNT1NMIiwiYXVkIjoiTEYifQ.JwFaDaNDXAo3qSquCmcpLgP6EfYqlqiha9dXhhbic-w",
        "Content-Type: application/json",
        "T: 60"
    ];
    
    $response = HttpCallnohead(
        "https://cmots.motilaloswal.cloud/R360/api/R/UserManagement/CreateUserProfile?i=200",
        json_encode($payload),
        $headers,
        "POST"
    );
    
    return json_decode($response, true);
}

// API 3: Add Referral Detail
function addReferralDetail($referFrom, $referTo) {
    $payload = [
        "utm_source" => "Mobile",
        "utm_parameter" => "",
        "utm_campaign" => "",
        "platform" => "Android",
        "referefrom" => $referFrom,
        "referto" => $referTo,
        "note" => ""
    ];
    
    $headers = [
        "User-Agent: Dart/3.9 (dart:io)",
        "Userid: ".$referTo,
        "Accept-Encoding: gzip",
        "Xapikey: +8236db25e85bd6f6301a8f69dee4ff5f=",
        "Host: zrdovnxg6j.execute-api.ap-south-1.amazonaws.com",
        "Authorization: eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyaWQiOiJBZG1pblRlc3QiLCJhcHBpZCI6IjEyIiwicm9sZSI6IlMiLCJuYmYiOjE3NjI4NzM0NzYsImV4cCI6MTc2MjkwOTQ3NiwiaWF0IjoxNzYyODczNDc2LCJpc3MiOiJsb2dpbl9hcGkiLCJhdWQiOiJ0cmFkaW5nX2FwaXMifQ.d21wyzf6TrR-8XmGiKfXJDSGHN_IxjMVQD1xOZhLmwQKY3IdEBDUKluHv2WESRcXsB9bLr55KolZGJpCGTTZguKkygFq3mWZwgtYYVIdNzH-kYwx3kWX3WdbbEcpC9uT5BJMa4AFFWrKOBBUvDa9fS1a2RHOjHB1JTZpwZKziwJdKjce9YEE9V3YgzwPmTZmDWG9h55JfadB_9pIzuJJTE259sgFQ_-KjfQ-B4yTHKaJEITUWj8diRvkVnN9i4VNdqafQnXbpkPSipTncKzl5tTj-WPozgei8icIPRhKqN2iFoaNWg54fZc9l_FppL80qwj5LGNUdwL-QDTjXo4oXA",
        "Content-Type: application/json",
        "Sentry-Trace: 4d872eeaf5f444a69c387717ec6a6c0a-a5b2af0306194b13-0",
        "Ipaddress: 2.0.2",
        "Sessionid: Android",
        "Baggage: sentry-trace_id=4d872eeaf5f444a69c387717ec6a6c0a,sentry-public_key=0ff1a1693d72ea2121c7b8f3a0afc7ea,sentry-release=com.mosl.research360app%402.0.2%2B210,sentry-environment=production,sentry-transaction=https%3A%2F%2Fzrdovnxg6j.execute-api.ap-south-1.amazonaws.com%2Fprod%2Fapi%2FReferral%2FAddReferralDetail,sentry-sample_rate=0.1,sentry-sample_rand=0.5313517183844305,sentry-sampled=false"
    ];
    
    $response = HttpCallnohead(
        "https://zrdovnxg6j.execute-api.ap-south-1.amazonaws.com/prod/api/Referral/AddReferralDetail",
        json_encode($payload),
        $headers,
        "POST"
    );
    
    return json_decode($response, true);
}

// Extract referral code from deeplink path
function extractReferralCode($data) {
    if (isset($data['data'])) {
        $dataStr = $data['data'];
        if (preg_match('/referral\?code=(\d+)/', $dataStr, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

// Check referral limit
function checkReferralLimit($referralCode, $logsFile) {
    $logs = json_decode(file_get_contents($logsFile), true);
    $count = 0;
    foreach ($logs as $log) {
        if ($log['referral_code'] == $referralCode && $log['status'] == 'success') {
            $count++;
        }
    }
    return $count < 20;
}

// Save log
function saveLog($logsFile, $logData) {
    $logs = json_decode(file_get_contents($logsFile), true);
    $logs[] = $logData;
    file_put_contents($logsFile, json_encode($logs, JSON_PRETTY_PRINT));
}

// Update stats
function updateStats($statsFile) {
    $stats = json_decode(file_get_contents($statsFile), true);
    $stats['total_success']++;
    file_put_contents($statsFile, json_encode($stats, JSON_PRETTY_PRINT));
}

// Get total success count
function getTotalSuccess($statsFile) {
    $stats = json_decode(file_get_contents($statsFile), true);
    return $stats['total_success'] ?? 0;
}

// Process referral
$result = null;
$storedLink = isset($_SESSION['referral_link']) ? $_SESSION['referral_link'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['referral_link'])) {
    $referralLink = trim($_POST['referral_link']);
    $_SESSION['referral_link'] = $referralLink; // Store in session for continuous auto-submit
    
    $result = [
        'success' => false,
        'message' => '',
        'details' => []
    ];
    
    try {
        // Step 1: Call Branch API
        $branchResponse = callBranchAPI($referralLink);
        $result['details']['branch_response'] = $branchResponse;
        
        if (!$branchResponse) {
            throw new Exception("Failed to call Branch API");
        }
        
        // Extract referral code
        $referralCode = extractReferralCode($branchResponse);
        if (!$referralCode) {
            throw new Exception("Failed to extract referral code from response");
        }
        
        $result['details']['referral_code'] = $referralCode;
        
        // Check referral limit - DISABLED for unlimited referrals
        // if (!checkReferralLimit($referralCode, $logsFile)) {
        //     throw new Exception("Referral limit reached (20 referrals max)");
        // }
        
        // Step 2: Create User Profile
        $mobileNumber = generateRandomMobile();
        $result['details']['mobile_number'] = $mobileNumber;
        
        $userResponse = createUserProfile($mobileNumber);
        $result['details']['user_response'] = $userResponse;
        
        if (!isset($userResponse['data']['user_id'])) {
            throw new Exception("Failed to create user profile");
        }
        
        $userId = $userResponse['data']['user_id'];
        $result['details']['user_id'] = $userId;
        
        // Step 3: Add Referral
        $referralResponse = addReferralDetail($referralCode, $userId);
        $result['details']['referral_response'] = $referralResponse;
        
        if (!isset($referralResponse['data']['status']) || !$referralResponse['data']['status']) {
            throw new Exception("Failed to add referral");
        }
        
        // Success!
        $result['success'] = true;
        $result['message'] = $referralResponse['data']['message'] ?? 'Referral successful!';
        $result['discount'] = $referralResponse['data']['referraldiscount'] ?? '0';
        
        // Save log
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'referral_code' => $referralCode,
            'user_id' => $userId,
            'mobile_number' => $mobileNumber,
            'status' => 'success',
            'discount' => $result['discount'],
            'referral_link' => $referralLink
        ];
        saveLog($logsFile, $logData);
        
        // Update stats
        updateStats($statsFile);
        
    } catch (Exception $e) {
        $result['success'] = false;
        $result['message'] = $e->getMessage();
        
        // Save error log
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'referral_code' => $referralCode ?? 'N/A',
            'status' => 'failed',
            'error' => $e->getMessage(),
            'referral_link' => $referralLink
        ];
        saveLog($logsFile, $logData);
    }
}

$totalSuccess = getTotalSuccess($statsFile);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research360 Referral Bot</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            width: 100%;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #667eea;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #666;
            font-size: 14px;
        }
        
        .stats-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .stats-box h2 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stats-box p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        
        .result-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .result-details h3 {
            color: #667eea;
            font-size: 18px;
            margin-bottom: 15px;
        }
        
        .result-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .result-item:last-child {
            border-bottom: none;
        }
        
        .result-item label {
            font-weight: 600;
            color: #666;
        }
        
        .result-item span {
            color: #333;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: white;
            font-size: 14px;
        }
        
        .loader {
            display: none;
            text-align: center;
            margin: 20px 0;
        }
        
        .loader.active {
            display: block;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>🚀 Research360 Referral Bot</h1>
                <p>Automate your referrals with ease</p>
            </div>
            
            <div class="stats-box">
                <h2><?php echo $totalSuccess; ?></h2>
                <p>Total Successful Referrals</p>
            </div>
            
            <?php if ($result): ?>
                <?php if ($result['success']): ?>
                    <div class="alert alert-success">
                        <strong>✅ Success!</strong> <?php echo htmlspecialchars($result['message']); ?>
                    </div>
                    
                    <div class="result-details">
                        <h3>📊 Referral Details</h3>
                        <div class="result-item">
                            <label>Referral Code:</label>
                            <span><?php echo htmlspecialchars($result['details']['referral_code']); ?></span>
                        </div>
                        <div class="result-item">
                            <label>User ID:</label>
                            <span><?php echo htmlspecialchars($result['details']['user_id']); ?></span>
                        </div>
                        <div class="result-item">
                            <label>Mobile Number:</label>
                            <span><?php echo htmlspecialchars($result['details']['mobile_number']); ?></span>
                        </div>
                        <div class="result-item">
                            <label>Discount:</label>
                            <span>₹<?php echo htmlspecialchars($result['discount']); ?></span>
                        </div>
                    </div>
                    
                    <div style="background: #e3f2fd; padding: 15px; border-radius: 10px; margin-top: 20px; text-align: center;">
                        <p style="color: #1976d2; font-weight: 600;">
                            ⏱️ Next submission in <span id="redirectCountdown">2</span> seconds...
                        </p>
                    </div>
                <?php else: ?>
                    <div class="alert alert-error">
                        <strong>❌ Error!</strong> <?php echo htmlspecialchars($result['message']); ?>
                    </div>
                    
                    <div style="background: #e3f2fd; padding: 15px; border-radius: 10px; margin-top: 20px; text-align: center;">
                        <p style="color: #1976d2; font-weight: 600;">
                            ⏱️ Retrying in <span id="redirectCountdown">2</span> seconds...
                        </p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <form method="POST" id="referralForm">
                <div class="form-group">
                    <label for="referral_link">🔗 Enter Referral Link</label>
                    <input 
                        type="text" 
                        id="referral_link" 
                        name="referral_link" 
                        placeholder="https://research360.app.link/pbnRJtl9cYb"
                        value="<?php echo isset($_POST['referral_link']) ? htmlspecialchars($_POST['referral_link']) : (isset($_SESSION['referral_link']) ? htmlspecialchars($_SESSION['referral_link']) : ''); ?>"
                        required
                    >
                </div>
                
                <button type="submit" class="btn">
                    🎯 Process Referral
                </button>
            </form>
            
            <div class="loader" id="loader">
                <div class="spinner"></div>
                <p style="margin-top: 10px; color: #667eea;">Processing referral...</p>
            </div>
            
            <?php if ($result): ?>
            <div id="autoSubmitSection" style="background: #e3f2fd; padding: 15px; border-radius: 10px; margin-top: 20px; text-align: center;">
                <p style="color: #1976d2; font-weight: 600; margin-bottom: 10px;">
                    ⏱️ Auto-submit: <span id="countdown">2</span> seconds
                </p>
                <p id="autoStatus" style="color: #666; font-size: 12px; margin-bottom: 10px;">Next submission in progress...</p>
                <button type="button" id="stopBtn" onclick="stopAutoSubmit()" style="padding: 10px 20px; background: #f44336; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif;">
                    ⏹️ Stop Auto-Submit
                </button>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            <p>Made with ❤️ for Research360 Community</p>
        </div>
    </div>
    
    <script>
        document.getElementById('referralForm').addEventListener('submit', function() {
            document.getElementById('loader').classList.add('active');
        });
        
        // Auto-submit every 2 seconds
        let autoSubmitInterval;
        let countdown = 2;
        let isAutoSubmitRunning = true;
        
        function startAutoSubmit() {
            if (autoSubmitInterval) {
                clearInterval(autoSubmitInterval);
            }
            isAutoSubmitRunning = true;
            const countdownElement = document.getElementById('countdown');
            const statusElement = document.getElementById('autoStatus');
            const stopBtn = document.getElementById('stopBtn');
            
            if (stopBtn) {
                stopBtn.textContent = '⏹️ Stop Auto-Submit';
                stopBtn.style.background = '#f44336';
            }
            
            autoSubmitInterval = setInterval(function() {
                if (!isAutoSubmitRunning) return;
                
                countdown--;
                if (countdownElement) {
                    countdownElement.textContent = countdown;
                }
                
                if (countdown <= 0) {
                    countdown = 2;
                    if (statusElement) {
                        statusElement.textContent = 'Submitting...';
                    }
                    document.getElementById('referralForm').submit();
                }
            }, 1000);
        }
        
        function stopAutoSubmit() {
            isAutoSubmitRunning = false;
            if (autoSubmitInterval) {
                clearInterval(autoSubmitInterval);
                autoSubmitInterval = null;
            }
            const stopBtn = document.getElementById('stopBtn');
            const statusElement = document.getElementById('autoStatus');
            
            if (stopBtn) {
                stopBtn.textContent = '▶️ Start Auto-Submit';
                stopBtn.style.background = '#4caf50';
                stopBtn.onclick = startAutoSubmit;
            }
            
            if (statusElement) {
                statusElement.textContent = 'Auto-submit stopped. Click button to resume.';
            }
        }
        
        // Start auto-submit only after user submits form first time
        window.addEventListener('load', function() {
            <?php if ($result): ?>
            // If result is shown, show controls and auto-submit after 2 seconds
            const autoSubmitSection = document.getElementById('autoSubmitSection');
            if (autoSubmitSection) {
                autoSubmitSection.style.display = 'block';
            }
            
            // Auto-submit form after 2 seconds to continue the loop
            let redirectCountdown = 2;
            const redirectElement = document.getElementById('redirectCountdown');
            const countdownElement = document.getElementById('countdown');
            const redirectInterval = setInterval(function() {
                redirectCountdown--;
                if (redirectElement) {
                    redirectElement.textContent = redirectCountdown;
                }
                if (countdownElement) {
                    countdownElement.textContent = redirectCountdown;
                }
                if (redirectCountdown <= 0) {
                    clearInterval(redirectInterval);
                    // Submit form automatically to continue the loop
                    document.getElementById('referralForm').submit();
                }
            }, 1000);
            <?php else: ?>
            // Check if we have a stored link from session - if yes, start auto-submit
            <?php if (!empty($storedLink)): ?>
            // Link is stored in session, start auto-submit automatically
            const autoSubmitSection = document.getElementById('autoSubmitSection');
            if (autoSubmitSection) {
                autoSubmitSection.style.display = 'block';
            }
            startAutoSubmit();
            <?php else: ?>
            // No stored link - wait for user to submit first
            const autoSubmitSection = document.getElementById('autoSubmitSection');
            if (autoSubmitSection) {
                autoSubmitSection.style.display = 'none';
            }
            <?php endif; ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
