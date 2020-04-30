<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Http\Resources\DesignResource;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DesignController extends Controller
{
    public function update(Request $request, $id) {

        $design = Design::findorfail($id);

        $this->authorize('update', $design);

        $this->validate($request, [
            'title' => ['required', 'unique:designs,title,' . $id],
            'description' => ['required', 'string', 'min:15', 'max:140'],
        ]);

        $design->update([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
            'is_live' => ! $design->upload_success ? false : $request->is_live,
        ]);

        return new DesignResource($design);
    }

    public function destroy($id) {
        //find design by id
        $design = Design::findorfail($id);
        //authorize user ability to delete
        $this->authorize('delete', $design);
        //delete associated files
        foreach (['thumbnail', 'large', 'original'] as $size) {
            if (Storage::disk($design->disk)->exists("uploads/designs/{$size}/" . $design->image)) {
                Storage::disk($design->disk)->delete("uploads/designs/{$size}/" . $design->image);
            }
        }
        //delete the design
        $design->delete();
        //return response
        return response()->json([
            'message' => 'Record deleted'
        ], 200);
    }
}
