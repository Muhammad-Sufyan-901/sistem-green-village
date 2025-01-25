<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadTransportPriceList extends Controller
{
    public function upload(Request $request)
    {
        // Function to upload user profile
        $allowedfileExtension = ['jpg'];
        $filepath = public_path('img/');
        $file = $request->file('photo');
        $arrFileUpload = [];
        if(!empty($request->file('photo')))
        {
            $getFileExt = $file->getClientOriginalExtension();
            $uploadedFile = 'transport-price-list.'.$getFileExt;
            
            $check = in_array($getFileExt, $allowedfileExtension);
            if(!$check)
                return response()->json(['status' => 'error', 'message' => 'Oops something went wrong, file extensions are not supported'], 422);

            if (file_exists($filepath.'transport-price-list.jpg')) 
            {
                unlink($filepath.'transport-price-list.jpg');
            }
            move_uploaded_file($file->getPathName(), $filepath.$uploadedFile);
        }
        return response()->json(['status' => 'success', 'message' => 'Success! data updated successfully', 'path_image' => '/img/'.$uploadedFile]);
    }
}
