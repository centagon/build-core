<style>
.header__label{
    position:absolute;
    width: 20%;
    padding-bottom: 1em;
}
.sidebar__actions{
    padding-bottom: 1em;
}
.sidebar .panel.img__panel
{
    text-align: center;
    background:url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAJUlEQVQoU2O8ffv2fwY0oKqqyoguxjgUFKI7GsTH5m4M3w1ChQBLoyXbEjDuswAAAABJRU5ErkJggg==');
}
.sidebar .panel img
{
    max-height: 800px;
    border: 1px solid rgba(0,0,0,0.2);
    width: auto;
}
</style>
<template>
    <div v-if="visible" class="sidebar sidebar--open">

        <div class="page-header">
            <div class="page-header__item header__label">
                <h1>Properties</h1>
            </div>

            <div class="page-header__item sidebar__actions">
                <div class="button-actions">
                    <button class="button button--error" v-on:click="remove">
                        Delete
                    </button>
                    <button class="button" v-on:click="hide">
                        Cancel
                    </button>
                    <button class="button" v-on:click="update">
                        Update
                    </button>
                    <button class="button button--success" v-on:click="save">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <h3>{{ asset.filename }}</h3>

        <tag-select :options="groups" v-model="asset.groups"></tag-select>

        <div class="panel img__panel">
            <img :src="preview_url" width="100%">
        </div>

        <dl>
            <dt>Filesize</dt>
            <dd>{{ asset.filesize.formatted }}</dd>

            <dt>Dimensions</dt>
            <dd>{{ asset.size.width }} &times; {{ asset.size.height }}</dd>

            <dt>URL</dt>
            <dd><a v-bind:href="asset.url" target="_blank">{{ asset.url }}</a></dd>
        </dl>

    </div>
</template>

<script>

    export default {

        mounted() {
            this.$root.$on('asset-show', event => {
                this.hide();

                this.groups = event.groups;
                this.asset = event.asset;

                this.show();
            });
        },

        data: function () {
            return {
                visible     : false,
                asset       : {},
                groups      : {},
                preview_url : ''
            }
        },

        methods: {

            hide() {
                this.asset = {};
                this.groups = {};
                this.visible = false;
            },

            show() {
                this.preview_url = this.asset.preview_url + '?time=' + new Date().getTime();
                this.visible = true;
            },

            update() {
                this.$root.$emit('asset-update', { asset: this.asset });

                this.hide();
            },

            remove() {
                this.$root.$emit('asset-remove', { asset: this.asset });

                this.hide();
            },

            save() {
                const asset = this.asset;

                this.$http.put(config.base_url + `/async/assets/${asset.id}`, { asset })
                    .then(response => {
                        window.location.reload();
                    });

            }
        }
    }

</script>
