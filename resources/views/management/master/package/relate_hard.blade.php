@extends('layouts.management')

@section('title', 'ハード紐づけ')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ') . session('search_package') }}">パッケージ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ詳細', $package) }}">詳細</a></li>
        <li class="breadcrumb-item active">ハード紐づけ</li>
    </ol>
    <h1 class="page-header">ハード紐づけ</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $package->name }}({{ $package->acronym }})</h4>
        </div>

        <div>
            <input type="text" id="search" class="form-control">
        </div>


        <form method="POST" action="{{ route('管理-マスター-パッケージハード紐づけ処理', $package) }}">
            {{ csrf_field() }}

            <div class="panel-body">
                <ul class="list-group">
                @foreach ($hards as $hard)
                    <li class="list-group-item" data-name="{{ $hard->name }}">
                        <div class="form-check">
                            {{ Form::checkbox('hard_id[]', $hard->id, $relatedHards->has($hard->id), ['id' => 'soft_' . $hard->id, 'class' => 'form-check-input']) }}
                            <label class="form-check-label" for="soft_{{ $hard->id }}">{{ $hard->name }}</label>
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
            <div class="panel-footer text-end">
                <button type="submit" class="btn btn-default">紐づけ</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $(()=>{
            const $search = $('#search');
            const $listItems = $('.list-group-item');

            $search.change(()=>{
                let pattern  = $search.val();

                if (pattern.length === 0) {
                    $listItems.show();
                } else {
                    $listItems.each((index, element) => {
                        let $e = $(element);
                        if ($e.data('name').indexOf(pattern) > -1) {
                            $e.show();
                        } else {
                            $e.hide();
                        }
                    });
                }
            });
        });
    </script>
@endsection
