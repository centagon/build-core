<template>
    <div v-if="visible" class="sidebar sidebar--open">

        <div class="page-header">
            <div class="page-header__item">
                <h1>Update asset</h1>
            </div>

            <div class="page-header__item">
                <div class="button-actions">
                    <button class="button" v-on:click="hide">
                        Cancel
                    </button>
                    <button class="button" v-on:click="upload" id="upload-button">
                        {{ upload_label }}
                    </button>
                </div>
            </div>
        </div>

        <h3>{{ asset.filename }}</h3>

        <div class="panel">
            <div id="file-form" action="handler.php" method="POST">
                <input type="file" id="file-select" name="photos[]" multiple/>
            </div>
        </div>

    </div>
</template>

<script>

    export default {

        data: function () {
            return {
                visible: false,
                upload_label: 'Upload',
                asset: {}
            }
        },

        mounted() {
            this.$root.$on('asset-update', event => {
                this.hide();

                this.asset = event.asset;

                this.show();
            });
        },

        methods: {
            show() {
                this.visible = true;
            },

            hide() {
                this.asset = {};
                this.visible = false;
            },

            upload(event){
                event.preventDefault();

                let self         = this;
                let form         = document.getElementById('file-form');
                let fileSelect   = document.getElementById('file-select');

                // Update button text.
                //
                // uploadButton.innerHTML = 'Uploading...';
                this.upload_label = 'Uploading...';

                let files = fileSelect.files;
                let formData = new FormData();

                //  For Replace pick first file.
                formData.append('photos[]', files[0], files[0].name);
                formData.append('asset', JSON.stringify(this.asset));

                let asset_id = this.asset.id;
                let xhr = new XMLHttpRequest();
                xhr.open('POST', `/admin/async/assets/${asset_id}/replace`, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', config.csrf_token);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        self.upload_label = 'Upload';

                        self.$root.$emit('asset-reload',{});
                        self.hide();

                    } else {
                        self.upload_label = 'Error Uploading';
                        // uploadButton.innerHTML = 'Error';
                        alert('An error occurred!');
                    }
                };

                xhr.send(formData);

            }

            // destroy() {
            //     this.$http.post(config.base_url + '/async/asset/' + this.asset.id, { _method: 'DELETE' })
            //         .then(response => {
            //             window.location.reload();
            //         });
            // }
        }

    }

</script>
