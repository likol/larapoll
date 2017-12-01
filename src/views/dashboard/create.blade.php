@extends('larapoll::layouts.app')
@section('title')
    投票管理： 建立
@endsection
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('manage.dashboard') }}">後台首頁</a></li>
            <li><a href="{{ route('poll.index') }}">投票</a></li>
            <li class="active">建立投票</li>
        </ol>
    <div class="well col-md-8 col-md-offset-2">
        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form method="POST" action=" {{ route('poll.store') }}">
            {{ csrf_field() }}
            <!-- Question Input -->
            <div class="form-group">
                <label for="question">投票主題:</label>
                <input type="text" id="question" name="question" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="option_1">選項 1:</label>
                <input id="option_1" type="text" name="options[0]" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="option_2">選項 2:</label>
                <input id="option_2" type="text" name="options[1]" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="description">投票描述:</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="start_at">投票起始時間:</label>
                        <input id="start_at" type="text" name="start_at" class="form-control flatpickr" />
                    </div>
                    <div class="col-md-6">
                        <label for="send_at">投票結束時間:</label>
                        <input id="end_at" type="text" name="end_at" class="form-control flatpickr" />
                    </div>
                </div>
            </div>

            <!-- Create Form Submit -->
            <div class="form-group">
                <input name="create" type="submit" value="建立" class="btn btn-primary form-control"/>
            </div>
        </form>
    </div>
</div>
@endsection