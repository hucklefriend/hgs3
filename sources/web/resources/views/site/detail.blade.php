@extends('layouts.app')

@section('content')
    @verbatim
    <style>
        .card_soft {
            margin: 5px 5px;
            width: 120px;
        }
    </style>
    @endverbatim

    @include('site.common.detail')

    @if ($isWebMaster)
        <div style="margin-top: 3rem;">
            <form method="POST" action="{{ url2('/site/delete/' . $site->id) }}" onsubmit="return confirm('{{ $site->name }}を削除します。\nよろしいですか？')">
                {{ csrf_tag($csrfToken) }}
                {{ method_field('DELETE') }}

                <button class="btn btn-danger">サイトを削除する</button>
            </form>
        </div>
    @endif

@endsection