<template>

    <div>
        <div class="row">

            <div class="small-12 medium-4 large-3">
                <div class="panel panel__sidebar">

                    <h3 class="panel__sidebar__title">File name</h3>

                    <input type="search" placeholder="Filter by filename" v-model="query">

                    <hr>

                    <h3 class="panel__sidebar__title">Asset Group</h3>

                    <label v-for="group in groups">
                        <input type="checkbox" v-bind:value="group.id" v-model="checkedGroups">
                        <span class="tag" v-bind:style="{ background: group.color }"></span>
                        {{ group.name }}
                    </label>

                    <hr>

                    <h3 class="panel__sidebar__title">Website</h3>

                    <label v-for="website in websites">
                        <input type="checkbox" v-bind:value="website.id" v-model="checkedWebsites">
                        {{ website.name }}
                    </label>

                </div>
            </div>

            <div class="small-12 medium-8 large-9">
                <div class="panel" v-if="rows.length == 0">
                    No results
                </div>

                <div class="row">

                    <div class="small-6 large-3" v-for="asset in rows">
                        <div class="panel panel__preview">
                            <div class="preview__image" v-bind:style="{ 'background-image': 'url(' + asset.preview_url + ')' }" v-on:click="show(asset.id)"></div>
                            <input type="checkbox" v-bind:value="asset.id" v-model="checkedAssets" class="selectable-item">
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="floating-action-bar" v-if="checkedAssets.length && rows.length">
            <div class="row">
                <div class="small-12 medium-9 medium-push-3">
                    <button class="button button--error" v-on:click="removeSelection">
                        Remove {{ checkedAssets.length }} item{{ checkedAssets.length > 1 ? 's' : '' }}
                    </button>
                </div>
            </div>
        </div>

        <remove-sidebar v-bind:visible="false"></remove-sidebar>
        <show-sidebar v-bind:visible="false"></show-sidebar>
    </div>

</template>

<script>

    import RemoveSidebar from './RemoveSidebar.vue';
    import ShowSidebar from './ShowSidebar.vue';

    export default {

        components: {
            'remove-sidebar': RemoveSidebar,
            'show-sidebar': ShowSidebar
        },

        data: function () {
            return {
                assets: [],
                groups: [],
                websites: [],
                query: '',

                checkedAssets: [],
                checkedGroups: [],
                checkedWebsites: []
            }
        },

        computed: {

            rows: function () {
                let assets = this.assets;
                let groups = this.checkedGroups;
                let websites = this.checkedWebsites;
                let query = this.query.toLowerCase();

                this.checkedAssets = [];

                if (query) {
                    assets = assets.filter(asset => {
                        return asset.filename.toLowerCase().indexOf(query) > -1;
                    });
                }

                if (groups.length) {
                    assets = assets.filter(asset => {
                        return asset.groups.filter(group => groups.indexOf(group.id) > -1).length > 0;
                    });
                }

                if (websites.length) {
                    assets = assets.filter(asset => {
                        return asset.websites.filter(website => websites.indexOf(website.id) > -1).length > 0;
                    });
                }

                return assets;
            }

        },

        /*
         * Once the component is mounted, we'll need to prepare
         * the component by calling several async routes.
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {

            /*
             * Prepare the component by fetching the
             * assets, groups and websites.
             */
            prepareComponent() {
                this.fetchAssets();

                this.fetchGroups();

                this.fetchWebsites();
            },

            /*
             * Fetch the assets.
             */
            fetchAssets() {
                this.$http.get(config.base_url + '/async/assets')
                    .then(response => {
                        this.assets = response.data;
                    });
            },

            /*
             * Fetch the groups.
             */
            fetchGroups() {
                this.$http.get(config.base_url + '/async/assets/fetch-groups')
                    .then(response => {
                        this.groups = response.data;
                    });
            },

            /*
             * Fetch the websites.
             */
            fetchWebsites() {
                this.$http.get(config.base_url + '/async/assets/fetch-websites')
                    .then(response => {
                        this.websites = response.data;
                    });
            },

            /*
             * Open the sidebar and show the selected item.
             */
            show(id) {
                let selected = null;

                for (let asset in this.assets) {
                    if (this.assets[asset].id == id) {
                        selected = this.assets[asset];
                    }
                }

                this.$root.$emit('asset-show', { asset: selected, groups: this.groups });
            },

            /*
             * Remove the selected items.
             */
            removeSelection() {
                for (let checkedKey in this.checkedAssets) {
                    let checkedAssetId = this.checkedAssets[checkedKey];

                    for (let asset in this.assets) {
                        if (this.assets[asset].id == checkedAssetId) {
                            this.removeAsset(asset);
                        }
                    }
                }

                this.checkedAssets = [];
            },

            removeAsset(key) {
                this.assets.splice(key, 1);
            }

        }

    }

</script>