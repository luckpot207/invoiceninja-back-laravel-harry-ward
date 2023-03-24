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

use App\Factory\ShingleTypeFactory;
use App\Filters\ShingleTypeFilters;
use App\Http\Requests\ShingleType\CreateShingleTypeRequest;
use App\Http\Requests\ShingleType\DestroyShingleTypeRequest;
use App\Http\Requests\ShingleType\EditShingleTypeRequest;
use App\Http\Requests\ShingleType\ShowShingleTypeRequest;
use App\Http\Requests\ShingleType\StoreShingleTypeRequest;
use App\Http\Requests\ShingleType\UpdateShingleTypeRequest;
use App\Http\Requests\ShingleType\UploadShingleTypeRequest;
use App\Models\Account;
use App\Models\ShingleType;
use App\Repositories\ShingleTypeRepository;
use App\Transformers\ShingleTypeTransformer;
use App\Utils\Traits\GeneratesCounter;
use App\Utils\Traits\MakesHash;
use App\Utils\Traits\SavesDocuments;
use Illuminate\Http\Response;

/**
 * Class ShingleTypeController.
 */
class ShingleTypeController extends BaseController
{
    use MakesHash;
    use SavesDocuments;
    use GeneratesCounter;

    protected $entity_type = ShingleType::class;

    protected $entity_transformer = ShingleTypeTransformer::class;

    protected $shingle_type_repo;

