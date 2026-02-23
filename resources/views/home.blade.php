{{-- Wrapper view for compatibility: render the existing file `home.remote.blade.php` by absolute path.
	This avoids Blade's view-name resolution which treats dots as directory separators.
	$__data forwards all route-passed variables (servicePrices, extraServices, etc.) into the sub-view.
--}}
{!! view()->file(resource_path('views/home.remote.blade.php'), $__data)->render() !!}
