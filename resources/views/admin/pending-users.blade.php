<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | User Grid (Dark)</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- 1. CSS Variables form First Code (Warm Dark Theme) --- */
        :root {
            --bg-body: #191919;
            --bg-card: #252526;
            --bg-hover: #2d2d2e;
            --text-main: #e4e4e7;
            --text-muted: #a1a1aa;
            --primary: #6366f1;
            --primary-soft: rgba(99, 102, 241, 0.15);
            --success: #10b981;
            --success-soft: rgba(16, 185, 129, 0.15);
            --danger: #ef4444;
            --danger-soft: rgba(239, 68, 68, 0.15);
            --warning: #f59e0b;
            --warning-soft: rgba(245, 158, 11, 0.15);
            --border: #3f3f46;
            --radius: 16px;
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
            color: #f4f4f5;
            letter-spacing: -0.025em;
        }

        .page-title p {
            margin: 8px 0 0;
            color: var(--text-muted);
            font-size: 15px;
        }

        /* --- Toolbar (Search & Filter) --- */
        .actions-toolbar {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            transition: all 0.2s ease;
            height: 46px;
        }

        .input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
            background: var(--bg-hover);
        }

        .input-group:hover {
            border-color: #52525b;
        }

        /* LTR Specific Adjustments for Search */
        .search-icon {
            position: absolute;
            left: 14px; /* LTR: Moved to left */
            right: auto;
            color: var(--text-muted);
            font-size: 14px;
            pointer-events: none;
        }

        .search-input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-main);
            padding: 0 16px 0 40px; /* LTR: Padding swapped */
            width: 240px;
            font-size: 14px;
            height: 100%;
            font-family: inherit;
            text-align: left; /* LTR */
        }

        .search-input::placeholder {
            color: #52525b;
        }

        .custom-select-wrapper {
            position: relative;
            min-width: 160px;
        }

        .custom-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-main);
            padding: 0 40px 0 16px; /* LTR: Padding swapped */
            width: 100%;
            height: 100%;
            font-size: 14px;
            cursor: pointer;
            font-family: inherit;
        }

        .custom-select option {
            background-color: var(--bg-card);
            color: var(--text-main);
            padding: 10px;
        }

        .select-arrow {
            position: absolute;
            right: 14px; /* LTR: Moved to right */
            left: auto;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 12px;
            pointer-events: none;
            transition: transform 0.2s;
        }

        .input-group:focus-within .select-arrow {
            transform: translateY(-50%) rotate(180deg);
            color: var(--primary);
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

        .status-strip {
            height: 4px;
            width: 100%;
            opacity: 0.8;
        }
        .user-card.status-approved .status-strip { background-color: var(--success); box-shadow: 0 0 10px var(--success); }
        .user-card.status-rejected .status-strip { background-color: var(--danger); }
        .user-card.status-pending .status-strip { background-color: var(--warning); }

        .user-card.is-admin {
            border: 1px solid #6366f1;
            background: linear-gradient(to bottom right, #252526, #1e1b4b); /* LTR Gradient Direction */
        }
        .user-card.is-admin .status-strip {
            background: var(--primary);
            height: 6px;
        }

        .card-body {
            padding: 24px;
            flex-grow: 1;
        }

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
            background: rgba(255,255,255,0.05);
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

        .role-tag.admin-tag { color: #818cf8; font-weight: 600; }

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

        .card-footer {
            padding: 16px 24px;
            background: rgba(0,0,0,0.2);
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
            font-family: 'Inter', sans-serif;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: #4f46e5; }

        .btn-success { background: #059669; color: white; }
        .btn-success:hover { background: #047857; }

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

        .floating-alert {
            position: fixed;
            top: 20px;
            right: 20px; /* LTR: Alert on right */
            left: auto;
            background: #27272a;
            padding: 16px 24px;
            border-left: 4px solid var(--success); /* LTR: Border Left */
            border-right: none;
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

        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        @media (max-width: 640px) {
            .users-grid { grid-template-columns: 1fr; }
            .page-header { flex-direction: column; align-items: start; gap: 15px; }
            .actions-toolbar { width: 100%; flex-direction: column; align-items: stretch; }
            .search-input { width: 100%; }
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
                <p>Manage permissions, registration requests, and user statuses.</p>
            </div>

            <div class="actions-toolbar">

                <div class="input-group">
                    <i class="fas fa-search search-icon"></i>
                    <input
                        id="userSearch"
                        type="text"
                        class="search-input"
                        placeholder="Search for user..."
                        autocomplete="off"
                    >
                </div>

                <div class="input-group custom-select-wrapper">
                    <select id="statusFilter" class="custom-select">
                        <option value="all">All Users</option>
                        <option value="pending">Pending Review</option>
                        <option value="approved">Active / Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="admin">Admins</option>
                    </select>
                    <i class="fas fa-chevron-down select-arrow"></i>
                </div>

            </div>
        </div>

        <div class="users-grid">

            {{-- LOGIC PART 1: PENDING USERS (Keeping Logic of Code 2) --}}
            @foreach($users->where('approval_status', 'pending') as $user)
                <div class="user-card status-pending {{ $user->role === 'admin' ? 'is-admin' : '' }}"
                    data-name="{{ strtolower($user->first_name . ' ' . $user->last_name . ' ' . $user->phone) }}"
                    data-status="pending"
                    data-role="{{ $user->role }}">

                    <div class="status-strip"></div>

                    <div class="card-body">
                        <div class="card-top">
                            <span class="user-id">#{{ $user->id }}</span>
                            <span class="status-pill pill-pending"><i class="fas fa-clock" style="margin-right:4px;"></i> Pending</span>
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
                                        <i class="fas fa-user"></i> User
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="meta-list">
                            <div class="meta-item">
                                <i class="fas fa-phone-alt"></i> {{ $user->phone }}
                            </div>
                            <div class="meta-item">
                                <i class="far fa-calendar-alt"></i> Joined: {{ $user->created_at ? $user->created_at->format('Y/m/d') : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <form method="POST" action="{{ route('admin.users.reject', $user->id) }}" style="flex:1">
                            @csrf
                            <button class="btn btn-reject">Reject</button>
                        </form>

                        <form method="POST" action="{{ route('admin.users.approve', $user->id) }}" style="flex:1">
                            @csrf
                            <button class="btn btn-success">Approve</button>
                        </form>
                    </div>
                </div>
            @endforeach

            {{-- LOGIC PART 2: APPROVED USERS (Keeping Logic of Code 2) --}}
            @foreach($users->where('approval_status', 'approved') as $user)
                <div class="user-card status-approved {{ $user->role === 'admin' ? 'is-admin' : '' }}"
                    data-name="{{ strtolower($user->first_name . ' ' . $user->last_name . ' ' . $user->phone) }}"
                    data-status="approved"
                    data-role="{{ $user->role }}">

                    <div class="status-strip"></div>

                    <div class="card-body">
                        <div class="card-top">
                            <span class="user-id">#{{ $user->id }}</span>
                            <span class="status-pill pill-approved"><i class="fas fa-check" style="margin-right:4px;"></i> Active</span>
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
                                        <i class="fas fa-user"></i> User
                                    @endif
                                </div>
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

                        <div class="meta-list">
                            <div class="meta-item">
                                <i class="fas fa-phone-alt"></i> {{ $user->phone }}
                            </div>
                            <div class="meta-item">
                                <i class="far fa-calendar-alt"></i> Joined: {{ $user->created_at ? $user->created_at->format('Y/m/d') : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        @if($user->role === 'admin')
                            <div class="locked-badge">
                                <i class="fas fa-lock"></i> Protected Account
                            </div>
                        @else
                            <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?');" style="flex:1">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger-outline">
                                    <i class="fas fa-trash-alt"></i> Delete User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach

            {{-- LOGIC PART 3: REJECTED USERS (Specifically keeping $rejected_users logic from Code 2) --}}
            @foreach($rejected_users as $user)
                <div class="user-card status-rejected {{ $user->role === 'admin' ? 'is-admin' : '' }}"
                    data-name="{{ strtolower($user->first_name . ' ' . $user->last_name . ' ' . $user->phone) }}"
                    data-status="rejected"
                    data-role="{{ $user->role }}">

                    <div class="status-strip"></div>

                    <div class="card-body">
                        <div class="card-top">
                            <span class="user-id">#{{ $user->id }}</span>
                            <span class="status-pill pill-rejected"><i class="fas fa-ban" style="margin-right:4px;"></i> Rejected</span>
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
                                        <i class="fas fa-user"></i> User
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="meta-list">
                            <div class="meta-item">
                                <i class="fas fa-phone-alt"></i> {{ $user->phone }}
                            </div>
                            <div class="meta-item">
                                <i class="far fa-calendar-alt"></i> Joined: {{ $user->created_at ? $user->created_at->format('Y/m/d') : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        @if($user->role === 'admin')
                            <div class="locked-badge">
                                <i class="fas fa-lock"></i> Protected Account
                            </div>
                        @else
                            <form method="POST" action="{{ route('admin.rejected.users.delete', $user->id) }}" onsubmit="return confirm('Are you sure you want to permanently delete this user?');" style="flex:1">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger-outline">
                                    <i class="fas fa-trash-alt"></i> Delete Permanently
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach

            @if($users->isEmpty() && $rejected_users->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-users" style="font-size: 48px; color: #52525b; margin-bottom: 20px;"></i>
                    <h3 style="margin: 0; color: var(--text-main);">No Users Found</h3>
                    <p style="color: var(--text-muted);">No data to display at the moment.</p>
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
