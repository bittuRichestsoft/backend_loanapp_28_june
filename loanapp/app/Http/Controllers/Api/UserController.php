<?php
namespace App\Http\Controllers\Api;
// require 'vendor/autoload.php';
use Plivo\RestClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\User;
use App\OTP;
use App\Applogin;
use App\PasswordReset;
use Hash;
use DB;
use Twilio;
use XmlAuthRequest;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Illuminate\Support\Str;
// use App;

class UserController extends Controller
{

  public function __construct()
    {
      $locale = \App::getLocale();
      // dd($locale);
      if (\App::isLocale('en')) {
        // die("here");
        $this->already_registered_and_verified = 'User already Registered and Verified.';
        $this->already_registered_not_verified = 'User already Registered but not Verified.';
        $this->otp_message = 'is the OTP for your CAPITAL account. NEVER SHARE YOUR OTP WITH ANYONE.';
        $this->otp_message_verify = 'We have sent an OTP on your mobile number. Please enter the OTP to verify your account.';
        $this->account_verified = 'Your account is verified.';
        $this->otp_invalid_crosscheck = 'Otp code is invalid.Please check your otp.';
        $this->otp_invalid_expired = 'Otp code is invalid or expired. Please check your otp.';
        $this->already_registered = 'You have already been registered.';
        $this->user_registered = 'User Registered successfully.';
        $this->userPassword_updated = 'Password Updated successfully.';

        $this->userPassword_Already_updated = "Password Already Updated successfully.";
        $this->account_not_exists = 'Account does not exists.';
        $this->user_blocked = 'You have been blocked by the administrator. Ask the administrator to activate your account.';
        $this->incorrect_pin = 'Incorrect Pin';
        $this->forgot_pin_not_be_same = 'Pin should be different from last';
        $this->logged_in = 'Logged in successfully';
        $this->session_expired = 'Session Expired';
        $this->logged_out = 'Logged out successfully';
        $this->details_updated = 'Your details have been Updated';
        $this->user_not_found = 'User Not Found';
        $this->user_not_found_with_mobile = "User with this mobile number doesn't exists";
        $this->new_pin_sent= "We have sent a new Pin on your mobile number";
        $this->choose_pin= "Choose a new pin for Capital App";
        $this->sms_sent= "Sms has been sent on your registered mobile number";
        $this->income_sources_fetched= "Income Sources Fetched";
      }
      else{
        $this->already_registered_and_verified = 'Usuário já cadastrado e verificado.';
        $this->already_registered_not_verified = 'Usuário já registrado, mas não verificado.';
        $this->otp_message = 'é o OTP para a tua conta Capital. Nunca compartilhe o seu OTP com ninguém.';
        // $this->otp_message = 'é o OTP para sua conta CAPITAL. NUNCA COMPARTILHE SUA OTP COM NINGUÉM.';
        $this->otp_message_verify = 'Enviamos uma OTP em seu número de celular. Digite o OTP para verificar sua conta.';
        $this->account_verified = 'Sua conta foi verificada.';
        $this->otp_invalid_crosscheck = 'O código otp é inválido. Verifique o seu otp.';
        // $this->otp_invalid_expired = 'O código Otp é inválido ou expirou. Por favor, verifique o seu otp.';
        $this->otp_invalid_expired = 'O Código OTP inserido é inválido ou expirou, verifique por favor o seu OTP.';
        $this->already_registered = 'Você já foi cadastrado.';
        $this->user_registered = 'Usuário registrado com sucesso.';
         $this->userPassword_updated = 'Password Updated successfully.';
         $this->userPassword_Already_updated = "Password Already Updated successfully.";
        $this->account_not_exists = 'Usuário registrado com sucesso.';
        $this->user_blocked = 'Você foi bloqueado pelo administrador. Peça ao administrador para ativar sua conta.';
        $this->incorrect_pin = 'PIN incorreto';
        // $this->forgot_pin_not_be_same = 'Pin should be different from last';
        $this->forgot_pin_not_be_same = 'O pin escolhido deve ser diferente dos anteriores';
        $this->logged_in = 'Conectado com sucesso';
        $this->session_expired = 'Sessão expirada';
        $this->logged_out = 'Saiu com sucesso';
        $this->details_updated = 'Seus detalhes foram atualizados';
        $this->user_not_found = 'Usuário não encontrado';
        $this->user_not_found_with_mobile = "Não existe usuário com este número de celular";
        $this->new_pin_sent= "Enviamos um novo PIN no seu número de celular";
        $this->choose_pin= "Escolha um novo pin para o aplicativo Capital";
        $this->sms_sent= "SMS foi enviado em seu número de celular registrado";
        $this->income_sources_fetched= "Fontes de renda buscadas";
      }
    }

