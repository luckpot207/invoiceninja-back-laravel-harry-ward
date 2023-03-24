<?php
/**
 * Invoice Ninja (https://invoiceninja.com).
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2023. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://www.elastic.co/licensing/elastic-license
 */

namespace App\Http\Controllers;

use App\Factory\UnderlaymentFactory;
use App\Filters\UnderlaymentFilters;
use App\Http\Requests\Underlayment\CreateUnderlaymentRequest;
use App\Http\Requests\Underlayment\DestroyUnderlaymentRequest;
use App\Http\Requests\Underlayment\EditUnderlaymentRequest;
use App\Http\Requests\Underlayment\ShowUnderlaymentRequest;
use App\Http\Requests\Underlayment\StoreUnderlaymentRequest;
use App\Http\Requests\Underlayment\UpdateUnderlaymentRequest;
use App\Http\Requests\Underlayment\UploadUnderlaymentRequest;
use App\Models\Account;
use App\Models\Underlayment;
use App\Repositories\UnderlaymentRepository;
use App\Transformers\UnderlaymentTransformer;
use App\Utils\Traits\GeneratesCounter;
use App\Utils\Traits\MakesHash;
use App\Utils\Traits\SavesDocuments;
use Illuminate\Http\Response;

/**
 * Class UnderlaymentController.
 */
class UnderlaymentController extends BaseController
{
    use MakesHash;
    use SavesDocuments;
    use GeneratesCounter;

    protected $entity_type = Underlayment::class;

    protected $entity_transformer = UnderlaymentTransformer::class;

    protected $underlayment_repo;

