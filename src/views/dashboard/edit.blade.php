@extends('larapoll::layouts.app')
@section('title')
    投票管理： 編輯
@endsection
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('manage.dashboard') }}">後台首頁</a></li>
            <li><a href="{{ route('poll.index') }}">投票</a></li>
            <li class="active">編輯投票</li>
        </ol>
        <div class="well col-md-8 col-md-offset-2">
            <form method="POST" action=" {{ route('poll.update', $poll->id) }}">
                {{ csrf_field() }}
                <!-- Question Input -->
                <div class="form-group">
                    <label>{{ $poll->question }}</label>
                </div>
                <ul class="options">
                    @foreach($poll->options as $option)
                        <li>{{ $option->name }}</li>
                    @endforeach
                </ul>
                <div class="form-group">
                    <label>{{ $poll->description }}</label>
                </div>

                @php
                    $maxCheck = $poll->maxCheck;
                    $count_options = $poll->optionsNumber()
                @endphp
                <label for="count_check">最多選擇數量</label>
                <select name="count_check" class="form-control">
                    @for($i =1; $i<= $count_options; $i++)
                        <option  {{ $i==$maxCheck? 'selected':'' }} >{{ $i }}</option>
                    @endfor
                </select>

                <div class="radio">
                    <label>
                        <input type="checkbox" name="close" {{ $poll->isLocked()? 'checked':'' }}> 關閉投票
                    </label>
                </div>

                <!-- Create Form Submit -->
                <div class="form-group">
                    <input name="update" type="submit" value="更新" class="btn btn-primary form-control"/>
                </div>
            </form>
        </div>
    </div>
@endsection