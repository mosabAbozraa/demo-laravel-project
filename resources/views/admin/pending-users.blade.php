<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | User Management</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --bg-card-hover: #334155;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --success: #10b981;
            --success-light: #34d399;
            --danger: #ef4444;
            --danger-light: #f87171;
            --warning: #f59e0b;
            --warning-light: #fbbf24;
            --border: #334155;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            min-height: 100vh;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 8s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, 20px); }
        }

        .page-header-content {
            position: relative;
            z-index: 1;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 15px;
        }

        .page-title h1 {
            font-size: 36px;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-subtitle {
            color: rgba(255,255,255,0.8);
            font-size: 16px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 25px;
        }

        .stat-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .stat-label {
            color: rgba(255,255,255,0.7);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            color: white;
            font-size: 32px;
            font-weight: 700;
        }

        /* Alert */
        .alert-success {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%);
            color: white;
            padding: 20px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .alert-success i {
            font-size: 24px;
        }

        /* Kanban Columns */
        .kanban-board {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .kanban-column {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        .column-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border);
        }

        .column-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .column-title h2 {
            font-size: 18px;
            font-weight: 600;
        }

        .column-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .column-pending .column-icon {
            background: linear-gradient(135deg, var(--warning) 0%, var(--warning-light) 100%);
            color: white;
        }

        .column-approved .column-icon {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%);
            color: white;
        }

        .column-rejected .column-icon {
            background: linear-gradient(135deg, var(--danger) 0%, var(--danger-light) 100%);
            color: white;
        }

        .column-count {
            background: rgba(255,255,255,0.1);
            color: var(--text-main);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        /* User Cards */
        .user-cards {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-height: 600px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .user-cards::-webkit-scrollbar {
            width: 6px;
        }

        .user-cards::-webkit-scrollbar-track {
            background: var(--border);
            border-radius: 10px;
        }

        .user-cards::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        .user-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .user-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .user-card:hover {
            background: var(--bg-card-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
        }

        .user-card:hover::before {
            opacity: 1;
        }

        .user-card.admin-card {
            border: 2px solid var(--primary);
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(79, 70, 229, 0.05) 100%);
        }

        .user-card.admin-card::before {
            opacity: 1;
        }

        .user-header {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
        }

        .user-avatar-wrapper {
            position: relative;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
            color: white;
            border: 3px solid var(--bg-card);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .role-indicator {
            position: absolute;
            bottom: -2px;
            left: -2px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            border: 2px solid var(--bg-card);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .role-indicator.admin {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #78350f;
        }

        .role-indicator.user {
            background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
            color: white;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-id {
            background: rgba(255,255,255,0.1);
            color: var(--text-muted);
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .user-phone {
            color: var(--text-muted);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .user-phone i {
            color: var(--primary);
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 10px;
        }

        .role-badge.admin {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3);
        }

        .role-badge.user {
            background: rgba(255,255,255,0.1);
            color: var(--text-muted);
        }

        .user-actions {
            display: flex;
            gap: 8px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border);
        }

        .btn {
            flex: 1;
            border: none;
            cursor: pointer;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
        }

        .btn i {
            font-size: 14px;
        }

        .btn-approve {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%);
            color: white;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);
        }

        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .btn-reject {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-reject:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, var(--danger) 0%, var(--danger-light) 100%);
            color: white;
            border-color: var(--danger);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .protected-label {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state p {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .kanban-board {
                grid-template-columns: 1fr;
            }

            .page-header {
                padding: 30px 20px;
            }

            .page-title h1 {
                font-size: 28px;
            }

            .stats-row {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>

<body>

<div class="dashboard-container">
    
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1>
                    <i class="fas fa-users-cog"></i>
                    إدارة المستخدمين
                </h1>
            </div>
            <p class="page-subtitle">إدارة طلبات التسجيل والمستخدمين المسجلين في النظام</p>
            
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-label">إجمالي المستخدمين</div>
                    <div class="stat-value">{{ count($users) }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">قيد المراجعة</div>
                    <div class="stat-value">{{ $users->where('approval_status', 'pending')->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">مقبول</div>
                    <div class="stat-value">{{ $users->where('approval_status', 'approved')->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">مرفوض</div>
                    <div class="stat-value">{{ $users->where('approval_status', 'rejected')->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="kanban-board">
        
        <!-- Pending Column -->
        <div class="kanban-column column-pending">
            <div class="column-header">
                <div class="column-title">
                    <div class="column-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h2>قيد المراجعة</h2>
                </div>
                <span class="column-count">{{ $users->where('approval_status', 'pending')->count() }}</span>
            </div>
            
            <div class="user-cards">
                @foreach($users->where('approval_status', 'pending') as $user)
                    <div class="user-card {{ $user->role === 'admin' ? 'admin-card' : '' }}">
                        <div class="user-header">
                            <div class="user-avatar-wrapper">
                                <div class="user-avatar">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="User">
                                    @else
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="role-indicator {{ $user->role }}">
                                    <i class="{{ $user->role === 'admin' ? 'fas fa-crown' : 'fas fa-user' }}"></i>
                                </div>
                            </div>
                            
                            <div class="user-details">
                                <div class="user-name">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                    <span class="user-id">#{{ $user->id }}</span>
                                </div>
                                <div class="user-phone">
                                    <i class="fas fa-phone"></i>
                                    {{ $user->phone }}
                                </div>
                                <span class="role-badge {{ $user->role }}">
                                    <i class="{{ $user->role === 'admin' ? 'fas fa-user-shield' : 'fas fa-user-tag' }}"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="user-actions">
                            <form method="POST" action="{{ route('admin.users.approve', $user->id) }}" style="flex: 1;">
                                @csrf
                                <button class="btn btn-approve" title="قبول المستخدم">
                                    <i class="fas fa-check"></i>
                                    قبول
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.users.reject', $user->id) }}" style="flex: 1;">
                                @csrf
                                <button class="btn btn-reject" title="رفض المستخدم">
                                    <i class="fas fa-times"></i>
                                    رفض
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                @if($users->where('approval_status', 'pending')->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>لا توجد طلبات قيد المراجعة</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Approved Column -->
        <div class="kanban-column column-approved">
            <div class="column-header">
                <div class="column-title">
                    <div class="column-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2>مقبول</h2>
                </div>
                <span class="column-count">{{ $users->where('approval_status', 'approved')->count() }}</span>
            </div>
            
            <div class="user-cards">
                @foreach($users->where('approval_status', 'approved') as $user)
                    <div class="user-card {{ $user->role === 'admin' ? 'admin-card' : '' }}">
                        <div class="user-header">
                            <div class="user-avatar-wrapper">
                                <div class="user-avatar">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="User">
                                    @else
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="role-indicator {{ $user->role }}">
                                    <i class="{{ $user->role === 'admin' ? 'fas fa-crown' : 'fas fa-user' }}"></i>
                                </div>
                            </div>
                            
                            <div class="user-details">
                                <div class="user-name">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                    <span class="user-id">#{{ $user->id }}</span>
                                </div>
                                <div class="user-phone">
                                    <i class="fas fa-phone"></i>
                                    {{ $user->phone }}
                                </div>
                                <span class="role-badge {{ $user->role }}">
                                    <i class="{{ $user->role === 'admin' ? 'fas fa-user-shield' : 'fas fa-user-tag' }}"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="user-actions">
                            @if($user->role === 'admin')
                                <span class="protected-label">
                                    <i class="fas fa-shield-alt"></i>
                                    محمي
                                </span>
                            @else
                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم نهائيًا؟');" style="flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-delete" title="حذف المستخدم">
                                        <i class="fas fa-trash-alt"></i>
                                        حذف
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach

                @if($users->where('approval_status', 'approved')->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-user-check"></i>
                        <p>لا توجد مستخدمين مقبولين</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Rejected Column -->
        <div class="kanban-column column-rejected">
            <div class="column-header">
                <div class="column-title">
                    <div class="column-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h2>مرفوض</h2>
                </div>
                <span class="column-count">{{ $users->where('approval_status', 'rejected')->count() }}</span>
            </div>
            
            <div class="user-cards">
                @foreach($users->where('approval_status', 'rejected') as $user)
                    <div class="user-card {{ $user->role === 'admin' ? 'admin-card' : '' }}">
                        <div class="user-header">
                            <div class="user-avatar-wrapper">
                                <div class="user-avatar">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="User">
                                    @else
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="role-indicator {{ $user->role }}">
                                    <i class="{{ $user->role === 'admin' ? 'fas fa-crown' : 'fas fa-user' }}"></i>
                                </div>
                            </div>
                            
                            <div class="user-details">
                                <div class="user-name">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                    <span class="user-id">#{{ $user->id }}</span>
                                </div>
                                <div class="user-phone">
                                    <i class="fas fa-phone"></i>
                                    {{ $user->phone }}
                                </div>
                                <span class="role-badge {{ $user->role }}">
                                    <i class="{{ $user->role === 'admin' ? 'fas fa-user-shield' : 'fas fa-user-tag' }}"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="user-actions">
                            @if($user->role === 'admin')
                                <span class="protected-label">
                                    <i class="fas fa-shield-alt"></i>
                                    محمي
                                </span>
                            @else
                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم نهائيًا؟');" style="flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-delete" title="حذف المستخدم">
                                        <i class="fas fa-trash-alt"></i>
                                        حذف
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach

                @if($users->where('approval_status', 'rejected')->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-user-times"></i>
                        <p>لا توجد مستخدمين مرفوضين</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

</body>
</html>