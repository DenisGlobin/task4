@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body" id="documents">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{--@foreach($docs as $doc)--}}
                            {{--<a href="{{ route('get.document', ['id' => $doc->id]) }}">Document #{{ $doc->id }}</a>--}}
                        {{--@endforeach--}}
                        {{--<br>--}}
                        {{--{{ $docs->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var docs = @json($docs);
        console.log(docs);
        var data = docs.data;
        // docs.data.forEach(function (doc) {
        //    console.log(doc);
        // });
        for (let i=0; i < data.length; i++) {
            console.log(docs.data[i]);
        }
        //$("div#documents").append($(''));
    </script>
@endsection