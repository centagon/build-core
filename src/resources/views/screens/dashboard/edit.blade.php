<form method="post" action="{{ route('admin.dashboard.update', $block->id) }}">
    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <style>
        form h1,
        form label {
            color: black !important;
        }
    </style>

    <div class="page-header">
        <div class="page-header__item">
            <h1 style="color: black;">Add new block</h1>
        </div>
        <div class="page-header__item">
            <div class="button-actions">
                <a href="#" class="button cancel-button">Cancel</a>
                <button class="button button--success">Save</button>
            </div>
        </div>
    </div>

    <label for="f-title">Block title</label>
    <input type="text" name="title" value="{{ $block->title }}">

    <label for="f-color">Color</label>
    <input type="hidden" id="f-color" name="color" value="{{ $block->color }}">
    <div class="row">
        @foreach ($colors as $color)
            <div class="small-1">
                <div class="panel color-panel" style="background-color: {{ $color->color }}; overflow: hidden; cursor: pointer;" data-ref="f-color" data-value="{{ $color->color }}" title="{{ $color->name }}">
                </div>
            </div>
        @endforeach
    </div>

    <label for="f-image">Image</label>
    <input type="text" id="f-image" name="image" value="{{ $block->image }}">

    <div class="row">
        <div class="small-12 medium-6">
            <label for="f-button_label">Button label</label>
            <input type="text" id="f-button_label" name="button_label" value="{{ $block->button_label }}">
        </div>
        <div class="small-12 medium-6">
            <label for="f-button_url">Button URL</label>
            <input type="text" id="f-button_url" name="button_url" value="{{ $block->button_url }}">
        </div>
    </div>

    <label for="f-content">Content</label>
    <textarea name="content" id="f-content" cols="30" rows="10">{{ $block->content }}</textarea>
</form>