@include('build.core::components.layout.header')

    <div class="row">
        <div class="small-12">
            <div class="page-header">
                <div class="page-header__item">
                    <h1>Assets</h1>
                </div>

                <div class="page-header__item">
                    <div class="button-actions">
                        <a href="{{ route('admin.assets.browser.create') }}" class="button button--success">
                            New file
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="content" id="vue-wrapper">
        <asset-picker></asset-picker>
    </section>

@include('build.core::components.layout.footer')