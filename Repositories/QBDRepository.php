<?php

namespace Modules\QBD\Repositories;

use DB;
use Modules\Qbd\Models\Qbd;
use App\Ninja\Repositories\BaseRepository;
//use App\Events\QbdWasCreated;
//use App\Events\QbdWasUpdated;

class QbdRepository extends BaseRepository
{
    public function getClassName()
    {
        return 'Modules\Qbd\Models\Qbd';
    }

    public function all()
    {
        return Qbd::scope()
                ->orderBy('created_at', 'desc')
                ->withTrashed();
    }

    public function find($filter = null, $userId = false)
    {
        $query = DB::table('qbd')
                    ->where('qbd.account_id', '=', \Auth::user()->account_id)
                    ->select(
                        
                        'qbd.public_id',
                        'qbd.deleted_at',
                        'qbd.created_at',
                        'qbd.is_deleted',
                        'qbd.user_id'
                    );

        $this->applyFilters($query, 'qbd');

        if ($userId) {
            $query->where('clients.user_id', '=', $userId);
        }

        /*
        if ($filter) {
            $query->where();
        }
        */

        return $query;
    }

    public function save($data, $qbd = null)
    {
        $entity = $qbd ?: Qbd::createNew();

        $entity->fill($data);
        $entity->save();

        /*
        if (!$publicId || intval($publicId) < 0) {
            event(new ClientWasCreated($client));
        } else {
            event(new ClientWasUpdated($client));
        }
        */

        return $entity;
    }

}
