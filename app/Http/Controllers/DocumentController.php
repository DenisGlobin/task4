<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware(['auth'])
            ->only(['create', 'store', 'edit', 'update', 'publish']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $documents = Document::paginate(20);
        return view('index', ['documents' => $documents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $this->authorize('create', Document::class);
        // The current user can create document...
        $document = new Document;
        $document->status = 'draft';
        $document->payload = json_encode($request->payload);
        $document->user_id = $user->id;
        $document->save();

        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id)
    {
        $document = Document::where('id', $id)->firstOrFail();
        return view('show', ['document' => $document]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(string $id)
    {
        $document = Document::where('id', $id)->firstOrFail();
        return view('edit', ['document' => $document]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);
        $user = Auth::user();

        $this->authorize('update', $document);
        // The current user can update the document...
        $targetDocument = json_decode($document->payload);
        $patchDocument = collect($request->payload);
        $patchedPayload = (new JsonPatcher())->patch($targetDocument, $patchDocument);
        $document->payload = json_encode($patchedPayload);
        $document->save();

        return redirect()->route('documents.index');
    }

    /**
     * Publish the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function publish(string $id)
    {
        $document = Document::findOrFail($id);
        $user = Auth::user();

        $this->authorize('publish', $document);
        $document->status = 'published';
        $document->save();

        return redirect()->route('documents.index');
    }
}
