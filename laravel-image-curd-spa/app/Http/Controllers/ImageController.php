<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Validator;

class ImageController extends Controller
{
    public function index()
    {
        return view('image.index', [
            'images' => Image::all()
        ]);
    }
    
    public function show(Image $image)
    {
        return response()->json([
            'status' => 200,
            'image' => $image
        ]);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'title' => ['required', 'string', 'min:5'],
            'image' => ['required','file', 'mimes:png,jpg,jpeg']
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        }

        $image = request()->file('image');
        $image_path = $image->store('image');

        
        $data = Image::create([
            'title' => request()->title,
            'image' => $image_path
        ]);

        if($data){
            return response()->json([
                'status' => 200,
                'message' => 'Image upload successfully'
            ]);
        }

    }


    public function update(Image $image)
    {
        $validator = Validator::make(request()->all(), [
            'title' => ['required', 'string', 'min:5'],
            'image' => ['required','file', 'mimes:png,jpg,jpeg']
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        }

        if(request()->file('image')){
            if(file_exists('storage/'.$image->image)){
                unlink('storage/'. $image->image);
            }

            $file = request()->file('image');
            $image_path = $file->store('image');
            $image->image = $image_path;
        }

        $image->title = request()->title;

        $image->update();

        return response()->json([
            'status' => 200,
            'message' => 'Image update successfully'
        ]);

    }

    public function destroy(Image $image)
    {
        if(file_exists('storage/'.$image->image)){
            unlink('storage/'. $image->image);
        }

        $image->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Image Delete Successfully'
        ]);
    }
}
