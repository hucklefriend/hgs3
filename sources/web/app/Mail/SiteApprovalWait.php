<?php
/**
 * 仮登録メーラブル
 */

namespace Hgs3\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Hgs3\Models\Orm;

class SiteApprovalWait extends Mailable
{
    use Queueable, SerializesModels;

    protected $site;

    /**
     * コンストラクタ
     */
    public function __construct(Orm\Site $site)
    {
        $this->site = $site;
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
            ->subject('サイト仮登録通知')
            ->text('mail.siteApprovalWait', ['site' => $this->site]);
    }
}