    /**
     * UnderlaymentController constructor.
     * @param UnderlaymentRepository $underlayment_repo
     */
    public function __construct(UnderlaymentRepository $underlayment_repo)
    {
        parent::__construct();

        $this->underlayment_repo = $underlayment_repo;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/underlayments",
     *      operationId="getUnderlayments",
     *      tags={"underlayments"},
     *      summary="Gets a list of underlayments",
     *      description="Lists underlayments",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(ref="#/components/parameters/index"),
     *      @OA\Response(
     *          response=200,
     *          description="A list of underlayments",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/Underlayment"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *       ),
     *       @OA\Response(
     *           response="default",
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     * @param UnderlaymentFilters $filters
     * @return Response|mixed
     */
    public function index(UnderlaymentFilters $filters)
    {
        $underlayments = Underlayment::filter($filters);
        $result = Underlayment::select('id', 'name')->get();
        $result = [
            "data" => $result
        ];

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param ShowUnderlaymentRequest $request
     * @param Underlayment $underlayment
     * @return Response
     *
     *
     * @OA\Get(
     *      path="/api/v1/underlayments/{id}",
     *      operationId="showUnderlayment",
     *      tags={"underlayments"},
     *      summary="Shows a underlayment",
     *      description="Displays a underlayment by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The Underlayment Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the expense object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/Underlayment"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default",
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     */
    public function show(ShowUnderlaymentRequest $request, Underlayment $underlayment)
    {
        return $this->itemResponse($underlayment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EditUnderlaymentRequest $request
     * @param Underlayment $underlayment
     * @return Response
     *
     *
     * @OA\Get(
     *      path="/api/v1/underlayments/{id}/edit",
     *      operationId="editUnderlayment",
     *      tags={"underlayments"},
     *      summary="Shows a underlayment for editting",
     *      description="Displays a underlayment by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The Underlayment Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the underlayment object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/Underlayment"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default",
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     */
    public function edit(EditUnderlaymentRequest $request, Underlayment $underlayment)
    {
        return $this->itemResponse($underlayment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUnderlaymentRequest $request
     * @param Underlayment $underlayment
     * @return Response
     *
     *
     *
     * @OA\Put(
     *      path="/api/v1/underlayments/{id}",
     *      operationId="updateUnderlayment",
     *      tags={"underlayments"},
     *      summary="Updates a underlayment",
     *      description="Handles the updating of a underlayment by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The Underlayment Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the underlayment object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/Underlayment"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default",
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     */
    public function update(UpdateUnderlaymentRequest $request, Underlayment $underlayment)
    {
        if ($request->entityIsDeleted($underlayment)) {
            return $request->disallowUpdate();
        }

        $underlayment->fill($request->all());
        $underlayment->number = empty($underlayment->number) ? $this->getNextUnderlaymentNumber($underlayment) : $underlayment->number;
        $underlayment->saveQuietly();

        if ($request->has('documents')) {
            $this->saveDocuments($request->input('documents'), $underlayment);
        }

        event('eloquent.updated: App\Models\Underlayment', $underlayment);

        return $this->itemResponse($underlayment->fresh());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateUnderlaymentRequest $request
     * @return Response
     *
     *
     *
     * @OA\Get(
     *      path="/api/v1/underlayments/create",
     *      operationId="getUnderlaymentsCreate",
     *      tags={"underlayments"},
     *      summary="Gets a new blank underlayment object",
     *      description="Returns a blank object with default values",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Response(
     *          response=200,
     *          description="A blank underlayment object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/Underlayment"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default",
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     */
    public function create(CreateUnderlaymentRequest $request)
    {
        $underlayment = UnderlaymentFactory::create();

        return $this->itemResponse($underlayment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUnderlaymentRequest $request
     * @return Response
     *
     *
     *
     * @OA\Post(
     *      path="/api/v1/underlayments",
     *      operationId="storeUnderlayment",
     *      tags={"underlayments"},
     *      summary="Adds a underlayment",
     *      description="Adds an underlayment to a company",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the saved underlayment object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/Underlayment"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default",
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     */
    public function store(StoreUnderlaymentRequest $request)
    {
        $underlayment = UnderlaymentFactory::create();
        $underlayment->fill($request->all());
        $underlayment->saveQuietly();

        event('eloquent.created: App\Models\Underlayment', $underlayment);

        return $this->itemResponse($underlayment->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyUnderlaymentRequest $request
     * @param Underlayment $underlayment
     * @return Response
     *
     *
     * @throws \Exception
     * @OA\Delete(
     *      path="/api/v1/underlayments/{id}",
     *      operationId="deleteUnderlayment",
     *      tags={"underlayments"},
     *      summary="Deletes a underlayment",
     *      description="Handles the deletion of a underlayment by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The Underlayment Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns a HTTP status",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default",
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     */
    public function destroy(DestroyUnderlaymentRequest $request, Underlayment $underlayment)
    {
        //may not need these destroy routes as we are using actions to 'archive/delete'
        $underlayment->delete();
        $underlayment->save();

        return $this->itemResponse($underlayment->fresh());
    }

    /**
     * Perform bulk actions on the list view.
     *
     * @return Response
     *
     *
     * @OA\Post(
     *      path="/api/v1/underlayments/bulk",
     *      operationId="bulkUnderlayments",
     *      tags={"underlayments"},
     *      summary="Performs bulk actions on an array of underlayments",
     *      description="",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/index"),
     *      @OA\RequestBody(
     *         description="User credentials",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(
     *                     type="integer",
     *                     description="Array of hashed IDs to be bulk 'actioned",
     *                     example="[0,1,2,3]",
     *                 ),
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="The Underlayment User response",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/Underlayment"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *       ),
     *       @OA\Response(
     *           response="default",
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     */
    public function bulk()
    {
        $action = request()->input('action');

        $ids = request()->input('ids');

        $underlayments = Underlayment::withTrashed()->find($this->transformKeys($ids));

        $underlayments->each(function ($underlayment, $key) use ($action) {
            if (auth()->user()->can('edit', $underlayment)) {
                $this->underlayment_repo->{$action}($underlayment);
            }
        });

        return $this->listResponse(Underlayment::withTrashed()->whereIn('id', $this->transformKeys($ids)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UploadProductRequest $request
     * @param Product $underlayment
     * @return Response
     *
     *
     *
     * @OA\Put(
     *      path="/api/v1/underlayments/{id}/upload",
     *      operationId="uploadUnderlayment",
     *      tags={"underlayments"},
     *      summary="Uploads a document to a underlayment",
     *      description="Handles the uploading of a document to a underlayment",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The Underlayment Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the Underlayment object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/Underlayment"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default",
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     */
    public function upload(UploadUnderlaymentRequest $request, Underlayment $underlayment)
    {
        if (! $this->checkFeature(Account::FEATURE_DOCUMENTS)) {
            return $this->featureFailure();
        }

        if ($request->has('documents')) {
            $this->saveDocuments($request->file('documents'), $underlayment);
        }

        return $this->itemResponse($underlayment->fresh());
    }
}
