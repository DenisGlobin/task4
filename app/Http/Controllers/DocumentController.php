<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        //
    }

    public function getDocument(string $id)
    {
        //
    }

    public function createDocument(Request $request)
    {
        //
    }

    public function editDocument(Request $request, string $id)
    {
        //
    }

    public function publishDocument(Request $request, string $id)
    {
        //
    }
}
