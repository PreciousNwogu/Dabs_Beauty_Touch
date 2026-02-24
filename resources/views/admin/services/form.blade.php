<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($service) ? 'Edit Service' : 'Add Service' }} – Dab's Beauty Touch Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family:'Segoe UI',sans-serif; background:linear-gradient(135deg,#f8f9fa,#e3eafc); min-height:100vh; }
        .top-nav { background:rgba(255,255,255,.95); backdrop-filter:blur(10px); box-shadow:0 2px 20px rgba(0,0,0,.1); padding:14px 24px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:100; }
        .top-nav .brand { font-weight:800; color:#030f68; font-size:1.15rem; text-decoration:none; }
        .top-nav .nav-links a { color:#030f68; text-decoration:none; font-weight:600; margin-left:20px; font-size:.9rem; }
        .top-nav .nav-links a:hover { color:#ff6600; }
        .page-header { background:linear-gradient(135deg,#030f68,#1a2fa8); color:white; padding:32px 32px 24px; border-radius:0 0 20px 20px; margin-bottom:28px; }
        .page-header h1 { font-size:1.8rem; font-weight:800; margin:0 0 4px; }
        .page-header p { margin:0; opacity:.8; font-size:.95rem; }
        .form-card { background:white; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); padding:32px; }
        .form-label { font-weight:700; font-size:.88rem; color:#030f68; }
        .form-control, .form-select { border-radius:10px; border:1.5px solid #e0e0e0; font-size:.93rem; }
        .form-control:focus, .form-select:focus { border-color:#030f68; box-shadow:0 0 0 3px rgba(3,15,104,.1); }
        .section-title { font-size:.75rem; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:#ff6600; border-bottom:2px solid #fff0e6; padding-bottom:8px; margin-bottom:18px; }
        .slug-hint { font-size:.78rem; color:#888; margin-top:4px; }
        .new-cat-toggle { font-size:.82rem; color:#ff6600; font-weight:700; cursor:pointer; text-decoration:underline; }
        .img-preview-box { width:100%; aspect-ratio:4/3; border-radius:14px; border:2px dashed #d0d8f0; background:#f4f6fb; display:flex; align-items:center; justify-content:center; overflow:hidden; transition:border-color .2s; }
        .img-preview-box img { width:100%; height:100%; object-fit:cover; border-radius:12px; }
        .img-preview-placeholder { text-align:center; color:#aaa; padding:16px; }
        .img-preview-placeholder i { font-size:2.5rem; display:block; margin-bottom:8px; }
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
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1>
                    <i class="bi bi-{{ isset($service) ? 'pencil-square' : 'plus-circle' }} me-2"></i>
                    {{ isset($service) ? 'Edit Service' : 'Add New Service' }}
                </h1>
                <p>{{ isset($service) ? 'Update details for: ' . $service->name : 'Fill in the details for the new service.' }}</p>
            </div>
            <a href="{{ route('admin.services.index') }}" class="btn btn-light fw-bold px-4">
                <i class="bi bi-arrow-left me-2"></i>Back to Services
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4">
                <i class="bi bi-check-circle-fill fs-5"></i><span>{{ session('success') }}</span>
            </div>
            @endif

            <div class="form-card mb-5">
                <form method="POST"
                      action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}">
                    @csrf
                    @if(isset($service))
                        @method('PUT')
                    @endif

                    {{-- BASIC INFO --}}
                    <p class="section-title"><i class="bi bi-info-circle me-2"></i>Basic Information</p>

                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Service Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $service->name ?? '') }}"
                                   placeholder="e.g. Box Braids"
                                   oninput="suggestSlug(this.value)"
                                   required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Slug <span class="text-muted fw-normal">(auto)</span></label>
                            <input type="text" name="slug" id="slugInput"
                                   class="form-control @error('slug') is-invalid @enderror"
                                   value="{{ old('slug', $service->slug ?? '') }}"
                                   placeholder="box-braids">
                            <div class="slug-hint">Used in URLs. Leave blank to auto-generate.</div>
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="3" placeholder="Brief description of the service…">{{ old('description', $service->description ?? '') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Service Image URL <span class="text-muted fw-normal">(optional)</span></label>
                        <div class="row g-3 align-items-start">
                            <div class="col-md-8">
                                <input type="text" name="image_url" id="imageUrlInput"
                                       class="form-control @error('image_url') is-invalid @enderror"
                                       value="{{ old('image_url', $service->image_url ?? '') }}"
                                       placeholder="https://… or /images/my-service.jpg"
                                       oninput="previewImage(this.value)">
                                <div class="slug-hint">Paste a full URL or a relative path like <code>/images/webbraids2.jpg</code>.</div>
                                @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <div class="img-preview-box" id="imgPreviewBox">
                                    @if(!empty($service->image_url ?? ''))
                                        <img id="imgPreview" src="{{ $service->image_url }}" alt="Preview">
                                    @else
                                        <div class="img-preview-placeholder" id="imgPlaceholder">
                                            <i class="bi bi-image"></i>
                                            <span style="font-size:.8rem">Image preview</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PRICING --}}
                    <p class="section-title mt-4"><i class="bi bi-currency-dollar me-2"></i>Pricing</p>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Base Price ($) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="base_price" step="1" min="0"
                                       class="form-control @error('base_price') is-invalid @enderror"
                                       value="{{ old('base_price', isset($service) ? (int)$service->base_price : '') }}"
                                       placeholder="e.g. 120" required>
                                @error('base_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Discount Price ($) <span class="text-muted fw-normal">(optional)</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="discount_price" step="1" min="0"
                                       class="form-control @error('discount_price') is-invalid @enderror"
                                       value="{{ old('discount_price', isset($service) && $service->discount_price !== null ? (int)$service->discount_price : '') }}"
                                       placeholder="Leave blank for no discount">
                                @error('discount_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="slug-hint">Must be less than base price. Leave blank to disable.</div>
                        </div>
                    </div>

                    {{-- CATEGORY & STATUS --}}
                    <p class="section-title mt-4"><i class="bi bi-tags me-2"></i>Category &amp; Status</p>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select name="category" id="categorySelect" class="form-select @error('category') is-invalid @enderror"
                                    onchange="toggleNewCategory(this.value)">
                                <option value="">— None —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}"
                                        {{ old('category', $service->category ?? '') === $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                                <option value="__new__">+ Add new category…</option>
                            </select>
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6" id="newCatWrapper" style="display:none">
                            <label class="form-label">New Category Name</label>
                            <input type="text" name="new_category" id="newCategoryInput"
                                   class="form-control @error('new_category') is-invalid @enderror"
                                   value="{{ old('new_category') }}"
                                   placeholder="e.g. Protective Styles">
                            @error('new_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label d-block">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                                   {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}
                                   style="width:2.5em;height:1.3em">
                            <label class="form-check-label fw-bold" for="isActive">Active (visible to customers)</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label d-block">Service Audience</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="for_kids" id="forKids" value="1"
                                   {{ old('for_kids', $service->for_kids ?? false) ? 'checked' : '' }}
                                   style="width:2.5em;height:1.3em">
                            <label class="form-check-label fw-bold" for="forKids">For Kids (appears in Kids Braids selector)</label>
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-warning fw-bold px-5" style="font-size:1rem">
                            <i class="bi bi-{{ isset($service) ? 'save' : 'plus-circle' }} me-2"></i>
                            {{ isset($service) ? 'Save Changes' : 'Add Service' }}
                        </button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary fw-bold px-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewImage(url) {
    const box  = document.getElementById('imgPreviewBox');
    const ph   = document.getElementById('imgPlaceholder');
    let   img  = document.getElementById('imgPreview');
    if (!url.trim()) {
        if (img) img.remove();
        if (!ph) { box.innerHTML = '<div class="img-preview-placeholder" id="imgPlaceholder"><i class="bi bi-image"></i><span style="font-size:.8rem">Image preview</span></div>'; }
        return;
    }
    if (!img) {
        if (ph) ph.remove();
        img = document.createElement('img');
        img.id = 'imgPreview';
        img.style.cssText = 'width:100%;height:100%;object-fit:cover;border-radius:12px';
        box.appendChild(img);
    }
    img.src = url;
    img.onerror = () => {
        img.remove();
        box.innerHTML = '<div class="img-preview-placeholder text-danger" id="imgPlaceholder"><i class="bi bi-exclamation-triangle" style="font-size:2rem;display:block;margin-bottom:6px"></i><span style="font-size:.78rem">Could not load image</span></div>';
    };
}
function suggestSlug(name) {
    const slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    const input = document.getElementById('slugInput');
    if (!input.dataset.manual) input.value = slug;
}
document.getElementById('slugInput').addEventListener('input', function() {
    this.dataset.manual = '1';
});
function toggleNewCategory(val) {
    const wrapper = document.getElementById('newCatWrapper');
    wrapper.style.display = val === '__new__' ? '' : 'none';
    document.getElementById('newCategoryInput').required = val === '__new__';
    if (val !== '__new__') document.getElementById('newCategoryInput').value = '';
}
// Restore new-cat state on validation error
(function() {
    const sel = document.getElementById('categorySelect');
    if (sel && sel.value === '__new__') toggleNewCategory('__new__');
})();
</script>
</body>
</html>