	private function Otp($message, $recipients){
	    $account_sid = getenv("TWILIO_SID");
	    $auth_token = getenv("TWILIO_AUTH_TOKEN");
	    $twilio_number = getenv("TWILIO_NUMBER");
	    $client = new Client($account_sid, $auth_token);
		try {
			$message = $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
            // print($message->sid);
            // die;
			return 1;
		} catch(Twilio\Exceptions\RestException $e) {
              // return $e->getMessage();
            // die("catch");
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            $email= "gagandeep@mailinator.com";
            $to = "Capitalapp@mailinator.com"; 
            $subject = "OTP Verification"; 
            // $message = $message; 
            // $headers = 'From: ' . $email . "\r\n" . 
            // 'Reply-To: ' . $email . "\r\n" . 
            // 'X-Mailer: PHP/' . phpversion();

            $headers  = "From: testsite < mail@testsite.com >\n";
            $headers .= "Cc: testsite < mail@testsite.com >\n"; 
            $headers .= "X-Sender: testsite < mail@testsite.com >\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();
            $headers .= "X-Priority: 1\n"; // Urgent message!
            $headers .= "Return-Path: mail@testsite.com\n"; // Return path for errors
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=iso-8859-1\n";

            $mail = mail($to,$subject,$message,$headers);
            // echo $mail;
            return $mail;

		};
        // try{
        //     $client = new RestClient("MAZWZMMTY5MJK5ZMUZOT", "ZGZkMzc5YmM2Mjc4YzdiNzkxOWQ1MGJiN2RkYjcw");
        //     $message_created = $client->messages->create(
        //         '+912228889990',
        //         [$recipients],
        //         $message
        //     );
        //     return 1;
        // }catch(PlivoRestException  $e){
        //          return $e->getMessage();
        // }
	}

	public function send_otp(Request $request){
    $statusCode=200;
    $validator = Validator::make ( $request->all (), ['phone' => 'required']);
    if ($validator->fails()){
      return response ()->json ([
          'status' => false,
          'message' => $validator->getMessageBag ()->first() 
      ], 400 );
    }



    if(User::where('phone',$request->phone)->where('is_active',1)->exists()) {
      return response ()->json ([
          'status' => false,
          'message' => $this->already_registered_and_verified
      ],400);
    }elseif(User::where('phone',$request->phone)->where('is_active',0)->exists()) {
      return response ()->json ([
          'status' => false,
          'message' => $this->already_registered_not_verified
      ],400);
    }else{
    	$otp = substr(str_shuffle("0123456789"), 0, 6);
    	$message = $otp.$this->otp_message;
    	$get_otp = OTP::where('phone_number' , $request->phone )->first();
    	if($get_otp){ 
        $get_otp->delete(); 
      }

    	$save_otp = new OTP;
    	$save_otp->otp = $otp;
    	$save_otp->phone_number = $request->phone;
    	$save_otp->save();
			$res =  $this->Otp($message, $request->phone);

			if( $res == 1 ){
				return response ()->json ([
          'status' => true,
          'message' => $this->otp_message_verify
      	],200);
			}else{
      //  die('a');
				return response ()->json ([
          'status' => false,
         // 'message' =>$res,
          'message' => "The number you have inputted does not match our records."
      	],400);
			}
			
    }        
  }

  /*****************Forgot Used Api**********************/
  public function forgortNewPin(Request $request)
  {
          $statusCode=200;
          $validator = Validator::make ( $request->all (), ['phone' => 'required']);

    if ($validator->fails()){
      return response ()->json ([
          'status' => false,
          'message' => $validator->getMessageBag ()->first() 
      ], 400 );
    }

      $user =   User::where('phone',$request->phone)->where('is_active',1)->first();

      if($user){

        $otp = substr(str_shuffle("0123456789"), 0, 6);
        $message = $otp.' '.$this->otp_message;
        $get_otp = OTP::where('phone_number' , $request->phone )->first();
        if($get_otp){ 
        $get_otp->delete(); 
      }

        $save_otp = new OTP;
        $save_otp->otp = $otp;
        $save_otp->phone_number = $request->phone;
        $save_otp->save();
            $res =  $this->Otp($message, $request->phone);

            if( $res == 1 ){
                return response ()->json ([
          'status' => true,
          'message' => $this->otp_message_verify
        ],200);
            }else{
                return response ()->json ([
          'status' => false,
          'message' => $res
        ],400);
            } 

      }else{

         return response()->json(['status' => 'false','message' => $this->user_not_found_with_mobile], 400 );

      }

  }


