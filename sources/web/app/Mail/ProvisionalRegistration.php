<?php
/**
 * 仮登録メーラブル
 */

namespace Hgs3\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProvisionalRegistration extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $token;

    /**
     * ProvisionalRegistration constructor.
     *
     * @param $email
     * @param $token
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
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
            ->from('webmaster@horrorgame.net', 'H.G.N.管理人')
            ->subject('仮登録のお知らせ')
            ->text('mail.pr', ['token' => $this->token, 'mail' => $this->email]);
    }
}
