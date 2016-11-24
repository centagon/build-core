<a class="{{ $node->get('style', 'alert') }} button" id="delete-button" href="{{ $node->view }}" disabled data-selectable-button data-open-sidebar="{{ str_slug($node->label) }}-sidebar">
    {!! $node->label !!}
</a>

<div class="sidebar" id="{{ str_slug($node->label) }}-sidebar" data-sidebar>
    <form method="post" action="{{ $node->confirm }}">
        {{ csrf_field() }}

        <input type="hidden" name="ids" data-id-collector>
        <div class="content"></div>
    </form>
</div>