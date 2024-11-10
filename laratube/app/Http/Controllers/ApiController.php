<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    public function register(Request $req)
    {
        // تحقق من البيانات المدخلة
        $validator = Validator::make($req->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'contact' => 'required|string|min:10',
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048', // تحقق من نوع الصورة
        ]);

        // إرسال استجابة فاشلة إذا كانت الطلبات غير صالحة
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'code' => 2], 400);
        }

        // معالجة تحميل الصورة
        $file = $req->file("file");
        $uploadPath = "images/profile";
        $originalName = time() . '_' . $file->getClientOriginalName(); // إضافة الطابع الزمني لتفادي تكرار الأسماء
        $file->move($uploadPath, $originalName);

        // إنشاء المستخدم
        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password)
        ]);

        if ($user) {
            // إنشاء الطالب
            $student = Student::create([
                'contact' => $req->contact,
                'profile_image' => $originalName,
                'user_id' => $user->id,
            ]);

            if ($student) {
                // إرسال استجابة ناجحة
                return response()->json([
                    'success' => true,
                    'code' => 1,
                    'message' => 'User created successfully',
                    'data' => $user
                ], Response::HTTP_OK);
            }
        }

        return response()->json(['success' => false, 'message' => 'User creation failed.'], 500);
    }

    public function login(Request $request)
    {
        // الحصول على بيانات الاعتماد
        $credentials = $request->only('email', 'password');

        // تحقق من صحة بيانات الاعتماد
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        // إرسال استجابة فاشلة إذا كانت الطلبات غير صالحة
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // محاولة إنشاء التوكن
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }

        // إرسال استجابة ناجحة مع التوكن
        return response()->json([
            'success' => true,
            'code' => 1,
            'message' => 'Login Successfully',
            'token' => $token,
            'user_details' => $credentials['email']
        ]);
    }

    public function get_user(Request $request)
    {
        // لا يوجد تعديل هنا، لكن تأكد من معالجة التوكن بشكل صحيح إذا كنت بحاجة لذلك
    }

    public function get_one_user(Request $request)
    {
        $inserted_id = $request->id;

        $result = DB::table('student')->where("id", $inserted_id)->first();

        if ($result) {
            return response()->json([
                "body" => [
                    "user" => [
                        "id" => $result->id,
                        "name" => $result->name,
                        "age" => $result->age,
                        "profile_image" => $result->profile_image,
                        "created_at" => $result->created_at,
                        "updated_at" => $result->updated_at
                    ]
                ],
                "status" => "successful"
            ]);
        } else {
            return response()->json([
                "body" => "No user found",
                "status" => "Error"
            ], 404);
        }
    }

    public function logout(Request $request)
    {
        if (empty($request->token)) {
            return response()->json([
                'success' => false,
                'code' => 2,
                'message' => 'Token is required'
            ], 400);
        }

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'code' => 1,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'code' => 2,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}