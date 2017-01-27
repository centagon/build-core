<template>
    <div v-if="visible" class="sidebar sidebar--open">

        <div class="page-header">
            <div class="page-header__item">
                <h1>Properties</h1>
            </div>

            <div class="page-header__item">
                <div class="button-actions">
                    <button class="button button--error" v-on:click="remove">
                        Delete
                    </button>
                    <button class="button" v-on:click="hide">
                        Cancel
                    </button>
                    <button class="button button--success" disabled>
                        Save
                    </button>
                </div>
            </div>
        </div>

        <h3>{{ asset.filename }}</h3>

        <tag-select :options="groups"></tag-select>

        <div class="panel">
            <img v-bind:src="asset.preview_url" width="100%">
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

                // var data = _.map(event.groups, (group) => {
                //     return _.pick(group, 'id', 'name')
                // });
                //
                // var rows = [];
                // for (var row in data) {
                //     rows.push({
                //         id: data[row].id,
                //         text: data[row].name
                //     });
                // }
                //
                // this.groups = rows;

                this.show();
            });
        },

        data: function () {
            return {
                visible: false,
                asset: {},
                groups: {}
            }
        },

        methods: {
            hide() {
                this.asset = {};
                this.groups = {};
                this.visible = false;
            },

            show() {
                this.visible = true;
            },

            remove() {
                this.$root.$emit('asset-remove', { asset: this.asset });

                this.hide();
            }
        }

    }

</script>
