<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | User Management</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-body: #f3f4f6;
            --bg-card: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --primary: #4f46e5;
            --primary-light: #e0e7ff;
            --success: #10b981;
            --success-bg: #d1fae5;
            --danger: #ef4444;
            --danger-bg: #fee2e2;
            --warning: #f59e0b;
            --warning-bg: #fef3c7;
            --border: #e5e7eb;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body {
            margin: 0;
            background-color: var(--bg-body);
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            color: #1f2937;
        }

        .page-title p {
            margin: 5px 0 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .alert-success {
            background-color: var(--success-bg);
            color: #065f46;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            border: 1px solid #a7f3d0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card {
            background: var(--bg-card);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        th {
            background-color: #f9fafb;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: left;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #f9fafb;
        }

        .tr-admin {
            background-color: #f5f7ff !important; 
            position: relative;
        }
        
        .tr-admin td:first-child {
            box-shadow: inset 4px 0 0 var(--primary); 
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;       
            height: 40px;
            border-radius: 50%;
            overflow: hidden; 
            background-color: #e0e7ff; 
            flex-shrink: 0;  
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--primary);
            border: 2px solid white; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 500;
            color: var(--text-main);
        }

        .user-phone {
            font-size: 12px;
            color: var(--text-muted);
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
            background-color: #f3f4f6;
            color: #374151;
        }

      
        .role-badge.admin {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-approved { background-color: var(--success-bg); color: #059669; }
        .status-rejected { background-color: var(--danger-bg); color: #dc2626; }
        .status-pending { background-color: var(--warning-bg); color: #d97706; }

        .actions-cell {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn {
            border: none;
            cursor: pointer;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-approve { background-color: var(--success); color: white; }
        .btn-approve:hover { background-color: #059669; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3); }

        .btn-reject { background-color: white; border: 1px solid var(--border); color: var(--text-muted); }
        .btn-reject:hover { background-color: #fef2f2; color: var(--danger); border-color: #fecaca; }

        .btn-delete { background-color: white; border: 1px solid var(--border); color: var(--danger); }
        .btn-delete:hover { background-color: var(--danger); color: white; }

        .protected-label {
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 12px;
            background: rgba(255,255,255,0.5);
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            .dashboard-container { padding: 10px; margin: 20px auto; }
            th, td { padding: 12px 15px; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        }
    </style>
</head>

<body>

<div class="dashboard-container">
    
    <div class="page-header">
        <div class="page-title">
            <h1>User Management</h1>
            <p>Manage pending approvals and registered users.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="30%">User Profile</th>
                    <th width="15%">Role</th>
                    <th width="15%">Status</th>
                    <th width="35%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="{{ $user->role === 'admin' ? 'tr-admin' : '' }}">
                        <td style="color: var(--text-muted); font-weight: 500;">#{{ $user->id }}</td>
                        
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="User Image">
                                    @else
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="user-info">
                                    <span class="user-name">{{ $user->first_name }} {{ $user->last_name }}</span>
                                    <span class="user-phone">{{ $user->phone }}</span>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="role-badge {{ $user->role === 'admin' ? 'admin' : '' }}">
                                <i class="{{ $user->role === 'admin' ? 'fas fa-user-shield' : 'fas fa-user-tag' }}" style="margin-right: 6px; font-size: 10px;"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td>
                            @if($user->approval_status == 'approved')
                                <span class="status-badge status-approved">Approved</span>
                            @elseif($user->approval_status == 'rejected')
                                <span class="status-badge status-rejected">Rejected</span>
                            @else
                                <span class="status-badge status-pending">Pending</span>
                            @endif
                        </td>

                        <td>
                            <div class="actions-cell">
                                @if($user->approval_status == 'pending')
                                    <form method="POST" action="{{ route('admin.users.approve', $user->id) }}">
                                        @csrf
                                        <button class="btn btn-approve" title="Approve User">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.reject', $user->id) }}">
                                        @csrf
                                        <button class="btn btn-reject" title="Reject User">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                
                                @else
                                    @if($user->role === 'admin')
                                        <span class="protected-label" title="Cannot delete Admin">
                                            <i class="fas fa-shield-alt"></i> Protected
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Are you sure you want to permanently delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-delete" title="Delete User">
                                                <i class="fas fa-trash-alt"></i> Delete User
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        @if($users->isEmpty())
            <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                <i class="fas fa-users-slash" style="font-size: 48px; margin-bottom: 10px; opacity: 0.5;"></i>
                <p>No users found.</p>
            </div>
        @endif
    </div>

</div>

</body>
</html>