@extends('layouts.app-modal')

@section('content')

@endsection

@section('javascript')
    <script>
        var modal = {{ $modal?$modal:'' }};

        $(function() {
            if (modal == 2) {
                window.parent.$('#iframeSchedule').modal('hide');
            }
        });
    </script>
@endsection

