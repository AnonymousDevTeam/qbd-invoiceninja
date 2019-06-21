<?php

namespace Modules\QBD\Http\Controllers;

use Auth;
use App\Http\Controllers\BaseController;
use App\Services\DatatableService;
use Modules\QBD\Datatables\QBDDatatable;
use Modules\QBD\Repositories\QBDRepository;
use Modules\QBD\Http\Requests\QBDRequest;
use Modules\QBD\Http\Requests\CreateQBDRequest;
use Modules\QBD\Http\Requests\UpdateQBDRequest;

class QBDController extends BaseController
{
    protected $QBDRepo;
    //protected $entityType = 'qbd';

    public function __construct(QBDRepository $qbdRepo)
    {
        //parent::__construct();

        $this->qbdRepo = $qbdRepo;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('list_wrapper', [
            'entityType' => 'qbd',
            'datatable' => new QBDDatatable(),
            'title' => mtrans('qbd', 'qbd_list'),
        ]);
    }

    public function datatable(DatatableService $datatableService)
    {
        $search = request()->input('sSearch');
        $userId = Auth::user()->filterId();

        $datatable = new QBDDatatable();
        $query = $this->qbdRepo->find($search, $userId);

        return $datatableService->createDatatable($datatable, $query);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(QBDRequest $request)
    {
        $data = [
            'qbd' => null,
            'method' => 'POST',
            'url' => 'qbd',
            'title' => mtrans('qbd', 'new_qbd'),
        ];

        return view('qbd::edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(CreateQBDRequest $request)
    {
        $qbd = $this->qbdRepo->save($request->input());

        return redirect()->to($qbd->present()->editUrl)
            ->with('message', mtrans('qbd', 'created_qbd'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(QBDRequest $request)
    {
        $qbd = $request->entity();

        $data = [
            'qbd' => $qbd,
            'method' => 'PUT',
            'url' => 'qbd/' . $qbd->public_id,
            'title' => mtrans('qbd', 'edit_qbd'),
        ];

        return view('qbd::edit', $data);
    }

    /**
     * Show the form for editing a resource.
     * @return Response
     */
    public function show(QBDRequest $request)
    {
        return redirect()->to("qbd/{$request->qbd}/edit");
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateQBDRequest $request)
    {
        $qbd = $this->qbdRepo->save($request->input(), $request->entity());

        return redirect()->to($qbd->present()->editUrl)
            ->with('message', mtrans('qbd', 'updated_qbd'));
    }

    /**
     * Update multiple resources
     */
    public function bulk()
    {
        $action = request()->input('action');
        $ids = request()->input('public_id') ?: request()->input('ids');
        $count = $this->qbdRepo->bulk($ids, $action);

        return redirect()->to('qbd')
            ->with('message', mtrans('qbd', $action . '_qbd_complete'));
    }
}
