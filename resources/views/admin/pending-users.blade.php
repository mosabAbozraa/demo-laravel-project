<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | User Grid (Dark)</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>

        /* --- Toolbar (Search & Filter) --- */
.actions-toolbar {
    display: flex;
    gap: 16px;
    align-items: center;
}

/* تصميم موحد للحقول */
.input-group {
    position: relative;
    display: flex;
    align-items: center;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    transition: all 0.2s ease;
    height: 46px; /* ارتفاع ثابت */
}

/* تأثير عند الضغط */
.input-group:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px var(--primary-soft);
    background: var(--bg-hover);
}

.input-group:hover {
    border-color: #52525b;
}

/* أيقونة البحث */
.search-icon {
    position: absolute;
    left: 14px;
    color: var(--text-muted);
    font-size: 14px;
    pointer-events: none;
}

/* حقل البحث */
.search-input {
    background: transparent;
    border: none;
    outline: none;
    color: var(--text-main);
    padding: 0 16px 0 40px; /* مسافة للأيقونة */
    width: 240px;
    font-size: 14px;
    height: 100%;
    font-family: inherit;
}

.search-input::placeholder {
    color: #52525b;
}

/* --- القائمة المنسدلة المحسنة --- */
.custom-select-wrapper {
    position: relative;
    min-width: 160px;
}

/* إخفاء السهم الافتراضي للمتصفح */
.custom-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: transparent;
    border: none;
    outline: none;
    color: var(--text-main);
    padding: 0 40px 0 16px; /* مسافة للسهم الجديد يسار ويمين */
    width: 100%;
    height: 100%;
    font-size: 14px;
    cursor: pointer;
    font-family: inherit;
}

/* تخصيص ألوان الخيارات داخل القائمة */
.custom-select option {
    background-color: var(--bg-card);
    color: var(--text-main);
    padding: 10px;
}

/* أيقونة السهم الجديدة */
.select-arrow {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 12px;
    pointer-events: none; /* للسماح بالضغط على القائمة من خلال الأيقونة */
    transition: transform 0.2s;
}

.input-group:focus-within .select-arrow {
    transform: translateY(-50%) rotate(180deg);
    color: var(--primary);
}

