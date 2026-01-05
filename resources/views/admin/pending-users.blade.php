<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxStay Admin | Pending Users</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root{
            /* LuxStay brand */
            --brand: #10b981;         /* emerald */
            --brand2:#34d399;
            --ink:#0b1220;
            --bg:#f6f7fb;
            --card:#ffffff;
            --border: rgba(15, 23, 42, 0.10);
            --text:#0f172a;
            --muted:#64748b;

            --warn:#f59e0b;
            --ok:#10b981;
            --bad:#ef4444;

            --shadow: 0 20px 60px rgba(15,23,42,0.12);
            --shadow-soft: 0 10px 30px rgba(15,23,42,0.08);
            --radius: 18px;
        }

        *{ box-sizing: border-box; }
        body{
            margin:0;
            font-family:"Plus Jakarta Sans", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* Background */
        .bg{
            position: fixed;
            inset:0;
            z-index:-1;
            background:
                radial-gradient(900px 520px at 15% 10%, rgba(16,185,129,0.14), transparent 55%),
                radial-gradient(900px 520px at 85% 15%, rgba(99,102,241,0.10), transparent 60%),
                linear-gradient(180deg, #f7f8fc, #f3f5fb);
        }
        .grid{
            position: fixed;
            inset:0;
            z-index:-1;
            opacity:0.55;
            background-image:
                linear-gradient(to right, rgba(15,23,42,0.06) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(15,23,42,0.06) 1px, transparent 1px);
            background-size: 52px 52px;
            mask-image: radial-gradient(circle at 50% 0%, black 55%, transparent 80%);
        }

        .wrap{
            max-width: 1200px;
            margin: 24px auto 40px;
            padding: 0 18px;
        }

        /* Top bar */
        .topbar{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:14px;
            padding: 16px 18px;
            border:1px solid var(--border);
            border-radius: var(--radius);
            background: rgba(255,255,255,0.86);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-soft);
            position: sticky;
            top: 14px;
            z-index: 10;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:12px;
            min-width: 220px;
        }
        .mark{
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display:flex;
            align-items:center;
            justify-content:center;
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            color: #fff;
            font-weight: 800;
            letter-spacing: .6px;
            box-shadow: 0 14px 30px rgba(16,185,129,0.22);
            user-select:none;
        }
        .brand-title{
            display:flex;
            flex-direction:column;
            line-height:1.15;
        }
        .brand-title strong{
            font-size: 15px;
            letter-spacing:-.2px;
        }
        .brand-title span{
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .page-meta{
            display:flex;
            flex-direction:column;
            gap:4px;
            flex:1;
        }
        .page-meta h1{
            margin:0;
            font-size: 16px;
            letter-spacing:-.2px;
        }
        .page-meta p{
            margin:0;
            font-size: 12px;
            color: var(--muted);
        }

        .search{
            display:flex;
            align-items:center;
            gap:10px;
            min-width: 280px;
        }
        .search .field{
            position:relative;
            width: 100%;
        }
        .search input{
            width:100%;
            padding: 12px 40px 12px 40px;
            border-radius: 14px;
            border: 1px solid rgba(15,23,42,0.12);
            background: #fff;
            font-size: 13px;
            transition: box-shadow .18s ease, border-color .18s ease;
        }
        .search input:focus{
            border-color: rgba(16,185,129,0.55);
            box-shadow: 0 0 0 4px rgba(16,185,129,0.14);
            outline: none;
        }
        .search .icon{
            position:absolute;
            right: 14px;
            top:50%;
            transform:translateY(-50%);
            color: rgba(100,116,139,0.9);
            font-size: 14px;
        }
        .search .clear{
            position:absolute;
            left: 10px;
            top:50%;
            transform:translateY(-50%);
            border:none;
            background: transparent;
            cursor:pointer;
            color: rgba(100,116,139,0.9);
            padding: 6px 8px;
            border-radius: 10px;
            display:none;
        }
        .search .clear:hover{
            background: rgba(15,23,42,0.06);
        }

        @media (max-width: 980px){
            .topbar{ flex-wrap: wrap; }
            .search{ min-width: 100%; }
            .brand{ min-width: auto; }
        }

        /* Stats */
        .stats{
            display:grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin: 14px 0 18px;
        }
        @media (max-width: 980px){
            .stats{ grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 460px){
            .stats{ grid-template-columns: 1fr; }
        }

        .stat{
            background: rgba(255,255,255,0.86);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-soft);
            padding: 14px 14px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 10px;
        }
        .stat .left{
            display:flex;
            flex-direction:column;
            gap:6px;
        }
        .stat .label{
            font-size: 12px;
            color: var(--muted);
        }
        .stat .value{
            font-size: 22px;
            font-weight: 800;
            letter-spacing:-.4px;
        }
        .stat .badge{
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display:flex;
            align-items:center;
            justify-content:center;
            border: 1px solid rgba(15,23,42,0.10);
            background: #fff;
            color: var(--text);
        }
        .stat.warn .badge{ color: var(--warn); }
        .stat.ok .badge{ color: var(--ok); }
        .stat.bad .badge{ color: var(--bad); }
        .stat.all .badge{ color: var(--brand); }

        /* Kanban */
        .board{
            display:grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            align-items:start;
        }
        @media (max-width: 980px){
            .board{ grid-template-columns: 1fr; }
        }

        .col{
            background: rgba(255,255,255,0.86);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-soft);
            overflow:hidden;
        }
        .col-head{
            padding: 14px 14px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            border-bottom: 1px solid rgba(15,23,42,0.08);
            background: rgba(255,255,255,0.65);
        }
        .col-title{
            display:flex;
            align-items:center;
            gap:10px;
            font-weight: 800;
            font-size: 13px;
        }
        .dot{
            width:10px;
            height:10px;
            border-radius: 999px;
            box-shadow: 0 0 0 4px rgba(15,23,42,0.06);
        }
        .dot.pending{ background: var(--warn); }
        .dot.approved{ background: var(--ok); }
        .dot.rejected{ background: var(--bad); }

        .count{
            font-size: 12px;
            color: var(--muted);
            background: rgba(15,23,42,0.06);
            border: 1px solid rgba(15,23,42,0.08);
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 800;
        }

        .col-body{
            padding: 12px;
            display:grid;
            gap: 10px;
            min-height: 120px;
        }

        /* User card */
        .u{
            background: #fff;
            border: 1px solid rgba(15,23,42,0.10);
            border-radius: 16px;
            padding: 12px;
            box-shadow: 0 10px 22px rgba(15,23,42,0.06);
            transition: transform .12s ease, box-shadow .12s ease;
        }
        .u:hover{
            transform: translateY(-2px);
            box-shadow: 0 16px 30px rgba(15,23,42,0.10);
        }

        .u-top{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 10px;
        }
        .u-left{
            display:flex;
            align-items:center;
            gap: 10px;
            min-width: 0;
        }
        .avatar{
            width: 42px;
            height: 42px;
            border-radius: 14px;
            overflow:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
            background: linear-gradient(135deg, rgba(16,185,129,0.18), rgba(99,102,241,0.10));
            border: 1px solid rgba(15,23,42,0.08);
            color: var(--brand-ink, #064e3b);
            font-weight: 900;
            flex: 0 0 auto;
        }
        .avatar img{
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
        }

        .who{
            min-width: 0;
            display:flex;
            flex-direction:column;
            gap: 4px;
        }
        .name{
            display:flex;
            gap: 8px;
            align-items:baseline;
            min-width:0;
        }
        .name strong{
            font-size: 13px;
            letter-spacing: -.2px;
            white-space: nowrap;
            overflow:hidden;
            text-overflow: ellipsis;
            max-width: 190px;
        }
        .id{
            font-size: 11px;
            color: var(--muted);
            background: rgba(15,23,42,0.05);
            border: 1px solid rgba(15,23,42,0.08);
            padding: 3px 8px;
            border-radius: 999px;
            flex: 0 0 auto;
        }
        .phone{
            font-size: 12px;
            color: var(--muted);
            display:flex;
            align-items:center;
            gap: 6px;
        }
        .phone i{ font-size: 12px; }

        .chips{
            margin-top: 10px;
            display:flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .chip{
            font-size: 11px;
            font-weight: 800;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(15,23,42,0.10);
            background: rgba(15,23,42,0.04);
            color: rgba(15,23,42,0.85);
            display:inline-flex;
            align-items:center;
            gap: 7px;
        }
        .chip.admin{
            background: rgba(16,185,129,0.10);
            border-color: rgba(16,185,129,0.25);
            color: #065f46;
        }

        .actions{
            margin-top: 12px;
            display:flex;
            gap: 8px;
        }

        .btn{
            width: 100%;
            border:none;
            padding: 10px 10px;
            border-radius: 14px;
            font-size: 12px;
            font-weight: 900;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            gap: 8px;
            transition: transform .12s ease, box-shadow .12s ease, filter .12s ease;
        }
        .btn:hover{ transform: translateY(-1px); filter:saturate(1.03); }
        .btn:active{ transform: translateY(0); }

        .btn-approve{
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            color:#fff;
            box-shadow: 0 14px 26px rgba(16,185,129,0.20);
        }
        .btn-reject{
            background: rgba(245,158,11,0.12);
            border: 1px solid rgba(245,158,11,0.25);
            color: #92400e;
        }
        .btn-delete{
            background: rgba(239,68,68,0.10);
            border: 1px solid rgba(239,68,68,0.22);
            color: #991b1b;
        }

        .protected{
            width:100%;
            padding: 10px 10px;
            border-radius: 14px;
            font-size: 12px;
            font-weight: 900;
            border: 1px solid rgba(15,23,42,0.10);
            background: rgba(15,23,42,0.04);
            color: rgba(15,23,42,0.70);
            display:flex;
            align-items:center;
            justify-content:center;
            gap: 8px;
        }

        .empty{
            border: 1px dashed rgba(15,23,42,0.18);
            border-radius: 16px;
            padding: 18px 12px;
            color: var(--muted);
            display:flex;
            align-items:center;
            justify-content:center;
            gap: 10px;
            background: rgba(255,255,255,0.7);
        }

        /* Modal confirm */
        .modal{
            position: fixed;
            inset:0;
            display:none;
            align-items:center;
            justify-content:center;
            padding: 18px;
            background: rgba(2,6,23,0.45);
            z-index: 999;
        }
        .modal.show{ display:flex; }
        .modal-card{
            width: 100%;
            max-width: 440px;
            background: #fff;
            border-radius: 18px;
            border: 1px solid rgba(15,23,42,0.12);
            box-shadow: var(--shadow);
            padding: 16px;
        }
        .modal-head{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 10px;
        }
        .modal-head h3{
            margin:0;
            font-size: 14px;
            letter-spacing:-.2px;
        }
        .modal-close{
            border:none;
            background: rgba(15,23,42,0.06);
            border-radius: 12px;
            padding: 8px 10px;
            cursor:pointer;
        }
        .modal p{
            margin: 10px 0 14px;
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
        }
        .modal-actions{
            display:flex;
            gap: 10px;
        }
        .modal-actions .btn{
            padding: 10px 12px;
        }
        .btn-ghost{
            background: rgba(15,23,42,0.06);
            border: 1px solid rgba(15,23,42,0.10);
            color: rgba(15,23,42,0.80);
            box-shadow: none;
        }
    </style>
</head>

<body>
<div class="bg"></div>
<div class="grid"></div>

@php
    $pendingUsers  = $users->where('approval_status', 'pending');
    $approvedUsers = $users->where('approval_status', 'approved');
    $rejectedUsers = $users->where('approval_status', 'rejected');

    $totalUsers = $users->count();
@endphp

<div class="wrap">

    <div class="topbar">
        <div class="brand">
            <div class="mark">LS</div>
            <div class="brand-title">
                <strong>LuxStay</strong>
                <span>Admin Console</span>
            </div>
        </div>

        <div class="page-meta">
            <h1>إدارة المستخدمين • مراجعة الطلبات</h1>
            <p>راجع طلبات التسجيل وفعّل الحسابات أو ارفضها بشكل منظم.</p>
        </div>

        <div class="search">
            <div class="field">
                <button class="clear" type="button" id="clearSearch" title="مسح البحث">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <i class="fa-solid fa-magnifying-glass icon"></i>
                <input id="searchInput" type="text" placeholder="ابحث بالاسم، الهاتف، أو #ID..." autocomplete="off">
            </div>
        </div>
    </div>

    <div class="stats">
        <div class="stat warn">
            <div class="left">
                <div class="label">طلبات جديدة (Pending)</div>
                <div class="value" id="statPending">{{ $pendingUsers->count() }}</div>
            </div>
            <div class="badge"><i class="fa-solid fa-hourglass-half"></i></div>
        </div>

        <div class="stat ok">
            <div class="left">
                <div class="label">أعضاء نشطين (Approved)</div>
                <div class="value" id="statApproved">{{ $approvedUsers->count() }}</div>
            </div>
            <div class="badge"><i class="fa-solid fa-circle-check"></i></div>
        </div>

        <div class="stat bad">
            <div class="left">
                <div class="label">مرفوضين (Rejected)</div>
                <div class="value" id="statRejected">{{ $rejectedUsers->count() }}</div>
            </div>
            <div class="badge"><i class="fa-solid fa-circle-xmark"></i></div>
        </div>

        <div class="stat all">
            <div class="left">
                <div class="label">إجمالي المستخدمين</div>
                <div class="value" id="statAll">{{ $totalUsers }}</div>
            </div>
            <div class="badge"><i class="fa-solid fa-users"></i></div>
        </div>
    </div>

    <div class="board">
        <!-- Pending -->
        <section class="col" aria-label="Pending users">
            <div class="col-head">
                <div class="col-title">
                    <span class="dot pending"></span>
                    طلبات التسجيل
                </div>
                <span class="count" id="countPending">{{ $pendingUsers->count() }}</span>
            </div>
            <div class="col-body" id="colPending">
                @forelse($pendingUsers as $user)
                    <article class="u user-item"
                        data-search="{{ strtolower($user->first_name.' '.$user->last_name.' '.$user->phone.' #'.$user->id.' '.$user->role) }}">
                        <div class="u-top">
                            <div class="u-left">
                                <div class="avatar">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="User">
                                    @else
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    @endif
                                </div>

                                <div class="who">
                                    <div class="name">
                                        <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                                        <span class="id">#{{ $user->id }}</span>
                                    </div>
                                    <div class="phone"><i class="fa-solid fa-phone"></i> {{ $user->phone }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="chips">
                            <span class="chip {{ $user->role === 'admin' ? 'admin' : '' }}">
                                <i class="fa-solid {{ $user->role === 'admin' ? 'fa-shield-halved' : 'fa-user' }}"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                            <span class="chip">
                                <i class="fa-solid fa-hourglass-half"></i>
                                Pending
                            </span>
                        </div>

                        <div class="actions">
                            <form method="POST" action="{{ route('admin.users.approve', $user->id) }}" style="flex:1;">
                                @csrf
                                <button class="btn btn-approve" type="submit" title="قبول">
                                    <i class="fa-solid fa-check"></i> قبول
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.users.reject', $user->id) }}" style="flex:1;">
                                @csrf
                                <button class="btn btn-reject" type="submit" title="رفض">
                                    <i class="fa-solid fa-xmark"></i> رفض
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="empty">
                        <i class="fa-regular fa-folder-open"></i>
                        <span>لا يوجد طلبات حالياً</span>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Approved -->
        <section class="col" aria-label="Approved users">
            <div class="col-head">
                <div class="col-title">
                    <span class="dot approved"></span>
                    الأعضاء النشطين
                </div>
                <span class="count" id="countApproved">{{ $approvedUsers->count() }}</span>
            </div>

            <div class="col-body" id="colApproved">
                @forelse($approvedUsers as $user)
                    <article class="u user-item"
                        data-search="{{ strtolower($user->first_name.' '.$user->last_name.' '.$user->phone.' #'.$user->id.' '.$user->role) }}">
                        <div class="u-top">
                            <div class="u-left">
                                <div class="avatar">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="User">
                                    @else
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    @endif
                                </div>

                                <div class="who">
                                    <div class="name">
                                        <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                                        <span class="id">#{{ $user->id }}</span>
                                    </div>
                                    <div class="phone"><i class="fa-solid fa-phone"></i> {{ $user->phone }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="chips">
                            <span class="chip {{ $user->role === 'admin' ? 'admin' : '' }}">
                                <i class="fa-solid {{ $user->role === 'admin' ? 'fa-shield-halved' : 'fa-user' }}"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                            <span class="chip">
                                <i class="fa-solid fa-circle-check"></i>
                                Approved
                            </span>
                        </div>

                        <div class="actions">
                            @if($user->role === 'admin')
                                <div class="protected">
                                    <i class="fa-solid fa-lock"></i>
                                    حساب محمي
                                </div>
                            @else
                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" style="flex:1;"
                                      data-confirm="delete" data-username="{{ $user->first_name }} {{ $user->last_name }}" data-id="{{ $user->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-delete" type="submit" title="حذف">
                                        <i class="fa-solid fa-trash"></i> حذف
                                    </button>
                                </form>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="empty">
                        <i class="fa-regular fa-folder-open"></i>
                        <span>القائمة فارغة</span>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Rejected -->
        <section class="col" aria-label="Rejected users">
            <div class="col-head">
                <div class="col-title">
                    <span class="dot rejected"></span>
                    المرفوضين
                </div>
                <span class="count" id="countRejected">{{ $rejectedUsers->count() }}</span>
            </div>

            <div class="col-body" id="colRejected">
                @forelse($rejectedUsers as $user)
                    <article class="u user-item"
                        data-search="{{ strtolower($user->first_name.' '.$user->last_name.' '.$user->phone.' #'.$user->id.' '.$user->role) }}">
                        <div class="u-top">
                            <div class="u-left">
                                <div class="avatar">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="User">
                                    @else
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    @endif
                                </div>

                                <div class="who">
                                    <div class="name">
                                        <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                                        <span class="id">#{{ $user->id }}</span>
                                    </div>
                                    <div class="phone"><i class="fa-solid fa-phone"></i> {{ $user->phone }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="chips">
                            <span class="chip {{ $user->role === 'admin' ? 'admin' : '' }}">
                                <i class="fa-solid {{ $user->role === 'admin' ? 'fa-shield-halved' : 'fa-user' }}"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                            <span class="chip">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Rejected
                            </span>
                        </div>

                        <div class="actions">
                            @if($user->role === 'admin')
                                <div class="protected">
                                    <i class="fa-solid fa-lock"></i>
                                    حساب محمي
                                </div>
                            @else
                                <form method="POST" action="{{ route('admin.rejected.users.delete', $user->id) }}" style="flex:1;"
                                      data-confirm="delete" data-username="{{ $user->first_name }} {{ $user->last_name }}" data-id="{{ $user->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-delete" type="submit" title="حذف">
                                        <i class="fa-solid fa-trash"></i> حذف نهائي
                                    </button>
                                </form>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="empty">
                        <i class="fa-regular fa-folder-open"></i>
                        <span>لا يوجد مستخدمين هنا</span>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

</div>

<!-- Confirm Modal -->
<div class="modal" id="confirmModal" aria-hidden="true">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="confirmTitle">
        <div class="modal-head">
            <h3 id="confirmTitle">تأكيد الحذف</h3>
            <button class="modal-close" type="button" onclick="closeModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <p id="confirmText">هل أنت متأكد؟</p>

        <div class="modal-actions">
            <button class="btn btn-ghost" type="button" onclick="closeModal()">إلغاء</button>
            <button class="btn btn-delete" type="button" id="confirmYes">
                <i class="fa-solid fa-trash"></i> نعم، احذف
            </button>
        </div>
    </div>
</div>

<script>
    // Search (client side)
    const input = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearch');

    const pendingCountEl  = document.getElementById('countPending');
    const approvedCountEl = document.getElementById('countApproved');
    const rejectedCountEl = document.getElementById('countRejected');

    function updateCounts() {
        const visibleIn = (colId) => {
            const col = document.getElementById(colId);
            const items = col.querySelectorAll('.user-item');
            let visible = 0;
            items.forEach(i => { if (i.style.display !== 'none') visible++; });
            return visible;
        };
        pendingCountEl.textContent  = visibleIn('colPending');
        approvedCountEl.textContent = visibleIn('colApproved');
        rejectedCountEl.textContent = visibleIn('colRejected');
    }

    function applySearch(q){
        const query = (q || '').trim().toLowerCase();
        const items = document.querySelectorAll('.user-item');

        items.forEach(card => {
            const hay = (card.getAttribute('data-search') || '');
            card.style.display = (!query || hay.includes(query)) ? '' : 'none';
        });

        clearBtn.style.display = query ? 'block' : 'none';
        updateCounts();
    }

    input?.addEventListener('input', (e) => applySearch(e.target.value));
    clearBtn?.addEventListener('click', () => { input.value=''; applySearch(''); input.focus(); });

    // Confirm modal for delete
    const modal = document.getElementById('confirmModal');
    const confirmText = document.getElementById('confirmText');
    const confirmYes = document.getElementById('confirmYes');
    let pendingForm = null;

    function openModal(message, form){
        pendingForm = form;
        confirmText.textContent = message;
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
    }
    function closeModal(){
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        pendingForm = null;
    }

    document.addEventListener('submit', function(e){
        const form = e.target;
        if(form && form.dataset && form.dataset.confirm === 'delete'){
            e.preventDefault();
            const name = form.dataset.username || 'هذا المستخدم';
            const id = form.dataset.id || '';
            openModal(`هل أنت متأكد من حذف ${name} ${id ? '(#'+id+')' : ''} نهائيًا؟`, form);
        }
    });

    confirmYes?.addEventListener('click', () => {
        if(pendingForm) pendingForm.submit();
    });

    modal?.addEventListener('click', (e) => {
        if(e.target === modal) closeModal();
    });

    // init counts (useful if you start with search prefilled)
    updateCounts();
</script>

</body>
</html>
