<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Secure Access</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-primary: #0a0e27;
            --bg-secondary: #151b38;
            --glass-bg: rgba(21, 27, 56, 0.75);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-primary: #ffffff;
            --text-secondary: #a5b4fc;
            --text-muted: #64748b;
            --error-bg: rgba(239, 68, 68, 0.1);
            --error-border: rgba(239, 68, 68, 0.3);
            --error-text: #fca5a5;
            --success-glow: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-primary);
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            position: relative;
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .gradient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.4;
            animation: float-complex 20s infinite ease-in-out;
        }

        .orb-1 { width: 600px; height: 600px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); top: -200px; left: -200px; }
        .orb-2 { width: 500px; height: 500px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); bottom: -150px; right: -150px; animation-delay: -10s; }
        .orb-3 { width: 400px; height: 400px; background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%); top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: -5s; }

        @keyframes float-complex {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, -30px) scale(1.1); }
            50% { transform: translate(-30px, 50px) scale(0.9); }
            75% { transform: translate(40px, 20px) scale(1.05); }
        }

        .particles { position: absolute; width: 100%; height: 100%; overflow: hidden; }
        .particle {
            position: absolute; width: 3px; height: 3px; background: rgba(255, 255, 255, 0.5);
            border-radius: 50%; animation: particle-float 15s infinite linear;
        }

        @keyframes particle-float {
            0% { transform: translateY(100vh) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) translateX(100px); opacity: 0; }
        }

        .login-container {
            position: relative;
            z-index: 10;
        }

        .login-card {
            width: 480px;
            padding: 40px 45px 50px 45px;
            background: var(--glass-bg);
            backdrop-filter: blur(40px) saturate(180%);
            -webkit-backdrop-filter: blur(40px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            position: relative;
            animation: card-entrance 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
            margin-top: 10px;
        }

        .login-header h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 36px;
            font-weight: 700;
            background: linear-gradient(135deg, #ffffff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 5px;
        }

        .login-header p {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .input-group { position: relative; margin-bottom: 25px; }
        .input-label {
            display: block; color: var(--text-secondary); font-size: 12px;
            font-weight: 500; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .input-wrapper { position: relative; }
        .input-icon {
            position: absolute; left: 18px; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 18px; transition: all 0.3s ease; z-index: 2;
        }
        .input-group input {
            width: 100%; padding: 15px 20px 15px 52px; background: rgba(10, 14, 39, 0.6);
            border: 1.5px solid rgba(255, 255, 255, 0.08); border-radius: 16px;
            color: var(--text-primary); font-size: 15px; font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }
        .input-group input:focus {
            outline: none; background: rgba(10, 14, 39, 0.8); border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        .input-group input:focus + .input-icon { color: #667eea; }

        input:-webkit-autofill, input:-webkit-autofill:hover, input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 50px rgba(10, 14, 39, 0.9) inset !important;
            -webkit-text-fill-color: var(--text-primary) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        .login-button {
            width: 100%; padding: 16px; margin-top: 5px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none; border-radius: 16px; color: white; font-size: 16px;
            font-weight: 600; cursor: pointer; transition: transform 0.2s;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
        }
        .login-button:hover { transform: translateY(-2px); background: linear-gradient(135deg, #764ba2 0%, #667eea 100%); }

        .error-message {
            background: var(--error-bg); border: 1px solid var(--error-border);
            border-radius: 12px; padding: 12px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px; color: var(--error-text);
            font-size: 13px;
        }

        .login-footer { margin-top: 25px; text-align: center; }
        .footer-text { color: var(--text-muted); font-size: 12px; letter-spacing: 0.5px; }

        @keyframes card-entrance {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="animated-bg">
        <div class="gradient-orb orb-1"></div>
        <div class="gradient-orb orb-2"></div>
        <div class="gradient-orb orb-3"></div>
        <div class="particles" id="particles"></div>
    </div>

    <div class="login-container">
        <div class="login-card">

            <div class="login-header">
                <h1>Admin Portal</h1>
                <p>Secure Dashboard Access</p>
            </div>

            @if($errors->any())
            <div class="error-message">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form method="POST" action="/admin/login">
                @csrf

                <div class="input-group">
                    <label class="input-label">Phone Number</label>
                    <div class="input-wrapper">
                        <input type="text" id="phoneInput" name="phone" placeholder="Enter phone" required autocomplete="username">
                        <i class="fas fa-mobile-alt input-icon"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="passInput" name="password" placeholder="Enter password" required autocomplete="current-password">
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                </div>

                <button type="submit" class="login-button">
                    Secure Login <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                </button>
            </form>

            <div class="login-footer">
                <p class="footer-text">ADMIN ACCESS ONLY</p>
            </div>
        </div>
    </div>

    <script>
        const particlesContainer = document.getElementById('particles');
        for (let i = 0; i < 30; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            particlesContainer.appendChild(particle);
        }
            </script>
</body>
</html>
