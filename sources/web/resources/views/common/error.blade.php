@if ($errors->has($formName))
    <div class="invalid-feedback alert alert-danger">
        @foreach ($errors->get($formName) as $msg)
            {{ $msg }}
            @if (!$loop->last)
                <br>
            @endif
        @endforeach
    </div>
@endif