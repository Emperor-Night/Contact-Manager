<?php

namespace App\TraitsHelpers;

use Illuminate\Support\Facades\Storage;
use App\Photo;

trait PhotoHelper
{

    public function checkForPhoto($request, $method = "")
    {
        if ($request->hasFile("image")) {

            $request->validate(["image" => "file|image|max:1999"]);

            $file = $request->file("image");
            $fileNameToStore = time() . "_" . $file->getClientOriginalName();
            $fileSize = round($file->getClientSize() / 1024, 1);

            if ($method == "update") {
                $this->deletePhoto();
            }

            $file->storeAs($this->storagePath, $fileNameToStore);
            $photo = Photo::create([
                "name" => $fileNameToStore,
                "size" => $fileSize
            ]);

            $this->photo_id = $photo->id;
        }
    }

    public function getPhotoPath()
    {
        if ($this->photo) {
            return $this->photoPath . $this->photo->name;
        } else {
            return $this->photoPath . "uni.png";
        }
    }

    public function getStoragePath()
    {
        return $this->storagePath . $this->photo->name;
    }

    public function deletePhoto()
    {
        if ($this->photo) {
            if (file_exists(public_path() . $this->getPhotoPath())) {
                Storage::delete($this->getStoragePath());
            }
            $this->photo->delete();
        }
    }


}