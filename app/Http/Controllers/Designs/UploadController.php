<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Design;
use Illuminate\Support\Facades\Auth;
use App\Jobs\UploadImage;

class UploadController extends Controller
{
    public function upload(Request $request) {
        $this->validate($request, [
            'image' => ['required', 'mimes:jpeg,gif,png,bmp', 'max:2048']
        ]);

        $image = $request->file('image');
        $image_path = $image->getPathname();

        $filename = time()."_". preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        $tmp = $image->storeAs('uploads/original', $filename, 'tmp');

        $design = auth()->user()->designs()->create([
            'image' => $filename,
            'disk' => config('site.upload_disk')
        ]);

        $this->dispatch(new UploadImage($design));

        return response()->json($design, 200);
    }
}
