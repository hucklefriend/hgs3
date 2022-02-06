<style>
    #soft-table th {
        width: 150px;
    }
</style>
<table class="table" id="soft-table">
    @if ($model->wasRecentlyCreated)
        <tr>
            <th>ID</th>
            <td>{{ $model->id }}</td>
        </tr>
    @endif
    <tr>
        <th>名前</th>
        <td>
            @include ('management.common.form.input', ['name' => 'name', 'options' => ['required', 'maxlength' => 200]])
        </td>
    </tr>
    <tr>
        <th>よみがな</th>
        <td>
            @include ('management.common.form.input', ['name' => 'phonetic', 'options' => ['required', 'maxlength' => 200]])
        </td>
    </tr>
    <tr>
        <th>よみがな(ソート用)</th>
        <td>
            @include ('management.common.form.input', ['name' => 'phonetic2', 'options' => ['required', 'maxlength' => 250]])
        </td>
    </tr>
    <tr>
        <th>ジャンル</th>
        <td>
            @include ('management.common.form.input', ['name' => 'genre', 'options' => ['required', 'maxlength' => 150]])
        </td>
    </tr>
    <tr>
        <th>シリーズ</th>
        <td>
            @include ('management.common.form.select', ['name' => 'series_id', 'list' => $series])
        </td>
    </tr>
    <tr>
        <th>フランチャイズ</th>
        <td>
            @include ('management.common.form.select', ['name' => 'franchise_id', 'list' => $franchises])
        </td>
    </tr>
    <tr>
        <th>あらすじ</th>
        <td><textarea class="form-control{{ invalid($errors, 'introduction') }}" id="introduction" name="introduction" rows="10">{{ old('introduction') }}</textarea></td>
    </tr>
    <tr>
        <th>あらすじの引用元</th>
        <td><input type="text" class="form-control{{ invalid($errors, 'introduction_from') }}" id="introduction_from" name="introduction_from" value="{{ old('introduction_from', '') }}" required maxlength="150" autocomplete="off"></td>
    </tr>
</table>

@section('js')
    <script>
        let series2Franchise = {!! json_encode($series2Franchise) !!};

        $(()=>{
            $("#franchise_id").select2();
            $("#series_id").select2();


            $("#series_id").change(function (){
                let seriesId = $(this).val();
                if (seriesId.length > 0) {
                    $("#franchise_id").val(series2Franchise[seriesId]);
                }
            });
        });
    </script>
@endsection
