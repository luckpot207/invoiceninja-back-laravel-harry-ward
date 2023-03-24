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

use App\Factory\ShingleTypeColorFactory;
use App\Filters\ShingleTypeColorFilters;
use App\Http\Requests\ShingleTypeColor\CreateShingleTypeColorRequest;
use App\Http\Requests\ShingleTypeColor\DestroyShingleTypeColorRequest;
use App\Http\Requests\ShingleTypeColor\EditShingleTypeColorRequest;
use App\Http\Requests\ShingleTypeColor\ShowShingleTypeColorRequest;
use App\Http\Requests\ShingleTypeColor\StoreShingleTypeColorRequest;
use App\Http\Requests\ShingleTypeColor\UpdateShingleTypeColorRequest;
use App\Http\Requests\ShingleTypeColor\UploadShingleTypeColorRequest;
use App\Models\Account;
use App\Models\ShingleTypeColor;
use App\Repositories\ShingleTypeColorRepository;
use App\Transformers\ShingleTypeColorTransformer;
use App\Utils\Traits\GeneratesCounter;
use App\Utils\Traits\MakesHash;
use App\Utils\Traits\SavesDocuments;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Class ShingleTypeColorController.
 */
class ShingleTypeColorController extends BaseController
{
    use MakesHash;
    use SavesDocuments;
    use GeneratesCounter;

    protected $entity_type = ShingleTypeColor::class;

    protected $entity_transformer = ShingleTypeColorTransformer::class;

    protected $shingle_type_color_repo;

