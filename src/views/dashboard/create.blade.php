@extends('larapoll::layouts.app')
@section('title')
    Polls- Creation
@endsection
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('poll.home') }}">首頁</a></li>
            <li><a href="{{ route('poll.index') }}">投票</a></li>
            <li class="active">建立投票</li>
        </ol>
    <div class="well col-md-8 col-md-offset-2">
        <form method="POST" action=" {{ route('poll.store') }}">
            {{ csrf_field() }}
            <!-- Question Input -->
            <div class="form-group">
                <label for="question">投票主題:</label>
                <input type="text" id="question" name="question" class="form-control"/>
            </div>
            <ul class="options">
                <li>
                    <input id="option_1" type="text" name="options[0]" class="form-control"/>
                    <input id="option_2" type="text" name="options[1]" class="form-control"/>
                </li>
            </ul>
            <!-- Create Form Submit -->
            <div class="form-group">
                <input name="create" type="submit" value="建立" class="btn btn-primary form-control"/>
            </div>
        </form>
    </div>
</div>
@endsection