<?php

namespace Ecommerce\Base\Traits;
use Illuminate\Support\Facades\Storage;


trait AttachFilesTrait
{
    /**
     * @param $request
     * @param $name
     * @param $folder
     * @return void
     */
    public function uploadFile($request,$name,$folder)
    {
        $image = $request->file($name)->getClientOriginalName();
        $request->file($name)->storeAs('attachments/',$folder.'/'.$image,'upload_attachments');

    }

    /**
     * @param $name
     * @return void
     */
    public function deleteFile($name)
    {
        $exists = Storage::disk('upload_attachments')->exists('attachments/library/' . $name);

        if ($exists) {
            Storage::disk('upload_attachments')->delete('attachments/library/' . $name);
        }
    }
}
