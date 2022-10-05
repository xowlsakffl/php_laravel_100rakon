<?php
namespace App\Traits;
use Illuminate\Support\Str;

trait UploadTrait
{
    private function imageUpload($image, $pdx, $sgdx = null, $osdx = null)
    {
        list($width, $height) = getimagesize($image);
        $uploadedImages = [
            'udx' => NULL,
            'pdx' => $pdx,
            'sgdx' => $sgdx,
            'osdx' => $osdx,
            'up_name' => $image->getClientOriginalName(),
            'real_name' => $image->storeAs('products', date('ymdHis'.intval(microtime(true) * 1000)).Str::random(20).".".$image->getClientOriginalExtension(), 'public'),
            'size' => $image->getSize(),
            'extension' => $image->getClientOriginalExtension(),
            'width' => $width,
            'height' => $height,
            'state' => 10,
            'created_at' => date('y-m-d h:i:s'),
            'updated_at' => date('y-m-d h:i:s'),
        ];

        return $uploadedImages;
    }
}
