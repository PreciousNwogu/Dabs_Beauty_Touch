<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Business Settings – Dab's Beauty Touch Admin</title>
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
        .form-card { background:white; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); padding:28px; margin-bottom:22px; }
        .section-title { font-size:.75rem; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:#ff6600; border-bottom:2px solid #fff0e6; padding-bottom:8px; margin-bottom:18px; }
        .form-label { font-weight:700; font-size:.88rem; color:#030f68; }
        .hint { font-size:.8rem; color:#777; }
        .preview { width:100%; max-height:180px; object-fit:cover; border-radius:12px; border:1px solid #e6eaf5; }
    </style>
</head>
<body>
<nav class="top-nav">
    <a class="brand" href="{{ route('admin.services.index') }}"><i class="bi bi-scissors me-2" style="color:#ff6600"></i>Dab's Beauty Touch — Admin</a>
    <div class="nav-links">
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
        <a href="{{ route('admin.services.index') }}"><i class="bi bi-grid me-1"></i>Services</a>
        <a href="{{ route('admin.settings.edit') }}" style="color:#ff6600"><i class="bi bi-sliders me-1"></i>Settings</a>
        <a href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right me-1"></i>View Site</a>
    </div>
</nav>

<div class="container-fluid px-3 px-md-4 pb-5">
    <div class="page-header mt-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1><i class="bi bi-sliders me-2"></i>Business Settings</h1>
                <p class="mb-0 opacity-75">Deposit, booking capacity, add-on prices, homepage categories, kids styles, and promo images.</p>
            </div>
            <a href="{{ route('admin.services.index') }}" class="btn btn-light fw-bold px-4">Back to Services</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-card">
            <p class="section-title"><i class="bi bi-cash-coin me-2"></i>Deposit &amp; booking capacity</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Interac email</label>
                    <input type="email" name="interac_email" class="form-control" value="{{ old('interac_email', $settings['interac_email']) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Deposit amount ($)</label>
                    <input type="number" step="0.01" min="0" name="interac_amount" class="form-control" value="{{ old('interac_amount', $settings['interac_amount']) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Max bookings / day</label>
                    <input type="number" min="1" max="10" name="max_bookings_per_day" class="form-control" value="{{ old('max_bookings_per_day', $settings['max_bookings_per_day']) }}" required>
                </div>
            </div>
        </div>

        <div class="form-card">
            <p class="section-title"><i class="bi bi-plus-slash-minus me-2"></i>Length &amp; add-on amounts</p>
            <p class="hint mb-3">These dollar amounts apply when a client picks length, finished tip, or front + back.</p>
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">Finished tip ($)</label>
                    <input type="number" step="0.01" name="finished_tip_amount" class="form-control" value="{{ old('finished_tip_amount', $settings['finished_tip_amount']) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Front + back ($)</label>
                    <input type="number" step="0.01" name="front_back_amount" class="form-control" value="{{ old('front_back_amount', $settings['front_back_amount']) }}" required>
                </div>
            </div>
            <div class="row g-2">
                @foreach(($settings['length_adjustments'] ?? []) as $length => $amount)
                    <div class="col-6 col-md-3">
                        <label class="form-label">{{ ucwords(str_replace('_', ' ', $length)) }}</label>
                        <input type="number" step="0.01" name="length[{{ $length }}]" class="form-control" value="{{ old('length.'.$length, $amount) }}">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-card">
            <p class="section-title"><i class="bi bi-grid-3x3-gap me-2"></i>Homepage categories</p>
            <p class="hint mb-3">Rename, hide, or reorder category cards on the homepage. Lower sort numbers appear first.</p>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Display name</th>
                            <th>Sort</th>
                            <th>Show</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td><code>{{ $cat['key'] }}</code></td>
                                <td>
                                    <input type="text" class="form-control" name="category[{{ $cat['key'] }}][label]" value="{{ old('category.'.$cat['key'].'.label', $cat['label']) }}">
                                </td>
                                <td style="max-width:100px;">
                                    <input type="number" class="form-control" name="category[{{ $cat['key'] }}][sort]" value="{{ old('category.'.$cat['key'].'.sort', $cat['sort']) }}">
                                </td>
                                <td>
                                    <input type="hidden" name="category[{{ $cat['key'] }}][visible]" value="0">
                                    <input type="checkbox" class="form-check-input" name="category[{{ $cat['key'] }}][visible]" value="1" @checked(old('category.'.$cat['key'].'.visible', $cat['visible']))>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-card">
            <p class="section-title"><i class="bi bi-emoji-smile me-2"></i>Kids styles</p>
            <p class="hint mb-3">Rename, hide, or reorder built-in kids selector styles. Prices still come from Services CMS.</p>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Style key</th>
                            <th>Display name</th>
                            <th>Sort</th>
                            <th>Show</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kidsStyles as $style)
                            <tr>
                                <td><code>{{ $style['key'] }}</code></td>
                                <td>
                                    <input type="text" class="form-control" name="kids[{{ $style['key'] }}][label]" value="{{ old('kids.'.$style['key'].'.label', $style['label']) }}">
                                </td>
                                <td style="max-width:100px;">
                                    <input type="number" class="form-control" name="kids[{{ $style['key'] }}][sort]" value="{{ old('kids.'.$style['key'].'.sort', $style['sort']) }}">
                                </td>
                                <td>
                                    <input type="hidden" name="kids[{{ $style['key'] }}][visible]" value="0">
                                    <input type="checkbox" class="form-check-input" name="kids[{{ $style['key'] }}][visible]" value="1" @checked(old('kids.'.$style['key'].'.visible', $style['visible']))>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-card">
            <p class="section-title"><i class="bi bi-image me-2"></i>Hero &amp; promo banner</p>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Homepage hero image</label>
                    <textarea name="hero_image_data" id="heroImageData" hidden>{{ old('hero_image_data') }}</textarea>
                    <input type="file" id="heroImageInput" class="form-control mb-2" accept=".jpg,.jpeg,.png,.webp,.gif,image/jpeg,image/png,image/webp,image/gif" onchange="onSiteImageChosen(this, 'heroImageData', 'heroPreview')">
                    <p class="hint mb-2">JPG, PNG, WEBP, or GIF · max 10 MB</p>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" name="remove_hero_image" value="1" id="removeHero" onchange="if(this.checked){ document.getElementById('heroImageData').value=''; document.getElementById('heroImageInput').value=''; }">
                        <label class="form-check-label" for="removeHero">Reset to default hero</label>
                    </div>
                    <img class="preview" id="heroPreview" src="{{ \App\Support\SiteSettings::heroImageUrl() }}" alt="Hero preview">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Promo banner image (optional)</label>
                    <textarea name="promo_image_data" id="promoImageData" hidden>{{ old('promo_image_data') }}</textarea>
                    <input type="file" id="promoImageInput" class="form-control mb-2" accept=".jpg,.jpeg,.png,.webp,.gif,image/jpeg,image/png,image/webp,image/gif" onchange="onSiteImageChosen(this, 'promoImageData', 'promoPreview')">
                    <p class="hint mb-2">JPG, PNG, WEBP, or GIF · max 10 MB</p>
                    <div class="form-check mb-2">
                        <input type="hidden" name="promo_enabled" value="0">
                        <input type="checkbox" class="form-check-input" name="promo_enabled" value="1" id="promoEnabled" @checked(old('promo_enabled', $settings['promo_enabled']))>
                        <label class="form-check-label" for="promoEnabled">Show promo banner on homepage</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" name="remove_promo_image" value="1" id="removePromo" onchange="if(this.checked){ document.getElementById('promoImageData').value=''; document.getElementById('promoImageInput').value=''; document.getElementById('promoPreview').style.display='none'; }">
                        <label class="form-check-label" for="removePromo">Remove promo image</label>
                    </div>
                    <input type="text" name="promo_title" class="form-control mb-2" placeholder="Promo title" value="{{ old('promo_title', $settings['promo_title']) }}">
                    <textarea name="promo_text" class="form-control mb-2" rows="3" placeholder="Promo text">{{ old('promo_text', $settings['promo_text']) }}</textarea>
                    <img class="preview" id="promoPreview" src="{{ \App\Support\SiteSettings::promoImageUrl() }}" alt="Promo preview" @if(\App\Support\SiteSettings::promoImageUrl() === '') style="display:none" @endif>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg px-4 fw-bold">
                <i class="bi bi-check2-circle me-1"></i>Save settings
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>
<script>
function onSiteImageChosen(input, dataFieldId, previewId) {
    const dataInput = document.getElementById(dataFieldId);
    const preview = document.getElementById(previewId);
    const file = input.files && input.files[0] ? input.files[0] : null;
    if (!file) {
        if (dataInput) dataInput.value = '';
        return;
    }
    const name = (file.name || '').toLowerCase();
    const allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
    const okType = allowed.indexOf(file.type) !== -1 || /\.(jpe?g|png|gif|webp)$/.test(name);
    if (!okType) {
        input.value = '';
        if (dataInput) dataInput.value = '';
        alert('Use a JPG, PNG, WEBP, or GIF image.');
        return;
    }
    if (file.size > 10 * 1024 * 1024) {
        input.value = '';
        if (dataInput) dataInput.value = '';
        alert('The image must be 10 MB or smaller.');
        return;
    }
    const reader = new FileReader();
    reader.onload = function (e) {
        const dataUrl = e.target && e.target.result ? String(e.target.result) : '';
        if (dataInput) dataInput.value = dataUrl;
        if (preview && dataUrl) {
            preview.src = dataUrl;
            preview.style.display = '';
        }
        const removeBox = dataFieldId === 'promoImageData'
            ? document.getElementById('removePromo')
            : document.getElementById('removeHero');
        if (removeBox) removeBox.checked = false;
    };
    reader.onerror = function () {
        input.value = '';
        if (dataInput) dataInput.value = '';
        alert('Could not read that image. Please try another file.');
    };
    reader.readAsDataURL(file);
}
</script>
</body>
</html>
