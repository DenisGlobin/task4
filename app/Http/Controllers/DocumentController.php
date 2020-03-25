<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use Illuminate\Support\Facades\Auth;
use App\Library\JsonPatcher;
use App\Http\Requests\StoreDocument;
use App\Http\Requests\UpdateDocument;
use App\Http\Requests\PublishDocument;

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
        $documents = Document::latest()->paginate(20);
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
     * @param \App\Http\Requests\StoreDocument  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocument $request)
    {
        $user = Auth::user();

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

        $this->authorize('view', $document);
        // The current user can view the document.
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

        $this->authorize('update', $document);
        // The current user can update the document.
        return view('edit', ['document' => $document]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateDocument $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDocument $request, string $id)
    {
        $document = Document::findOrFail($id);

        $targetDocument = json_decode($document->payload);
        $patchDocument = json_decode($request->payload);
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

        $this->authorize('publish', $document);
        $document->status = 'published';
        $document->save();

        return redirect()->route('documents.index');
    }
}
