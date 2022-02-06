<style>
    #series-table th {
        width: 150px;
    }
</style>
<table class="table" id="series-table">
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
        <th>フランチャイズ</th>
        <td>
            @include ('management.common.form.select', ['name' => 'franchise_id', 'list' => $franchises])
        </td>
    </tr>
</table>

@section('js')
    <script>
        $(()=>{
            $("#franchise_id").select2();
        });
    </script>
@endsection
