<template>

    <div class="custom-input custom-input--asset">
        
        <div v-if="selected" >
            <input type="hidden" v-bind:name="name" v-model="selected.id"/>
            
            <a class="button" v-on:click="browseAsset">Choose file</a>
            <a class="button button--clear" v-on:click="clearSelected">Clear</a>
            
            <label>{{selected.filename}}</label>
        </div>
        
        <div v-else>
            <input type="hidden" v-bind:name="name" value=""/>

            <a class="button" v-on:click="browseAsset">Choose file</a>
            
            <label>{{placeholder}}</label>
        </div>
        
    </div>
    
</template>

<script>

    export default {

        data() {
            return {
                browser: null,
                selected: null
            };
        },
        
        props: {
            'name': null,
            'value': null,
            'placeholder': {
                default: 'None selected'
            }
        },

        mounted() {
            this.attachListeners();
            
            this.fetchAsset(this.value).then( ( asset ) => {
                if (asset && asset.id) {
                    this.selected = asset;
                }
            });
        },
        
        methods: {
            attachListeners() {
                
                build.core.WindowDispatch.listen( (message) => {
                    
                    if (this.browser && ( this.browser.reference === message.source ) ) {
                        this.closeBrowser();

                        this.selected = message.data;
                    }
                    
                });
                
            },
            
            fetchAsset(id) {
                return this.$http.get(config.base_url + `/async/assets/${id}` ).then( (response) => {
                    return response.data;
                });
            },
            browseAsset() {
                this.closeBrowser();
                this.browser = build.core.WindowDispatch.open(config.base_url + '/asset-browser/files', 'Media Browser', 1000, 600);
            },
            
            clearSelected() {
                this.selected = null;
            },
        
            closeBrowser() {
                if ( this.browser ) {
                    try {
                        this.browser.reference.close();
                    } catch (e) {
                        //
                    }
                }

                this.browser = null;
            },
            
        },

        destroyed() {
        },

        watch: {
            
            selected: function () {
                
                if (this.selected && ( this.selected.id !== parseInt(this.value) ) ) {
                    this.$emit('change', this.selected);
                }
                
            }
            
        }

    }

</script>