/* تحسين الموبايل */
@media (max-width: 640px) {
    .actions-toolbar {
        width: 100%;
        flex-direction: column;
        align-items: stretch;
    }
    .search-input { width: 100%; }
}
        :root {
            /* --- Warm Dark Palette --- */
            --bg-body: #191919;       /* رمادي غامق جداً ودافئ للخلفية */
            --bg-card: #252526;       /* درجة أفتح قليلاً للكروت */
            --bg-hover: #2d2d2e;      /* عند تمرير الماوس */
            
            --text-main: #e4e4e7;     /* أبيض مائل للرمادي (ليس ناصعاً) */
            --text-muted: #a1a1aa;    /* رمادي متوسط للنصوص الثانوية */
            
            --primary: #6366f1;       /* إنديجو أفتح قليلاً ليناسب الخلفية الداكنة */
            --primary-soft: rgba(99, 102, 241, 0.15);
            
            /* Status Colors (Adjusted for Dark Mode visibility) */
            --success: #10b981;
            --success-soft: rgba(16, 185, 129, 0.15);
            
            --danger: #ef4444;
            --danger-soft: rgba(239, 68, 68, 0.15);
            
            --warning: #f59e0b;
            --warning-soft: rgba(245, 158, 11, 0.15);
            
            --border: #3f3f46;        /* حدود ناعمة */
            --radius: 16px;
            
            /* Shadows are more subtle in dark mode */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
            --shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }

        body {
            margin: 0;
            background-color: var(--bg-body);
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 24px;
        }

        /* --- Header Section --- */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 40px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 20px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            color: #f4f4f5; /* لون فاتح للعنوان */
            letter-spacing: -0.025em;
        }

        .page-title p {
            margin: 8px 0 0;
            color: var(--text-muted);
            font-size: 15px;
        }

        /* --- Grid Layout --- */
        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        /* --- Card Component --- */
        .user-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-sm);
        }

        .user-card:hover {
            transform: translateY(-4px);
            background: var(--bg-hover);
            box-shadow: var(--shadow-hover);
            border-color: #52525b;
        }

        /* Status Top Bar */
        .status-strip {
            height: 4px; /* أنحف قليلاً ليكون أرقى */
            width: 100%;
            opacity: 0.8;
        }
        .user-card.status-approved .status-strip { background-color: var(--success); box-shadow: 0 0 10px var(--success); }
        .user-card.status-rejected .status-strip { background-color: var(--danger); }
        .user-card.status-pending .status-strip { background-color: var(--warning); }
        
        /* Special Admin Styling */
        .user-card.is-admin {
            border: 1px solid #6366f1; /* حدود ملونة للمشرف */
            background: linear-gradient(to bottom right, #252526, #1e1b4b); /* تدرج لوني غامق جداً */
        }
        .user-card.is-admin .status-strip {
            background: var(--primary);
            height: 6px;
        }

        .card-body {
            padding: 24px;
            flex-grow: 1;
        }

        /* Header inside card */
        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 20px;
        }

        .user-id {
            font-size: 12px;
            font-family: monospace;
            color: var(--text-muted);
            background: rgba(255,255,255,0.05); /* شفافية بدلاً من لون ثابت */
            padding: 4px 8px;
            border-radius: 6px;
        }

        .status-pill {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 20px;
            letter-spacing: 0.05em;
        }
        .pill-approved { background: var(--success-soft); color: #34d399; }
        .pill-rejected { background: var(--danger-soft); color: #f87171; }
        .pill-pending { background: var(--warning-soft); color: #fbbf24; }

        /* Profile Info */
        .profile-section {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
        }

        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 18px; 
            object-fit: cover;
            background: #2d2d30;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 700;
            border: 2px solid rgba(255,255,255,0.05);
        }

        .user-details h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: var(--text-main);
        }

        .role-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            margin-top: 5px;
            color: var(--text-muted);
            font-weight: 500;
        }
        
        .role-tag.admin-tag { color: #818cf8; font-weight: 600; }

        /* Meta Data List */
        .meta-list {
            margin-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
            padding-top: 15px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }
        .meta-item i { width: 16px; text-align: center; color: #52525b; }

        /* --- Footer / Actions --- */
        .card-footer {
            padding: 16px 24px;
            background: rgba(0,0,0,0.2); /* خلفية داكنة للفوتر */
            border-top: 1px solid var(--border);
            display: flex;
            gap: 12px;
        }

        .btn {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* Dark Mode Button Styles */
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: #4f46e5; }

        .btn-success { background: #059669; color: white; } /* أخضر أغمق قليلاً */
        .btn-success:hover { background: #047857; }

        /* Reject/Delete buttons need to look good on dark bg */
        .btn-danger-outline { 
            background: transparent; 
            border: 1px solid #7f1d1d; 
            color: #f87171; 
        }
        .btn-danger-outline:hover { 
            background: rgba(239, 68, 68, 0.1); 
            border-color: #ef4444; 
        }

        .btn-reject { 
            background: transparent; 
            border: 1px solid #52525b; 
            color: var(--text-muted); 
        }
        .btn-reject:hover { 
            background: rgba(255,255,255,0.05); 
            color: #e4e4e7; 
            border-color: #71717a; 
        }

        .locked-badge {
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #52525b;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px;
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 2px dashed var(--border);
        }

        /* Success Alert (Dark) */
        .floating-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #27272a;
            padding: 16px 24px;
            border-left: 4px solid var(--success);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border-radius: 8px;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-main);
            animation: slideIn 0.3s ease-out;
            border: 1px solid var(--border);
        }
        
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        @media (max-width: 640px) {
            .users-grid { grid-template-columns: 1fr; }
            .page-header { flex-direction: column; align-items: start; gap: 15px; }
        }
    </style>
</head>

<body>

    @if(session('success'))
        <div class="floating-alert">
            <i class="fas fa-check-circle" style="color: var(--success); font-size: 20px;"></i>
            <div>
                <strong style="display:block; font-size:14px;">Success</strong>
                <span style="color: var(--text-muted); font-size:13px;">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="dashboard-container">
        
<div class="page-header">
    <div class="page-title">
        <h1>User Management</h1>
        <p>Manage access, approvals, and user roles.</p>
    </div>

    <div class="actions-toolbar">
        
        <div class="input-group">
            <i class="fas fa-search search-icon"></i>
            <input 
                id="userSearch"
                type="text" 
                class="search-input"
                placeholder="Search users..."
                autocomplete="off"
            >
        </div>

        <div class="input-group custom-select-wrapper">
            <select id="statusFilter" class="custom-select">
                <option value="all">All Users</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="admin">Admins</option>
            </select>
            <i class="fas fa-chevron-down select-arrow"></i>
        </div>

    </div>
</div>


    <!-- SEARCH & FILTER -->
    <div style="display:flex; gap:14px; align-items:center; flex-wrap:wrap;">
        
       
      
    </div>
</div>


        <div class="users-grid">
            
            @foreach($users as $user)
<div 
    class="user-card status-{{ $user->approval_status }} {{ $user->role === 'admin' ? 'is-admin' : '' }}"
    data-name="{{ strtolower($user->first_name . ' ' . $user->last_name . ' ' . $user->phone) }}"
    data-status="{{ $user->approval_status }}"
    data-role="{{ $user->role }}"
>

                    
                    <div class="status-strip"></div>

                    <div class="card-body">
                        <div class="card-top">
                            <span class="user-id">#{{ $user->id }}</span>
                            
                            @if($user->approval_status == 'approved')
                                <span class="status-pill pill-approved"><i class="fas fa-check" style="margin-right:4px;"></i> Active</span>
                            @elseif($user->approval_status == 'rejected')
                                <span class="status-pill pill-rejected"><i class="fas fa-ban" style="margin-right:4px;"></i> Rejected</span>
                            @else
                                <span class="status-pill pill-pending"><i class="fas fa-clock" style="margin-right:4px;"></i> Pending</span>
                            @endif
                        </div>

                        <div class="profile-section">
                            <div class="avatar">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="User" class="avatar">
                                @else
                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="user-details">
                                <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                                <div class="role-tag {{ $user->role === 'admin' ? 'admin-tag' : '' }}">
                                    @if($user->role === 'admin')
                                        <i class="fas fa-crown"></i> System Admin
                                    @else
                                        <i class="fas fa-user"></i> Standard User
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="meta-list">
                            <div class="meta-item">
                                <i class="fas fa-phone-alt"></i> {{ $user->phone }}
                            </div>
                            <div class="meta-item">
                                <i class="far fa-calendar-alt"></i> Joined at: {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        
                        @if($user->approval_status == 'pending')
                            <form method="POST" action="{{ route('admin.users.reject', $user->id) }}" style="flex:1">
                                @csrf
                                <button class="btn btn-reject">Reject</button>
                            </form>
                            
                            <form method="POST" action="{{ route('admin.users.approve', $user->id) }}" style="flex:1">
                                @csrf
                                <button class="btn btn-success">Approve</button>
                            </form>

                        @else
                            @if($user->role === 'admin')
                                <div class="locked-badge">
                                    <i class="fas fa-lock"></i> Account Protected
                                </div>
                            @else
                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Permanently delete this user?');" style="flex:1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger-outline">
                                        <i class="fas fa-trash-alt"></i> Remove User
                                    </button>
                                </form>
                            @endif
                        @endif

                    </div>
                </div>
            @endforeach

            @if($users->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-users" style="font-size: 48px; color: #52525b; margin-bottom: 20px;"></i>
                    <h3 style="margin: 0; color: var(--text-main);">No users found</h3>
                    <p style="color: var(--text-muted);">There are no registered users to display at the moment.</p>
                </div>
            @endif

        </div>
    </div>
<script>
    const searchInput = document.getElementById('userSearch');
    const statusFilter = document.getElementById('statusFilter');
    const cards = document.querySelectorAll('.user-card');

    function filterUsers() {
        const searchValue = searchInput.value.toLowerCase();
        const filterValue = statusFilter.value;

        cards.forEach(card => {
            const name = card.dataset.name;
            const status = card.dataset.status;
            const role = card.dataset.role;

            const matchesSearch = name.includes(searchValue);

            let matchesFilter = false;
            if (filterValue === 'all') matchesFilter = true;
            else if (filterValue === 'admin') matchesFilter = role === 'admin';
            else matchesFilter = status === filterValue;

            card.style.display = (matchesSearch && matchesFilter) ? 'flex' : 'none';
        });
    }

    searchInput.addEventListener('input', filterUsers);
    statusFilter.addEventListener('change', filterUsers);
</script>

</body>
</html>
