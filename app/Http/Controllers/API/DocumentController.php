<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Document;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\DocumentsResource;
use Illuminate\Support\Facades\Auth;
use App\Library\JsonPatcher;
use App\Http\Requests\StoreDocument;
use App\Http\Requests\UpdateDocument;

class DocumentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:api'])
            ->only(['store', 'update', 'publish']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @param int $perPage
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $page = 1, int $perPage = 20)
    {
        $userId = isset(auth()->user()->id) ? auth()->user()->id : null;
        // whatever is the result of your query that you wish to paginate.
        $items = Document::where('status', 'published')
            ->orWhere('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();
        // The total number of items. If the `$items` has all the data, you can do something like this:
        $total = count($items);
        $paginator = new LengthAwarePaginator($items, $total, $perPage, $page);

        DocumentsResource::withoutWrapping();
        return (new DocumentsResource($paginator))
            ->response()
            ->header('Content-type', 'application/json')
            ->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $document = Document::where('id', $id)->firstOrFail();
        $user = Auth::guard('api')->user();
        $user = !is_null($user) ? $user : new User;

        if ($user->can('view', $document)) {
            // The current user can view this document...
            DocumentResource::wrap('document');
            return (new DocumentResource($document))
                ->response()
                ->setEncodingOptions(JSON_PRETTY_PRINT)
                ->header('Content-type', 'application/json')
                ->setStatusCode(200);
        } else {
            return response()->json(['error' => 'Not Authorized.'], 401, ['Content-type' => 'application/json; charset=utf-8']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDocument $request)
    {
        $user = Auth::guard('api')->user();

        $document = new Document;
        $document->status = 'draft';
        $document->payload = json_encode($request->payload);
        $document->user_id = $user->id;
        $document->save();

        return response()->json($document, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDocument $request, string $id)
    {
        $document = Document::findOrFail($id);

        $targetDocument = json_decode($document->payload);
        $patchDocument = json_decode($request->payload);
        $patchedPayload = (new JsonPatcher())->patch($targetDocument, $patchDocument);
        $document->payload = json_encode($patchedPayload);
        $document->save();

        return response()->json($document, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);
    }

    /**
     * Publish the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish(string $id)
    {
        $document = Document::findOrFail($id);
        $user = Auth::guard('api')->user();

        if ($user->can('publish', $document)) {
            $document->status = 'published';
            $document->save();

            return response()->json($document, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);
        }
    }
}
