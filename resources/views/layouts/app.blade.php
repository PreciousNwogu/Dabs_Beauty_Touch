<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "Dab's Beauty Touch")</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        body { background: #f8f9fa; }
    </style>
</head>
<body>

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
