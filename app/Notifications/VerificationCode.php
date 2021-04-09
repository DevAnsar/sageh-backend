<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class VerificationCode extends Notification  implements ShouldQueue
{
    use Queueable;
    protected $mobile_number;
    protected $code;

    /**
     * Create a new notification instance.
     *
     * @param $mobile_number
     * @param $code
     */
    public function __construct($mobile_number,$code)
    {
        $this->mobile_number=$mobile_number;
        $this->code=$code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    public function toSms($notifiable)
    {
        return [
            'mobile_number'=>$this->mobile_number,
            'message'=>$this->code,
            'type'=>'VerificationCode',
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
