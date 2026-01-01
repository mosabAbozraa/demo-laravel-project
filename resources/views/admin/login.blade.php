<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Secure Login</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-color: #0f172a;
            --primary-color: #6366f1;
            --accent-color: #818cf8;
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-white: #f8fafc;
            --text-muted: #94a3b8;
            --error-bg: rgba(239, 68, 68, 0.15);
            --error-text: #fca5a5;
            --input-bg: rgba(15, 23, 42, 0.6); /* لون خلفية الحقل الموحد */
        }

        * {
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        body {
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.15) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 20%);
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .background-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
            animation: float 10s infinite ease-in-out;
        }
        .orb-1 { width: 300px; height: 300px; background: #4338ca; top: -50px; left: -50px; }
        .orb-2 { width: 400px; height: 400px; background: #3b82f6; bottom: -100px; right: -100px; animation-delay: -5s; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, 50px); }
        }

        .login-card {
            width: 400px;
            padding: 40px 35px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -50%;
            width: 200%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.03), transparent);
            transform: rotate(30deg);
            pointer-events: none;
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: var(--text-white);
            margin: 0 0 8px 0;
            letter-spacing: 0.5px;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 14px;
            margin: 0;
        }

        .icon-header {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            color: white;
            font-size: 20px;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 16px;
            transition: color 0.3s;
            z-index: 2;
        }

        .input-group input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            background: var(--input-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-white);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            background: rgba(15, 23, 42, 0.8);
        }

        .input-group input:focus + i {
            color: var(--primary-color);
        }

        .input-group input::placeholder {
            color: rgba(148, 163, 184, 0.5);
        }

        /* --------------------------------------------------------- */
        /* HERE IS THE FIX: Override Browser Autofill Styles       */
        /* --------------------------------------------------------- */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active{
            /* يجبر المتصفح على استخدام لون الخلفية الغامق بدلاً من الأبيض */
            -webkit-box-shadow: 0 0 0 30px #1e293b inset !important;
            /* يجبر النص على أن يكون أبيض */
            -webkit-text-fill-color: var(--text-white) !important;
            transition: background-color 5000s ease-in-out 0s;
            caret-color: var(--text-white); /* لون مؤشر الكتابة */
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            background: linear-gradient(135deg, var(--primary-color), #4f46e5);
            color: white;
            font-weight: 600;
            border-radius: 12px;
            font-size: 15px;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .error {
            background: var(--error-bg);
            color: var(--error-text);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(239, 68, 68, 0.2);
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .footer-link {
            text-align: center;
            margin-top: 20px;
        }
        .footer-link a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 12px;
            transition: color 0.3s;
        }
        .footer-link a:hover {
            color: var(--primary-color);
        }

    </style>
</head>

<body>

    <div class="background-orb orb-1"></div>
    <div class="background-orb orb-2"></div>

    <div class="login-card">
        
        <div class="login-header">
            <div class="icon-header">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h2>Admin Portal</h2>
            <p>Welcome back, please login to your account.</p>
        </div>

        @if($errors->any())
            <div class="error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="/admin/login">
            @csrf

            <div class="input-group">
                <input type="text" name="phone" placeholder="Phone Number" required autocomplete="username">
                <i class="fas fa-phone-alt"></i>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                <i class="fas fa-lock"></i>
            </div>

            <button type="submit">
                Secure Login <i class="fas fa-arrow-right" style="margin-left: 8px; font-size: 12px;"></i>
            </button>
        </form>

        <div class="footer-link">
            <a href="#">Forgot your password?</a>
        </div>
    </div>

</body>
</html>