    /**
     * ShingleTypeColorController constructor.
     * @param ShingleTypeColorRepository $shingle_type_color_repo
     */
    public function __construct(ShingleTypeColorRepository $shingle_type_color_repo)
    {
        parent::__construct();

        $this->shingle_type_color_repo = $shingle_type_color_repo;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/shingle_colors",
     *      operationId="getShingleTypeColors",
     *      tags={"shingle_type_colors"},
     *      summary="Gets a list of shingle_type_colors",
     *      description="Lists shingle_type_colors",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(ref="#/components/parameters/index"),
     *      @OA\Response(
     *          response=200,
     *          description="A list of shingle_type_colors",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleTypeColor"),
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
     * @param ShingleTypeColorFilters $filters
     * @return Response|mixed
     */
    public function index(ShingleTypeColorFilters $filters)
    {
        $shingle_type_colors = ShingleTypeColor::filter($filters);

        $result = ShingleTypeColor::select('id', 'name')->get();
        $result = [
            "data" => $result
        ];

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param ShowShingleTypeColorRequest $request
     * @param ShingleTypeColor $shingle_type_color
     * @return Response
     *
     *
     * @OA\Get(
     *      path="/api/v1/shingle_type_colors/{id}",
     *      operationId="showShingleTypeColor",
     *      tags={"shingle_type_colors"},
     *      summary="Shows a shingle_type_color",
     *      description="Displays a shingle_type_color by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ShingleTypeColor Hashed ID",
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
     *          @OA\JsonContent(ref="#/components/schemas/ShingleTypeColor"),
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
    public function show(ShowShingleTypeColorRequest $request, ShingleTypeColor $shingle_type_color)
    {
        return $this->itemResponse($shingle_type_color);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EditShingleTypeColorRequest $request
     * @param ShingleTypeColor $shingle_type_color
     * @return Response
     *
     *
     * @OA\Get(
     *      path="/api/v1/shingle_type_colors/{id}/edit",
     *      operationId="editShingleTypeColor",
     *      tags={"shingle_type_colors"},
     *      summary="Shows a shingle_type_color for editting",
     *      description="Displays a shingle_type_color by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ShingleTypeColor Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the shingle_type_color object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleTypeColor"),
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
    public function edit(EditShingleTypeColorRequest $request, ShingleTypeColor $shingle_type_color)
    {
        return $this->itemResponse($shingle_type_color);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateShingleTypeColorRequest $request
     * @param ShingleTypeColor $shingle_type_color
     * @return Response
     *
     *
     *
     * @OA\Put(
     *      path="/api/v1/shingle_type_colors/{id}",
     *      operationId="updateShingleTypeColor",
     *      tags={"shingle_type_colors"},
     *      summary="Updates a shingle_type_color",
     *      description="Handles the updating of a shingle_type_color by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ShingleTypeColor Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the shingle_type_color object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleTypeColor"),
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
    public function update(UpdateShingleTypeColorRequest $request, ShingleTypeColor $shingle_type_color)
    {
        if ($request->entityIsDeleted($shingle_type_color)) {
            return $request->disallowUpdate();
        }

        $shingle_type_color->fill($request->all());
        $shingle_type_color->number = empty($shingle_type_color->number) ? $this->getNextShingleTypeColorNumber($shingle_type_color) : $shingle_type_color->number;
        $shingle_type_color->saveQuietly();

        if ($request->has('documents')) {
            $this->saveDocuments($request->input('documents'), $shingle_type_color);
        }

        event('eloquent.updated: App\Models\ShingleTypeColor', $shingle_type_color);

        return $this->itemResponse($shingle_type_color->fresh());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateShingleTypeColorRequest $request
     * @return Response
     *
     *
     *
     * @OA\Get(
     *      path="/api/v1/shingle_type_colors/create",
     *      operationId="getShingleTypeColorsCreate",
     *      tags={"shingle_type_colors"},
     *      summary="Gets a new blank shingle_type_color object",
     *      description="Returns a blank object with default values",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Response(
     *          response=200,
     *          description="A blank shingle_type_color object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleTypeColor"),
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
    public function create(CreateShingleTypeColorRequest $request)
    {
        $shingle_type_color = ShingleTypeColorFactory::create();

        return $this->itemResponse($shingle_type_color);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreShingleTypeColorRequest $request
     * @return Response
     *
     *
     *
     * @OA\Post(
     *      path="/api/v1/shingle_type_colors",
     *      operationId="storeShingleTypeColor",
     *      tags={"shingle_type_colors"},
     *      summary="Adds a shingle_type_color",
     *      description="Adds an shingle_type_color to a company",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the saved shingle_type_color object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleTypeColor"),
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
    public function store(StoreShingleTypeColorRequest $request)
    {
        $shingle_type_color = ShingleTypeColorFactory::create();
        $shingle_type_color->fill($request->all());
        $shingle_type_color->saveQuietly();

        event('eloquent.created: App\Models\ShingleTypeColor', $shingle_type_color);

        return $this->itemResponse($shingle_type_color->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyShingleTypeColorRequest $request
     * @param ShingleTypeColor $shingle_type_color
     * @return Response
     *
     *
     * @throws \Exception
     * @OA\Delete(
     *      path="/api/v1/shingle_type_colors/{id}",
     *      operationId="deleteShingleTypeColor",
     *      tags={"shingle_type_colors"},
     *      summary="Deletes a shingle_type_color",
     *      description="Handles the deletion of a shingle_type_color by id",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ShingleTypeColor Hashed ID",
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
    public function destroy(DestroyShingleTypeColorRequest $request, ShingleTypeColor $shingle_type_color)
    {
        //may not need these destroy routes as we are using actions to 'archive/delete'
        $shingle_type_color->delete();
        $shingle_type_color->save();

        return $this->itemResponse($shingle_type_color->fresh());
    }

    /**
     * Perform bulk actions on the list view.
     *
     * @return Response
     *
     *
     * @OA\Post(
     *      path="/api/v1/shingle_type_colors/bulk",
     *      operationId="bulkShingleTypeColors",
     *      tags={"shingle_type_colors"},
     *      summary="Performs bulk actions on an array of shingle_type_colors",
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
     *          description="The ShingleTypeColor User response",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleTypeColor"),
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

        $shingle_type_colors = ShingleTypeColor::withTrashed()->find($this->transformKeys($ids));

        $shingle_type_colors->each(function ($shingle_type_color, $key) use ($action) {
            if (auth()->user()->can('edit', $shingle_type_color)) {
                $this->shingle_type_color_repo->{$action}($shingle_type_color);
            }
        });

        return $this->listResponse(ShingleTypeColor::withTrashed()->whereIn('id', $this->transformKeys($ids)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UploadProductRequest $request
     * @param Product $shingle_type_color
     * @return Response
     *
     *
     *
     * @OA\Put(
     *      path="/api/v1/shingle_type_colors/{id}/upload",
     *      operationId="uploadShingleTypeColor",
     *      tags={"shingle_type_colors"},
     *      summary="Uploads a document to a shingle_type_color",
     *      description="Handles the uploading of a document to a shingle_type_color",
     *      @OA\Parameter(ref="#/components/parameters/X-API-TOKEN"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ShingleTypeColor Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the ShingleTypeColor object",
     *          @OA\Header(header="X-MINIMUM-CLIENT-VERSION", ref="#/components/headers/X-MINIMUM-CLIENT-VERSION"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/ShingleTypeColor"),
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
    public function upload(UploadShingleTypeColorRequest $request, ShingleTypeColor $shingle_type_color)
    {
        if (! $this->checkFeature(Account::FEATURE_DOCUMENTS)) {
            return $this->featureFailure();
        }

        if ($request->has('documents')) {
            $this->saveDocuments($request->file('documents'), $shingle_type_color);
        }

        return $this->itemResponse($shingle_type_color->fresh());
    }
}
