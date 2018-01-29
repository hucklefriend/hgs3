<div id="timeline">
@foreach ($timelines as $tl)
    <div>{{ date('Y-m-d H:i:s', intval($tl['time'])) }}</div>
    <p>{!!  $tl['text'] !!}</p>
    <hr>
@endforeach
</div>
@if ($hasNext)
    <div><button type="button" id="more_btn">さらに読み込む</button></div>
@endif


    <script>
        {{ route('マイページ') }}
        let url = '{{ route('タイムライン追加取得', ['showId' => $user->show_id]) }}';
        let moreTime = {{ $moreTime }};

        $(function (){
            $('#more_btn').click(function (){
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {time: moreTIme},
                    timeout: 3000
                }).done(function (data){
                    if (!data.hasNext) {
                        $('#more_btn').hide();
                    }

                    data.timelines.forEach(function (element, index, array){
                        let date = new Date(element.time * 1000);
                        let hour  = ( date.getHours()   < 10 ) ? '0' + date.getHours()   : date.getHours();
                        let min   = ( date.getMinutes() < 10 ) ? '0' + date.getMinutes() : date.getMinutes();
                        let sec   = ( date.getSeconds() < 10 ) ? '0' + date.getSeconds() : date.getSeconds();

                        let html = '<div>';
                        html += date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ';
                        html += hour + ':' + min + ':' + sec;
                        html += '</div>';
                        html += '<p>' + element.text + '<p>';
                        html += '<hr>';

                        $('#timeline').append(html);
                    });

                    moreTime = data.moreTime;
                });
            })
        });
    </script>
