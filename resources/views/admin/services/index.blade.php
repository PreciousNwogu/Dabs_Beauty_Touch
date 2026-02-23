<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Services CMS – Dab's Beauty Touch Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg,#f8f9fa,#e3eafc); min-height:100vh; }
        .top-nav { background:rgba(255,255,255,.95); backdrop-filter:blur(10px); box-shadow:0 2px 20px rgba(0,0,0,.1); padding:14px 24px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:100; }
        .top-nav .brand { font-weight:800; color:#030f68; font-size:1.15rem; text-decoration:none; }
        .top-nav .nav-links a { color:#030f68; text-decoration:none; font-weight:600; margin-left:20px; font-size:.9rem; }
        .top-nav .nav-links a:hover { color:#ff6600; }
        .page-header { background:linear-gradient(135deg,#030f68,#1a2fa8); color:white; padding:32px 32px 24px; border-radius:0 0 20px 20px; margin-bottom:28px; }
        .page-header h1 { font-size:1.8rem; font-weight:800; margin:0 0 4px; }
        .page-header p { margin:0; opacity:.8; font-size:.95rem; }
        .cms-card { background:white; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); overflow:hidden; }
        .cms-card-header { padding:18px 22px; border-bottom:2px solid #f0f0f0; display:flex; align-items:center; justify-content:space-between; background:#fafafa; }
        .badge-category { background:#e3eafc; color:#030f68; font-size:.75rem; font-weight:700; padding:3px 10px; border-radius:20px; }
        .price-main { font-size:1.05rem; font-weight:800; color:#030f68; }
        .price-discounted { color:#ff6600!important; }
        .price-original { text-decoration:line-through; color:#999; font-size:.82rem; }
        .table th { font-size:.78rem; text-transform:uppercase; letter-spacing:.05em; color:#888; font-weight:700; border:none; background:#fafafa; }
        .table td { vertical-align:middle; border-color:#f0f0f0; }
        .table tbody tr:hover { background:#fffbf7; }
        .btn-action { font-size:.8rem; font-weight:600; padding:5px 12px; border-radius:8px; }
        .filter-bar { padding:14px 22px; background:white; border-bottom:1px solid #f0f0f0; display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        .filter-bar select, .filter-bar input { font-size:.88rem; border-radius:8px; border:1px solid #ddd; padding:6px 12px; }
        .discount-inline { display:none; background:#fff8f0; border:1px solid #ffd0a0; border-radius:10px; padding:12px 16px; margin-top:8px; }
        .discount-inline.show { display:block; }
        .stat-pill { display:inline-flex; align-items:center; gap:6px; background:white; border-radius:10px; padding:10px 18px; box-shadow:0 2px 10px rgba(0,0,0,.07); font-weight:700; color:#030f68; }
        .stat-pill .num { font-size:1.4rem; color:#ff6600; }
    </style>
</head>
<body>

<nav class="top-nav">
    <a class="brand" href="{{ route('admin.services.index') }}"><i class="bi bi-scissors me-2" style="color:#ff6600"></i>Dab's Beauty Touch — Admin</a>
    <div class="nav-links">
        <a href="{{ url('/admin/dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
        <a href="{{ route('admin.services.index') }}" style="color:#ff6600"><i class="bi bi-grid me-1"></i>Services</a>
        <a href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right me-1"></i>View Site</a>
        <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display:none">@csrf</form>
    </div>
</nav>

<div class="container-fluid px-3 px-md-4">
    <div class="page-header mt-3">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
            <div>
                <h1><i class="bi bi-grid-3x3-gap me-2"></i>Services CMS</h1>
                <p>Add, edit, delete services and manage pricing &amp; discounts.</p>
            </div>
            <a href="{{ route('admin.services.create') }}" class="btn btn-warning fw-bold px-4">
                <i class="bi bi-plus-circle me-2"></i>Add New Service
            </a>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-3 mb-4">
        <div class="stat-pill"><span class="num">{{ $services->count() }}</span> Total Services</div>
        <div class="stat-pill"><span class="num">{{ $services->where('is_active', true)->count() }}</span> Active</div>
        <div class="stat-pill"><span class="num">{{ $services->whereNotNull('discount_price')->count() }}</span> On Discount</div>
        <div class="stat-pill"><span class="num">{{ $categories->count() }}</span> Categories</div>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4">
            <i class="bi bi-check-circle-fill fs-5"></i><span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="cms-card mb-5">
        <div class="filter-bar">
            <span class="fw-bold text-muted" style="font-size:.85rem">Filter:</span>
            <select id="filterCategory" onchange="applyFilters()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
            <select id="filterStatus" onchange="applyFilters()">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="discounted">Has Discount</option>
            </select>
            <input id="filterSearch" type="text" placeholder="Search by name…" oninput="applyFilters()" style="width:200px">
            <button class="btn btn-sm btn-outline-secondary btn-action" onclick="clearFilters()">
                <i class="bi bi-x-circle me-1"></i>Clear
            </button>
        </div>

        <div class="table-responsive">
            <table class="table mb-0" id="servicesTable">
                <thead>
                    <tr>
                        <th style="width:25%">Service Name</th>
                        <th style="width:13%">Category</th>
                        <th style="width:10%">Base Price</th>
                        <th style="width:10%">Discount</th>
                        <th style="width:10%">Effective</th>
                        <th style="width:7%">Status</th>
                        <th style="width:25%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr
                        data-category="{{ strtolower($service->category ?? '') }}"
                        data-status="{{ $service->is_active ? 'active' : 'inactive' }}"
                        data-discount="{{ $service->discount_price !== null ? 'discounted' : '' }}"
                        data-name="{{ strtolower($service->name) }}"
                    >
                        <td>
                            <div class="fw-bold" style="color:#030f68">{{ $service->name }}</div>
                            <div class="text-muted" style="font-size:.75rem">slug: {{ $service->slug }}</div>
                            @if($service->description)
                                <div class="text-muted mt-1" style="font-size:.8rem;max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $service->description }}</div>
                            @endif
                        </td>
                        <td>
                            @if($service->category)
                                <span class="badge-category">{{ $service->category }}</span>
                            @else
                                <span class="text-muted" style="font-size:.82rem">—</span>
                            @endif
                        </td>
                        <td><span class="price-main">${{ number_format($service->base_price, 0) }}</span></td>
                        <td>
                            @if($service->discount_price !== null)
                                <span class="price-main price-discounted">${{ number_format($service->discount_price, 0) }}</span><br>
                                <button class="btn btn-sm btn-link p-0 text-danger fw-bold" style="font-size:.75rem" onclick="removeDiscount({{ $service->id }})">
                                    <i class="bi bi-x-circle me-1"></i>Remove
                                </button>
                                <form id="remove-discount-{{ $service->id }}" action="{{ route('admin.services.discount', $service) }}" method="POST" style="display:none">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="discount_price" value="">
                                </form>
                            @else
                                <span class="text-muted" style="font-size:.82rem">None</span>
                            @endif
                        </td>
                        <td>
                            @if($service->has_discount)
                                <div class="price-main price-discounted">${{ number_format($service->effective_price, 0) }}</div>
                                <div class="price-original">${{ number_format($service->base_price, 0) }}</div>
                            @else
                                <span class="price-main">${{ number_format($service->effective_price, 0) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($service->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success fw-bold" style="font-size:.75rem;padding:4px 10px;border-radius:20px">Active</span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning fw-bold" style="font-size:.75rem;padding:4px 10px;border-radius:20px">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary btn-action">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <button class="btn btn-sm btn-outline-warning btn-action" onclick="toggleDiscountPanel({{ $service->id }})">
                                    <i class="bi bi-tag me-1"></i>Discount
                                </button>
                                <button class="btn btn-sm btn-outline-danger btn-action" onclick="confirmDelete({{ $service->id }}, '{{ addslashes($service->name) }}')">
                                    <i class="bi bi-trash me-1"></i>Delete
                                </button>
                            </div>

                            <div class="discount-inline" id="discount-panel-{{ $service->id }}">
                                <form action="{{ route('admin.services.discount', $service) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <label class="form-label fw-bold mb-1" style="font-size:.82rem;color:#ff6600">
                                        <i class="bi bi-tag-fill me-1"></i>Set Discount Price
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="discount_price" class="form-control" step="1" min="0"
                                               value="{{ $service->discount_price ?? '' }}"
                                               placeholder="e.g. {{ max(0, $service->base_price - 20) }}">
                                        <button class="btn btn-warning fw-bold" type="submit">Save</button>
                                    </div>
                                    <div class="text-muted mt-1" style="font-size:.75rem">
                                        Base: ${{ number_format($service->base_price, 0) }}. Leave blank to clear discount.
                                    </div>
                                </form>
                            </div>

                            <form id="delete-form-{{ $service->id }}" action="{{ route('admin.services.destroy', $service) }}" method="POST" style="display:none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($services->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
            <p class="text-muted fw-bold">No services yet.</p>
            <a href="{{ route('admin.services.create') }}" class="btn btn-warning px-4 fw-bold">
                <i class="bi bi-plus-circle me-2"></i>Add First Service
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;overflow:hidden">
            <div class="modal-header" style="background:linear-gradient(135deg,#dc3545,#ff6b6b);color:white">
                <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle me-2"></i>Delete Service</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-1">Are you sure you want to permanently delete:</p>
                <p class="fw-bold fs-5" id="deleteServiceName" style="color:#dc3545"></p>
                <p class="text-muted small mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger fw-bold px-4" id="confirmDeleteBtn"><i class="bi bi-trash me-2"></i>Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let pendingDeleteId = null;
function confirmDelete(id, name) {
    pendingDeleteId = id;
    document.getElementById('deleteServiceName').textContent = name;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (pendingDeleteId) document.getElementById('delete-form-' + pendingDeleteId).submit();
});
function removeDiscount(id) {
    if (!confirm('Remove discount for this service?')) return;
    document.getElementById('remove-discount-' + id).submit();
}
function toggleDiscountPanel(id) {
    const panel = document.getElementById('discount-panel-' + id);
    document.querySelectorAll('.discount-inline').forEach(p => { if (p !== panel) p.classList.remove('show'); });
    panel.classList.toggle('show');
}
function applyFilters() {
    const cat    = document.getElementById('filterCategory').value.toLowerCase();
    const status = document.getElementById('filterStatus').value.toLowerCase();
    const search = document.getElementById('filterSearch').value.toLowerCase();
    document.querySelectorAll('#servicesTable tbody tr').forEach(row => {
        const ok = (!cat    || row.dataset.category === cat)
                && (!status || row.dataset.status === status || (status === 'discounted' && row.dataset.discount === 'discounted'))
                && (!search || row.dataset.name.includes(search));
        row.style.display = ok ? '' : 'none';
    });
}
function clearFilters() {
    ['filterCategory','filterStatus','filterSearch'].forEach(id => document.getElementById(id).value = '');
    applyFilters();
}
</script>
</body>
</html>
