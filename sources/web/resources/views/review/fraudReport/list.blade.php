@extends('layouts.app')

@section('content')

    <section>
        <div class="d-flex align-items-stretch">
            <div class="p-2 align-self-center">
                <div class="review-point-outline">
                    <p class="review-point">{{ $review->point }}</p>
                </div>
            </div>
            <div class="p-12 align-self-center">
                @if($review->is_spoiler == 1) <span class="badge badge-pill badge-danger">ネタバレあり！</span> @endif
                <div class="break-word" style="width: 100%;">
                    <h5>
                        <a href="{{ url2('review/detail') }}/{{ $review->id }}">{{ $review->title }}</a>
                    </h5>
                </div>
                <div>
                    <i class="far fa-user"></i><a href="{{ url2('user/profile') }}/{{ $writer->id }}">{{ $writer->name }}</a>
                    {{ $review->post_at }}
                </div>
            </div>
        </div>
    </section>


    <br>


    <table class="table table-responsive">
        <tr>
            <th>報告日時</th>
            <th>内容</th>
            <th>対応状況</th>
            <th></th>
        </tr>

    @foreach ($list as $r)
        <tr>
            <td>{{ $r->created_at }}</td>
            <td>
                @if ($r->types == 0)
                    その他
                @else
                    @for ($i = 0; $i < 4; $i++)
                        @if ($i == 0 && $r->types % 10 == 1)
                            ネタバレがあるのに、「ネタバレあり」の表示がない<br>
                        @elseif (($r->types / (10 ** $i)) % 10 == 1)
                            @switch ($i)
                                @case(1)
                                暴言や他のレビューへの批判など、不快になることが書かれている<br>
                                @break
                                @case (2)
                                違うゲームの内容が書かれている
                                @break
                                @case (3)
                                一部または全てに嘘の内容が書かれている
                                @break
                            @endswitch
                        @endif
                    @endfor
                @endif
            </td>
            <td>
                {{ \Hgs3\Constants\Review\FraudReport\Status::getText($r->status) }}
            </td>
            <td></td>
        </tr>
    @endforeach

    </table>

    {{ $list->links() }}

@endsection