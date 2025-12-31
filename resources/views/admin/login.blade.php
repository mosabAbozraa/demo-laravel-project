<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            font-family: Arial, sans-serif;
        }

        .login-card {
            background: #ffffff;
            width: 360px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #0f172a;
        }

        label {
            font-size: 14px;
            color: #334155;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #cbd5f5;
            border-radius: 6px;
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #3b82f6;
            color: #fff;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
        }

        button:hover {
            background: #2563eb;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="login-card">
    <h2>Admin Panel</h2>

    @if($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/admin/login">
        @csrf

        <label>Phone</label>
        <input type="text" name="phone" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
