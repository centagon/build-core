<div class="row {{ $errors->has($node->get('name')) ? 'error' : '' }}">
    <div class="small-12 medium-6 medium-push-3">
        <label>{{ $node->get('label') }}</label>
    </div>
    <div class="small-12 medium-6 medium-push-3">

        <div class="checkboxes">
            @foreach ($node->getOptions() as $key => $value)
                <label>
                    <input type="radio"
                           name="{{ $node->get('name') }}"
                           value="{{ $key }}"
                           {{ $node->isChecked($key) ? 'checked' : '' }} />

                    {{ $value }}
                </label>
            @endforeach
        </div>

    </div>
</div>