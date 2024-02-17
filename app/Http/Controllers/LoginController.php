<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Mail\AuthConfirm;
use App\Models\twoFactors;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function formLogin()
   {
       return view('authentication.login.login');
   }

   public function loginValidate(LoginRequest $request)
   {
       try {

           $userLogin = User::where('email', $request->email)->first();

           if ($userLogin) {

               if (Hash::check($request->password, $userLogin->password)) {

                   $code = rand(10000, 99999);


                   TwoFactors::create([
                       'user_id' => $userLogin->id,
                       'code'    => $code,
                   ]);

                   Mail::to($userLogin['email'])->send(new AuthConfirm(['userName' => $userLogin['name'], 'code' => $code]));

                   $request->session()->put('user_id', $userLogin['id']);

                   return redirect()->route('login.code');

               } else {

                   throw new \Exception("Incorrect password. Try again");
               }
           }else{

               throw new \Exception("Email not found, register");
           }
       }catch (\Exception $e){

           return  redirect()->route('login.index')->withErrors(["Error: {$e->getMessage()}."]);
       }


   }

   public function  formCode(Request $request)
   {

       return view('authentication.login.confirmCode');
   }
   public function confirmCode(Request $request){

       try {

           $userId = session('user_id');

           $confirmCode = twoFactors::where('user_id',$userId)->first();

           if($confirmCode->code != $request->code){

               if($confirmCode->failed_attempts == 3){

                   twoFactors::destroy($confirmCode->id);

                   return redirect()->route('login.index')->withErrors(["Error: The maximum number of attempts has been exceeded, please try again."]);
               }

               $confirmCode->increment('failed_attempts');

               $confirmCode->save();

               throw new \Exception("Incorrect code. Try again!");

           }


           twoFactors::destroy($confirmCode->id);

           $userInfo = User::where('id',$userId)->first();

           $userInstance = new User([
               'name' => $userInfo->name,
               'email' => $userInfo->email,
               'password' => $userInfo->password,
           ]);

           return redirect()->route('home.index');

       }catch (\Exception $e){
           return  redirect()->route('login.code')->withErrors(["Error: {$e->getMessage()}."]);
       }

    }


}
