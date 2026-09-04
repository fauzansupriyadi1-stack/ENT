<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - FZN NEWS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1c4424;
            --primary-dark: #123018;
            --accent: #2e6b3c;
            --bg: #f0f4f8;
            --card-bg: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --font-sans: 'Inter', sans-serif;
            --font-serif: 'Playfair Display', serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-sans);
            background-color: var(--bg);
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            background-color: var(--card-bg);
            width: 100%;
            max-width: 420px;
            padding: 40px 32px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header h1 {
            font-family: var(--font-serif);
            font-size: 2.2rem;
            font-weight: 900;
            color: var(--primary);
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .login-header p {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-family: var(--font-sans);
            font-size: 0.95rem;
            transition: all 0.2s;
            background-color: #f8fafc;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(28, 68, 36, 0.1);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 0.85rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .checkbox-group input {
            cursor: pointer;
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
        }

        .checkbox-group label {
            font-weight: 500;
            cursor: pointer;
            color: var(--text-muted);
        }

        .btn-login {
            background-color: var(--primary);
            color: #fff;
            border: none;
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-login:hover {
            background-color: var(--primary-dark);
        }

        .btn-login:active {
            transform: scale(0.98);
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            font-size: 0.85rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        
        .back-link:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h1>FZN NEWS</h1>
            <p>Login to Admin Dashboard</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@fznnews.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <div class="form-options">
                <div class="checkbox-group">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat Saya</label>
                </div>
            </div>

            <button type="submit" class="btn-login">Masuk Dashboard</button>
        </form>
        
        <a href="{{ route('home') }}" class="back-link">← Kembali ke Halaman Utama</a>
    </div>

</body>
</html>
