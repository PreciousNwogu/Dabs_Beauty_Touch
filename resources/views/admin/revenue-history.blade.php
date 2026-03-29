<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Revenue History - Dab's Beauty Touch Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg,#f8f9fa,#e3eafc); min-height:100vh; }
        .top-nav { background:rgba(255,255,255,.95); backdrop-filter:blur(10px); box-shadow:0 2px 20px rgba(0,0,0,.1); padding:14px 24px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:100; }
        .top-nav .brand { font-weight:800; color:#030f68; font-size:1.15rem; text-decoration:none; }
        .top-nav .nav-links a { color:#030f68; text-decoration:none; font-weight:600; margin-left:20px; font-size:.9rem; }
        .top-nav .nav-links a:hover { color:#ff6600; }
        .page-header { background:linear-gradient(135deg,#0f3460,#16518f); color:white; padding:32px 32px 24px; border-radius:0 0 20px 20px; margin-bottom:28px; }
        .page-header h1 { font-size:1.8rem; font-weight:800; margin:0 0 4px; }
        .page-header p { margin:0; opacity:.85; font-size:.95rem; }
        .stat-pill { display:inline-flex; align-items:center; gap:8px; background:white; border-radius:10px; padding:10px 18px; box-shadow:0 2px 10px rgba(0,0,0,.07); font-weight:700; color:#0f3460; }
        .stat-pill .num { font-size:1.25rem; color:#16518f; }
        .card-shell { background:white; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); overflow:hidden; }
        .table th { font-size:.78rem; text-transform:uppercase; letter-spacing:.05em; color:#888; font-weight:700; border:none; background:#fafafa; }
        .table td { vertical-align:middle; border-color:#f0f0f0; }
        .table tbody tr:hover { background:#f8fbff; }
        .growth-up { color:#198754; font-weight:700; }
        .growth-down { color:#dc3545; font-weight:700; }
        .growth-flat { color:#6c757d; font-weight:700; }
    </style>
</head>
<body>

<nav class="top-nav">
    <a class="brand" href="{{ route('admin.dashboard') }}"><i class="bi bi-scissors me-2" style="color:#ff6600"></i>Dab's Beauty Touch - Admin</a>
    <div class="nav-links">
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
        <a href="{{ route('admin.services.index') }}"><i class="bi bi-grid me-1"></i>Services</a>
        <a href="{{ route('admin.completed-services') }}"><i class="bi bi-check2-square me-1"></i>Completed Services</a>
        <a href="{{ route('admin.revenue-history') }}" style="color:#16518f"><i class="bi bi-graph-up-arrow me-1"></i>Revenue History</a>
    </div>
</nav>

<div class="container-fluid px-3 px-md-4 pb-5">
    <div class="page-header mt-3">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
            <div>
                <h1><i class="bi bi-graph-up-arrow me-2"></i>Revenue Growth Tracking</h1>
                <p>Compare monthly revenue trends and track growth over time.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light fw-bold px-4">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-3 mb-4">
        <div class="stat-pill"><span class="num">${{ number_format($summary['current_month_revenue'], 2) }}</span> Current Month</div>
        <div class="stat-pill"><span class="num">${{ number_format($summary['previous_month_revenue'], 2) }}</span> Previous Month</div>
        <div class="stat-pill">
            @if(is_null($summary['current_month_growth_percent']))
                <span class="num">N/A</span> Growth Rate
            @else
                <span class="num">{{ number_format($summary['current_month_growth_percent'], 1) }}%</span> Growth Rate
            @endif
        </div>
    </div>

    <div class="card-shell">
        <div class="table-responsive">
            <table class="table mb-0 table-hover">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Revenue</th>
                        <th>Previous Month</th>
                        <th>Growth</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $row)
                    <tr>
                        <td><strong>{{ $row['month_label'] }}</strong></td>
                        <td>${{ number_format($row['revenue'], 2) }}</td>
                        <td>${{ number_format($row['previous_revenue'], 2) }}</td>
                        <td>
                            @if(is_null($row['growth_percent']))
                                <span class="growth-flat">N/A</span>
                            @elseif($row['growth_percent'] > 0)
                                <span class="growth-up"><i class="bi bi-arrow-up-right"></i> {{ number_format($row['growth_percent'], 1) }}%</span>
                            @elseif($row['growth_percent'] < 0)
                                <span class="growth-down"><i class="bi bi-arrow-down-right"></i> {{ number_format($row['growth_percent'], 1) }}%</span>
                            @else
                                <span class="growth-flat">0.0%</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No completed booking revenue found yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
