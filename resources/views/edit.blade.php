@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit document</div>

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

                        <form action="{{ route('documents.update', ['id' => $document->id]) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <div class="form-group">
                                <label for="payload">Payload: </label>
                                <textarea class="form-control" id="payload" name="payload" rows="6">{{ $document->payload }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <br><hr>
                        <form action="{{ route('documents.publish', ['id' => $document->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success" data-toggle="tooltip"
                                    data-placement="top" title="Publish this document. You can't edit this document anymore."
                            >Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection