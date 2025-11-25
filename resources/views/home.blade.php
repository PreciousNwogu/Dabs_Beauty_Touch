{{-- Wrapper view for compatibility: render the existing file `home.remote.blade.php` by absolute path.
	This avoids Blade's view-name resolution which treats dots as directory separators.
--}}
{!! view()->file(resource_path('views/home.remote.blade.php'))->render() !!}
