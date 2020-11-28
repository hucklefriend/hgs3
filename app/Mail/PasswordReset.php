<?php
/**
 * パスワード再設定メーラブル
 */

namespace Hgs3\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;

    /**
     * コンストラクタ
     *
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
            ->from(env('ADMIN_MAIL'), env('APP_NAME'))
            ->subject('パスワード再設定のお知らせ')
            ->text('mail.passwordReset', ['token' => $this->token]);
    }
}