  public function forgotVerifyOTP(Request $request)
  {
        
       $validator = Validator::make ($request->all (),
        ['otp' => 'required',
         'phone' => 'required',
        ]);
        if ($validator->fails ()) 
        {
            return response ()->json ([
                'status' => 'false',
                'message' => $validator->getMessageBag()->first ()
            ],400);
        } 

        $response = [];
        $status_code = 200;

        //   if(env('ENVIRONMENT')=="dev"){
        //     $country_code = "+91";
        //     $phone = substr ($request->phone, -10);
        //     $request->phone = $country_code.$phone;
        // }
        // else{
        //     $country_code = "+244";

  
        //     $myString = 'This is from itsolutionstuff.com website.';
                 
        //     $contains = Str::contains($request->phone, [$country_code]);
        //     if($contains ==true){
        //         $request->phone = $request->phone;
        //     }else{
        //         $request->phone = $country_code.$request->phone;
        //     }

        // }

        $otpc = OTP::where('phone_number',$request->phone)->where('otp',$request->otp)->first();   

        if(!empty($otpc->otp))
        {
            if( $request->otp == $otpc->otp ) 
            {
                $otpc->delete();
                return response ()->json ([
                  'status' => 'true' , 
                    'message' => $this->account_verified
                ], 200);
            }
            else
            {
                return response ()->json ([
                    'status' => 'false',
                    'message' => $this->otp_invalid_crosscheck
                ], 400);
            }
        }
        else
        {
            return response ()->json ([
                'status' => 'false',
                'message' => $this->otp_invalid_expired
             ], 400);
        }

  }

