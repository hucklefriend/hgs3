<?
/**
 * ORM: sites
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    public function getHandleGames()
    {
        return SiteHandleGame::where('site_id', $this->id)
            ->get()
            ->pluck('game_id');
    }
}
