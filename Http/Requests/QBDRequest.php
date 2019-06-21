<?php

namespace Modules\QBD\Http\Requests;

use App\Http\Requests\EntityRequest;

class QBDRequest extends EntityRequest
{
    protected $entityType = 'qbd';
}
