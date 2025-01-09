<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function store(Request $request)
    {
        try {
            // التحقق من البيانات المدخلة
            $validatedData = $request->validate([
                'restaurant_id' => 'required|exists:restaurants,id', // يجب أن يكون معرف المطعم موجودًا
                'branch_name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'phone' => 'nullable|string|max:15',
                'working_hours' => 'nullable|string|max:255',
                'manager_name' => 'nullable|string|max:255',
                'email' => 'nullable|email',
                'location' => 'nullable|string',
            ]);
    
            // تخزين البيانات باستخدام دالة store من النموذج
            $branch = Branch::create($validatedData);
    
            // إرجاع استجابة بنجاح
            return response()->json([
                'status' => 'success',
                'message' => 'Branch created successfully',
                'data' => $branch
            ], 201); // كود الاستجابة 201 (نجاح في الإنشاء)
    
        } catch (\Exception $e) {
            // إرجاع استجابة عند حدوث خطأ
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create branch: ' . $e->getMessage()
            ], 500); // كود الاستجابة 500 (خطأ في الخادم)
        }
    }



    public function getBranches(Request $request)
{
    try {
        // إذا كان هناك معرف المطعم في الاستعلام (اختياري)، نقوم بالبحث عن فروع هذا المطعم فقط
        if ($request->has('restaurant_id')) {
            // جلب الفروع مع معلومات المطعم المرتبطة بكل فرع باستخدام with()
            $branches = Branch::where('restaurant_id', $request->restaurant_id)
                            ->with('restaurant') // ربط الفروع مع المطعم
                            ->get();
        } else {
            // إذا لم يتم تقديم معرف المطعم، نقوم بإرجاع جميع الفروع مع معلومات المطعم
            $branches = Branch::with('restaurant')->get();
        }

        // إذا كانت الفروع موجودة، إرجاعها مع رسالة نجاح
        return response()->json([
            'status' => 'success',
            'message' => 'Branches retrieved successfully',
            'data' => $branches
        ], 200); // كود الاستجابة 200 (نجاح)

    } catch (\Exception $e) {
        // إرجاع استجابة عند حدوث خطأ
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to retrieve branches: ' . $e->getMessage()
        ], 500); // كود الاستجابة 500 (خطأ في الخادم)
    }
}

    
}
