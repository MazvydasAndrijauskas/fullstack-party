@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div id="issue-details" class="panel-body">
                        <div class="col-xs-12">
                            <a class="back-to-issues" href="{{ url('issues') }}"> <i class="fa fa-arrow-left"></i> Back to issues</a>
                            @include('issues._errors')
                            <div class="col-xs-12 text-right">
                                @if ($issue->user->login == Auth::user()->name)
                                    <a href="{{ url("issues/$issue->number/edit") }}" class="btn btn-default">Edit</a>
                                @endif
                                <a href="{{ url("issues/create") }}" class="btn btn-success">Create</a>
                            </div>
                            <div class="summary col-xs-12">
                                <div class="info col-xs-12">
                                    <span class="issue-title">
                                        {!! $issue->title !!}
                                    </span>
                                    <span class="number"> #{{ $issue->number }}</span>
                                    <div class="status">
                                        <span class="state">
                                            <i class="fa fa-exclamation-circle"></i> {{ $issue->state }}
                                        </span>
                                        <span class="issue-creator">{{ $issue->user->login }}</span>
                                        opened this
                                        issue {{ \Carbon\Carbon::createFromTimestamp(strtotime($issue->created_at))->diffForHumans() }}
                                        <span> - {{ $issue->comments }} comment(s)</span>
                                    </div>
                                </div>
                            </div>
                            @if (!empty($issue->body))
                                <div class="comment col-xs-12">
                                    <div class="info">
                                        <span class="issue-creator">{{ $issue->user->login }}</span>
                                        commented {{ \Carbon\Carbon::createFromTimestamp(strtotime($issue->created_at))->diffForHumans() }}
                                    </div>
                                    <div class="body">
                                        {!! nl2br($issue->body) !!}
                                    </div>
                                </div>
                            @endif
                            @foreach ($comments as $comment)
                                <div class="comment col-xs-12">
                                    <div class="info">
                                        <span class="issue-creator">{{ $comment->user->login }}</span>
                                        commented {{ \Carbon\Carbon::createFromTimestamp(strtotime($comment->created_at))->diffForHumans() }}
                                    </div>
                                    <div class="body">
                                        {!! nl2br($comment->body) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
