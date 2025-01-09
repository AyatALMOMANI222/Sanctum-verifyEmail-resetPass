<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
{
    try {
        // التحقق من البيانات المدخلة
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'branch_ids' => 'required|array', // تأكد من أن هناك مصفوفة من المعرفات الخاصة بالفروع
            'branch_ids.*' => 'exists:branches,id', // التحقق من أن الفروع موجودة في جدول branches
        ]);

        // إنشاء الفئة الجديدة في جدول categories
        $category = Category::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        // إضافة السجلات إلى جدول branch_category (ربط الفئة بالفروع)
        foreach ($validatedData['branch_ids'] as $branchId) {
            // إضافة علاقة الفئة بالفرع في جدول branch_category
            \App\Models\BranchCategory::create([
                'branch_id' => $branchId,
                'category_id' => $category->id,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Category created and added to branches successfully',
            'data' => $category
        ], 201); // كود الاستجابة 201 (نجاح في الإنشاء)

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to create category: ' . $e->getMessage()
        ], 500); // كود الاستجابة 500 (خطأ في الخادم)
    }
}
public function getAllCategoriesWithBranches(Request $request)
{
    try {
        // التصفية حسب الاسم إذا كان هناك اسم ممرر في الطلب
        $query = Category::query();

        // التصفية حسب الاسم إذا تم توفيره
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // جلب الفئات مع الفروع المرتبطة بها
        $categories = $query->with(['branches'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ], 200); // كود الاستجابة 200 (نجاح في الاسترجاع)

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to retrieve categories: ' . $e->getMessage()
        ], 500); // كود الاستجابة 500 (خطأ في الخادم)
    }
}

}