   public function forgotCreateNewPin(Request $request)
   {
       
        $validator = Validator::make ($request->all (),['phone' => 'required','pin' => 'required','device_type'=> 'required']);

        if ($validator->fails ()) 
        {
            return response ()->json ([
                'status' => 'false',
                'message' => $validator->getMessageBag()->first ()
            ],400);
        }


        $pin = $request->pin;
          
        //  if(env('ENVIRONMENT')=="dev"){
        //     $country_code = "+91";
        //     $phone = substr ($request->phone, -10);
        //     $request->phone = $country_code.$phone;
        // }
        // else{
        //     $country_code = "+244";

  
        //     $myString = 'This is from itsolutionstuff.com website.';
                 
        //     $contains = Str::contains($request->phone, [$country_code]);
        //     if($contains ==true){
        //         $request->phone = $request->phone;
        //     }else{
        //         $request->phone = $country_code.$request->phone;
        //     }

        // }

            $user = User::where('phone' , $request->phone)->first();

            if($user){
             if( ! Hash::check($pin, $user->password) ){
                        
                 $newpin = Hash::make( $pin );

                  $updateUser = User::where('phone' , $request->phone)->update(array( 'password' => $newpin ));  
                  $session_id= str_random(32);
                  if($updateUser){
                    $userData = User::where('phone' , $request->phone)->first();
                    $app = new AppLogin();
                    $app->device_type = $request->device_type;
                    $app->device_token = $request->device_token ?? "";
                    $app->user_id = $userData->id;
                    $app->session_id = $session_id;
                    $app->save();

                    $response = [
                        'status' => 'true',
                        'message'=> $this->userPassword_updated,
                        'session_id' => $session_id,
                        'profile' => User::getUser($userData)
                    ];
                    $status_code = 200;
                    return response()->json($response,$status_code , $headers=[], $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);  
                  }else{
                        $session_id= str_random(32);
                        $userData = User::where('phone' , $request->phone)->first();
                        $app = new AppLogin();
                        $app->device_type = $request->device_type;
                        $app->device_token = $request->device_token ?? "";
                        $app->user_id = $userData->id;
                        $app->session_id = $session_id;
                        $app->save();
                        $userData = User::where('phone' , $request->phone)->first();
                        $response = [
                        'status' => 'true',
                        'message'=> $this->userPassword_Already_updated,
                        'session_id' => $session_id,
                        'profile' => User::getUser($userData)

                    ];
                    $status_code = 200;
                    return response()->json($response,$status_code , $headers=[], $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);  

                  }


                }else{

                    $statusCode = 200;
                    $response = [
                      "status" => false,
                      "message" => $this->forgot_pin_not_be_same
                    ];

                return response()->json($response,$statusCode , $headers=[], $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);  
                }

            }else{


                 $statusCode = 200;
                $response = [
                'status' => false,
                "message" => $this->account_not_exists
            ];

    return response()->json($response,$statusCode , $headers=[], $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);  
            }


   }
    public function fill_otp(Request $request){
		$validator = Validator::make ($request->all (),
        ['otp' => 'required']);
        if ($validator->fails ()) 
        {
            return response ()->json ([
                'status' => 'false',
                'message' => $validator->getMessageBag()->first ()
            ],400);
        }
        
        $response = [];
        $status_code = 200;
        
        $otpc = OTP::where('otp',$request->otp)->first();       
        if(!empty($otpc->otp))
        {
            if( $request->otp == $otpc->otp ) 
		    {
		    	$otpc->delete();
                return response ()->json ([
                  'status' => 'true' , 
                	'message' => $this->account_verified
                ], 200);
            }
            else
            {
                return response ()->json ([
                    'status' => 'false',
                    'message' => $this->otp_invalid_crosscheck
                ], 400);
            }
        }
        else
        {
            return response ()->json ([
                'status' => 'false',
                'message' => $this->otp_invalid_expired
             ], 400);
        }
        
        return response()->json($response,$status_code , $headers=[], $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
	}

	public function create_pin(Request $request){

		$status_code=200;
        $response=[];
        
        $validator = Validator::make ( $request->all (),[
            'pin' => 'required|max:6|min:6',
            'confirm_pin'=>'required|same:pin',
            'phone' => 'required',
        ]);
        if ($validator->fails()) 
        {
            return response ()->json ([
                'status' => 'false',
                'message' => $validator->getMessageBag ()->first () 
            ], 400 );
        }

        $session_id= str_random(32);

        // if(env('ENVIRONMENT')=="dev"){
        //     $country_code = "+91";
        //     $phone = substr ($request->phone, -10);
        //     $request->phone = $country_code.$phone;
        // }
        // else{
        //     $country_code = "+244";

  
        //     $myString = 'This is from itsolutionstuff.com website.';
                 
        //     $contains = Str::contains($request->phone, [$country_code]);
        //     if($contains ==true){
        //         $request->phone = $request->phone;
        //     }else{
        //         $request->phone = $country_code.$request->phone;
        //     }

            
        // }
        
        // $request->phone = $country_code.$phone; 
        
        $user = User::where( 'phone' , $request->phone )->first();
        if( $user ){
        	$response = [
        		'status' => 'false',
	            'message'=>$this->already_registered,
	        ];
	        return response()->json($response, $status_code, $headers=[], $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }

	    $user = new User();
        $user->phone = $request->phone;
        $user->password = Hash::make( $request->pin );
        $user->user_role = 1;
        $user->save();

        $app = new AppLogin();
        $app->device_type = $request->device_type;
        $app->device_token = $request->device_token;
        $app->user_id = $user->id;
        $app->session_id = $session_id;
        $app->save();

        $response = [
            'status' => 'true',
            'message'=>$this->user_registered,
            'session_id' => $session_id,
            'profile' => User::getUser($user)
        ];
        return response()->json($response,$status_code , $headers=[], $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
	}

	public function loginPin(request $request)
    {

        $statusCode=200;
        $response=[];

        $validator = Validator::make($request->all(),
        [
        	'pin' => 'required|max:6|min:6',
            'phone'=>'required'
      	]);
        if($validator->fails()) 
        {
            $statusCode=200;
             $response = [
            'status' => false,
            "message" => $validator->getMessageBag()->first()];
        }else
        {
            $pin = $request->pin;
            $phone = $request->phone;
            
            $user = User::where('phone' , $phone)->first();

            if( $user == null ) 
            {
                $statusCode = 200;
                $response = [
                'status' => false,
                "message" => $this->account_not_exists
            ];
            }
            elseif($user->is_active == 0)
            {
                $statusCode = 200;
                $response = [
                    'status' => false,
                    "message" => $this->user_blocked
                ];        
            }
            else 
            {
                // dd($this->incorrect_pin);
                if( ! Hash::check($pin, $user->password) ){
                    $statusCode = 200;
                    $response = [
                      "status" => false,
                      "message" => $this->incorrect_pin
                    ];
                }else{
                    $session_id = str_random(32);
                    $checkdetail = AppLogin::where( "user_id", $user->id)->first();
                    if(!empty($checkdetail))
                    {
                        $checkdetail->device_type = $request->device_type;
                        $checkdetail->device_token = $request->device_token;
                        $checkdetail->session_id = $session_id;
                        $checkdetail->save();
                    }
                    else
                    {
                        $app = new AppLogin();
                        $app->device_type = $request->device_type;
                        $app->device_token = $request->device_token;
                        $app->user_id = $user->id;
                        $app->session_id = $session_id;
                        $app->save();

                    }
                    $statusCode = 200;
                    $response = [
                        "status" => true,
                        "message"=>$this->logged_in,
                        "session_id" =>  $session_id,
                        "profile" => User::getUser($user)
                    ];
                }            
            }
        }

        
        $status_code=200;
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }

    public function logout(request $request)
    {
        $statusCode=200;
        $response=[];
        $user_id =  User::validateSessionId($request->session_id);
        if (! $user_id) {
            return response ()->json (['status' => 'false','message' => $this->session_expired], 403);
        }else{
            $logout = AppLogin::where('session_id',$request->session_id)->first();
            $logout->session_id = '';
            $logout->save();

            ob_get_clean();
            $response=['status' => 'true',"message" => $this->logged_out ];
            
            return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function update_profile(request $request){
    	$status_code=200;
        $response=[];

        $app_login = Applogin::where( 'session_id' , $request->session_id )->first();
        if( ! $app_login ){
        	$response = [
        		'status' => 'false',
            'message'=>$this->session_expired,
	        ];
	        return response()->json($response, $status_code, $headers=[], $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        $validator = Validator::make($request->all(),
        [
          'first_name' => 'required',
          'dob' => 'required',
          'id_number' => 'required',
          'bank_account' => 'required',
        	'source_of_income' => 'numeric',
        	'email' => 'unique:users,email,'.$app_login->user_id,
      	]);
        if($validator->fails()) {
            $status_code=400;
            $response = [
            'status' => 'false',
            "message" => $validator->getMessageBag()->first()];
            return response()->json($response, $status_code, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $user = User::find($app_login->user_id);
        if( $user ){
    		$user->first_name = $request->first_name;
    		$user->last_name = $request->last_name;
    		$user->email = $request->email;
    		$user->gender = $request->gender;
    		$user->dob = $request->dob;
    		$user->id_number = $request->id_number;
    		$user->bank_account = $request->bank_account;
    		$user->source_of_income = $request->source_of_income;
    
    		if( $request->hasFile('id_doc') ){
    			if($user->id_doc != '' ){
	    			$check_file_exists = public_path().'/uploads/id_doc/'.$user->id_doc;
	    			if( $check_file_exists ){
	    				unlink($check_file_exists);
	    			}
	    		}

    			$file = $request->file('id_doc');
    			$ext = $file->getClientOriginalExtension();
    			$file_name = date('His').time().'.'.$ext;

    			$destinationPath = public_path().'/uploads/id_doc/';
    			$file->move( $destinationPath , $file_name);

    			$user->id_doc = $file_name;
    		}

    		$user->save();

    		$status_code = 200;
        $response = [
                'status' => 'true',
                "message"=>$this->details_updated,
                "session_id" =>  $request->session_id,
                "profile" => User::getUser($user)
        ];
        return response()->json($response, $status_code, $headers=[], $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

    	}else{
    		$response = [
        		'status' => 'false',
	            'message'=> $this->user_not_found,
	        ];
	        return response()->json($response, $status_code, $headers=[], $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    	}
    }
    
    public function forgotPin(Request $request)
    {
        $status_code = 200;
        $response = [];
        $validator = Validator::make ($request->all (), ['phone' => 'required']);

        if($validator->fails ()) {
            return response()->json(['status' => 'false', 'message' => $validator->getMessageBag()->first ()],400);
        }

        $user = User::where('phone',$request->phone)->first();
        if( $user == null ){
            return response()->json(['status' => 'false','message' => $this->user_not_found_with_mobile], 400 );
        }else {
            $new_pin = substr(str_shuffle("0123456789"), 0, 6);            
            $message = 'We have received a request to change the pin. Use '.$new_pin.' as your new pin to login for Capital App';

            $res =  $this->Otp($message, $request->phone);
            // dd($res);
            if( $res == true ){
                $user->password = Hash::make( $new_pin );
                $user->save();
                return response ()->json (['status' => 'true', 'message' => $this->new_pin_sent],200);
            }else{
                if( $user->email != '' ){                  
                    $email = $user->email;
                    $username = $user->name;
                    $rand_str = str_random(32);

                    $password_reset = PasswordReset::where( 'email' , $email )->first();
                    if( $password_reset ){
                        DB::table('password_resets')->where('email', $email)->delete();
                    }
                    $password_reset = new PasswordReset;
                    $password_reset->email = $email;
                    $password_reset->token = $rand_str;
                    $password_reset->save();
                    

                    Mail::send( "api.email.forgot_pin",
                    [
                        "recovery" => $rand_str,
                        "username" => $username,
                        "email"   =>  $email
                    ],
                    function ($m) use ($email) 
                    {
                        $m->from ( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME') );
                        $m->to ($email)->subject ( $this->choose_pin );
                    });

                    $response = [ 'status' => 'true', "message"=>$this->sms_sent ];           
                    return response()->json($response, $status_code, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                }else{
                    return response ()->json ([ 'status' => 'false', 'message' => $res ],400);
                }
            }
        }
    }

    public function resetpin(Request $request)
    {    
        $recovery = PasswordReset::where('token',$request->key)->first();
        if(!$recovery)
        {
            return response ()->json (['status' => 'false',
            'message' =>"link expired"], 200 );
        }
        $user = User::where( 'email' , $recovery->email )->first();
        return View( 'api.email.resetpassword' , [ 'id'=> $user->id ]);
    }

    public function resetPasswordPost(Request $request)
    {
        $statusCode = 200;
        $response = [];
        $validator = Validator::make ($request->all (),[
            'new_pin' => 'required|max:6|min:6', 
            'confirm_pin' => 'required|same:new_pin',
        ]);
        if($validator->fails ()) 
        {
            return response()->json(['status' => 'false',
            'message' => $validator->getMessageBag()->first ()],400);
        }

        $id = $request->id;
        $user = User::where( 'id' , $id )->update([ 'password' => Hash::make( $request->new_pin ) ]);

        $user = User::find($id);
        $user->password = Hash::make( $request->new_pin );
        $user->save();

        DB::table('password_resets')->where('email', $user->email)->delete();

       return response ()->json(['status' => 'true','message' =>"password updated"],200);
    }

    public function incomeSources(Request $request)
    {   
        // if(env('ENVIRONMENT')=='dev')
        // {
        //    $income_sources = DB::table('income_sources')->where('id','<',6)->limit(5)->get(['id','name']);
        // } 
        // else
        // {
        //    $income_sources = DB::table('income_sources')->where('id','>=',6)->limit(5)->get(['id','name']);
        // }
        $income_sources = DB::table('income_sources')->get(['id','name']);

        $response = [
          "status" => "true",
          "message"=>$this->income_sources_fetched,
          "result" => $income_sources
        ];           
        return response()->json($response, 200, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    
    public function change_password(Request $request) {

        $statusCode = 200;
        $response = [ ];

        $session_id = $request->session_id;
        $user_id = User::validateSessionId($session_id);
        if (! $user_id) {
          return response ()->json (['error' => 'bad_request','message' => $this->session_expired ,"status"=> 401]);
        }
        
       $validator = Validator::make($request->all(),
        [
          'old_password' => 'required|digits:6',
          'new_password' => 'required|numeric|digits:6',
          'confirm_password' => 'required|numeric|digits:6',
        ]);

        if($validator->fails()) 
        {
          $statusCode=400;
          $response = [
            "status" => false,
            "message" => $validator->getMessageBag()->first()
          ];
          return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $password = $request->new_password;
        $new_password = $request->confirm_password;
        $user = User::where("id","=",$user_id)->first();
        $current_password = $user->password;   
        
        if(Hash::check($request->old_password, $current_password))
        {   
            $user = User::find($user_id);        
            $user->password = Hash::make( $request->new_password ) ;
            $user->save(); 
            $response = [
                "status" => true,
                "message" => "Password updated."
            ];
            return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        else
        {           
            $response = [
                "status" => false,
                "message"=>"Wrong password",
                ];
            return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); 
        }


    }




}