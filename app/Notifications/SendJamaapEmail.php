<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendJamaapEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $pending;
    public function __construct($pending = null)
    {
        //
        $this->pending = $pending;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message =  (new MailMessage)
            ->subject($this->pending->subject)
            ->from($this->pending->mail_from, $this->pending->from_name)
            ->cc($this->pending->mail_from, $this->pending->from_name)
            ->cc($this->pending->reply_to, $this->pending->from_name)
            ->bcc('hemmy6894@gmail.com',"Developer Mail")
            ->replyTo("tanzania@jamaap.co.tz", $this->pending->from_name);
        $i = 1;
        foreach (explode(",", $this->pending->attachment)  as $attach) {
            if($attach == ""){
                break;
            }
            $content = file_get_contents($this->pending->url . str_replace(" ","%20",$attach));
            $ex = explode("/",$attach);
            if($c = count($ex)){
                $extension = $ex[$c-1];
            }
            $message->attachData($content, "$extension");
            $i++;
        }
        $message->view(
            'jamaap.mail',
            ['from_name' =>  $this->pending->from_name, "mail_body" => $this->pending->body, "mail_template" => $this->pending->template, "signature" => $this->pending->signature]
        );
        return $message;
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
