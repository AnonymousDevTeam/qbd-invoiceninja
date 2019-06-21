<?php

namespace Modules\QBD\Datatables;

use Utils;
use URL;
use Auth;
use App\Ninja\Datatables\EntityDatatable;

class QBDDatatable extends EntityDatatable
{
    public $entityType = 'qbd';
    public $sortCol = 1;

    public function columns()
    {
        return [
            
            [
                'created_at',
                function ($model) {
                    return Utils::fromSqlDateTime($model->created_at);
                }
            ],
        ];
    }

    public function actions()
    {
        return [
            [
                mtrans('qbd', 'edit_qbd'),
                function ($model) {
                    return URL::to("qbd/{$model->public_id}/edit");
                },
                function ($model) {
                    return Auth::user()->can('editByOwner', ['qbd', $model->user_id]);
                }
            ],
        ];
    }

}
