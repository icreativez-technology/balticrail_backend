<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

use Illuminate\Support\Str;

trait ImageFunctionsTrait
{
    public function file_upload($image,$title,$save_path)
    {
        $file = $image;
        $storage_save = Storage::disk('public');
        $filename = Str::slug($title).".".$file->getClientOriginalExtension();
        $folder = date('d')."/".rand(0,59);
        $saveto = $save_path.$folder;
        $storage_save->put($saveto."/".$filename, file_get_contents($image));

        $save_path_array = array();
        $save_path_array['saveto'] = $saveto."/";
        $save_path_array['filename'] = $filename;

        return $save_path_array;
    }

	public function image_upload($image,$title,$save_path)
	{
        $file = $image;
        $filename = Str::slug($title).".".$file->getClientOriginalExtension();

        $folder = date('d')."/".rand(0,59);
        $saveto = $save_path.$folder;

        $file_upload_path = public_path($saveto);
        File::makeDirectory($file_upload_path,0777, true, true);

        $complete_image_path = public_path($saveto."/".$filename);
        Image::make($file)->save($complete_image_path, 80);

        Storage::disk('public')->put($saveto."/".$filename, file_get_contents($file));
        $complete_image_path_resize = public_path($saveto."/"."r_".$filename);

        $img = Image::make($file);
        $img->resize(260, 260, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($complete_image_path_resize, 80);

        $storage_save = Storage::disk('public');
        $storage_save->put($saveto."/"."r_".$filename, (string)$img);

        $complete_image_path_resize = public_path($saveto."/"."b_".$filename);

        $img = Image::make($file);
        $img->resize(450, 450, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($complete_image_path_resize, 80);

        $storage_save = Storage::disk('public');
        $storage_save->put($saveto."/"."b_".$filename, (string)$img);

        $save_path_array = array();
        $save_path_array['saveto'] = $saveto."/";
        $save_path_array['filename'] = $filename;

        return $save_path_array;
	}

}