    /**
     * ShingleTypeController constructor.
     * @param ShingleTypeRepository $shingle_type_repo
     */
    public function __construct(ShingleTypeRepository $shingle_type_repo)
    {
        parent::__construct();

        $this->shingle_type_repo = $shingle_type_repo;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/shingle_types",
     *      operationId="getShingleTypes",
     *      tags={"shingle_types"},
     *      summary="Gets a list of shingle_types",
     *      description="Lists shingle_types",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(ref="#/components/parameters/index"),
     *      @OA\Response(
     *          response=200,
     *          description="A list of shingle_types",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleType"),
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
     * @param ShingleTypeFilters $filters
     * @return Response|mixed
     */
    public function index(ShingleTypeFilters $filters)
    {
        $shingle_types = ShingleType::filter($filters);
        $result = ShingleType::select('id', 'name')->with('colors')->get();
        $result = [
            "data" => $result
        ];

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param ShowShingleTypeRequest $request
     * @param ShingleType $shingle_type
     * @return Response
     *
     *
     * @OA\Get(
     *      path="/api/v1/shingle_types/{id}",
     *      operationId="showShingleType",
     *      tags={"shingle_types"},
     *      summary="Shows a shingle_type",
     *      description="Displays a shingle_type by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ShingleType Hashed ID",
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
     *          @OA\JsonContent(ref="#/components/schemas/ShingleType"),
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
    public function show(ShowShingleTypeRequest $request, ShingleType $shingle_type)
    {
        return $this->itemResponse($shingle_type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EditShingleTypeRequest $request
     * @param ShingleType $shingle_type
     * @return Response
     *
     *
     * @OA\Get(
     *      path="/api/v1/shingle_types/{id}/edit",
     *      operationId="editShingleType",
     *      tags={"shingle_types"},
     *      summary="Shows a shingle_type for editting",
     *      description="Displays a shingle_type by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ShingleType Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the shingle_type object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleType"),
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
    public function edit(EditShingleTypeRequest $request, ShingleType $shingle_type)
    {
        return $this->itemResponse($shingle_type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateShingleTypeRequest $request
     * @param ShingleType $shingle_type
     * @return Response
     *
     *
     *
     * @OA\Put(
     *      path="/api/v1/shingle_types/{id}",
     *      operationId="updateShingleType",
     *      tags={"shingle_types"},
     *      summary="Updates a shingle_type",
     *      description="Handles the updating of a shingle_type by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ShingleType Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the shingle_type object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleType"),
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
    public function update(UpdateShingleTypeRequest $request, ShingleType $shingle_type)
    {
        if ($request->entityIsDeleted($shingle_type)) {
            return $request->disallowUpdate();
        }

        $shingle_type->fill($request->all());
        $shingle_type->number = empty($shingle_type->number) ? $this->getNextShingleTypeNumber($shingle_type) : $shingle_type->number;
        $shingle_type->saveQuietly();

        if ($request->has('documents')) {
            $this->saveDocuments($request->input('documents'), $shingle_type);
        }

        event('eloquent.updated: App\Models\ShingleType', $shingle_type);

        return $this->itemResponse($shingle_type->fresh());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateShingleTypeRequest $request
     * @return Response
     *
     *
     *
     * @OA\Get(
     *      path="/api/v1/shingle_types/create",
     *      operationId="getShingleTypesCreate",
     *      tags={"shingle_types"},
     *      summary="Gets a new blank shingle_type object",
     *      description="Returns a blank object with default values",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Response(
     *          response=200,
     *          description="A blank shingle_type object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleType"),
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
    public function create(CreateShingleTypeRequest $request)
    {
        $shingle_type = ShingleTypeFactory::create();

        return $this->itemResponse($shingle_type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreShingleTypeRequest $request
     * @return Response
     *
     *
     *
     * @OA\Post(
     *      path="/api/v1/shingle_types",
     *      operationId="storeShingleType",
     *      tags={"shingle_types"},
     *      summary="Adds a shingle_type",
     *      description="Adds an shingle_type to a company",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the saved shingle_type object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleType"),
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
    public function store(StoreShingleTypeRequest $request)
    {
        $shingle_type = ShingleTypeFactory::create();
        $shingle_type->fill($request->all());
        $shingle_type->saveQuietly();

        event('eloquent.created: App\Models\ShingleType', $shingle_type);

        return $this->itemResponse($shingle_type->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyShingleTypeRequest $request
     * @param ShingleType $shingle_type
     * @return Response
     *
     *
     * @throws \Exception
     * @OA\Delete(
     *      path="/api/v1/shingle_types/{id}",
     *      operationId="deleteShingleType",
     *      tags={"shingle_types"},
     *      summary="Deletes a shingle_type",
     *      description="Handles the deletion of a shingle_type by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ShingleType Hashed ID",
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
    public function destroy(DestroyShingleTypeRequest $request, ShingleType $shingle_type)
    {
        //may not need these destroy routes as we are using actions to 'archive/delete'
        $shingle_type->delete();
        $shingle_type->save();

        return $this->itemResponse($shingle_type->fresh());
    }

    /**
     * Perform bulk actions on the list view.
     *
     * @return Response
     *
     *
     * @OA\Post(
     *      path="/api/v1/shingle_types/bulk",
     *      operationId="bulkShingleTypes",
     *      tags={"shingle_types"},
     *      summary="Performs bulk actions on an array of shingle_types",
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
     *          description="The ShingleType User response",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleType"),
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

        $shingle_types = ShingleType::withTrashed()->find($this->transformKeys($ids));

        $shingle_types->each(function ($shingle_type, $key) use ($action) {
            if (auth()->user()->can('edit', $shingle_type)) {
                $this->shingle_type_repo->{$action}($shingle_type);
            }
        });

        return $this->listResponse(ShingleType::withTrashed()->whereIn('id', $this->transformKeys($ids)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UploadProductRequest $request
     * @param Product $shingle_type
     * @return Response
     *
     *
     *
     * @OA\Put(
     *      path="/api/v1/shingle_types/{id}/upload",
     *      operationId="uploadShingleType",
     *      tags={"shingle_types"},
     *      summary="Uploads a document to a shingle_type",
     *      description="Handles the uploading of a document to a shingle_type",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ShingleType Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the ShingleType object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleType"),
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
    public function upload(UploadShingleTypeRequest $request, ShingleType $shingle_type)
    {
        if (! $this->checkFeature(Account::FEATURE_DOCUMENTS)) {
            return $this->featureFailure();
        }

        if ($request->has('documents')) {
            $this->saveDocuments($request->file('documents'), $shingle_type);
        }

        return $this->itemResponse($shingle_type->fresh());
    }
}
