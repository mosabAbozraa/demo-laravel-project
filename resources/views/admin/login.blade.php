<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LuxStay Admin | Sign In</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root{
            /* LuxStay brand (premium emerald + deep ink) */
            --brand: #10b981;         /* emerald */
            --brand-ink: #064e3b;     /* deep emerald ink */
            --ink: #0b1220;
            --ink-2: #111b2e;

            --bg: #f6f7fb;
            --card: rgba(255,255,255,0.85);
            --card-solid: #ffffff;

            --border: rgba(15, 23, 42, 0.10);
            --text: #0f172a;
            --muted: #64748b;

            --danger: #ef4444;
            --danger-bg: rgba(239, 68, 68, 0.08);
            --danger-border: rgba(239, 68, 68, 0.25);

            --shadow: 0 20px 60px rgba(15, 23, 42, 0.12);
            --shadow-soft: 0 10px 30px rgba(15, 23, 42, 0.08);
            --radius: 20px;
        }

        * { box-sizing: border-box; }
        html, body { height: 100%; }

        body{
            margin:0;
            font-family: "Plus Jakarta Sans", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            color: var(--text);
            background: var(--bg);
            display:flex;
            align-items:center;
            justify-content:center;
            padding: 24px;
            position:relative;
            overflow:hidden;
        }

        /* Clean admin background: soft grid + tasteful brand glow */
        .bg{
            position:absolute;
            inset:0;
            z-index:-1;
            background:
                radial-gradient(900px 500px at 20% 20%, rgba(16,185,129,0.14), transparent 55%),
                radial-gradient(900px 500px at 80% 30%, rgba(99,102,241,0.10), transparent 60%),
                linear-gradient(180deg, #f7f8fc, #f3f5fb);
        }

        .grid{
            position:absolute;
            inset:0;
            z-index:-1;
            opacity:0.6;
            background-image:
                linear-gradient(to right, rgba(15,23,42,0.06) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(15,23,42,0.06) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(circle at 50% 30%, black 55%, transparent 80%);
        }

        .shell{
            width: 100%;
            max-width: 980px;
            display:grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 22px;
            align-items: stretch;
        }

        @media (max-width: 900px){
            .shell{ grid-template-columns: 1fr; max-width: 460px; }
        }

        /* Brand panel (left) */
        .brand-panel{
            border-radius: var(--radius);
            padding: 34px;
            background: linear-gradient(135deg, rgba(16,185,129,0.14), rgba(255,255,255,0.65));
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
            position:relative;
            overflow:hidden;
            min-height: 420px;
        }

        .brand-panel::after{
            content:"";
            position:absolute;
            inset:-120px;
            background:
                radial-gradient(circle at 30% 30%, rgba(16,185,129,0.18), transparent 55%),
                radial-gradient(circle at 70% 70%, rgba(16,185,129,0.10), transparent 60%);
            transform: rotate(10deg);
        }

        .brand-panel > * { position:relative; z-index:1; }

        .brand-top{
            display:flex;
            align-items:center;
            gap: 12px;
        }

        .mark{
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display:flex;
            align-items:center;
            justify-content:center;
            background: linear-gradient(135deg, var(--brand), #34d399);
            color: white;
            font-weight: 800;
            letter-spacing: 0.5px;
            box-shadow: 0 14px 30px rgba(16,185,129,0.25);
            user-select:none;
        }

        .brand-name{
            display:flex;
            flex-direction:column;
            line-height:1.05;
        }

        .brand-name strong{
            font-size: 16px;
            letter-spacing: 0.2px;
        }

        .brand-name span{
            font-size: 12px;
            color: var(--muted);
            margin-top: 3px;
        }

        .headline{
            margin: 28px 0 10px;
            font-size: 30px;
            letter-spacing: -0.7px;
        }

        .sub{
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
            max-width: 52ch;
        }

        .bullets{
            margin-top: 22px;
            display:grid;
            gap: 10px;
        }
        .bullet{
            display:flex;
            gap: 10px;
            align-items:flex-start;
            padding: 12px 12px;
            border-radius: 14px;
            background: rgba(255,255,255,0.55);
            border: 1px solid rgba(15,23,42,0.08);
        }
        .dot{
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: var(--brand);
            margin-top: 5px;
            box-shadow: 0 0 0 4px rgba(16,185,129,0.12);
        }
        .bullet b{
            font-size: 13px;
        }
        .bullet p{
            margin: 3px 0 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        /* Login card (right) */
        .card{
            border-radius: var(--radius);
            background: var(--card);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            padding: 30px;
            min-height: 420px;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .card h1{
            margin: 0 0 6px;
            font-size: 22px;
            letter-spacing: -0.3px;
        }

        .card .hint{
            margin: 0 0 18px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .alert{
            display:flex;
            gap: 10px;
            align-items:flex-start;
            padding: 12px 12px;
            margin: 0 0 14px;
            border-radius: 14px;
            background: var(--danger-bg);
            border: 1px solid var(--danger-border);
            color: #991b1b;
            font-size: 13px;
        }
        .alert svg{
            flex: 0 0 auto;
            margin-top: 2px;
        }

        .field{
            margin-bottom: 12px;
        }

        label{
            display:block;
            font-size: 12px;
            font-weight: 700;
            color: rgba(15,23,42,0.85);
            margin: 0 0 7px 2px;
        }

        .control{
            position:relative;
        }

        input{
            width:100%;
            padding: 14px 14px 14px 44px;
            border-radius: 14px;
            border: 1px solid rgba(15,23,42,0.12);
            background: var(--card-solid);
            color: var(--text);
            font-size: 14px;
            transition: box-shadow .18s ease, border-color .18s ease;
        }

        input::placeholder{ color: rgba(100,116,139,0.75); }

        .icon{
            position:absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: rgba(100,116,139,0.85);
        }

        .control:focus-within input{
            border-color: rgba(16,185,129,0.55);
            box-shadow: 0 0 0 4px rgba(16,185,129,0.14);
        }

        .invalid input{
            border-color: rgba(239,68,68,0.45);
            box-shadow: 0 0 0 4px rgba(239,68,68,0.10);
        }
        .error{
            margin: 7px 0 0 2px;
            font-size: 12px;
            color: #b91c1c;
        }

        .row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 12px;
            margin: 10px 0 6px;
        }

        .small{
            font-size: 12px;
            color: var(--muted);
            display:flex;
            align-items:center;
            gap: 8px;
        }

        .toggle{
            border: 1px solid rgba(15,23,42,0.10);
            background: rgba(255,255,255,0.9);
            color: rgba(15,23,42,0.75);
            padding: 8px 10px;
            border-radius: 12px;
            cursor:pointer;
            font-size: 12px;
            font-weight: 700;
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .toggle:hover{
            transform: translateY(-1px);
            box-shadow: 0 10px 18px rgba(15,23,42,0.08);
        }

        .btn{
            width:100%;
            margin-top: 12px;
            padding: 14px 16px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--brand), #34d399);
            color: white;
            font-weight: 800;
            letter-spacing: 0.2px;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            gap: 10px;
            box-shadow: 0 16px 30px rgba(16,185,129,0.22);
            transition: transform .15s ease, filter .15s ease, box-shadow .15s ease;
        }
        .btn:hover{
            transform: translateY(-2px);
            filter: saturate(1.03);
            box-shadow: 0 22px 40px rgba(16,185,129,0.26);
        }
        .btn:active{ transform: translateY(0); }

        .footer{
            margin-top: 14px;
            text-align:center;
            font-size: 12px;
            color: var(--muted);
        }

        .badge{
            display:inline-flex;
            align-items:center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            border: 1px solid rgba(15,23,42,0.10);
            background: rgba(255,255,255,0.7);
        }

        .lock{
            width: 12px; height: 12px;
            color: rgba(6,78,59,0.9);
        }

        @media (prefers-reduced-motion: reduce){
            *{ transition:none !important; }
        }
    </style>
</head>

<body>
    <div class="bg"></div>
    <div class="grid"></div>

    <div class="shell">
        <!-- Brand side -->
        <section class="brand-panel" aria-label="LuxStay branding">
            <div class="brand-top">
                <div class="mark" aria-hidden="true">LS</div>
                <div class="brand-name">
                    <strong>LuxStay</strong>
                    <span>Admin Console</span>
                </div>
            </div>

            <h2 class="headline">Manage LuxStay with confidence.</h2>
            <p class="sub">
                Secure access for authorized staff. Review users, manage properties, and monitor activity from one place.
            </p>

            <div class="bullets">
                <div class="bullet">
                    <span class="dot" aria-hidden="true"></span>
                    <div>
                        <b>Clean workflow</b>
                        <p>Fast review actions with clear status and audit-friendly UI.</p>
                    </div>
                </div>
                <div class="bullet">
                    <span class="dot" aria-hidden="true"></span>
                    <div>
                        <b>Secure access</b>
                        <p>Validated inputs, clear errors, and safe admin-only entry.</p>
                    </div>
                </div>
                <div class="bullet">
                    <span class="dot" aria-hidden="true"></span>
                    <div>
                        <b>Professional look</b>
                        <p>Modern admin styling that matches a premium product brand.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Login side -->
        <main class="card" role="main" aria-label="Admin login form">
            <h1>Sign in</h1>
            <p class="hint">Enter your admin credentials to continue to the LuxStay dashboard.</p>

            @if ($errors->any())
                <div class="alert" role="alert" aria-live="polite">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 9v5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 17h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                        <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <form method="POST" action="/admin/login" novalidate>
                @csrf

                <div class="field @error('phone') invalid @enderror">
                    <label for="phone">Phone</label>
                    <div class="control">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 4h4l2 5-2 1c1 3 3 5 6 6l1-2 5 2v4c0 1-1 2-2 2-9 0-16-7-16-16 0-1 1-2 2-2Z"
                                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <input
                            id="phone"
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="09xxxxxxxx"
                            required
                            autocomplete="username"
                            inputmode="tel"
                            aria-invalid="@error('phone') true @else false @enderror"
                        />
                    </div>
                    @error('phone')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field @error('password') invalid @enderror">
                    <label for="password">Password</label>
                    <div class="control">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M6 11h12v10H6V11Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        </svg>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Enter password"
                            required
                            autocomplete="current-password"
                            aria-invalid="@error('password') true @else false @enderror"
                        />
                    </div>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="small">
                        <span class="badge">
                            <svg class="lock" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M6 11h12v10H6V11Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            </svg>
                            Admin only
                        </span>
                    </div>

                    <button type="button" class="toggle" onclick="togglePassword()" aria-label="Show or hide password">
                        Show
                    </button>
                </div>

                <button type="submit" class="btn">
                    Continue to Dashboard
                    <span aria-hidden="true">→</span>
                </button>

                <div class="footer">
                    LuxStay © {{ date('Y') }} • Restricted access
                </div>
            </form>
        </main>
    </div>

    <script>
        function togglePassword(){
            const input = document.getElementById('password');
            const btn = document.querySelector('.toggle');
            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';
            btn.textContent = isHidden ? 'Hide' : 'Show';
        }
    </script>
</body>
</html>
