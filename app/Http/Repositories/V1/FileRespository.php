<?php

namespace App\Http\Repositories\V1;

use App\Models\Film;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileRespository
{    
    public function store($request, $model)
    {
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = rand(1111,9999).time().$image->getClientOriginalExtension();
            $path = 'uploads/'.$name;
            Storage::putFileAs('uploads', $image, $name);
            $model->photo = $path;
            $model->save();
        }
        return $model;
    }
}
