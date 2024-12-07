<?php

namespace App\Services\Web\Backend;

use App\Helper\Helper;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;

class CateogryService
{
    public function store(array $data)
    {
        try {
            DB::beginTransaction();
            $image = Helper::uploadFile($data['image'], 'category');
            $Category = Category::create([
                'name' => $data['name'],
                'cost' => $data['cost'],
                'provision' => $data['provision'],
            ]);

            $Category->image()->create([
                'url' => $image
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Helper::deleteFile($image);
            throw $e;
        }
    }
}
