<?php

namespace Build\Core\Http\Controllers\Assets;

use Build\Core\Http\Controller;
use Illuminate\Http\Request;
use Build\Core\Eloquent\Models\Asset;

class FrontendController extends Controller {
    
    /**
     * Format the Image input request
     * 
     * @param Request $request
     * @param string $uuid The assets Uuid
     * @param string $format The format modifiers
     * @return mixed Return the image with all the modifiers applied
     */
    public function formatMedia(Request $request, $uuid, $format = null)
    {
        if ( !($asset = Asset::where('uuid',$uuid)->first()) ) {
            return response('File not found', 404);
        }
        
        return $asset->formatter()->parse($format)->response();
    }
    
}