@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div id="issue-form" class="panel-body">
                        <div class="col-xs-12">
                            <a class="back-to-issues" href="{{ url('issues') }}"> <i class="fa fa-arrow-left"></i> Back
                                to issues</a>
                        </div>
                        @include('issues._errors')
                        <div>
                            <form method="POST" action="{{ url("issues") }}">
                                @include('issues._form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
