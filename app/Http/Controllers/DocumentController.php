<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\DocumentsResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Library\JsonPatcher;

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
            ->only(['createDocument', 'editDocument', 'publishDocument']);
    }

    public function index(int $page = 1, int $perPage = 20)
    {
        // whatever is the result of your query that you wish to paginate.
        $items = Document::all();
        // The total number of items. If the `$items` has all the data, you can do something like this:
        $total = count($items);
        $paginator = new LengthAwarePaginator($items, $total, $perPage, $page);

        DocumentsResource::withoutWrapping();
        return (new DocumentsResource($paginator))
            ->response()
            ->header('Content-type', 'application/json')
            ->setStatusCode(200);
    }

    public function getDocument(string $id)
    {
        $document = Document::where('id', $id)->firstOrFail();

        DocumentResource::wrap('document');
        return (new DocumentResource($document))
            ->response()
            ->setEncodingOptions(JSON_PRETTY_PRINT)
            ->header('Content-type', 'application/json')
            ->setStatusCode(200);
    }

    public function createDocument(Request $request)
    {
        $user = Auth::guard('api')->user();
//        $this->authorize('create', Document::class);
        if ($user->can('create', Document::class)) {
            // The current user can create document...
            $document = new Document;
            $document->status = 'draft';
            $document->payload = json_encode($request->payload);
            $document->user_id = $user->id();
            $document->save();

            return response()->json($document, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);
        } else {
            return response()->json(['error' => 'Not Authorized.'], 401, ['Content-type' => 'application/json; charset=utf-8']);
        }
    }

    public function editDocument(Request $request, string $id)
    {
        $document = Document::findOrFail($id);
        $user = Auth::guard('api')->user();

//        $this->authorize('update', $document);
        if ($user->can('update', $document)) {
            // The current user can update the document...
            $targetDocument = json_decode($document->payload);
            $patchDocument = collect($request->payload);
            $patchedPayload = (new JsonPatcher())->patch($targetDocument, $patchDocument);
            $document->payload = json_encode($patchedPayload);
            $document->save();

            return response()->json($document, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);
        }
    }

    public function publishDocument(Request $request, string $id)
    {
        $document = Document::findOrFail($id);
        $user = Auth::guard('api')->user();

//        $this->authorize('publish', $document);
        if ($user->can('publish', $document)) {
            $document->status = 'published';
            $document->save();

            return response()->json($document, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);
        }
    }
}
