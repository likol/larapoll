@extends('larapoll::layouts.app')
@section('title')
    投票管理： 列表
@endsection
@section('style')
    <style>
        .table td, .table th {
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('manage.dashboard') }}">後台首頁</a></li>
            <li class="active">投票</li>
        </ol>
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($polls->count() >= 1)
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>投票主題</th>
                    <th>選項數</th>
                    <th>投票數</th>
                    <th>狀態</th>
                    <th>編輯</th>
                    <th>新增選項</th>
                    <th>移除選項</th>
                    <th>移除投票</th>
                    <th>關閉/開放投票</th>
                    <th>觀看投票會員</th>
                </tr>
                </thead>
                <tbody>
                @foreach($polls as $poll)
                    <tr>
                        <th scope="row">{{ $poll->id }}</th>
                        <td>{{ $poll->question }}</td>
                        <td>{{ $poll->options_count }}</td>
                        <td>{{ $poll->votes_count }}</td>
                        <td>
                            @if($poll->isLocked())
                                <span class="label label-danger">關閉</span>
                            @else
                                <span class="label label-success">開放</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('poll.edit', $poll->id) }}">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-success btn-sm" href="{{ route('poll.options.push', $poll->id) }}">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('poll.options.remove', $poll->id) }}">
                                <i class="fa fa-minus-circle" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('poll.remove', $poll->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            @php $route = $poll->isLocked()? 'poll.unlock': 'poll.lock' @endphp
                            @php $fa = $poll->isLocked()? 'fa fa-unlock': 'fa fa-lock' @endphp
                            <form action="{{ route($route, $poll->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <button type="submit" class="btn btn-sm">
                                    <i class="{{ $fa }}" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                        <td><a class="btn btn-info btn-sm" href="{{ route('poll.view', $poll->id) }}">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <smal>No poll has been found. Try to add one <a href="{{ route('poll.create') }}">Now</a></smal>
        @endif
        {{ $polls->links() }}
    </div>
@endsection