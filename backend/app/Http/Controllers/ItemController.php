<?php

namespace App\Http\Controllers;

use App\Models\BranchCategory;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function store(Request $request)
{
    try {
        // التحقق من البيانات المدخلة
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'branch_category_id' => 'required|exists:branch_category,id', // يجب أن يكون معرف الفئة الفرعية موجودًا
            'currency' => 'required|string|max:10',
            'size' => 'nullable|string|max:50',
            'flavor' => 'nullable|string|max:50',
        ]);

        // إنشاء العنصر الجديد
        $item = Item::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'discount_price' => $validatedData['discount_price'],
            'branch_category_id' => $validatedData['branch_category_id'],
            'currency' => $validatedData['currency'],
            'size' => $validatedData['size'],
            'flavor' => $validatedData['flavor'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Item created successfully',
            'data' => $item
        ], 201); // كود الاستجابة 201 (نجاح في الإنشاء)

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to create item: ' . $e->getMessage()
        ], 500); // كود الاستجابة 500 (خطأ في الخادم)
    }
}
public function getItemsByBranchCategory(Request $request)
{
    try {
        // التحقق من وجود معرّف الفئة الفرعية في الطلب
        if (!$request->has('branch_category_id')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Branch category ID is required'
            ], 400); // كود الاستجابة 400 (طلب خاطئ)
        }

        // التحقق من أن الفئة الفرعية موجودة
        $branchCategory = BranchCategory::find($request->branch_category_id);
        if (!$branchCategory) {
            return response()->json([
                'status' => 'error',
                'message' => 'Branch category not found'
            ], 404); // كود الاستجابة 404 (غير موجود)
        }

        // استرجاع العناصر المرتبطة بالفئة الفرعية
        $items = Item::where('branch_category_id', $request->branch_category_id)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Items retrieved successfully',
            'data' => $items
        ], 200); // كود الاستجابة 200 (نجاح)
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to retrieve items: ' . $e->getMessage()
        ], 500); // كود الاستجابة 500 (خطأ في الخادم)
    }
}

}
