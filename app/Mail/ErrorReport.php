<?php
/**
 * エラーレポートメール
 */

namespace Hgs3\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Input;

class ErrorReport extends Mailable
{
    use Queueable, SerializesModels;

    protected $e;

    /**
     * ProvisionalRegistration constructor.
     *
     * @param $email
     * @param $token
     */
    public function __construct(\Exception $e)
    {
        $this->e = $e;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to('bug@horrorgame.net')
            ->from(env('ADMIN_MAIL'), env('APP_NAME'))
            ->subject('エラー発生')
            ->text('mail.errorReport', [
                'e'    => $this->e,
                'req' => app('request'),
            ]);
    }
}
