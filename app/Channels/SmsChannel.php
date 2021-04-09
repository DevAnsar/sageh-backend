<?php
namespace App\Channels;
use App\Lib\SMSIR;
use Illuminate\Notifications\Notification;
class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toSms($notifiable);
        $mobile_number=$data['mobile_number'];
        $message=$data['message'];

        $type=isset($data['type']) ? $data['type'] : null;


        $api = new SMSIR(env('SMSIR_APIkey',''),env('SMSIR_SecretKey',''),env('SMSIR_LineNumber',''));
        try{
            if ($type=='order_change_status'){
                $result=$api->SendMessage([$mobile_number],[$message]);
            }else if($type=='VerificationCode'){
                $result =$api->SendMessage([$mobile_number],[$message]);
//                $result =$api->VerificationCode($message,$mobile_number);
            }else{
                $result =$api->VerificationCode($message,$mobile_number);
            }
            return $result;
        }
        catch(\Exception $e)
        {

        }
    }
}
