@extends('layouts.app')

@section('title')サイト更新履歴@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::siteUpdateHistory($site) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $site->name }}</h1>
            <p>サイトの更新履歴</p>
        </header>

        <div class="card">
            <div class="card-body">
                @foreach($updateHistories as $updateHistory)
                    @php $date = format_date2(strtotime($updateHistory->site_updated_at)); @endphp
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1"><small>{{ format_date2(strtotime($updateHistory->site_updated_at)) }}</small></p>
                            <p class="mb-0">{!! nl2br(e($updateHistory->detail)); !!}</p>
                        </div>
                        <div class="align-self-center d-flex flex-wrap">
                            <div class="align-self-center mr-3">
                                <a href="{{ route('サイト更新履歴編集', ['siteUpdateHistory' => $updateHistory->id]) }}" class="and-more mr-3"><i class="fas fa-pen"></i> 変更</a>
                            </div>
                            <form method="POST" action="{{ route('サイト更新履歴削除処理', ['siteUpdateHistory' => $updateHistory->id]) }}" class="align-self-center" onsubmit="return confirm('{{ $date }}の更新履歴を削除します。');">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger btn-sm"><small><i class="fas fa-eraser"></i> 削除</small></button>
                            </form>
                        </div>
                    </div>
                @if (!$loop->last) <hr> @endif
                @endforeach
            </div>
        </div>
        @include('common.pager', ['pager' => $updateHistories])
    </div>

@endsection
