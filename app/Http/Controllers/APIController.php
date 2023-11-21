<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Testing\Fakes\Fake;

class APIController extends Controller
{
    function createUser(Request $request)
    {
        $response = [
            "code" => 200,
            "status" => true,
        ];

        $rules = [
            "name" => ["required"],
            "no_ktp" => ["required", "numeric", "digits:16", "unique:users,no_ktp"],
            "email" => ["required", "unique:users,email"],
            "balance" => ["required", "numeric"],
            "password" => ["required", "min:8"],
            "pin" => ["required", "digits:6"],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response["code"] = 400;
            $response["status"] = \false;
            $response["message"] = "please check the parameters";
            $response["errors"] = $validator->errors();
        } else {
            $faker = Faker::create('id_ID');
            $norek = $faker->bothify("############");
            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->pin = $request->pin;
            $newUser->email = $request->email;
            $newUser->norek = $norek;
            $newUser->password = \bcrypt($request->password);
            $newUser->balance = $request->balance;
            $newUser->no_ktp = $request->no_ktp;
            $newUser->save();

            $response["message"] = "success to create new user";
            $response["data"] = $newUser;
        }

        return \response()->json($response, $response["code"]);
    }

    function loginUser(Request $request)  {
        $creadentials = $request->only("email","password");
        if(Auth::attempt($creadentials)) {
             $user = Auth::user();
             $token = $user->createToken($user->id)->accessToken;
 
             return \response()->json([
                 "status" => true,
                 "data" => $user,
                 "token" => $token
             ]);
         } else {
             return \response()->json([
                 "status" => \false,
                 "message" => "invalid credentials!"
             ]);
         }
     }

    function updateUser(Request $request)
    {
        $response = [
            "code" => 200,
            "status" => true,
        ];

        $rules = [
            "name" => ["required", "min:3"],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response["code"] = 400;
            $response["status"] = \false;
            $response["message"] = "please check the parameters";
            $response["errors"] = $validator->errors();
        } else {
            $user = $request->user();
            $user->name = $request->name;
            $user->update();

            $response["message"] = "success to update user";
            $response["data"] = $user;
        }

        return \response()->json($response, $response["code"]);
    }

    function getDataUser(Request $request) {
        return \response()->json([
            "status" => true,
            "data" => User::find($request->user()->id)
        ]);
    }

    function getDataBank(Request $request)
    {
        $response = [
            "code" => 200,
            "status" => \true
        ];
        $response["message"] = "success get data bank account";
        $response["data"] = [
            "name" => $request->user()->name,
            "norek" => $request->user()->norek,
            "saldo" => $request->user()->balance,
        ];

        return \response()->json($response, $response["code"]);
    }

    function topUpSaldo(Request $request)
    {
        $response = [
            "code" => 200,
            "status" => true,
        ];

        $rules = [
            "norek" => ["required", "numeric"],
            "amount" => ["required", "numeric", "min:5000"],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response["code"] = 400;
            $response["status"] = \false;
            $response["message"] = "please check the parameters";
            $response["errors"] = $validator->errors();
        } else {
            $findBank = User::where("norek", $request->norek)->first();
            if (!$findBank) {
                $response["code"] = 400;
                $response["status"] = \false;
                $response["message"] = "rekening number not found";
            } else {
                $findBank->balance += $request->amount;
                $findBank->save();
                $response["message"] = "success get data bank account";
                $response["data"] = [
                    "name" => $findBank->name,
                    "norek" => $findBank->norek,
                    "saldo" => $findBank->balance,
                ];
            }
        }

        return \response()->json($response, $response["code"]);
    }

    function transferAmount(Request $request)
    {
        $response = [
            "code" => 200,
            "status" => true,
        ];

        $rules = [
            "receiver_number" => ["required", "numeric"],
            "amount" => ["required", "numeric"],
            "pin" => ["required", "numeric"],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response["code"] = 400;
            $response["status"] = \false;
            $response["message"] = "please check the parameters";
            $response["errors"] = $validator->errors();
        } else {
            if($request->sender_number == $request->receiver_number) {
                $response["code"] = 400;
                $response["status"] = \false;
                $response["message"] = "sender number cannot be the same on receiver number ";
            } else {
                $findSender = $request->user();
                $findReceiver = User::where("norek", $request->receiver_number)->first();
                if($findSender->balance < $request->amount) {
                    $response["code"] = 400;
                    $response["status"] = \false;
                    $response["message"] = "sender's balance is not sufficient";
                } else {
                    if(!$findReceiver) {
                        $response["code"] = 400;
                        $response["status"] = \false;
                        $response["message"] = "bank account receiver not found";
                    } else if($findSender->pin != $request->pin) {
                        $response["code"] = 400;
                        $response["status"] = \false;
                        $response["message"] = "invalid pin!";
                    } else {
                        $newTransaction = new Transaction();
                        $newTransaction->sender_id = $findSender->id;
                        $newTransaction->receiver_id = $findReceiver->id;
                        $newTransaction->amount = $request->amount;
                        $newTransaction->save();

                        $findSender->balance -= $request->amount;
                        $findSender->update();
                        $findReceiver->balance += $request->amount;
                        $findReceiver->update();
        
                        $response["message"] = "success create transaction";
                    }
                }
            }
        }

        return \response()->json($response, $response["code"]);
    }

    function getMutation(Request $request) {
        $response = [
            "code" => 200,
            "status" => \true
        ];
        $findBank = User::with(["debits", "credits","debits.receiver","credits.sender"])->where("id", $request->user()->id)->first();
        if (!$findBank) {
            $response["code"] = 400;
            $response["status"] = \false;
            $response["message"] = "rekening number not found";
        } else {
            $response["message"] = "success get data mutations";
            $response["data"] = [
                "name" => $findBank->name,
                "norek" => $findBank->norek,
                "saldo" => $findBank->balance,
                "mutations" => [
                    "debits" => $findBank->debits,
                    "credits" => $findBank->credits,
                ]
            ];
        }

        return \response()->json($response, $response["code"]);
    }

    function changePin(Request $request) {
        $response = [
            "code" => 200,
            "status" => true,
        ];

        $rules = [
            "pin" => ["required", "digits:6"],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response["code"] = 400;
            $response["status"] = \false;
            $response["message"] = "please check the parameters";
            $response["errors"] = $validator->errors();
        } else {
            $user = $request->user();
            $user->pin = $request->pin;
            $user->update();

            $response["message"] = "success to update user";
            $response["data"] = $user;
        }

        return \response()->json($response, $response["code"]);
    }
    
}
