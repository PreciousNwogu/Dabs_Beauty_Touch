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
        .img-preview-box.has-image { border-style:solid; border-color:#c5d0f0; }
        .img-preview-box img { width:100%; height:100%; object-fit:cover; border-radius:12px; }
        .img-preview-placeholder { text-align:center; color:#aaa; padding:16px; }
        .img-preview-placeholder i { font-size:2.5rem; display:block; margin-bottom:8px; }
        .image-source-btn { border:1.5px solid #d0d8f0; background:#fff; color:#030f68; font-weight:700; border-radius:10px; padding:8px 14px; }
        .image-source-btn.active { background:#030f68; color:#fff; border-color:#030f68; }
        .gallery-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(92px,1fr)); gap:8px; max-height:280px; overflow:auto; padding:4px; }
        .gallery-tile { border:2px solid #e6eaf5; border-radius:10px; overflow:hidden; cursor:pointer; background:#f7f8fc; aspect-ratio:1; padding:0; }
        .gallery-tile img { width:100%; height:100%; object-fit:cover; display:block; }
        .gallery-tile.selected { border-color:#ff6600; box-shadow:0 0 0 2px rgba(255,102,0,.25); }
        .gallery-tile .tile-label { display:none; }
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
                      action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}"
                      enctype="multipart/form-data">
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

                    @php
                        $currentImage = old('image_url', $service->image_url ?? '');
                        $currentImageSrc = '';
                        if ($currentImage) {
                            $currentImageSrc = preg_match('#^https?://#i', $currentImage)
                                ? $currentImage
                                : asset(ltrim($currentImage, '/'));
                        }
                    @endphp
                    <div class="mb-3">
                        <label class="form-label">Service Image <span class="text-muted fw-normal">(optional)</span></label>
                        <div class="row g-3 align-items-start">
                            <div class="col-md-8">
                                <input type="hidden" name="image_url" id="imageUrlInput" value="{{ $currentImage }}">
                                <input type="hidden" name="remove_image" id="removeImageInput" value="0">

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <button type="button" class="image-source-btn active" id="btnUploadSource" onclick="showImageSource('upload')">
                                        <i class="bi bi-upload me-1"></i>Upload file
                                    </button>
                                    <button type="button" class="image-source-btn" id="btnGallerySource" onclick="showImageSource('gallery')">
                                        <i class="bi bi-images me-1"></i>Choose from gallery
                                    </button>
                                </div>

                                <div id="uploadPanel">
                                    <input type="file" name="image" id="imageFileInput"
                                           class="form-control @error('image') is-invalid @enderror"
                                           accept="image/jpeg,image/png,image/gif,image/webp,image/avif"
                                           onchange="onImageFileChosen(this)">
                                    <div class="slug-hint">JPG, PNG, WEBP, AVIF, or GIF. Max 5 MB.</div>
                                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div id="galleryPanel" style="display:none">
                                    <input type="search" id="gallerySearch" class="form-control mb-2" placeholder="Search gallery…" oninput="filterGallery(this.value)">
                                    <div class="gallery-grid" id="galleryGrid">
                                        @foreach(($galleryImages ?? []) as $img)
                                            <button type="button" class="gallery-tile{{ $currentImage === $img['path'] ? ' selected' : '' }}"
                                                    data-path="{{ $img['path'] }}"
                                                    data-url="{{ $img['url'] }}"
                                                    data-name="{{ strtolower($img['name']) }}"
                                                    onclick="selectGalleryImage(this)">
                                                <img src="{{ $img['url'] }}" alt="{{ $img['name'] }}">
                                            </button>
                                        @endforeach
                                    </div>
                                    @if(empty($galleryImages))
                                        <div class="slug-hint">No gallery images found yet. Upload a file instead.</div>
                                    @endif
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="clearImageBtn" onclick="clearServiceImage()" {{ $currentImage ? '' : 'style=display:none' }}>
                                    <i class="bi bi-x-circle me-1"></i>Remove image
                                </button>
                                @error('image_url')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <div class="img-preview-box{{ $currentImageSrc ? ' has-image' : '' }}" id="imgPreviewBox">
                                    @if($currentImageSrc)
                                        <img id="imgPreview" src="{{ $currentImageSrc }}" alt="Preview">
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
                            @if(isset($service) && ($service->slug === 'kids-braids'))
                                <div class="slug-hint mt-1">Homepage “Kids Braids” starting price only. Individual kids styles (Knotless, Cornrows, etc.) have their own CMS rows.</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Discount Price ($) <span class="text-muted fw-normal">(optional)</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="discount_price" id="discountPriceInput" step="1" min="0"
                                       class="form-control @error('discount_price') is-invalid @enderror"
                                       value="{{ old('discount_price', isset($service) && $service->discount_price !== null ? (int)$service->discount_price : '') }}"
                                       placeholder="Leave blank for no discount"
                                       oninput="toggleDiscountExpiry(this.value)">
                                @error('discount_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="slug-hint">Must be less than base price. Leave blank to disable.</div>
                            <div class="slug-hint mt-1" id="kidsPriceHint" style="{{ old('for_kids', $service->for_kids ?? false) ? '' : 'display:none' }}">
                                This price is independent. Changing it updates only this kids style on the selector, not other services.
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3" id="discountExpiryRow" style="{{ old('discount_price', isset($service) && $service->discount_price !== null ? $service->discount_price : '') !== '' ? '' : 'display:none' }}">
                        <div class="col-md-6 offset-md-6">
                            <label class="form-label">Discount Ends At <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="datetime-local" name="discount_ends_at" id="discountEndsAt"
                                   class="form-control @error('discount_ends_at') is-invalid @enderror"
                                   value="{{ old('discount_ends_at', isset($service) && $service->discount_ends_at ? $service->discount_ends_at->format('Y-m-d\TH:i') : '') }}">
                            <div class="slug-hint">Leave blank for no expiry. Countdown shows on service cards.</div>
                            @error('discount_ends_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- CATEGORY & STATUS --}}
                    <p class="section-title mt-4"><i class="bi bi-tags me-2"></i>Category &amp; Status</p>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Homepage Category</label>
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
                            <div class="slug-hint">Adult styles appear inside this category card on the homepage.</div>
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
                            <div class="slug-hint mt-1">Kids style prices are edited one service at a time. Adult services and other kids styles stay unchanged.</div>
                        </div>
                    </div>

                    <div id="adultStyleOptions">
                        <p class="section-title mt-4"><i class="bi bi-sliders me-2"></i>Adult Booking Options</p>
                        <p class="slug-hint mb-3">These options apply to this style on the homepage — including existing service cards. Turn length, tip, sizes, or row add-ons on or off here.</p>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Time estimate</label>
                                <input type="text" name="duration" class="form-control"
                                       value="{{ old('duration', $service->duration ?? '') }}"
                                       placeholder="e.g. 3–4 hrs">
                                <div class="slug-hint">Shown on the style card in the size picker.</div>
                            </div>
                        </div>

                        @php
                            $sizeLabels = \App\Support\AdultServiceCatalog::sizeLabels();
                            $savedSizes = old('size_price', $service->size_options ?? []);
                            $savedEnabled = old('size_enabled', array_fill_keys(array_keys($savedSizes ?: []), '1'));
                        @endphp
                        <div class="mb-4">
                            <label class="form-label">Braid sizes</label>
                            <div class="slug-hint mb-2">Check the sizes customers can choose. Each size gets its own price on the homepage card.</div>
                            <div class="row g-2">
                                @foreach($sizeLabels as $sizeKey => $sizeLabel)
                                    @php
                                        $isOn = !empty($savedEnabled[$sizeKey]);
                                        $sizeVal = $savedSizes[$sizeKey] ?? old('base_price', isset($service) ? (int) $service->base_price : '');
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2 p-2" style="border:1.5px solid #e0e0e0;border-radius:10px">
                                            <input class="form-check-input m-0" type="checkbox" name="size_enabled[{{ $sizeKey }}]" id="size_{{ $sizeKey }}" value="1"
                                                   {{ $isOn ? 'checked' : '' }}
                                                   onchange="document.getElementById('size_price_{{ $sizeKey }}').disabled = !this.checked">
                                            <label class="form-check-label fw-bold flex-grow-1 mb-0" for="size_{{ $sizeKey }}">{{ $sizeLabel }}</label>
                                            <div class="input-group input-group-sm" style="max-width:130px">
                                                <span class="input-group-text">$</span>
                                                <input type="number" name="size_price[{{ $sizeKey }}]" id="size_price_{{ $sizeKey }}"
                                                       class="form-control" min="0" step="1"
                                                       value="{{ $sizeVal }}"
                                                       {{ $isOn ? '' : 'disabled' }}
                                                       placeholder="Price">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="has_length" id="hasLength" value="1"
                                       {{ old('has_length', $service->has_length ?? true) ? 'checked' : '' }}
                                       style="width:2.5em;height:1.3em">
                                <label class="form-check-label fw-bold" for="hasLength">Length adjustment (price changes with length)</label>
                                <div class="slug-hint">Customers pick neck through classic length. Price updates from the length map.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="has_tip_finish" id="hasTipFinish" value="1"
                                       {{ old('has_tip_finish', $service->has_tip_finish ?? false) ? 'checked' : '' }}
                                       style="width:2.5em;height:1.3em">
                                <label class="form-check-label fw-bold" for="hasTipFinish">Tip / finish option</label>
                                <div class="slug-hint">Shows curled tip vs finished tip. Finished tip adds $20 on mid-back and longer.</div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Number of rows</label>
                            <div class="slug-hint mb-2">Only toggled choices appear on the booking page. Set the add-on price for each option.</div>
                        </div>
                        @php
                            $rowToggles = [
                                ['key' => 'eight_to_ten', 'flag' => 'has_eight_to_ten_rows', 'price' => 'eight_to_ten_rows_price', 'label' => '8–10 rows', 'default' => 0],
                                ['key' => 'ten_plus', 'flag' => 'has_row_options', 'price' => 'ten_plus_rows_price', 'label' => '10+ rows / tiny', 'default' => 30],
                                ['key' => 'fifteen_plus', 'flag' => 'has_fifteen_plus_rows', 'price' => 'fifteen_plus_rows_price', 'label' => '15+ rows', 'default' => 30],
                            ];
                        @endphp
                        @foreach($rowToggles as $rowToggle)
                            @php
                                $flagOn = old($rowToggle['flag'], isset($service) ? ($service->{$rowToggle['flag']} ?? false) : false);
                                $priceVal = old($rowToggle['price'], isset($service) && $service->{$rowToggle['price']} !== null ? (int) $service->{$rowToggle['price']} : $rowToggle['default']);
                            @endphp
                            <div class="mb-3">
                                <div class="d-flex align-items-center gap-2 p-2" style="border:1.5px solid #e0e0e0;border-radius:10px">
                                    <input class="form-check-input m-0" type="checkbox" name="{{ $rowToggle['flag'] }}" id="rowToggle_{{ $rowToggle['key'] }}" value="1"
                                           {{ $flagOn ? 'checked' : '' }}
                                           style="width:2.5em;height:1.3em"
                                           onchange="document.getElementById('rowPrice_{{ $rowToggle['key'] }}').disabled = !this.checked">
                                    <label class="form-check-label fw-bold flex-grow-1 mb-0" for="rowToggle_{{ $rowToggle['key'] }}">{{ $rowToggle['label'] }}</label>
                                    <div class="input-group input-group-sm" style="max-width:130px">
                                        <span class="input-group-text">+$</span>
                                        <input type="number" name="{{ $rowToggle['price'] }}" id="rowPrice_{{ $rowToggle['key'] }}"
                                               class="form-control" min="0" step="1"
                                               value="{{ $priceVal }}"
                                               {{ $flagOn ? '' : 'disabled' }}
                                               placeholder="0">
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
function showImageSource(source) {
    const uploadPanel = document.getElementById('uploadPanel');
    const galleryPanel = document.getElementById('galleryPanel');
    const btnUpload = document.getElementById('btnUploadSource');
    const btnGallery = document.getElementById('btnGallerySource');
    const isGallery = source === 'gallery';
    if (uploadPanel) uploadPanel.style.display = isGallery ? 'none' : '';
    if (galleryPanel) galleryPanel.style.display = isGallery ? '' : 'none';
    if (btnUpload) btnUpload.classList.toggle('active', !isGallery);
    if (btnGallery) btnGallery.classList.toggle('active', isGallery);
}

function setImagePreview(url) {
    const box = document.getElementById('imgPreviewBox');
    const clearBtn = document.getElementById('clearImageBtn');
    if (!box) return;
    if (!url) {
        box.classList.remove('has-image');
        box.innerHTML = '<div class="img-preview-placeholder" id="imgPlaceholder"><i class="bi bi-image"></i><span style="font-size:.8rem">Image preview</span></div>';
        if (clearBtn) clearBtn.style.display = 'none';
        return;
    }
    box.classList.add('has-image');
    box.innerHTML = '<img id="imgPreview" src="' + url + '" alt="Preview">';
    const img = document.getElementById('imgPreview');
    if (img) {
        img.onerror = function() {
            box.classList.remove('has-image');
            box.innerHTML = '<div class="img-preview-placeholder text-danger" id="imgPlaceholder"><i class="bi bi-exclamation-triangle" style="font-size:2rem;display:block;margin-bottom:6px"></i><span style="font-size:.78rem">Could not load image</span></div>';
        };
    }
    if (clearBtn) clearBtn.style.display = '';
}

function onImageFileChosen(input) {
    const file = input && input.files && input.files[0];
    const hidden = document.getElementById('imageUrlInput');
    const remove = document.getElementById('removeImageInput');
    if (hidden) hidden.value = '';
    if (remove) remove.value = '0';
    document.querySelectorAll('.gallery-tile.selected').forEach(function(el) { el.classList.remove('selected'); });
    if (!file) {
        setImagePreview('');
        return;
    }
    const reader = new FileReader();
    reader.onload = function(e) { setImagePreview(e.target.result); };
    reader.readAsDataURL(file);
}

function selectGalleryImage(btn) {
    const hidden = document.getElementById('imageUrlInput');
    const remove = document.getElementById('removeImageInput');
    const fileInput = document.getElementById('imageFileInput');
    document.querySelectorAll('.gallery-tile.selected').forEach(function(el) { el.classList.remove('selected'); });
    btn.classList.add('selected');
    if (hidden) hidden.value = btn.dataset.path || '';
    if (remove) remove.value = '0';
    if (fileInput) fileInput.value = '';
    setImagePreview(btn.dataset.url || '');
}

function clearServiceImage() {
    const hidden = document.getElementById('imageUrlInput');
    const remove = document.getElementById('removeImageInput');
    const fileInput = document.getElementById('imageFileInput');
    if (hidden) hidden.value = '';
    if (remove) remove.value = '1';
    if (fileInput) fileInput.value = '';
    document.querySelectorAll('.gallery-tile.selected').forEach(function(el) { el.classList.remove('selected'); });
    setImagePreview('');
}

function filterGallery(query) {
    const q = (query || '').toLowerCase().trim();
    document.querySelectorAll('#galleryGrid .gallery-tile').forEach(function(tile) {
        const name = tile.dataset.name || '';
        tile.style.display = (!q || name.indexOf(q) !== -1) ? '' : 'none';
    });
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
function toggleDiscountExpiry(val) {
    const row = document.getElementById('discountExpiryRow');
    if (!row) return;
    row.style.display = val.trim() !== '' ? '' : 'none';
    if (val.trim() === '') {
        const dt = document.getElementById('discountEndsAt');
        if (dt) dt.value = '';
    }
}
// Restore expiry row state on validation error
(function() {
    const dp = document.getElementById('discountPriceInput');
    if (dp) toggleDiscountExpiry(dp.value);
})();
(function() {
    const kids = document.getElementById('forKids');
    const hint = document.getElementById('kidsPriceHint');
    const adult = document.getElementById('adultStyleOptions');
    const sync = () => {
        const isKids = !!(kids && kids.checked);
        if (hint) hint.style.display = isKids ? '' : 'none';
        if (adult) adult.style.display = isKids ? 'none' : '';
    };
    if (kids) kids.addEventListener('change', sync);
    sync();
})();
</script>
</body>
</html>
