<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\User;
use App\UserAccount;
use App\OTP;
use App\LoanAmount;
use App\RequestLoan;
use App\PostLoan;
use App\LoanDuration;
use App\LoanTerms;
use App\LoanReasons;
use App\Applogin;
use App\PasswordReset;
use App\LoanOffers;
use App\Loans;
use App\Notification;
use Hash;
use DB;
use Twilio;
use XmlAuthRequest;
use Carbon\Carbon;
use Twilio\Rest\Client;


class LoanController extends Controller
{
  public function __construct()
    {
      $locale = \App::getLocale();
      // dd($locale);
      if (\App::isLocale('en')) {
         $this->reason_data='Reason Data';
         $this->no_data='No Data Found.';
         $this->score_amount="you can't request this lone because credit score limit is:";
         $this->accept_msg='You can not send/accept this offer because you have already given/taken';
         $this->request_send='Loan requested not send';
         $this->success_msg='Loan requested successfully';
         $this->offer_send='Offers not sent';
         $this->friend_offer='Offers sent to selected friends';
         $this->loan_offers="All Loan Offers";
         $this->loan_posted="Loan posted successfully";
         $this->loan_val="Give Loan Offer calculated successfully";
         $this->invite_friends='invite friends';
         $this->recieve_loan='Received Loan Offers';
         $this->request_data='Request from other persones accepted by me';
         $this->loan_amount="Loan Amounts fetched";
         $this->seven_days="7 days Payment of AOA";
         $this->fifteen_days="15 days Payment of AOA";
         $this->tone_days="21 days Payment of AOA ";
         $this->thirtyone="30 Days Payment of AOA ";
         $this->installment="Installments Fetched";
         $this->terms_data="Terms Data";
         $this->interest_data="Interest Data";
         $this->loan_history="Loan History Fetched";
         $this->meta_data="Meta Data of Device Inserted";
         $this->rate_data="Interest Rates Fetched.";
         $this->durations="Durations Fetched.";
         $this->discounts="Discounts Fetched.";
         $this->accept_loan="You can't accept this lone because credit score limit is:";
         $this->loan_accepted="your loan has been accepted";
         
         $this->sendacc_offer="You can not send/accept this offer because you have not registered";
         $this->accept_lonaoff="Loan Offer Accepted";
         $this->reject_lonaoff="Loan cancelled";
         $this->loan_details="Loan detail";
         $this->no_loan_detail="Loan detail no data found";
         $this->installment_fetched="Notifications Fetched.";
         $this->notification_detail="All Un-read Notification Status Changed.";
         $this->notification_count="All Un-read Notification count.";
         $this->status_changed="Notification Status Changed.";
         $this->current_loan="Current Loan Status Fetched Successfully";
         $this->status_history="history status";
         $this->score_limit="user credit score limit";
         $this->type_loan="Received Loan Offers By Type";
         $this->data_list="DataList Found";
         $this->no_data_list="DataList Not Found";

         $this->requesting_to_you_loan  = "requesting to you for a loan";
         $this->share_for_loan  = "shared a Loan Offer with you";
         $this->invite_for_loan  = "is invite you for download this app";
         $this->shared_loan_Offer_with_you = " shared a Loan Offer with you";
         $this->loan_completed_paid_amount = "Loan Completed paid amount";
         $this->you_paying_much_as_paid = "you paying much as paid";
         $this->loan_paid_amount = "Loan paid Amount";
         $this->amount_pending_to_complete = "Amount Pending To Complete";
      }
      else
      {
         $this->reject_lonaoff='Empréstimo cancelado';
         $this->reason_data='Dados do motivo';
         $this->no_data='Nenhum dado encontrado';
         $this->score_amount='Você não pode solicitar isso porque o limite de pontuação de crédito é:';
         $this->accept_msg='Você não pode enviar / aceitar esta oferta porque você já deu / aceitou';
         $this->request_send='Empréstimo solicitado não enviado';
         $this->success_msg='Empréstimo solicitado com sucesso';
         $this->offer_send='Ofertas não enviadas';
         $this->friend_offer='Ofertas enviadas para amigos selecionados';
         $this->loan_offers="Todas as ofertas de empréstimo";
         $this->loan_posted="Empréstimo postado com sucesso";
         $this->loan_val="Oferta de empréstimo calculada com sucesso";
         $this->invite_friends='convide amigos';
         $this->recieve_loan="Ofertas de empréstimo recebidas";
         $this->request_data='Pedido de outras pessoas aceito por mim';
         $this->loan_amount='Valores do empréstimo obtidos';
         $this->seven_days="7 dias de pagamento de AOA";
         $this->fifteen_days="15 dias de pagamento de AOA";
         $this->tone_days="Pagamento de AOA por 21 dias";
         $this->thirtyone="30 Dias de Pagamento de AOA";
         $this->installment="Parcelas buscadas";
         $this->terms_data="Dados de termos";
         $this->interest_data="Dados de interesse";
         $this->loan_history="Histórico de empréstimo obtido";
         $this->meta_data="Metadados do dispositivo inserido";
         $this->rate_data="Taxas de juros obtidas.";
         $this->durations="Durações buscadas.";
         $this->discounts="Descontos obtidos.";
         $this->accept_loan="Você não pode aceitar isto porque o limite de pontuação de crédito é:";
         $this->loan_accepted="seu empréstimo foi aceito";
         $this->sendacc_offer="Você não pode enviar / aceitar esta oferta porque você não se inscreveu";
         $this->accept_lonaoff="Oferta de empréstimo aceita";
         $this->loan_details="Detalhe do empréstimo";
         $this->no_loan_detail="Detalhe do empréstimo sem dados encontrados";
         $this->installment_fetched="Notificações obtidas.";
         $this->notification_detail="Todos os status de notificação não lidos foram alterados.";
         $this->notification_count="Contagem de todas as notificações não lidas.";
         $this->status_changed="Status de notificação alterado.";
         $this->current_loan="Status do empréstimo atual obtido com sucesso";
         $this->status_history="histórico status";
         $this->score_limit="limite de pontuação de crédito do usuário";
         $this->type_loan="Ofertas de empréstimo recebidas por tipo";
         $this->data_list="DataList Encontrado";
         $this->no_data_list="DataList não encontrado";

         $this->requesting_to_you_loan  = "solicitando a você um empréstimo";
         $this->invite_for_loan  = "está convidando você para baixar este aplicativo";
         $this->shared_loan_Offer_with_you = " compartilhou uma oferta de empréstimo com você";
         $this->loan_completed_paid_amount = "Valor pago do empréstimo concluído";
         $this->you_paying_much_as_paid = "você está pagando tanto quanto pagou";
         $this->loan_paid_amount = "Valor do empréstimo pago";
         $this->amount_pending_to_complete = "Quantidade pendente para concluir";
      }
    }


