@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div id="issue-container" class="panel-body">
                        <div class="total-count text-center">
                            <i class="fa fa-exclamation-circle issue-icon"></i> {{ $issues['total'] }} Open
                        </div>
                        <div class="col-xs-12 text-right">
                            <a href="{{ url('issues/create') }}" class="btn btn-success">New issue</a>
                        </div>
                        <div class="col-xs-12">
                            @foreach ($issues['issues'] as $issue)
                                <div class="issue col-xs-12">
                                    <div class="col-xs-1">
                                        <i class="fa fa-exclamation-circle issue-icon"></i>
                                    </div>
                                    <div class="summary col-xs-8 col-md-9">
                                        <a href="{{ url("issues/$issue->number") }}" class="issue-title">
                                            {!! $issue->title !!}
                                        </a>
                                        @foreach ($issue->labels as $label)
                                            <span class="issue-label" style="background-color: #{{ $label->color }}">{{ $label->name }}</span>
                                        @endforeach
                                        <div class="opened-by">
                                                #{{ $issue->number }}
                                            opened {{ \Carbon\Carbon::createFromTimestamp(strtotime($issue->created_at))->diffForHumans() }}
                                            by <span class="issue-creator">{{ $issue->user->login }}</span>
                                        </div>
                                    </div>
                                    <div class="comments col-xs-2 text-right">
                                        <span> <i class="fa fa-comment"></i> {!! $issue->comments !!}</span>
                                    </div>
                                </div>
                            @endforeach
                            <div class="pagination col-xs-12 text-center">
                                @foreach ($pagination as $page)
                                    <a class="page {{ $page == $current ? 'current' : '' }}" href="{{ url("issues?page=$page") }}">{{ $page }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
