<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function store(Request $request)
    {
        try {
            // التحقق من البيانات المدخلة (يمكنك إضافة قواعد تحقق إضافية هنا)
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email',
                'phone' => 'nullable|string|max:15',
                'domain' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);
    
            // تخزين البيانات باستخدام دالة store من النموذج
            $restaurant = Restaurant::create($validatedData);
    
            // إرجاع استجابة بنجاح
            return response()->json([
                'status' => 'success',
                'message' => 'Restaurant created successfully',
                'data' => $restaurant
            ], 201); // أكواد الاستجابة مثل 201 (نجاح)
    
        } catch (\Exception $e) {
            // إرجاع استجابة عند حدوث خطأ
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create restaurant: ' . $e->getMessage()
            ], 500); // كود الاستجابة 500 (خدمة فشل أو خطأ في الخادم)
        }
    }
    public function getRestInfo($id)
{
    try {
        // محاولة العثور على المطعم باستخدام المعرف
        $restaurant = Restaurant::find($id);
        
        // إذا لم يتم العثور على المطعم، إرجاع استجابة تحتوي على خطأ
        if (!$restaurant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Restaurant not found'
            ], 404); // كود الاستجابة 404 (المورد غير موجود)
        }

        // إرجاع استجابة تحتوي على بيانات المطعم
        return response()->json([
            'status' => 'success',
            'message' => 'Restaurant information retrieved successfully',
            'data' => $restaurant
        ], 200); // كود الاستجابة 200 (نجاح)
    
    } catch (\Exception $e) {
        // إرجاع استجابة عند حدوث خطأ
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to retrieve restaurant information: ' . $e->getMessage()
        ], 500); // كود الاستجابة 500 (خطأ في الخادم)
    }
}

}
