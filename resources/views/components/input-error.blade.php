@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => '']) }}>
        @foreach ((array) $messages as $message)
            <small class="error form-text text-danger">
                {{ $message }}
            </small>
        @endforeach
    </div>
@endif
