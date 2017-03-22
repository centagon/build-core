<div class="row {{ $errors->has($node->name) ? 'error' : '' }}" for="{{ $node->name }}">
    <div class="small-12 medium-6 medium-push-3">
        <label for="f-{{ $node->name }}">
            {{ $node->label }}
        </label>
    </div>
    <div class="small-12 medium-6 medium-push-3">

        <select name="{{ $node->name }}[]" id="f-{{ $node->name }}" multiple data-placeholder="{{ $node->placeholder }}">
            @foreach ($node->getGroups() as $group)
                <option value="{{ $group->getKey() }}">{{ $group->name }}</option>
            @endforeach
        </select>

    </div>
</div>