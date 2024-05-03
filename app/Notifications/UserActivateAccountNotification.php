<?php

namespace App\Notifications;

use App\Models\Email;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserActivateAccountNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $email;
    protected $password;
    protected $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, Email $email, $password, $token)
    {
        $this->user = $user;
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;
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
        $url = config('common.front_url') . '/' . $this->token;
        $credentials = null;
        if (!is_null($this->password)) {
            $credentials = '<strong>' . __('form.users.login') . '</strong> : ' . $this->user->login . '<br><strong>' . __('form.users.password') . '</strong> : ' . $this->password;
        }

        $template = $this->email->template;

        $template = str_replace(config('common.variable_template_email.created_user_name'), $this->user->first_name, $template);
        $template = str_replace(config('common.variable_template_email.user_credential'), $credentials, $template);
        $template = str_replace(config('common.variable_template_email.lien'), $url, $template);

        $message = (new MailMessage)->view('emails.template_email', compact('template'));
        $headers = json_decode($this->email->headers, true);
        foreach ($headers as $header) {
            $head = $header['header_name'];
            $message->$head($header['header_value']);
        }

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

    /**
     * Notification via focal point space
     *
     * @return boolean
     */
    public function toDatabase($notifiable)
    {
        return [];
    }
}
