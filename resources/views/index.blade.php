@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Documents</div>

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

                        @foreach($documents as $document)
                            @can('view', $document)
                                <p>
                                    Document #: <a href="{{ route('documents.show', ['id' => $document->id]) }}">{{ $document->id }}</a>
                                </p>
                                <p>Created at: {{ $document->created_at }}</p>
                                <p>Modify at: {{ $document->modify_at }}</p>
                                @can('update', $document)
                                    <a href="{{ route('documents.edit', ['id' => $document->id]) }}">Edit</a>
                                @endcan
                                <br><hr>
                            @endcan
                        @endforeach
                        <br>
                        {{ $documents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
