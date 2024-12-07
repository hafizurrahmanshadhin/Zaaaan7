<?php

namespace App\Services\Web\Backend;

use App\Models\Category;
use Exception;

class CateogryService
{
    public function store(array $data)
    {
        try {
            Category::created([
                'name' => $data['name'],
                'cost' => $data['cost'],
                'provision' => $data['provision'],
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
