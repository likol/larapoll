@extends('larapoll::layouts.app')
@section('title')
    Polls- Remove options
@endsection
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('manage.dashboard') }}">後台首頁</a></li>
            <li><a href="{{ route('poll.index') }}">投票</a></li>
            <li class="active">移除選項</li>
        </ol>
        <div class="well col-md-8 col-md-offset-2">
            @if($errors->any())
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="POST" action=" {{ route('poll.options.remove', $poll->id) }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <!-- Question Input -->
                <div class="form-group">
                    <label>{{ $poll->question }}</label>
                    <div class="radio">
                        @foreach($poll->options as $option)
                            <label>
                                <input type="checkbox" name="options[]" value={{ $option->id }}> {{ $option->name }}
                            </label>
                            <br/>
                        @endforeach
                    </div>
                </div>
                <!-- Create Form Submit -->
                <div class="form-group">
                    <input name="Delete" type="submit" value="移除" class="btn btn-danger form-control" >
                </div>
            </form>
        </div>
    </div>
@endsection
