<?php
/**
 * レビューURL確認メーラブル
 */

namespace Hgs3\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Hgs3\Models\Orm;

class ReviewUrlApprovalWait extends Mailable
{
    use Queueable, SerializesModels;

    protected $site;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
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
            ->subject('レビューURLを承認してね')
            ->text('mail.reviewUrlApprovalWait');
    }
}
