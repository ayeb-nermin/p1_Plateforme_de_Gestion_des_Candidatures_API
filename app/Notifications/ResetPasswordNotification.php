<?php

namespace App\Notifications;

use App\Models\Email;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{

    use Queueable;

    public $token;
    public $email;
    public $user;

    public function __construct(User $user, Email $email, $token)
    {
        $this->token = $token;
        $this->email = $email;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = config('common.front_url')  . '/' . config('common.routes.forgot_password') . '/' . $this->token;

        $template = str_replace(config('common.variable_template_email.forgot_password'), $url, $this->email->template);
        $template = str_replace(config('common.variable_template_email.lien'), $url, $template);

        $message = (new MailMessage)->view('emails.template_email', compact('template'));
        $headers = json_decode($this->email->headers, true);
        foreach ($headers as $header) {
            $head = $header['header_name'];
            $message->$head($header['header_value']);
        }
        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [];
    }
}
