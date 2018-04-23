@if ($errors->has($formName))
    <div class="invalid-feedback ml-2">
        @foreach ($errors->get($formName) as $msg)
            {{ $msg }}
            @if (!$loop->last)
                <br>
            @endif
        @endforeach
    </div>
@endif