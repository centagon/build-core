<template>
    <div v-if="visible" class="sidebar sidebar--open">

        <div class="page-header">
            <div class="page-header__item">
                <h1>Remove page</h1>
            </div>

            <div class="page-header__item">
                <div class="button-actions">
                    <button class="button" v-on:click="hide">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <h3>{{ page.filename }}</h3>

        <div class="panel">
            <p>Are you sure you want to remove this page? This action cannot be reverted!</p>
            <button class="button button--error" v-on:click="destroy">Yes, remove this page!</button>
        </div>

    </div>
</template>

<script>

    export default {

        data: function () {
            return {
                visible: false,
                page: {}
            }
        },

        mounted() {
            this.$root.$on('page-remove', event => {
                this.hide();

                this.page = event.page;

                this.show();
            });
        },

        methods: {
            show() {
                this.visible = true;
            },

            hide() {
                this.page = {};
                this.visible = false;
            },

            /**
             * Post a destroy request to the pages controller
             * and reload the current window on success. 
             */
            destroy() {
                this.$http.post(config.base_url + '/async/page/' + this.page.id, { _method: 'DELETE' })
                    .then(response => window.location.reload());
            }
        }

    }

</script>
