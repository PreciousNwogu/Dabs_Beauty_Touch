<?php

namespace App\Http\Controllers;

use App\Support\PersistedUpload;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PersistedImageController extends Controller
{
    public function __invoke(Request $request): BinaryFileResponse
    {
        $publicPath = '/'.ltrim($request->path(), '/');
        if (! PersistedUpload::isSafePublicPath($publicPath)) {
            abort(404);
        }

        $absolute = PersistedUpload::absolutePath($publicPath);
        if (! is_file($absolute) && ! PersistedUpload::restoreOne($publicPath)) {
            abort(404);
        }

        return response()->file($absolute, [
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
