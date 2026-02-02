<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', "Dab's Beauty Touch - Professional Hair Braiding Services")</title>
    <meta name="title" content="@yield('meta_title', "Dab's Beauty Touch - Professional Hair Braiding Services")">
    <meta name="description" content="@yield('meta_description', "Professional hair braiding services in Ottawa. Expert stylists specializing in knotless braids, box braids, wig installation, and custom styles.")">
    <meta name="keywords" content="@yield('meta_keywords', 'hair braiding Ottawa, knotless braids, box braids, wig installation, hair styling')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical', url('/'))">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('og_url', url('/'))">
    <meta property="og:title" content="@yield('og_title', "Dab's Beauty Touch - Professional Hair Braiding Services")">
    <meta property="og:description" content="@yield('og_description', "Professional hair braiding services in Ottawa. Expert stylists specializing in knotless braids, box braids, wig installation, and custom styles.")">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.jpg'))">
    <meta property="og:site_name" content="Dab's Beauty Touch">
    <meta property="og:locale" content="en_CA">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="@yield('twitter_url', url('/'))">
    <meta name="twitter:title" content="@yield('twitter_title', "Dab's Beauty Touch - Professional Hair Braiding Services")">
    <meta name="twitter:description" content="@yield('twitter_description', "Professional hair braiding services in Ottawa. Expert stylists specializing in knotless braids, box braids, wig installation, and custom styles.")">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/logo.jpg'))">

    <!-- Additional Meta Tags -->
    @stack('meta')
    
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        body { background: #f8f9fa; }
    </style>
</head>
<body>

@include('partials.cookie-consent')
@include('partials.site-header')

<main class="py-4">
    @yield('content')
</main>

@include('partials.site-footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

<script>
// Global helper: disable finish and length radios if an image was pasted or preview exists
(function(){
    function setDisabled(val){
        ['kb_finish','kb_length','hair_length'].forEach(name=>{
            document.querySelectorAll('input[name="'+name+'"]').forEach(i=> i.disabled = val);
        });
    }

    function checkPreview(){
        try{
            const preview = document.getElementById('previewImg') || document.querySelector('.pasted-image');
            if(preview){
                // if img element and has src, disable
                if(preview.tagName && preview.tagName.toLowerCase()==='img'){
                    if(preview.src && preview.src.trim() !== ''){ setDisabled(true); return; }
                } else {
                    // any pasted-image element exists
                    setDisabled(true); return;
                }
            }
            // check file input
            const sample = document.getElementById('sample_picture');
            if(sample && sample.files && sample.files.length>0){ setDisabled(true); return; }
            // otherwise enable
            setDisabled(false);
        }catch(e){ console.warn('checkPreview error', e); }
    }

    document.addEventListener('DOMContentLoaded', function(){ checkPreview(); });

    // when sample picture changes
    document.addEventListener('change', function(e){ if(e.target && e.target.id==='sample_picture') checkPreview(); });

    // when paste event contains image
    document.addEventListener('paste', function(e){
        try{
            const items = (e.clipboardData || window.clipboardData).items;
            if(!items) return;
            for(let i=0;i<items.length;i++){
                if(items[i].type && items[i].type.indexOf('image')!==-1){ setDisabled(true); return; }
            }
        }catch(ex){ }
    });
})();
</script>

</body>
</html>
