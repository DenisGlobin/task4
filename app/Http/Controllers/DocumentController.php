<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\DocumentsResource;

class DocumentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth'])
            ->only(['createDocument', 'editDocument', 'publishDocument']);
    }

    public function index(int $page = 1, int $perPage = 20)
    {
        // whatever is the result of your query that you wish to paginate.
        $items = Document::all();
        // The total number of items. If the `$items` has all the data, you can do something like this:
        $total = count($items);
        $paginator = new LengthAwarePaginator($items, $total, $perPage, $page);

//        return response()->json($paginator, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);

        DocumentsResource::withoutWrapping();
        return (new DocumentsResource($paginator))
            ->response()
            ->header('Content-type', 'application/json')
            ->setStatusCode(200);
    }

    public function getDocument(string $id)
    {
        $document = Document::where('id', $id)->firstOrFail();
//        return response()->json($document, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);

//        DocumentResource::withoutWrapping();
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
        $document->payload = 'draft';
        $document->payload = json_encode($request->payload);
        $document->save();
        return response()->json($document, 201, ['Content-type'=> 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);
    }

    public function editDocument(Request $request, string $id)
    {
        $document = Document::findOrFail($id);
//        $document->update($request->all());
        $document->payload = json_encode($request->payload);
        $document->save();
        return response()->json($document, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);
    }

    public function publishDocument(Request $request, string $id)
    {
        //
    }
}
