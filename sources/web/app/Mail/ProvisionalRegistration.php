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
            ->from('webmaster@horrorgame.net', 'H.G.N.-Horror Game Network-')
            ->subject('仮登録のお知らせ')
            ->text('mail.provisionalRegistration', ['token' => $this->token]);
    }
}
