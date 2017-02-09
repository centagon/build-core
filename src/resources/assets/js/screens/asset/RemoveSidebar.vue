<template>
    <div v-if="visible" class="sidebar sidebar--open">

        <div class="page-header">
            <div class="page-header__item">
                <h1>Remove asset</h1>
            </div>

            <div class="page-header__item">
                <div class="button-actions">
                    <button class="button" v-on:click="hide">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <h3>{{ asset.filename }}</h3>

        <div class="panel">
            <p>Are you sure you want to remove this asset? This action cannot be reverted!</p>
            <button class="button button--error" v-on:click="destroy">Yes, remove this asset!</button>
        </div>

    </div>
</template>

<script>

    export default {

        data: function () {
            return {
                visible: false,
                asset: {}
            }
        },

        mounted() {
            this.$root.$on('asset-remove', event => {
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

            destroy() {
                this.$http.post(config.base_url + '/async/asset/' + this.asset.id, { _method: 'DELETE' })
                    .then(response => {
                        window.location.reload();
                    });
            }
        }

    }

</script>
