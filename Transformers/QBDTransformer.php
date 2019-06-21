<?php

namespace Modules\QBD\Transformers;

use Modules\Qbd\Models\Qbd;
use App\Ninja\Transformers\EntityTransformer;

/**
 * @SWG\Definition(definition="Qbd", @SWG\Xml(name="Qbd"))
 */

class QbdTransformer extends EntityTransformer
{
    /**
    * @SWG\Property(property="id", type="integer", example=1, readOnly=true)
    * @SWG\Property(property="user_id", type="integer", example=1)
    * @SWG\Property(property="account_key", type="string", example="123456")
    * @SWG\Property(property="updated_at", type="integer", example=1451160233, readOnly=true)
    * @SWG\Property(property="archived_at", type="integer", example=1451160233, readOnly=true)
    */

    /**
     * @param Qbd $qbd
     * @return array
     */
    public function transform(Qbd $qbd)
    {
        return array_merge($this->getDefaults($qbd), [
            
            'id' => (int) $qbd->public_id,
            'updated_at' => $this->getTimestamp($qbd->updated_at),
            'archived_at' => $this->getTimestamp($qbd->deleted_at),
        ]);
    }
}
