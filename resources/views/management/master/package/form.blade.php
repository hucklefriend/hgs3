<style>
    #platform-table th {
        width: 150px;
    }
</style>
<table class="table" id="platform-table">
    <tr>
        <th>名前</th>
        <td>
            @include ('management.common.form.input', ['name' => 'name', 'options' => ['required', 'maxlength' => 100]])
        </td>
    </tr>
    <tr>
        <th>略称</th>
        <td>
            @include ('management.common.form.input', ['name' => 'acronym', 'options' => ['required', 'maxlength' => 100]])
        </td>
    </tr>
    <tr>
        <th>メーカー</th>
        <td>
            @include ('management.common.form.select', ['name' => 'maker_id', 'list' => $makers])
        </td>
    </tr>
    <tr>
        <th>ハード</th>
        <td>
            @include ('management.common.form.select', ['name' => 'hard_id', 'list' => $hards])
        </td>
    </tr>
    <tr>
        <th>プラットフォーム</th>
        <td>
            @include ('management.common.form.select', ['name' => 'platform_id', 'list' => $platforms])
        </td>
    </tr>
    <tr>
        <th>リリース日(数値)</th>
        <td>
            @include ('management.common.form.input', ['name' => 'release_at', 'options' => ['required', 'maxlength' => 20]])
        </td>
    </tr>
    <tr>
        <th>リリース日(数値)</th>
        <td>
            @include ('management.common.form.input', ['type' => 'number', 'name' => 'release_int', 'options' => ['required', 'max' => 99999999, 'min' => 0]])
        </td>
    </tr>
    <tr>
        <th>R指定</th>
        <td>
            @include ('management.common.form.select', ['name' => 'rated_r', 'list' => \Hgs3\Enums\RatedR::selectList()])
        </td>
    </tr>
</table>

@section('js')
    <script>
        $(()=>{
            $("#maker_id").select2();
            $("#hard_id").select2();
            $("#platform_id").select2();
        });
    </script>
@endsection