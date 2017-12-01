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
            <li><a href="{{ route('poll.index') }}">投票</a></li>
            <li class="active">參與投票列表</li>
        </ol>

        @if($votes->count() >= 1)
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>會員姓名</th>
                    <th>暱稱</th>
                    <th>性別</th>
                    <th>電子郵件</th>
                </tr>
                </thead>
                <tbody>
                @foreach($votes as $key => $vote)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $vote->user->fullName }}</td>
                        <td>{{ $vote->user->name }}</td>
                        <td>{{ $vote->user->getGenderStr() }}</td>
                        <td>{{ $vote->user->email }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <smal>還沒有會員參與投票</smal>
        @endif
    </div>
@endsection