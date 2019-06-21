<?php

namespace Modules\QBD\Http\ApiControllers;

use App\Http\Controllers\BaseAPIController;
use Modules\Qbd\Repositories\QbdRepository;
use Modules\Qbd\Http\Requests\QbdRequest;
use Modules\Qbd\Http\Requests\CreateQbdRequest;
use Modules\Qbd\Http\Requests\UpdateQbdRequest;

class QbdApiController extends BaseAPIController
{
    protected $QbdRepo;
    protected $entityType = 'qbd';

    public function __construct(QbdRepository $qbdRepo)
    {
        parent::__construct();

        $this->qbdRepo = $qbdRepo;
    }

    /**
     * @SWG\Get(
     *   path="/qbd",
     *   summary="List qbd",
     *   operationId="listQbds",
     *   tags={"qbd"},
     *   @SWG\Response(
     *     response=200,
     *     description="A list of qbd",
     *      @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/Qbd"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function index()
    {
        $data = $this->qbdRepo->all();

        return $this->listResponse($data);
    }

    /**
     * @SWG\Get(
     *   path="/qbd/{qbd_id}",
     *   summary="Individual Qbd",
     *   operationId="getQbd",
     *   tags={"qbd"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="qbd_id",
     *     type="integer",
     *     required=true
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="A single qbd",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Qbd"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function show(QbdRequest $request)
    {
        return $this->itemResponse($request->entity());
    }




    /**
     * @SWG\Post(
     *   path="/qbd",
     *   summary="Create a qbd",
     *   operationId="createQbd",
     *   tags={"qbd"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="qbd",
     *     @SWG\Schema(ref="#/definitions/Qbd")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="New qbd",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Qbd"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function store(CreateQbdRequest $request)
    {
        $qbd = $this->qbdRepo->save($request->input());

        return $this->itemResponse($qbd);
    }

    /**
     * @SWG\Put(
     *   path="/qbd/{qbd_id}",
     *   summary="Update a qbd",
     *   operationId="updateQbd",
     *   tags={"qbd"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="qbd_id",
     *     type="integer",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="qbd",
     *     @SWG\Schema(ref="#/definitions/Qbd")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Updated qbd",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Qbd"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function update(UpdateQbdRequest $request, $publicId)
    {
        if ($request->action) {
            return $this->handleAction($request);
        }

        $qbd = $this->qbdRepo->save($request->input(), $request->entity());

        return $this->itemResponse($qbd);
    }


    /**
     * @SWG\Delete(
     *   path="/qbd/{qbd_id}",
     *   summary="Delete a qbd",
     *   operationId="deleteQbd",
     *   tags={"qbd"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="qbd_id",
     *     type="integer",
     *     required=true
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Deleted qbd",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Qbd"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function destroy(UpdateQbdRequest $request)
    {
        $qbd = $request->entity();

        $this->qbdRepo->delete($qbd);

        return $this->itemResponse($qbd);
    }

}
