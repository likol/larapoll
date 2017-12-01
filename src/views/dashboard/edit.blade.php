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
                    <label for="question">投票主題:</label>
                    <input type="text" id="question" name="question" class="form-control" value="{{ $poll->question }}"/>
                </div>

                @foreach($poll->options as $key=>$option)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="option_{{ $option->id }}">選項 {{ $key+1 }}:</label>
                                <input id="option_{{ $option->id }}" type="text" name="options[{{ $option->id }}]" class="form-control" value="{{ $option->name }}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="votes_{{ $option->id }}">選項 {{ $key+1 }} 投票基數:</label>
                                <input id="votes_{{ $option->id }}" type="text" name="votes[{{ $option->id }}]" class="form-control" value="{{ $option->votes }}"/>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="form-group">
                    <label for="description">投票描述:</label>
                    <textarea name="description" class="form-control" rows="3">{{ $poll->description }}</textarea>
                </div>

                @php
                    $maxCheck = $poll->maxCheck;
                    $count_options = $poll->optionsNumber()
                @endphp
                <div class="form-group">
                    <label for="count_check">最多選擇數量</label>
                    <select name="count_check" class="form-control">
                        @for($i =1; $i<= $count_options; $i++)
                            <option  {{ $i==$maxCheck? 'selected':'' }} >{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="start_at">投票起始時間:</label>
                            <input id="start_at" type="text" name="start_at" class="form-control flatpickr" value="{{ $poll->start_at }}" />
                        </div>
                        <div class="col-md-6">
                            <label for="send_at">投票結束時間:</label>
                            <input id="end_at" type="text" name="end_at" class="form-control flatpickr" value="{{ $poll->end_at }}" />
                        </div>
                    </div>
                </div>

                <!-- Create Form Submit -->
                <div class="form-group">
                    <input name="update" type="submit" value="更新" class="btn btn-primary form-control"/>
                </div>
            </form>
        </div>
    </div>
@endsection