<?php


namespace App\Services;


use Intervention\Image\Facades\Image;

class StoreImageService
{
    public function make($employee)
    {
        $this->storeImage($employee);
    }

    private function storeImage($employee)
    {
        if(request()->has('photo')){
//            dd(request()->photo);
//            $smallPhoto = null;
            $employee->update([
                'photo' => request()->photo->store('employees_photos', 'public'),
                'small_photo' => request()->photo->store('small_employees_photos', 'public'),
                'type_photo' => 'image'
            ]);

            $photo = Image::make(public_path('storage/' . $employee->photo))->fit(300, 300, null, 'center');
//            $photo->rotate(-45);
            $photo->save();

            $smallPhoto = Image::make(public_path('storage/' . $employee->small_photo))->fit(100, 100, null, 'center');
//            $smallPhoto->rotate(-90);
            $smallPhoto->save();
        }
    }
}
