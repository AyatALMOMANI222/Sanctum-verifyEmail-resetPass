<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
    ];


    public function branchCategories()
    {
        return $this->hasMany(BranchCategory::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_category');
    }
    public function items()
    {
        return $this->hasManyThrough(Item::class, BranchCategory::class);
    }
}