  public function requestloan(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id =  User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 403]);
    }
    $validator = Validator::make($request->all(),
    [
      'amount' => 'required',
      'type' => 'required',
      'interest' => 'required',
      'to' => 'required',
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

    $user = User::where('id',$user_id)->first();
    $t = $user->cred_score;
    $credit_score = DB::table('credit_score_amount')->where(function ($query) use ($t) {
      $query->where('from', '<=', $t);
      $query->where('to', '>=', $t);
    })->first();

    if( $request->amount > $credit_score->amount ){
       $response = [
          "status" => false,
          "message"=>$this->score_amount.$credit_score->amount,    
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    /* ====================== check for only one loan accept or offer =====================  */

    $check = Loans::where('user_id',$user_id)->where('status',1)->where('loan_status',"0")->where('loanCompletedStatus',0)->get();
    $check1 = Loans::where('user_id',$user_id)->where('status',1)->where('loan_status',"1")->where('loanCompletedStatus',0)->get();

    $check2 = Loans::where('taken_by',$user_id)->where('status',1)->where('loan_status',"0")->where('loanCompletedStatus',0)->get();
    $check3 = Loans::where('taken_by',$user_id)->where('status',1)->where('loan_status',"1")->where('loanCompletedStatus',0)->get();

    if($request->to=="all"){
      $phones = DB::table("users")->where('user_role',1)->select("phone")->get();
      $no =[];
      
      foreach ($phones as $key => $value) {
        $no[] = $value->phone;
      }

      $to = implode(',', $no);
      $request_to ="M";
    }else{
      $to = $request->to;
      $request_to ="C";
    }
    // print_r(count($check));
    if(count($check) >= 1){
      // echo "nither give nor request in give case";
        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=> $check,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // print_r(count($check1));
    if(count($check1) >= 1){
      // echo "nither give nor request in request case";
        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=>$check1,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    if(count($check2) >= 1){
      // echo "nither give nor request in request case";
        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=>$check2,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    if(count($check3) >= 1){
      // echo "nither give nor request in request case";
        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=>$check3,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    // die;
    // dd($to);
    /* ==================================================================================== */
    $to_no = explode(',', $to);
     
    $user_no = DB::table("users")->where('id',$user_id)->select("phone")->first();


    foreach ($to_no as $key => $value) {

      // if(env('ENVIRONMENT')=="dev"){
      //     $country_code = "+91";
      //     $phone = substr ($value, -10);
      // }
      // else{
      //     $country_code = "+244";
      //     $phone = substr ($value, -9);
      // }

      // $value = $country_code.$phone;
      // $given_to_no[] = $country_code.$phone;
      $given_to_no[] = $value;
      
      if($value == $user_no->phone) { 
        unset($to_no[$key]); 
      } 
       
    }
    
    // print_r($to_no);
    // echo " string ";
    // print_r($to_no);
    // die;
    $phones_push_notification=[];
    foreach ($to_no as $key => $value) {

      $user = User::where('phone',$value)->first();

      if($user==null){
        $phones_invite[] = $value;
        
      }
      else{
        $phones_push_notification[] = $value;
        
      }      
    }

    // print_r($given_to_no); die;
   
    if(empty($to_no)){
      $response = [
        "status" => false,
        "message"=>$this->request_send,
        "data"=>[],
      ];

    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); 
    }else{

    $to_phone_num = $to_no;
    // foreach ($to_no as $key => $value) {
    //   # code...

    //      if(strpos($value, '+91') == false){
    //           $country_code = "+91";
    //           $phone = substr ($value, -10);
    //       }elseif(strpos($value , '+244') == false){
    //          $country_code = "+244";
    //          $phone = substr ($value, -9);
    //       }
    //        $to_phone_num[] = $country_code.$phone;
    // }

  // print_r($to_phone_num); die;

      $request_loan=new Loans();
      $request_loan->taken_by=$user_id;
      $request_loan->amount=$request->amount;
      $request_loan->duration_type=$request->type;
      $request_loan->to_be_paid=$request->to_be_paid;
      $request_loan->installment=$request->installment;
      $request_loan->interest=$request->interest;
      $request_loan->admin_interest=$request->interest/2;
      $request_loan->user_interest=$request->interest/2;
      $request_loan->loan_status="1";
      $request_loan->request_to=$request_to;
      $request_loan->given_to=implode(',', $to_phone_num);
      $request_loan->created_at=date('Y-m-d H:i:s');
      $request_loan->save();

      if(!empty($phones_invite)){
        // dd($phones_invite);
        $userIds=User::where('id',$user_id)->select('id','first_name','last_name')->first();
        $body_msg = $userIds->first_name." ".$userIds->last_name.' '.$this->requesting_to_you_loan;
        $this->sendInviteMsg($phones_invite,$body_msg); //send messages, 

      }else if(!empty($to_phone_num)){     //$phones_push_notification  change to $to_no

        $userIds=User::where('id',$user_id)->select('id','first_name','last_name')->first();
        $body_msg = $userIds->first_name." ".$userIds->last_name.' '.$this->requesting_to_you_loan;
        // dd($body_msg);

        if($request_to == 'C'){

          // print_r($to_phone_num); die;
          $this->sendOffer($to_phone_num,$body_msg); //send push notification,  
          foreach ($to_phone_num as $key => $to_phone) {
            $user_no=User::where('phone',$to_phone)->select('id','first_name','last_name')->first();

            // print_r($user_no);
            // print_r($request_loan->id);
            $noti = DB::table('notifications')->insert(array('from'=>$user_id,'to'=>$user_no->id,'loan_id'=>$request_loan->id,'title'=>"Capital",'body'=>$body_msg));

          }
        }
        
     
      }

      $response = [
        "status" => true,
        "message"=>$this->success_msg,
        "data"=>$request_loan,
      ];

      return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);   
    }

  }

  public function giveLoanOffer(request $request)
  {
    $statusCode=200;
    $response=[];
    $request_to='';
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }
    $validator = Validator::make($request->all(),
    [
      'amount' => 'required',
      'type' => 'required',
      'to' => 'required',
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

    $user = User::where('id',$user_id)->first();

    // dd($user);
    if($user->cred_score == null){

      $response = [
          "status" => false,
          "message"=> "Can't send the loan since credit score unavailable",
          
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    $t = $user->cred_score;


    $credit_score = DB::table('credit_score_amount')->where(function ($query) use ($t) {
      $query->where('from', '<=', $t);
      $query->where('to', '>=', $t);
    })->first();

    if( $request->amount > $credit_score->amount ){
        $response = [
          "status" => false,
          "message"=>$this->score_amount.$credit_score->amount,
          
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
   
    if($request->to=="all"){
      $phones = DB::table("users")->where('user_role',1)->select("phone")->get();

      // dd($phones);
      $no =[];
      foreach ($phones as $key => $value) {
        $no[] = $value->phone;
    }
      $to = implode(',', $no);
      $request_to ="M";
    }else{
      $to = $request->to;
      $request_to ="C";
    }
    
    // dd($to);
    // print_r($to);

    /* ====================== check for only one loan accept or offer =====================  */

    $check = Loans::where('user_id',$user_id)->where('status',1)->where('loan_status',"0")->Where('loanCompletedStatus',0)->get();
    $check1 = Loans::where('user_id',$user_id)->where('status',1)->where('loan_status',"1")->Where('loanCompletedStatus',0)->get();

    $check2 = Loans::where('taken_by',$user_id)->where('status',1)->where('loan_status',"0")->Where('loanCompletedStatus',0)->get();
    $check3 = Loans::where('taken_by',$user_id)->where('status',1)->where('loan_status',"1")->Where('loanCompletedStatus',0)->get();

    // print_r($check); die;
    if(count($check) >= 1){
      // echo "nither give nor request in give case";
      
        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=> $check,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // print_r(count($check1));
    if(count($check1) >= 1){
      // echo "nither give nor request in request case";
        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=>$check1,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    if(count($check2) >= 1){
      // echo "nither give nor request in request case";
        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=>$check2,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    if(count($check3) >= 1){
      // echo "nither give nor request in request case";
        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=>$check3,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    // die;

    /* ==================================================================================== */

    $exist =  DB::table('loan_duration')->find($request->type);
     if(empty($exist)){
     $response = [

      "status" => 404,
      "message"=>'type not found',
      
    ];
    return response()->json($response, 404 , $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
     }


    $installment = 0;
    // if($request->type==1){
    //   $interest = 3.75;
    //   $to_be_paid = ($interest*$request->amount)/100 + $request->amount; //weekly
    //   $installment = sprintf("%.2f", $to_be_paid/4); 
    // }
    if($request->type==1){
      $interest = 5;
      $admin_interest = 2.5;
      $to_be_paid = ($interest*$request->amount)/100 + $request->amount; //7 days
    }
    if($request->type==2){
      $interest = 10;
      $admin_interest = 5;
      $to_be_paid = ($interest*$request->amount)/100 + $request->amount; //15 days
    }
    if($request->type==3){
      $interest = 15;
      $admin_interest = 7.5;
      $to_be_paid = ($interest*$request->amount)/100 + $request->amount; //21 days
    }
    if($request->type==4){
      $interest = 20;
      $admin_interest = 10;
      $to_be_paid = ($interest*$request->amount)/100 + $request->amount; //30 days
    }

        // print_r($admin_interest); die; 
    $total_interest = $interest + $admin_interest;

    $total_interest_amount = ($request->amount * $total_interest) / 100;
    $to_be_paid = $to_be_paid + ($admin_interest * $request->amount) / 100;

    $to = explode(',', $to);
    $user_no = DB::table("users")->where('id',$user_id)->select("phone")->first();

    // if (($key = array_search($user_no->phone, $to)) !== false) {
    //     unset($to[$key]);
    // }

    // print_r($to);

      
    foreach ($to as $key => $value) {

      // if(env('ENVIRONMENT')=="dev"){
      //     $country_code = "+91";
      //     $phone = substr ($value, -10);
      // }
      // else{
      //     $country_code = "+244";
      //     $phone = substr ($value, -9);
      // }

      // $value = $country_code.$phone;


      // $given_to_no[] = $country_code.$phone;
      $given_to_no[] = $value;

      if($value == $user_no->phone) { 
        unset($to[$key]); 
      } 
       
    }
      

    // print_r($to);
    
    foreach ($to as $res) {

      // print_r($res); die;
      $user = User::where('phone',$res)->first();
      // print_r($user->id);

      if($user==null){

        // dd($res);
        $phones_invite[] = $res;
      }
      else{
        $phones_push_notification[] = $res;
      }      
    }

    if(empty($to)){

      $response = [
        "status" => false,
        "message"=>$this->offer_send,
        "data"=>[],
      ];

    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); 
    }else{
    // dd($phones_push_notification);
      // print_r($to); die;
    $to_phone_num = [];
    foreach ($to as $key => $value) {
      # code...

         // if(strpos($value, '+91') == false){
         //      $country_code = "+91";
         //      $phone = substr ($value, -10);
         //  }elseif(strpos($value , '+244') == false){
         //     $country_code = "+244";
         //     $phone = substr ($value, -9);
         //  }
           // $to_phone_num[] = $country_code.$phone;
           $to_phone_num[] = $value;
    }

    // print_r($to_phone_num); die;
    $arr = array(
        'user_id' => $user_id,
        'amount' => $request->amount,
        'to_be_paid' => $to_be_paid,
        'interest' => sprintf("%.2f", $interest),
        'admin_interest' => sprintf("%.2f", $admin_interest),
        'user_interest' => sprintf("%.2f", $total_interest),
        'installment' => $installment,
        'duration_type' => $request->type,
        'given_to' =>  implode(',', $to_phone_num),
        'request_to' =>  $request_to
    );

    // DB::enableQueryLog();
     // print_r($arr); die;
    $loan_give = Loans::create($arr);
      
    // $log = DB::getQueryLog();

    // dd($log);
    
    if(!empty($phones_invite)){
      // dd($phones_invite);
      $userIds=User::where('id',$user_id)->select('id','first_name','last_name')->first();

      $body_msg = $userIds->first_name." ".$userIds->last_name.' '.$this->shared_loan_Offer_with_you;

      $this->sendInviteMsg($phones_invite,$body_msg); //send messages, 
    }
    if(!empty($to_phone_num)){    // $phones_push_notification change to $to_phone_num

      // $userIds=User::whereIn('phone',$phones_push_notification)->select('id','first_name','last_name')->first();
      $userIds=User::where('id',$user_id)->select('id','first_name','last_name')->first();

      // $body_msg = $userIds->first_name." ".$userIds->last_name.' shared a Loan Offer with you';

      $body_msg = $userIds->first_name." ".$userIds->last_name.' '.$this->shared_loan_Offer_with_you;
      
      // dd($body_msg);
      if($request_to == "C"){

        $this->sendOffer($to_phone_num,$body_msg); //send push notification,  
        foreach ($to_phone_num as $key => $to_phone) {
          $user_no=User::where('phone',$to_phone)->select('id','first_name','last_name')->first();
          // print_r($user_no->id);

          if($user_no){
            $noti = DB::table('notifications')->insert(array('from'=>$user_id,'to'=>$user_no->id,'loan_id'=>$loan_give->id,'title'=>"Capital",'body'=>$body_msg));
          }
        
        }
      }
      
  
    }

      $response = [
        "status" => true,
        "message"=>$this->friend_offer,
        "numbers"=>$to_phone_num,
      ];
      return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

  }

  public function getGivenLoanOffers(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (!$user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }
    // return $user_id;

    if($request->status == "0"){
      $givenLoan = DB::table('loans')->where(function ($query) use ($user_id) {
            $query->where('user_id', null)->where('taken_by', $user_id)->where('status', '!=' , 2);
        })->orWhere(function ($query) use ($user_id) {
            $query->where('user_id', $user_id)->where('taken_by', null)->where('status', '!=' , 2);
        })->orderBy('created_at','DESC')->get();
    }

    else if($request->status == "1"){
        $givenLoan = DB::table('loans')->where(function ($query) use ($user_id) {
            $query->where('taken_by', $user_id)->where('loan_status', 1);
        })->orWhere(function ($query) use ($user_id) {
            $query->where('user_id', $user_id)->where('loan_status', 0);
        })->orderBy('created_at','DESC')->get();
    }
    // return $givenLoan;
    // print_r($givenLoan);

    foreach ($givenLoan as $key => $value) {   
      $created_at = date('Y-m-d h:i:s', strtotime($value->created_at));
      $value->created_date = $created_at;
      
      if($value->loan_status=="0"){
      $value->condition = "Given";
      }else{
        $value->condition = "Request";
      } 

      // print_r($value->duration_type);
      $loan_duration = DB::table('loan_duration')->where('id',$value->duration_type)->first();
      // return $loan_duration;
      $value->duration_type = $loan_duration->package_name;

      $value->admin_interest = sprintf("%.2f", $value->admin_interest);
      $value->user_interest = sprintf("%.2f", $value->user_interest);
    }

    $response = [
      "status" => true,
      "message"=>$this->loan_offers,
      "numbers"=>$givenLoan,
    ];
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

  public function postLoan(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 403]);
    }
    $validator = Validator::make($request->all(),
    [
      'amount' => 'required',
      'interest_rate' => 'required',
      'type' => 'required',
      'discount' => 'nullable'
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
    $to_be_paid = 0; //to be calculated
    $installment = 0;
    $interest =0;
    $post_loan=new PostLoan();
    $post_loan->user_id=$user_id;
    $post_loan->amount=$request->amount;
    $post_loan->type=$request->type; //loan_duration join
    $post_loan->to_be_paid=$to_be_paid; //tcalculate it based on interst and duration
    $post_loan->installment=$installment; //calculate it based on interst and duration
    $post_loan->interest_rate=$request->interest_rate;
    $post_loan->interest=$interest; //calculate it based on interst and duration
    $post_loan->discount=$request->discount; //discounts join
    $post_loan->created_at=date('Y-m-d H:i:s');
    $post_loan->save();
    // dd($post_loan);
    $response = [
      "status" => true,
      "message"=>$this->loan_posted,
      "data"=>$post_loan,
    ];
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

  public function giveLoanOfferInformation(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }
    $validator = Validator::make($request->all(),
    [
      'amount' => 'required',
      'type' => 'required',
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
    $installment = "";
     $interest = "";
    // if($request->type==1){
    //   $interest = 3.75;
    //   $admin_interest = 1.87;
    //   $to_be_paid = ($interest*$request->amount)/100 + $request->amount; //weekly
    //   $installment = sprintf("%.2f", $to_be_paid/4); 
    // }

     $exist =  DB::table('loan_duration')->find($request->type);
     if(empty($exist)){
     $response = [

      "status" => 404,
      "message"=>'type not found',
      
    ];
    return response()->json($response, 404 , $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
     }
     $admin_interest = '';
    if($request->type==1){
      $interest = 5;
      $admin_interest = 2.5;
      $to_be_paid = ($interest*$request->amount)/100 + $request->amount; //7 days
    }
    if($request->type==2){
      $interest = 10;
      $admin_interest = 5;
      $to_be_paid = ($interest*$request->amount)/100 + $request->amount; //15 days
    }
    if($request->type==3){
      $interest = 15;
      $admin_interest = 7.5;
      $to_be_paid = ($interest*$request->amount)/100 + $request->amount; //21 days
    }
    if($request->type==4){
      $interest = 20;
      $admin_interest = 10;
      $to_be_paid = ($interest*$request->amount)/100 + $request->amount; //30 days
    }

    // print_r($admin_interest); die; 
    $total_interest = $interest + $admin_interest;

    $total_interest_amount = ($request->amount * $total_interest) / 100;

    $to_be_paid = $to_be_paid+ ($admin_interest * $request->amount) / 100;

    $result = [];
    $result['amount'] = $request->amount;
    $result['type'] = $request->type;
    $result['installment'] = $installment;
    $result['interest'] = sprintf("%.2f", $interest);
    $result['admin_interest'] = sprintf("%.2f", $admin_interest);
    $result['total_interest'] = sprintf("%.2f", $total_interest);
    $result['total_interest_amount'] = $total_interest_amount;


    $response = [
      "status" => true,
      "message"=>$this->loan_val,
      "data"=>$result,
    ];
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

   public function invite_friends(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }
    $validator = Validator::make($request->all(),
    [
      'contact' => 'required',
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

    $to = explode(',', $request->contact);
    $userIds=User::where('id',$user_id)->select('id','first_name','last_name')->first();
    $body_msg = $userIds->first_name." ".$userIds->last_name.' '.$this->invite_for_loan;
    $this->sendInviteMsg($to,$body_msg); 
    
    $response = [
      "status" => true,
      "message"=>$this->invite_friends,
      "numbers"=>$to,
    ];
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }


  public function getReceivedLoanOffers(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }

    $validator = Validator::make($request->all(),
    [
      'status' => 'required',
    ]);
    if($validator->fails()) 
    {
        $statusCode=400;
        $response = [
        "status" => false,
        "message" => $validator->getMessageBag()->first()];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }

    $status = $request->status;

    $phone = User::where('id',$user_id)->pluck('phone')->toArray();

    // print($phone[0]);

    // if(env('ENVIRONMENT')=="dev"){
         
    //     $number = explode('+91', $phone[0]);
          
    // }
    // else{
    //     $number = explode('+244', $phone[0]);
    // }

    $number = $phone[0];

    // print_r($number); die;
    // print($number);
    if($status == 0){
      $result = DB::table('loans')->where(function ($query) use ($number) {
        $query->where('given_to', 'like',"%".$number."%")->where('status', 0);
      });


    }else{
      $result = DB::table('loans')->Where(function ($query) use ($number) {
        $query->where('temp_phone', $number)->where('status',1);
      });
    }
    $result = $result->orderBy('id','DESC')->get();

    // dd($result);

    foreach ($result as $key => $value) {
          $loan_duration = DB::table('loan_duration')->where('id',$value->duration_type)->first();
        $value->duration_type = $loan_duration->package_name;
    }
    $response = [
      "status" => true,
      "message"=>$this->recieve_loan,
      "numbers"=>$result,
    ];
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }



  public function loanReqListAccepByUser(Request $request){       // request from other persones accepted by me

    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }
    
    $phone = User::where('id',$user_id)->pluck('phone')->toArray();

    $result = DB::table('loans')->where(['status'=>"1",'taken_by'=>$phone[0]])->get(); // status 1 = accepted request

    if(count($result) > 0 ){
      $response = [
        "status" => true,
        "message"=>$this->request_data,
        "request"=>$result,
      ];
    }else{
      $response = [
        "status" => false,
        "message"=>$this->request_data,
        "request"=>$result,
      ];

    }
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

  }

  private function sendInviteMsg($phone,$body_msg){
    $account_sid = getenv("TWILIO_SID");
    $auth_token = getenv("TWILIO_AUTH_TOKEN");
    $twilio_number = getenv("TWILIO_NUMBER");
    $client = new Client($account_sid, $auth_token);

    foreach ($phone as $key => $value) {
      try {
      $msg =  $client->messages->create($value, ['from' => $twilio_number, 'body' => $body_msg." https://play.google.com/store/apps/details?id=com.richest.capital  "] );
       
      } catch(Twilio\Exceptions\RestException $e) {
          return $e->getMessage();
      };
    }

  }

  private function sendInvite($phone){
    $account_sid = getenv("TWILIO_SID");
    $auth_token = getenv("TWILIO_AUTH_TOKEN");
    $twilio_number = getenv("TWILIO_NUMBER");
    $client = new Client($account_sid, $auth_token);
    foreach ($phone as $key => $value) {
      try {
        $client->messages->create($value, ['from' => $twilio_number, 'body' => " https://play.google.com/store/apps/details?id=com.richest.capital  "] );
      } catch(Twilio\Exceptions\RestException $e) {
          return $e->getMessage();
      };
    }

  }

  private function sendOffer($phone,$body_msg){
    $userIds=User::whereIn('phone',$phone)->select('id','first_name','last_name')->get();
    

    $app_login=DB::table('app_login')->whereIn('user_id',$userIds->toArray())->orderBy('created_at','DESC')->get();
    // print_r($phone);
    // dd($app_login->toArray());

    if(!empty($app_login))
    {
      foreach($app_login as $a)
      {
          if ($a->device_type == 1) //android 
          {

             // print_r($a->device_token); 
    /*=========================== ANDROID notification code ================================*/

            $SERVER_KEY='AAAAwj5K4zE:APA91bFUVmVfr8VwHbPP7VVxJt8qqYnsGIQOL1iMnerGnwnxix8GQkBSU0eQ5KX3xdb7wXXemJAPR1aDsMeRirNva8UANwC7pb-zC7cr9h_CwdvgID7Hdnw6VIQjxz2uYFmy1JFQeOH8';
            // $SERVER_KEY='AAAAbNXGqKw:APA91bHUcXo-3wb63KbWkJJi0ndC0AUgZhdIK5PhjACFQ66Zk80uqARduFHmgDdMgI-_FfM50fL318Dmc-Zk6wyg_BM6K8lTsPl200eJl8_Gd_ODFoU5QS6TAlnB3JFAvoC9he-d5cRD';

            
            $registrationIds = $a->device_token;
            // echo ",";
            // print_r($registrationIds);
            #prep the bundle

              $msg = array
                        (
                        'body'  => $body_msg,
                        'title' => 'Capital',
                        );

            $fields = array
                   (
                    'to'        => $registrationIds,
                    'data'    => $msg,
                   );

            $headers = array
                   (
                    'Authorization: key=' .$SERVER_KEY,
                    'Content-Type: application/json'
                   );

            #Send Reponse To FireBase Server
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            // print_r($result);
            curl_close( $ch );

    /*===================================================================================*/
          } 
          elseif ($a->device_type == 2) //iphone
          {
              $url = "https://fcm.googleapis.com/fcm/send";
              $registrationIds = [ $a->device_token ];
              $serverKey ='AAAAwj5K4zE:APA91bFUVmVfr8VwHbPP7VVxJt8qqYnsGIQOL1iMnerGnwnxix8GQkBSU0eQ5KX3xdb7wXXemJAPR1aDsMeRirNva8UANwC7pb-zC7cr9h_CwdvgID7Hdnw6VIQjxz2uYFmy1JFQeOH8';
              $title = 'Capital';
              $body = $body_msg;
              $notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' =>'0','msg_data'=>'');
              $arrayToSend = array('registration_ids' => $registrationIds, 'notification'=>$notification,'priority'=>'high');
              $json = json_encode($arrayToSend);
              $headers = array();
              $headers[] = 'Content-Type: application/json';
              $headers[] = 'Authorization: key='. $serverKey;
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
              curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
              curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $result = curl_exec($ch);
              // $r=explode(',', $result);
              // dd($r);
              if ($result === FALSE) 
              {
                  die('FCM Send Error: ' . curl_error($ch));
              }
              curl_close( $ch );
          }
      }
    }
  }

  public function loanAmount(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id =  User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 403]);
    }
    $device_type = User::fetchDevicetype($session_id);
    // dd($device_type); // 1=android/2=ios
    if($device_type==1){
      $os = "android";
    }
    elseif($device_type==2){
      $os = "ios";  
    }
    $app_login = Applogin::where('session_id',$session_id)->first();
    // dd($app_login->device_model);
    $device_model = $app_login->device_model;
    $phone = DB::table('phones')->where('model',$device_model)->first();
    // dd($phone);
    if($phone==null){
      $array = array(
          0 => array(
            'id'=>1,
            'currency'=>'AOA',
            'amount'=>5000
          ),
          1 => array(
            'id'=>2,
            'currency'=>'AOA',
            'amount'=>10000
          ),
          2 => array(
            'id'=>3,
            'currency'=>'AOA',
            'amount'=>15000
          ),
          3 => array(
            'id'=>4,
            'currency'=>'AOA',
            'amount'=>20000
          ),
          4 => array(
            'id'=>5,
            'currency'=>'AOA',
            'amount'=>25000
          ),
          5 => array(
            'id'=>6,
            'currency'=>'AOA',
            'amount'=>30000
          ),
          
      );
      
      $response = [
        "status" => true,
        "message"=>$this->loan_amount,
        "result" => $array
      ];
      return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    $phone_price = $phone->score;
    $loan_amount_query = LoanAmount::select('id','range_from','range_to','amount')->where('range_from', '<=',  $phone_price)->where('range_to', '>',  $phone_price);
    $loan_amount=$loan_amount_query->orderBy('amount','ASC')->get();
    if(!$loan_amount->isEmpty())
    {
      foreach($loan_amount as $amount)
      {
         $array[]=array(
          'id'=>$amount->id,
          'currency'=>'AOA',
          'amount'=>$amount->amount
        );
      }
      $response = [
        "status" => true,
        "message"=>$this->loan_amount,
        "result" => $array
      ];
    }
    else
    {
      $array = array(
          0 => array(
            'id'=>1,
            'currency'=>'AOA',
            'amount'=>5000
          ),
          1 => array(
            'id'=>2,
            'currency'=>'AOA',
            'amount'=>10000
          ),
          2 => array(
            'id'=>3,
            'currency'=>'AOA',
            'amount'=>15000
          ),
          3 => array(
            'id'=>4,
            'currency'=>'AOA',
            'amount'=>20000
          ),
          4 => array(
            'id'=>5,
            'currency'=>'AOA',
            'amount'=>25000
          ),
          5 => array(
            'id'=>6,
            'currency'=>'AOA',
            'amount'=>30000
          ),
      );
      
      $response = [
        "status" => true,
        "message"=>$this->loan_amount,
        "result" => $array
      ];
    }
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

  public function durationTime(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id =  User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 403]);
    }
    $device_type = User::fetchDevicetype($session_id);
    // dd($device_type); // 1=android/2=ios
    if($device_type==1){
      $os = "android";
    }
    elseif($device_type==2){
      $os = "ios";
    }
    
    $predefined_installments = DB::table('predefined_installments')->select('id','amount','duration_type','number')->where('amount',$request->amount)->first();
    if($predefined_installments==null){
      $add_in_predefined_installments_table = DB::table('predefined_installments')->insert(array('amount'=>$request->amount,'duration_type'=>1,'number'=>10));

      // $response = [
      //   "status" => false,
      //   "message"=>"No Data Found.",
      //   "result" => []
      // ];
      // return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
      $predefined_installments = DB::table('predefined_installments')->select('id','amount','duration_type','number')->where('amount',$request->amount)->first();
    }
    $installment_excluding_interest = $predefined_installments->amount/$predefined_installments->number;
    // dd($installment_excluding_interest);
    //for 7 days
    $installment_including_interest_7_days = ($installment_excluding_interest*5)/100 + $installment_excluding_interest;
    $predefined_installments->days_7_installment = $installment_including_interest_7_days;

    //for 15 days
    $installment_including_interest_15_days = ($installment_excluding_interest*10)/100 + $installment_excluding_interest;
    $predefined_installments->days_15_installment = $installment_including_interest_15_days;

    //for 21 days
    $installment_including_interest_21_days = ($installment_excluding_interest*15)/100 + $installment_excluding_interest;
    $predefined_installments->days_21_installment = $installment_including_interest_21_days;

    //for 30 days
    $installment_including_interest_30_days = ($installment_excluding_interest*20)/100 + $installment_excluding_interest;
    $predefined_installments->days_30_installment = $installment_including_interest_30_days;
    // dd($predefined_installments);
    $arr = [];
    $arr['id']=$predefined_installments->id;
    $arr['installments']=$predefined_installments->number;
    $arr['principal_amount']=$predefined_installments->amount;
    $ins = [];
    $object=(object)[];
    $object->statement = $this->seven_days.$predefined_installments->days_7_installment;
    $object->type = "7 Days";
    $object->installment = sprintf("%.2f", $predefined_installments->days_7_installment);
    $object->interest = sprintf("%.2f", 5);
    $object->admin_interest = sprintf("%.2f", 2.5);
    $object->interest_amount = sprintf("%.2f", ($installment_excluding_interest*5)/100);
    $object->total_to_be_paid = sprintf("%.2f", $installment_including_interest_7_days*10);
    $object->currency = "AOA";

    $total_interest = 5 + 2.5;
    $total_interest_amount = ($request->amount * $total_interest) / 100;
 
    $object->total_interest =  sprintf("%.2f", $total_interest);
    $object->total_interest_amount =  sprintf("%.2f", $total_interest_amount);
    // $object->duration_type = $predefined_installments->duration_type;
    $object->duration_type = 1;
    array_push($ins, $object);
    

    $object=(object)[];
    $object->statement = $this->fifteen_days.$predefined_installments->days_15_installment;
    $object->type = "15 Days";
    $object->installment = sprintf("%.2f", $predefined_installments->days_15_installment);
    $object->interest = sprintf("%.2f", 10);
    $object->admin_interest = sprintf("%.2f", 5);
    $object->interest_amount = sprintf("%.2f", ($installment_excluding_interest*10)/100);
    $object->total_to_be_paid = sprintf("%.2f", $installment_including_interest_15_days*10);
    $object->currency = "AOA";

    $total_interest = 10 + 5;
    $total_interest_amount = ($request->amount * $total_interest) / 100;
 
    $object->total_interest =  sprintf("%.2f", $total_interest);
    $object->total_interest_amount =  sprintf("%.2f", $total_interest_amount);

    // $object->duration_type = $predefined_installments->duration_type;
    $object->duration_type = 2;
    array_push($ins, $object);

    $object=(object)[];
    $object->statement = $this->tone_days.$predefined_installments->days_21_installment;
    $object->type = "21 days";
    $object->installment = sprintf("%.2f", $predefined_installments->days_21_installment);
    $object->interest = sprintf("%.2f", 15);
    $object->admin_interest = sprintf("%.2f", 7.5);
    $object->interest_amount = sprintf("%.2f", ($installment_excluding_interest*15)/100);
    $object->total_to_be_paid = sprintf("%.2f", $installment_including_interest_21_days*10);
    $object->currency = "AOA";

    $total_interest = 15 + 7.5;
    $total_interest_amount = ($request->amount * $total_interest) / 100;
 
    $object->total_interest =  sprintf("%.2f", $total_interest);
    $object->total_interest_amount =  sprintf("%.2f", $total_interest_amount);

    // $object->duration_type = $predefined_installments->duration_type;
    $object->duration_type = 3;
    array_push($ins, $object);

    $object=(object)[];
    $object->statement = $this->thirtyone.$predefined_installments->days_30_installment;
    $object->type = "30 Days";
    $object->installment = sprintf("%.2f", $predefined_installments->days_30_installment);
    $object->interest = sprintf("%.2f", 20);
    $object->admin_interest = sprintf("%.2f", 10);
    $object->interest_amount = sprintf("%.2f", ($installment_excluding_interest*20)/100);
    $object->total_to_be_paid = sprintf("%.2f", $installment_including_interest_30_days*10);
    $object->currency = "AOA";

    $total_interest = 20 + 10;
    $total_interest_amount = ($request->amount * $total_interest) / 100;
 
    $object->total_interest =  sprintf("%.2f", $total_interest);
    $object->total_interest_amount =  sprintf("%.2f", $total_interest_amount);

    // $object->duration_type = $predefined_installments->duration_type;
    $object->duration_type = 4;
    array_push($ins, $object);

    $arr['data'] = $ins;

    if(!empty($arr))
    {
        $response = [
          "status" => true,
          "message"=>$this->installment,
          "result" => $arr
        ];
    }
   else
   {
      $response = [
        "status" => false,
        "message"=>$this->no_data,
        "result" => []
      ];
   }        

    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

  public function loan_terms(request $request)
  {
     $statusCode=200;
     $response=[];
     $loan_package=LoanTerms::orderBy('id','DESC')->get();
     if(!empty($loan_package))
     {
         foreach($loan_package as $package)
          {
             $array[]=array(
              'id'=>$package->id,
              'terms_name'=>$package->name
            );
          }
          $response = [
          "status" => "true",
          "message"=>$this->terms_data,
          "result" => $array
        ];
     }
     else
     {
        $response = [
          "status" => "false",
          "message"=>$this->no_data,
          "result" => []
        ];
     }

     return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

  }

  public function loan_reasons(request $request)
  {
     $statusCode=200;
     $response=[];
     if(env('ENVIRONMENT')=="dev")
     {
      
     $loan_package=LoanReasons::where('id','<',9)->orderBy('id','DESC')->limit(8)->get();
    }else
    {
      
      $loan_package=LoanReasons::orderBy('id','DESC')->limit(8)->get(); 
    }
     if(!empty($loan_package))
     {
         foreach($loan_package as $package)
          {
             $array[]=array(
              'id'=>$package->id,
              'name'=>$package->name
            );
          }

          $response = [
          "status" => "true",
          "message"=>$this->reason_data,
          "result" => $array
        ];
     }
     else
     {
        $response = [
          "status" => "false",
          "message"=>$this->no_data,
          "result" => []
        ];
     }

     return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

  }

  public function amount_data(request $request)
  {
      $response=[];
      $statusCode=200;
      $user_id =  User::validateSessionId($request->session_id);
      if(! $user_id) 
      {
            return response ()->json (['status' => 'false','message' => 'Session Expired'], 403);
      }else
      {
           $amount=$request->amount;
           $terms=$request->terms;
           $duration=$request->duration;
           $duration_time=LoanDuration::where('id',$duration)->first();
           if($duration_time->package_name=='Weekly Payment')
           {
               $rate=(3.75*100)/10;
               $total_interst=$amount+($rate*$terms);
               
           }
           elseif($duration_time->package_name=='7 days payment')
           {
               $rate=(5*100)/10;
               $total_interst=$amount+($rate*$terms);
           }
           elseif($duration_time->package_name=='21 days payment')
           {
               $rate=(10*100)/10;
               $total_interst=$amount+($rate*$terms);
           }
           elseif($duration_time->package_name=='30 days payment')
           {
               $rate=(15*100)/10;
               $total_interst=$amount+($rate*$terms);
           }
           elseif($duration_time->package_name=='60 days payment')
           {
               $rate=(20*100)/10;
               $total_interst=$amount+($rate*$terms);
           }

          $interst=$total_interst-$amount;
          $response = [
          "status" => "true",
          "message"=>$this->interest_data,
          'currency'=>'AOA',
          "Total Amount" => (string)$total_interst,
          'Interest price'=>(string)$interst
          ];

          return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
      }
  }

  public function requestLoanHistory(request $request)
  {
      $response=[];
      $statusCode=200;
      $user_id =  User::validateSessionId($request->session_id);
      if(! $user_id) 
      {
        return response ()->json (['status' => 'false','message' => 'Session Expired'], 403);
      }
      else
      {
        $loans_data=RequestLoan::where('user_id',$user_id)->orderBy('created_at','DESC')->get();
        if($loans_data->isEmpty()){
          $array = [];
        }
        foreach($loans_data as $res)
        {
            $history = DB::table('emi_history')->where('user_id',$user_id)->get();
            if($history->isEmpty()){
              $history = [];
            }
            $array[]=array(
             'id'=>$res->id,
             'amount'=>$res->amount,
             'to_be_paid'=>$res->to_be_paid,
             'type'=>$res->type,
             'installment'=>$res->installment,
             'interest_rate'=>$res->interest_rate,
             'interest_rate'=>$res->interest_rate,
             'status'=>$res->status,
             'date'=>date('d/m/Y',strtotime($res->created_at)),
             'emi_history'=>$history,
            );
        }

          $response = [
            "status" => true,
            "message"=>$this->loan_history,
            "result"=>$array,
          ];

          return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
      }
  }

  public function fetchDeviceInfo(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id =  User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 403]);
    }
    $validator = Validator::make($request->all(),
    [
      'device_model' => 'required',
      'contact_count' => 'required',
    ]);
    if($validator->fails()) 
    {
        $statusCode=400;
        $response = [
        "status" => false,
        "message" => $validator->getMessageBag()->first()];
        return response()->json($response, $status_code, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    $device_type = User::fetchDevicetype($session_id);
    // dd($device_type); // 1=android/2=ios
    if($device_type==1){
      $os = "android";
    }
    elseif($device_type==2){
      $os = "ios";
    } 
    $contact_count='';
    if ($request->contact_count == 0) {
          $contact_count = 0; 
    }else{
         $contact_count = $request->contact_count;
    }


    $app_login = Applogin::firstOrNew(array('session_id' => $session_id));
    $app_login->device_model = $request->device_model;
    $app_login->contact_count = $contact_count;
    $app_login->save();

    $response = [
      "status" => true,
      "message"=>$this->meta_data,
      "result"=>$app_login,
    ];

    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
      
  }

  public function interestRates(Request $request)
  {    
      $interest_rates = DB::table('interest_rates')->get(['id','rate']);
      $response = [
        "status" => "true",
        "message"=>$this->rate_data,
        "result" => $interest_rates
      ];           
      return response()->json($response, 200, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

  public function durations(Request $request)
  {    
      // if(env('ENVIRONMENT')=='dev')
      // {
      //    $durations = DB::table('loan_duration')->where('id','<',6)->limit(5)->get(['id','number','calendar_value']);
      // }
      // else
      // {
      //    $durations = DB::table('loan_duration')->where('id','>=',6)->limit(5)->get(['id','number','calendar_value']);
      // }

       $durations = DB::table('loan_duration')->get(['id','number','calendar_value']);
      
      $response = [
        "status" => "true",
        "message"=>$this->durations,
        "result" => $durations
      ];           
      return response()->json($response, 200, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

  public function discounts(Request $request)
  {    
      $discounts = DB::table('discounts')->where('status',1)->get(['id','name']);
      $response = [
        "status" => "true",
        "message"=>$this->discounts,
        "result" => $discounts
      ];           
      return response()->json($response, 200, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

  public function acceptLoanOffer(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }

    $loan_id = $request->id;


    /* ====================== check for only one loan accept or offer =====================  */

    $check4 = loans::where('id',$loan_id)->select('user_id','taken_by','status','amount')->first();
    
    // dd($check4);

    $user = User::where('id',$user_id)->first();

    $t = $user->cred_score;
    $credit_score = DB::table('credit_score_amount')->where(function ($query) use ($t) {
      $query->where('from', '<=', $t);
      $query->where('to', '>=', $t);
    })->first();

    if( $check4->amount > $credit_score->amount ){
       $response = [
          "status" => false,
          "message"=>$this->accept_loan.$credit_score->amount,
          
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    $checkloan_Userid="";
    if($check4->taken_by == null){
      $checkloan_Userid= $check4->user_id;
    }else{
      $checkloan_Userid= $check4->taken_by;
    } 
    
    // $check_user = Loans::where('user_id', $checkloan_Userid)->where('status',1)->where('loanCompletedStatus',0)->get();
    

    // if(count($check_user) >= 1){
    //   // echo "nither give nor request in give case";

    //     $response = [
    //       "status" => false,
    //       "message"=>$this->accept_msg,
    //       "numbers"=> $check_user,
    //     ];
    //     return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    // } 

    $check_user = Loans::where('user_id',$user_id)->where('status',1)->where('loan_status',"0")->where('loanCompletedStatus',0)->get();

    $check = Loans::where('user_id',$user_id)->where('status',1)->where('loan_status',"0")->where('loanCompletedStatus',0)->get();
    $check1 = Loans::where('user_id',$user_id)->where('status',1)->where('loan_status',"1")->where('loanCompletedStatus',0)->get();

    $check2 = Loans::where('taken_by',$user_id)->where('status',1)->where('loan_status',"0")->where('loanCompletedStatus',0)->get();
    $check3 = Loans::where('taken_by',$user_id)->where('status',1)->where('loan_status',"1")->where('loanCompletedStatus',0)->get();

    // print_r($check);
    if(count($check) >= 1){
      // echo "nither give nor request in give case";

        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=> $check,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // print_r(count($check1));
    if(count($check1) >= 1){
      // echo "nither give nor request in request case";
        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=>$check1,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    if(count($check2) >= 1){
      // echo "nither give nor request in request case";
        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=>$check2,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    if(count($check3) >= 1){
      // echo "nither give nor request in request case";
        $response = [
          "status" => false,
          "message"=>$this->accept_msg,
          "numbers"=>$check3,
        ];
        return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    // die;

    /* ==================================================================================== */
    


    $loan_id = $request->id;
    $card_number = $request->card_number;
    $expiry = $request->expiry;
    $cvv = $request->cvv;
    $phone = User::where('id',$user_id)->pluck('phone')->toArray();
    $from_phone = User::where('id', $checkloan_Userid)->pluck('phone')->toArray();
    

    UserAccount::firstOrCreate(array('user_id'=>$user_id,'card_number'=>$card_number,'expiray'=>$expiry,'cvv'=>$cvv));
    $phones_push_notification[] = $from_phone[0];
    // dd($phones_push_notification);
    $user = User::where('id',$user_id)->first();

    $body_msg = $user->first_name.' '.$this->loan_accepted;

    $this->sendOffer($phones_push_notification,$body_msg);
    $noti = DB::table('notifications')->insert(array('from'=>$user_id,'to'=> $checkloan_Userid,'loan_id'=>$loan_id,'title'=>"Capital",'body'=>$body_msg));
    // print_r($phone); 
    // $loanOffer = LoanOffers::firstOrNew(array('id' => $request->id));
    
    $user = User::where('phone',$phone[0])->first();

    if(empty($user->id)){
      $statusCode=400;
      $response = [
        "status" => false,
        "message"=>$this->sendacc_offer,
      ];
      return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    $checkloanUser = Loans::where('id',$loan_id)->first();
  
    if($checkloanUser->taken_by == null){
      $loan_Userid= "taken_by";
    }else{
      $loan_Userid= "user_id";
    } 


    $loanOffer = Loans::where('id',$loan_id)->update(array('status'=>1,'temp_phone'=>$phone[0], $loan_Userid => $user->id));  
    $loanOffer = Loans::where('id',$loan_id)->get();
    
    // $loanOffer->status = $status;
    // $loanOffer->taken_by = $phone[0];
    // $loanOffer->save();
    $response = [
      "status" => true,
      "message"=>$this->accept_lonaoff,
      "numbers"=>$loanOffer,
    ];
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

  public function loanCompletedStatus(Request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }

    $validator = Validator::make($request->all(),
    [
      'loan_id' => 'required',
    
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

    $data  = DB::table('emi_history')->where('user_id',$user_id)->where('loan_id',$request->loan_id)->first();
    $loan  = DB::table('loans')->where('id',$request->loan_id)->first();
      if($data){

        $emi_history = DB::table('emi_history')->where('user_id',$user_id)->where('loan_id',$request->loan_id)->get();

        // print_r($emi_history->sum('installment')); 
       $installmentSum =  $emi_history->sum('installment');


          if($loan->to_be_paid == $installmentSum){

            DB::table('loans')->where('id', $request->loan_id)->update(array('loanCompletedStatus' => 1));
               $pendingPaidAmount = $loan->to_be_paid - $installmentSum;
             $response = [
                "status" => false,
                'to_be_paid' => $loan->to_be_paid,
                'pendingAmout' => $pendingPaidAmount,
                "message"=> $this->loan_completed_paid_amount.' '.$pendingPaidAmount,
              ];
              return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
          }else{

              
            $emi_history = DB::table('emi_history')->where('user_id',$user_id)->where('loan_id',$request->loan_id)->get();
            $installmentSum =  $emi_history->sum('installment');
               $pendingPaidAmount = $loan->to_be_paid - $installmentSum;
             if(!empty($request->paid_amount)){


             if($request->paid_amount <= $pendingPaidAmount ){
                     DB::table('emi_history')->insert(array('user_id' => $user_id, 'loan_id' => $request->loan_id,'installment' => $request->paid_amount)); 
                  }else{
              $emi_history = DB::table('emi_history')->where('user_id',$user_id)->where('loan_id',$request->loan_id)->get();
                $loan  = DB::table('loans')->where('id',$request->loan_id)->first();
              // print_r($emi_history->sum('installment')); 
               $installmentSum =  $emi_history->sum('installment');
              $pendingPaidAmount = $loan->to_be_paid - $installmentSum;

                   $response = [
                   "status" => false,
                    'to_be_paid' => $loan->to_be_paid,
                    'pendingAmout' => $pendingPaidAmount,
                  "message"=> $this->you_paying_much_as_paid,
              ];
              return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                  }

          

             }   
                $emi_history = DB::table('emi_history')->where('user_id',$user_id)->where('loan_id',$request->loan_id)->get();
                $loan  = DB::table('loans')->where('id',$request->loan_id)->first();
              // print_r($emi_history->sum('installment')); 
               $installmentSum =  $emi_history->sum('installment');
              $pendingPaidAmount = $loan->to_be_paid - $installmentSum;

             $response = [
                   "status" => true,
                  'to_be_paid' => $loan->to_be_paid,
                  'pendingAmout' => $pendingPaidAmount,
                  "message" => $pendingPaidAmount.' '.$this->amount_pending_to_complete,
              ];
              return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
          }

      }else{


           $validator = Validator::make($request->all(),
          [
            'paid_amount' => 'required',
          
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

                $emi_history = DB::table('emi_history')->where('user_id',$user_id)->where('loan_id',$request->loan_id)->get();
                $loan  = DB::table('loans')->where('id',$request->loan_id)->first();
              // print_r($emi_history->sum('installment')); 
               $installmentSum =  $emi_history->sum('installment');
              $pendingPaidAmount = $loan->to_be_paid - $installmentSum;

             if($request->paid_amount <= $pendingPaidAmount){
              DB::table('emi_history')->insert(array('user_id' => $user_id, 'loan_id' => $request->loan_id,'installment' => $request->paid_amount));
               }else{
                 $emi_history = DB::table('emi_history')->where('user_id',$user_id)->where('loan_id',$request->loan_id)->get();

                  // print_r($emi_history->sum('installment')); 
                   $installmentSum =  $emi_history->sum('installment');
                   $pendingPaidAmount = $loan->to_be_paid - $installmentSum; 

                   $response = [
                   "status" => true,
                    'to_be_paid' => $loan->to_be_paid,
                    'pendingAmout' => $pendingPaidAmount,
                    "message"=> $this->you_paying_much_as_paid,
              ];
              return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

               }
            $data  = DB::table('emi_history')->where('user_id',$user_id)->where('loan_id',$request->loan_id)->first();
            $loan  = DB::table('loans')->where('id',$request->loan_id)->first();

        if($loan->to_be_paid == $data->installment){

          DB::table('loans')->where('id', $request->loan_id)->update(array('loanCompletedStatus' => 1));

             $response = [
                "status" => false,
                "message"=> $this->loan_completed_paid_amount.' '.$data->installment,
              ];
              return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
          }
  
           $emi_history = DB::table('emi_history')->where('user_id',$user_id)->where('loan_id',$request->loan_id)->get();

              // print_r($emi_history->sum('installment')); 
               $installmentSum =  $emi_history->sum('installment');
              $pendingPaidAmount = $loan->to_be_paid - $installmentSum; 
  
     $response = [
        "status" => true,
        'to_be_paid' => $loan->to_be_paid,
        'pendingAmout' => $pendingPaidAmount,
        "message"=> $this->loan_paid_amount.' '.$request->paid_amount,
   
      ];
      return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);  
      }
  }
  public function loan_detail(Request $request){

    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }

    $id = $request->id;
    $givenLoan = Loans::where('id',$id)->orderBy('id','DESC')->get();
      
    if(count($givenLoan) >= 1){

      foreach ($givenLoan as $key => $value) {   

        $created_at = date('Y-m-d h:i:s', strtotime($value->created_at));
        $value->created_date = $created_at;
        
        if($value->loan_status=="0"){
          $value->condition = "Given";
        }else{
          $value->condition = "Request";
        } 

        $history = DB::table('emi_history')->where('loan_id',$value->id)->get();
        
        if($history->isEmpty()){
          $value->emi_history = [];
        }
        
        $value->emi_history = $history;

          
        $loan_duration = DB::table('loan_duration')->where('id',$value->duration_type)->first();
        $value->duration_type = $loan_duration->package_name;

      }

      $response = [
        "status" => true,
        "message"=>$this->loan_details,
        "loan_detail"=>$givenLoan,
      ];
      return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }else{
      $response = [
        "status" => false,
        "message"=>$this->no_loan_detail,
        "loan_detail"=>[],
      ];
      return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }  

  }

  public function notifications(Request $request)
  {   
      $statusCode=200;
      $response=[];
      $session_id = $request->session_id;
      $user_id = User::validateSessionId($session_id);
      if (! $user_id) {
        return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
      } 
      $notifications = Notification::where('to',$user_id)->select('id','loan_id','title','body','status as read_status','created_at')->orderBy('id','DESC')->get();
      // dd($notifications);
      foreach ($notifications as $key => $value) {
        $created_at = date('Y-m-d h:i:s', strtotime($value->created_at));

        $value->created_date = $created_at;

      }

      // print_r($notifications->toArray());
      $response = [
        "status" => true,
        "message"=>$this->installment_fetched,
        "result" => $notifications
      ];           
      return response()->json($response, 200, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

  public function notifications_all_read(Request $request){

      $statusCode=200;
      $response=[];
      $session_id = $request->session_id;
      
      $user_id = User::validateSessionId($session_id);
      if (! $user_id) {
        return response ()->json(['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
      }
      $noti = Notification::where('to',$user_id)->update(array('status'=>"1"));
     

      $response = [
        "status" => true,
        "message"=>$this->notification_detail,
        // "result" => $noti,
      ];           
      return response()->json($response, 200, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

  }

  public function notifications_all_un_read_count(Request $request){

      $statusCode=200;
      $response=[];
      $session_id = $request->session_id;
      
      $user_id = User::validateSessionId($session_id);
      if (! $user_id) {
        return response ()->json(['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
      }
      $noti = Notification::where('to',$user_id)->where('status',"0")->get();
     
      $response = [
        "status" => true,
        "message"=>$this->notification_count,
        "unread_count" => count($noti),
      ];     
            
      return response()->json($response, 200, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

  }

  public function changeNotificationStatus(Request $request)
  {   
      $statusCode=200;
      $response=[];
      $session_id = $request->session_id;
      $user_id = User::validateSessionId($session_id);
      if (! $user_id) {
        return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
      }
      $user = User::where('id',$user_id)->first();
      if($user->notification_status==1){
        $user->notification_status = 0;
        $user->save();
      }
      else{
        $user->notification_status = 1;
        $user->save();
      }

      // dd($user->notification_status);   

      $response = [
        "status" => true,
        "message"=>$this->status_changed,
        "result" => $user->notification_status,
      ];           
      return response()->json($response, 200, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

  public function currentLoanStatus(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 403]);
    }

    $user = User::where('id',$user_id)->first();
   // echo "<pre>";print_r($user);die;
   
    if($user->cred_score == ""){

      $amount = "";
      $loan_amount = $amount;
      $main_status = true;  
      $myArray = [];
      $result['response'] = $myArray;
      $result['amount'] = $loan_amount;
      $result['to_be_paid'] = "";
      $result['condition'] = "send request";
      $result['status'] = 0;
      $result['installments'] = "";

      $response = [
      "status" => $main_status,
      "message"=>$this->current_loan,
      "data"=>$result,
      
    ];  


    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);   
    }else{
     $cred_score=$user->cred_score;
     $credit_score = DB::table('credit_score_amount')->where(function ($query) use ($cred_score) {
            $query->where('from', '<=', $cred_score);
            $query->where('to', '>=', $cred_score);
          })->first();
    


    // $check_request_loans = DB::table('loans')
    // ->where('user_id',$user_id)
    // ->orWhere('taken_by',$user_id)->get();

  $check_request_loansTaken_by = DB::table('loans')
   ->Where('taken_by',$user_id)->where('status',"1")
   ->where('loanCompletedStatus',"0")->get();
   

    $check_request_loansUser_id = DB::table('loans')
   ->Where('user_id',$user_id)->where('status',"1")->where('loanCompletedStatus',"0")->get();

   // print_r($check_request_loansUser_id); die;
    $condition = "";
    $status = "";
    $id = "";
   
   if(count($check_request_loansTaken_by) >= 1){

    foreach ($check_request_loansTaken_by as $key => $value) {   
    $created_at = date('Y-m-d h:i:s', strtotime($value->created_at));
    $value->created_date = $created_at; 

         
                $value->condition = "Request";
                $condition = $value->condition;
                $amount = $value->amount;
                $status = $value->status;
                $id = $value->id;
                $loan_amount = $amount;

        }


      $main_status = true;
      $myArray = [];
      $predefined_installments = DB::table('predefined_installments')->where('amount',$loan_amount)->first();
      // dd($predefined_installments);
      $number=0;
      if($predefined_installments==null){
        $add_in_predefined_installments_table = DB::table('predefined_installments')->insert(array('amount'=>$loan_amount,'duration_type'=>1,'number'=>10));
        $predefined_installments = DB::table('predefined_installments')->where('amount',$loan_amount)->first();
        // dd($predefined_installments);
      }
      if($predefined_installments!=null){
        // if($predefined_installments->duration_type == 1){
        //   $obj = (object)[];
        //   $obj->time = "7 days";
        //   $obj->interest = "5%";
        //   $myArray[] = $obj; 
        // }
        // if($predefined_installments->duration_type == 2){
        //   $obj = (object)[];
        //   $obj->time = "15 days";
        //   $obj->interest = "10%";
        //   $myArray[] = $obj;  
        // }
        // if($predefined_installments->duration_type == 3){
        //   $obj = (object)[];
        //   $obj->time = "21 days";
        //   $obj->interest = "15%";
        //   $myArray[] = $obj;   
        // }
        // if($predefined_installments->duration_type == 4){
        //   $obj = (object)[];
        //   $obj->time = "30 days";
        //   $obj->interest = "20%"; 
        //   $myArray[] = $obj;    
        // }
        $number = $predefined_installments->number;
      }



        if($value->duration_type == 1){
          $obj = (object)[];
          $obj->time = "7 days";
          $obj->interest = "5%";
          $myArray[] = $obj; 
        }
        if($value->duration_type == 2){
          $obj = (object)[];
          $obj->time = "15 days";
          $obj->interest = "10%";
          $myArray[] = $obj;  
        }
        if($value->duration_type == 3){
          $obj = (object)[];
          $obj->time = "21 days";
          $obj->interest = "15%";
          $myArray[] = $obj;   
        }
        if($value->duration_type == 4){
          $obj = (object)[];
          $obj->time = "30 days";
          $obj->interest = "20%"; 
          $myArray[] = $obj;    
        }


    $result['response'] = $myArray;
    $result['id'] = $id;
    $result['to_be_paid'] = $value->to_be_paid ?? 0;
    $result['amount'] = $loan_amount;
    $result['condition'] = $condition;
    $result['status'] = $status;
    $result['installments'] = $number;


    // print_r($result); die;
   $response = [
      "status" => $main_status,
      "message"=>$this->current_loan,
      "data"=>$result,
    ];

    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); 

   }elseif(count($check_request_loansUser_id) >= 1){

      // print_r($check_request_loansUser_id); die;
        foreach ($check_request_loansUser_id as $key => $value) {   
    $created_at = date('Y-m-d h:i:s', strtotime($value->created_at));
    $value->created_date = $created_at; 
     
               $value->condition = "Given";
          
               $condition = $value->condition;
               $amount = $value->amount;
                $status = $value->status;
                $id = $value->id;
                $loan_amount = $amount;

        }

      $main_status = true;
      $myArray = [];
      $predefined_installments = DB::table('predefined_installments')->where('amount',$loan_amount)->first();
      // dd($predefined_installments);
      $number=0;
      if($predefined_installments==null){
        $add_in_predefined_installments_table = DB::table('predefined_installments')->insert(array('amount'=>$loan_amount,'duration_type'=>1,'number'=>10));
        $predefined_installments = DB::table('predefined_installments')->where('amount',$loan_amount)->first();
        // dd($predefined_installments);
      }
      if($predefined_installments!=null){
        // if($predefined_installments->duration_type == 1){
        //   $obj = (object)[];
        //   $obj->time = "7 days";
        //   $obj->interest = "5%";
        //   $myArray[] = $obj; 
        // }
        // if($predefined_installments->duration_type == 2){
        //   $obj = (object)[];
        //   $obj->time = "15 days";
        //   $obj->interest = "10%";
        //   $myArray[] = $obj;  
        // }
        // if($predefined_installments->duration_type == 3){
        //   $obj = (object)[];
        //   $obj->time = "21 days";
        //   $obj->interest = "15%";
        //   $myArray[] = $obj;   
        // }
        // if($predefined_installments->duration_type == 4){
        //   $obj = (object)[];
        //   $obj->time = "30 days";
        //   $obj->interest = "20%"; 
        //   $myArray[] = $obj;    
        // }
        $number = $predefined_installments->number;
      }

       if($value->duration_type == 1){
          $obj = (object)[];
          $obj->time = "7 days";
          $obj->interest = "5%";
          $myArray[] = $obj; 
        }
        if($value->duration_type == 2){
          $obj = (object)[];
          $obj->time = "15 days";
          $obj->interest = "10%";
          $myArray[] = $obj;  
        }
        if($value->duration_type == 3){
          $obj = (object)[];
          $obj->time = "21 days";
          $obj->interest = "15%";
          $myArray[] = $obj;   
        }
        if($value->duration_type == 4){
          $obj = (object)[];
          $obj->time = "30 days";
          $obj->interest = "20%"; 
          $myArray[] = $obj;    
        }
    $result['response'] = $myArray;
    $result['id'] = $id;
    $result['to_be_paid'] = $value->to_be_paid ?? 0;
    $result['amount'] = $loan_amount;
    $result['condition'] = $condition;
    $result['status'] = $status;
    $result['installments'] = $number;

    // print_r($result); die;
     $response = [
      "status" => $main_status,
      "message"=>$this->current_loan,
      "data"=>$result,
    ];

    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); 

   }else{

     $query = DB::table('loan_amount')->where('id',$user->loan_limit)->first(); //changes from loan_limits
    $predefined_installments = DB::table('predefined_installments')->where('amount',$query->amount)->first();
    $number='';


    if($predefined_installments->duration_type == 1){
      $obj = (object)[];
      $obj->time = "7 days";
      $obj->interest = "5%";
      $myArray[] = $obj; 
    }
    if($predefined_installments->duration_type == 2){
      $obj = (object)[];
      $obj->time = "15 days";
      $obj->interest = "10%";
      $myArray[] = $obj;  
    }
    if($predefined_installments->duration_type == 3){
      $obj = (object)[];
      $obj->time = "21 days";
      $obj->interest = "15%";
      $myArray[] = $obj;   
    }
    if($predefined_installments->duration_type == 4){
      $obj = (object)[];
      $obj->time = "30 days";
      $obj->interest = "20%"; 
      $myArray[] = $obj;    
    }    


      $amount = $credit_score->amount;
      $loan_amount = $amount;
      $main_status = true;  

      $result['response'] = $myArray;
      $result['amount'] = $loan_amount;
      $result['to_be_paid'] = "";
      $result['condition'] = "send request";
      $result['status'] = 0;
      $result['installments'] = $predefined_installments->number;

       $response = [
      "status" => $main_status,
      "message"=>$this->current_loan,
      "data"=>$result,
    ];

    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); 
   }
   }
  
  }


  public function history_status(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 403]);
    }

    $user = User::where('id',$user_id)->first();
    //echo "<pre>";print_r($user);die;
    // if(env('ENVIRONMENT')=="dev"){
    //     $country_code = "+91";
    //     $phone = substr ($user->phone, -10);
    // }
    // else{
    //     $country_code = "+244";
    //     $phone = substr ($user->phone, -9);
    // }
    
    // $phone = $country_code.$phone;
    $phone = $user->phone;


    // return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);  

    $check = Loans::where('user_id',$user_id)->orWhere('taken_by',$user_id)->orderBy('id','DESC')->get();
   
    if(count($check) == 0){

    $check_no = Loans::whereRaw("find_in_set('".$phone."',given_to)")->orderBy('id','DESC')->first();
    
    if(empty($check_no)){

      $response = [
        "status" => false,
        "message"=>$this->status_history,
      ];

    }else{

      $response = [
        "status" => true,
        "message"=>$this->status_history,
        "data" => [$check_no]
      ];  
    }



      // $response = [
      //   "status" => false,
      //   "message"=>"history status",
      // ];

    }else{
      $response = [
        "status" => true,
        "message"=>$this->status_history,
        "data" => $check
      ];  
    }

    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);   
  }


  public function fetch_credit_limit_score(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 403]);
    }

    $userDetail = DB::table('app_login')->where('session_id', $session_id )->first();
 //  dd($userDetail);

   
    $device_model = $userDetail->device_model;
    $contact_count = $userDetail->contact_count;
     if($device_model == "" && $contact_count == "" ){
      $response = [
      "status" => true,
      "message"=>$this->score_limit,
      "data" => '1000',
      "amount" => '10000'
    ];  
  

    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);   
     }else{
      $phone_rate = 0;
    $contact_score = 0;

    $phone_score = DB::table('phones')->where('model',$device_model)->first();
    if(empty($phone_score)){
      $phone_rate = 127;
    }else{
      $phone_rate = $phone_score->score;
    }

    // print_r($phone_rate); die;
    $contact_score = DB::table('contacts')->where('contacts',$contact_count)->first();
    ;
    $contact_score = DB::table('contacts')->where(function ($query) use ($contact_count) {
      $query->where('from', '<=', $contact_count);
      $query->where('to', '>=', $contact_count);
    })->first();

    if(empty($contact_score)){
      $contact_score = 127;
    }else{
      $contact_score = $contact_score->score;
    }

    // dump($phone_rate);
    // dump($contact_score);

    $phone_contact_score = $phone_rate + $contact_score + 340 + 255;
  // dd($phone_contact_score);

    if($phone_contact_score > 900){


    $response = [
      "status" => false,
      "message"=> "Creadit score can'nt greater than 900",
    
    ];  
  

    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); 

    }
    DB::table('users')->where('id',$user_id)->update(array('cred_score'=>$phone_contact_score));

    $user = User::where('id',$user_id)->first();
    $t = $user->cred_score;

    // dd($t);
    $credit_score = DB::table('credit_score_amount')->where(function ($query) use ($t) {
      $query->where('from', '<=', $t);
      $query->where('to', '>=', $t);
    })->first();

    // dd($credit_score);
    // $check = Loans::where('user_id',$user_id)->orWhere('taken_by',$user_id)->get();
    // 40%-History -- 340 points
    // 30%-Organised contact list , bill payment etc -- 255 points
    // 30%-Reason for loan -- 255 points (edited) 

    // 340 + 250 + 255 = 845

    // 845 (excellent)

 
    $response = [
      "status" => true,
      "message"=>$this->score_limit,
      "data" => $phone_contact_score,
      "amount" => $credit_score->amount
    ];  
  

    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);   
     }
    
  }

  public function getOffersGivenByEntity(request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }
    $validator = Validator::make($request->all(),
    [
      'type' => 'required',
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

    $phone = User::where('id',$user_id)->pluck('phone')->toArray();
    $number = $phone[0];
    $type=$request->type;
    $request1 =[];
    DB::enableQueryLog();
    if($type == 'M'){ //1=Marketplace
        $result = DB::table('loans')
        // ->where(function($q) use ($user_id) {
        //  $q->where('taken_by', $user_id)->where('user_id', null)->where('loan_status', '1');
        // })
        // ->orWhere(function($q1) use ($user_id) {
        //     $q1->where('user_id', $user_id)->where('taken_by', null)->where('loan_status', '0');
        // })
        ->where(function($q2) use ($number) {
            $q2->where('given_to', 'LIKE', '%'.$number.'%');
        })->where('status', '0')->where('request_to', 'M')->orderBy('id','DESC')->get();
    }else{ //2=Contacts
      $result = DB::table('loans')
        // ->where(function($q) use ($user_id) {
        //  $q->where('taken_by', $user_id)->where('user_id', null)->where('loan_status', '1');
        // })
        // ->orWhere(function($q1) use ($user_id) {
        //     $q1->where('user_id', $user_id)->where('taken_by', null)->where('loan_status', '0');
        // })
        ->where(function($q2) use ($number) {
            $q2->where('given_to', 'LIKE', '%'.$number.'%');
        })->where('status', '0')->where('request_to', 'C')->orderBy('id','DESC')->get();
    }
    // $log = DB::getQueryLog();

    // dd($result);
    foreach ($result as $key => $value) {
            $loan_duration = DB::table('loan_duration')->where('id',$value->duration_type)->first();
            $value->duration_type = $loan_duration->package_name;
    }
    $response = [
      "status" => true,
      "message"=>$this->type_loan,
      "numbers"=>$result,
    ];
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }


  public function loanApprovedList(Request $request)
  {
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $user_id = User::validateSessionId($session_id);
    if (!$user_id) {
      return response()->json(['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }

   $validator = Validator::make($request->all(),
    [
      'status' => 'required',
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
    // dd($user_id);

    // DB::enableQueryLog();   
    //user_id -> given  ,  taken_by -> taken or request
    if($request->status==1){
      $dataList = DB::table('loans')->where('status', 1)->where('taken_by',$user_id)->orderBy('id','DESC')->get();
        // print_r($dataList); die;
    } else {  

      // print_r($user_id); die;
      $query = DB::table('loans')->where('status', 1);
      $query = $query->where(function ($query1) use ($user_id) {
          // $query1->where('taken_by',$user_id);
          $query1->orWhere('user_id',$user_id); 

      });

      $dataList = $query->orderBy('id','DESC')->get(); 

    }

    if($dataList->count() > 0){

      foreach ($dataList as $key => $value) {
        # code...
        $loan_duration = DB::table('loan_duration')->where('id',$value->duration_type)->first();
        $value->duration_type = $loan_duration->package_name;
       
      }


      $response = [
      "status" => true,
      "message" =>$this->data_list,
      "datalist" => $dataList,
    ];
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }else{
     $response = [
      "status" => false,
      "message" =>$this->no_data_list,
      "datalist" => [],
    ];
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
  }


  public function loanReqRejectByUser(Request $request){       // loan request rejeted by me 25-6-21
    
    
    $statusCode=200;
    $response=[];
    $session_id = $request->session_id;
    $id = $request->id;
   
    $validator = Validator::make($request->all(),
    [
      'id' => 'required|exists:loans,id',
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
    $user_id = User::validateSessionId($session_id);
    
    if (! $user_id) {
      return response ()->json (['error' => 'bad_request','message' => 'Session Expired' ,"status"=> 401]);
    }
    
    
    $result = DB::table('loans')->where(['id'=>$request->id])->update(['status'=>2]); // status 2 = rejected request

    
      $response = [
        "status" => $statusCode,
        "message"=>$this->reject_lonaoff,
        "success"=>true,
      ];
   
    
    return response()->json($response, $statusCode, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

  }

}