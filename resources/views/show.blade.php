@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Document</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('errors'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('errors') }}
                            </div>
                        @endif

                        <p>Id: {{ $document->id }}</p>
                        <p>Status: {{ $document->status }}</p>
                        <p>Payload: {{ $document->payload }}</p>
                        <p>Created at: {{ $document->created_at }}</p>
                        <p>Modify at: {{ $document->modify_at }}</p>
                        <p>Owner: {{ $document->user->name }}</p>

                        <br>
                        @can('update', $document)
                            <a href="{{ route('documents.edit', ['id' => $document->id]) }}">Edit</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection