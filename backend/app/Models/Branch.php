<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'branch_name',
        'address',
        'phone',
        'working_hours',
        'manager_name',
        'email',
        'location',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function branchCategories()
    {
        return $this->hasMany(BranchCategory::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'branch_category');
    }
    public function items()
    {
        return $this->hasManyThrough(Item::class, BranchCategory::class);
    }
}
