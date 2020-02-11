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
//        dd(json_decode($document->payload, true));

        DocumentResource::wrap('document');
        return (new DocumentResource($document))
            ->response()
            ->setEncodingOptions(JSON_PRETTY_PRINT)
            ->header('Content-type', 'application/json')
            ->setStatusCode(200);
    }

    public function createDocument(Request $request)
    {
//      $document = Document::create($request->all());
        $document = new Document;
        $document->status = 'draft';
        $document->payload = json_encode($request->payload);
        $document->user_id = Auth::guard('api')->id();
        $document->save();
        return response()->json($document, 201, ['Content-type'=> 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);
    }

    public function editDocument(Request $request, string $id)
    {
//        dd(json_decode($request->payload, true, 512, JSON_OBJECT_AS_ARRAY));
        $document = Document::findOrFail($id);

        $targetDocument = json_decode($document->payload);
//        var_dump($targetDocument);
//        die();
        $patchDocument = collect($request->payload);
        $patchedPayload = (new JsonPatcher())->patch($targetDocument, $patchDocument);
        $document->payload = json_encode($patchedPayload);

//        $document->payload = json_encode($request->payload);
        $document->save();
        return response()->json($document, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);
    }

    public function publishDocument(Request $request, string $id)
    {
        //
    }
}
