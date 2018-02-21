<?php
/**
 * メール認証メーラブル
 */

namespace Hgs3\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterMailAuth extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;

    /**
     * ProvisionalRegistration constructor.
     *
     * @param $email
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('webmaster@horrorgame.net', 'H.G.N.')
            ->subject('メール認証登録の確認')
            ->text('mail.registerMailAuth', ['token' => $this->token]);
    }
}
