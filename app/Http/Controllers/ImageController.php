<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{

    public function storeImage(Request $request)
    {
        $request->validate([
            'caption'  => 'required|max:255',
            'category' => 'required',
            'image'    => 'required|mimes:png,jpg,jpeg,bmp'
        ], [
            'caption.required' => 'Please enter a caption',
            'category.required' => 'please select a category'
        ]);



        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();

            $thumbPath = public_path('user_images/thumbnail');

            $resize_img = Image::make($file->getRealPath());
            $resize_img->resize(300, 200, function ($c) {
                $c->aspectRatio();
            })->save($thumbPath . '/' . $imageName);

            $file->move(public_path('user_images'), $imageName);
        }

        GalleryImage::create([
            'user_id'  => Auth::user()->id,
            'caption'  => $request->caption,
            'category' => $request->category,
            'image'    => $imageName,
        ]);

        return redirect()->back()->with('success', 'Uploaded Successfully.');
    }
}
