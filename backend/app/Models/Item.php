<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'branch_category_id',
        'currency',
        'size',
        'flavor',
    ];

    public function branchCategory()
    {
        return $this->belongsTo(BranchCategory::class, 'branch_category_id');
    }

    public function branch()
    {
        return $this->belongsToThrough(Branch::class, BranchCategory::class);
    }
    public function category()
    {
        return $this->belongsToThrough(Category::class, BranchCategory::class);
    }
}
