<table class="table">
    @if ($model->wasRecentlyCreated)
        <tr>
            <th>ID</th>
            <td>{{ $model->id }}</td>
        </tr>
    @endif
    <tr>
        <th>名前</th>
        <td>
            @include ('management.common.form.input', ['name' => 'name', 'options' => ['required', 'maxlength' => 100]])
        </td>
    </tr>
    <tr>
        <th>よみがな</th>
        <td>
            @include ('management.common.form.input', ['name' => 'phonetic', 'options' => ['required', 'maxlength' => 100]])
        </td>
    </tr>
    <tr>
        <th>略称</th>
        <td>
            @include ('management.common.form.input', ['name' => 'acronym', 'options' => ['required', 'maxlength' => 100]])
        </td>
    </tr>
    <tr>
        <th>表示順(発売日の数値)</th>
        <td>
            @include ('management.common.form.input', ['type' => 'number', 'name' => 'sort_order', 'options' => ['required', 'min' => 0, 'max' => 99999999]])
        </td>
    </tr>
    <tr>
        <th>メーカー</th>
        <td>
            @include ('management.common.form.select', ['name' => 'maker_id', 'list' => $makers])
        </td>
    </tr>
</table>

@section('js')
    <script>
        $(()=>{
            $("#maker_id").select2();
        });
    </script>
@endsection