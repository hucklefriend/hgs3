@if ($errors->has($formName))
    <div class="invalid-feedback">
        @foreach ($errors->get($formName) as $msg)
            {{ $msg }}
            @if (!$loop->last)
                <br>
            @endif
        @endforeach
    </div>
@endif