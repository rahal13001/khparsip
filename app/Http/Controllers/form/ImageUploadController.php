<?php

namespace App\Http\Controllers\form;

use App\Http\Controllers\Controller;
use App\Models\ImageUpload;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function storeImage(Request $request)
    {
        $ImageUpload = new ImageUpload();
        $ImageUpload->id = 0;
        $ImageUpload->exists = true;
        $images = $ImageUpload->addMediaFromRequest(key:'upload')->toMediaCollection(collectionName:'images_upload');

    
        return response()->json([
            'url' =>$images
        ]);


        // if ($request->hasFile('upload')) {
        //     $originName = $request->file('upload')->getClientOriginalName();
        //     $fileName = pathinfo($originName, PATHINFO_FILENAME);
        //     $extension = $request->file('upload')->getClientOriginalExtension();
        //     $fileName = $fileName . '_' . time() . '.' . $extension;
    
        //     $request->file('upload')->move(public_path('media'), $fileName);
    
        //     $url = asset('media/' . $fileName);
        //     return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        // }

        // if($request->hasFile('upload')) {
        //     $originName = $request->file('upload')->getClientOriginalName();
        //     $fileName = pathinfo($originName, PATHINFO_FILENAME);
        //     $extension = $request->file('upload')->getClientOriginalExtension();
        //     $fileName = $fileName.'_'.time().'.'.$extension;
        //     $request->file('upload')->move(public_path('images'), $fileName);
        //     $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        //     $url = asset('images/'.$fileName); 
        //     $msg = 'Image successfully uploaded'; 
        //     $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
        //     @header('Content-type: text/html; charset=utf-8'); 
        //     echo $response;
        // }
    }
}
