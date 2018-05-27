<div class="card">
    <div class="card-body">
        <div id="timeline">
            @foreach ($timelines as $tl)
                <p class="mb-4">
                    {{ format_date($tl['time']) }}<br>
                    {!!  $tl['text'] !!}
                </p>
                <hr>
            @endforeach
        </div>
@if ($hasNext)
        <div class="text-center">
            <button type="button" class="btn btn-outline-light" id="more_btn">さらに読み込む</button>
        </div>
@endif
    </div>
</div>
<script>
    let moreTime = {{ $moreTime }};
    let nowLoading = false;

    $(function (){


        $('#more_btn').click(function (){
            if (nowLoading) {
                return false;
            }

            $.ajax({
                type: "GET",
                url: '{{ route('タイムライン追加取得', ['showId' => $user->show_id]) }}',
                data: {time: moreTime},
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
