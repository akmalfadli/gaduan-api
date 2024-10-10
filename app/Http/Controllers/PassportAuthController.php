<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
       
        $token['token'] = $user->createToken('GaduanAuthApp')->accessToken;
 
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ], 200);
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
        if (auth()->attempt($data)) {
            $token['token'] = auth()->user()->createToken('GaduanAuthApp')->accessToken;
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorised'
            ], 401);
        }
    }   

    public function logout(Request $request){
        if(Auth::user()){
         $user = Auth::user()->token();
         $user->revoke();
      return response()->json([
          'success' => true,
          'message' => 'Logout successfully',
         ]);
        } else{
         return response()->json([
          'success' => false,
          'message' => 'Unable to Logout',
         ]);
        }
       }
}