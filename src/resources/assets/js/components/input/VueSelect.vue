<template>
    <div class="vue-select">
        <div class="vue-select-main" :id="main_uid">
            <div v-if="multiple" @click="toggleSearch($event)">
                <ul class="vue-select-main-selected">
                    <li v-for="option in selected_options"
                        @click.stop
                        class="vue-select-main-selected-option">
                        {{ option.name }}
                        <span class="remove" @click="optionUnselected(option, $event)"></span>
                    </li>
                </ul>
                <div v-if="!selected_options.length" class="vue-select-main-placeholder">
                    <label>{{ placeholder }}</label>
                </div>
            </div>
            <div v-else @click="toggleSearch($event)">
                <div v-if="selected_options.length">
                    <label>{{ selected_options[0].name }}</label>
                </div>
                <div v-else>
                    <div class="vue-select-main-placeholder">
                        <label>{{ placeholder }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="vue-select-search" 
             v-if="search_visible"
             :style="search_position"
             >
            <input type="search" v-model="search" :id="search_uid"/>
            <ul class="vue-select-search-results">
                <li 
                    v-for="option in search_results" 
                    @click="optionSelected(option)"
                    :disabled="isSelectedKey(option.id)"
                    class="vue-select-search-result">
                    <label>{{ option.name }}</label>
                </li>
            </ul>
        </div>
    </div>
</template>
<style lang="sass">
    .vue-select {
        font-size: 14px;
        font-family: arial;
        display: block;
        width: 100%;
        position: relative;
        border-radius: 2px;
        border: 1px solid #d5d5d5;
        
        .vue-select-main {
            padding: 4px;
            
            label {
                margin: 0;
                padding: 0;
            }
            
            .vue-select-main-placeholder {
                padding: 0 3px;
                color: lightgrey;
                line-height: 25px;
            }
            
            .vue-select-main-selected {
                list-style: none;
                margin: 0;
                -webkit-padding-start: 0;
                
                li {
                    display: inline-block;
                    margin-right: 4px;
                    margin-bottom: 2px;
                    padding: 4px 20px 4px 4px;
                    background-color: lightgrey;
                    border-radius: 4px;
                    border-color: #d5d5d5;
                    font-size: 12px;
                    position: relative;
                    
                    .remove {
                        position: absolute;
                        top: 4px;
                        right: 4px;
                        width: 11px;
                        height: 11px;
                        border-radius: 2px;
                        background-color: darken(lightgrey, 20%);
                        
                        &:hover {
                            background-color: darken(lightgrey, 40%);
                            cursor: pointer;
                        }
                        
                        &:after {
                            position: absolute;
                            left: 4px;
                            top: 1px;
                            content: "x";
                            font-size: 7px;
                            line-height: 7px;
                        }
                        
                    }
                }
            }
        }
        
        .vue-select-search {
            position: absolute;
            z-index:1;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 4px;
            border-radius: 0;
            border: 1px solid #d5d5d5;
            
            input[type=search] {
                border: 1px solid #0077c8;
                border-radius: 2px;
                padding: 4px;
                width: 100%;
            }
            
            .vue-select-search-results {
                -webkit-padding-start: 0;
                margin: 0;
                list-style: none;
                max-height: 250px;
                overflow-y: auto;
                
                li {
                    &[disabled] {
                        color: lightgrey;
                    }
                    &:hover {
                        background-color: darken(white, 20%);
                    }
                }
            }
        }
    }
</style>
<script>
    export default {
        props: [
            'value',
            'autoclear',
            'options',
            'multiple',
        ],

        data() {
            return {
                main_uid: this._uid + '_main',
                search_uid: this._uid + '_search',
                placeholder: '--Select an option--',
                current: null,
                search: null,
                search_visible: false,
            };
        },

        computed: {
            
            search_position() {
                return {
                    top: $('#'+this.main_uid).outerHeight() + 'px'
                };
            },
            
            search_results() {
                
                if (!this.search) {
                    return this.prepared_options;
                }
                
                return _.filter(this.prepared_options, (option) => {
                    return (option.name.toLowerCase().indexOf(this.search.toLowerCase()) !== -1);
                });
                
            },
            
            prepared_options() {
                let results = [];
                
                _.each(this.options, (item, index) => {
                    let name = this.getItemName(item,index);
                    let id = this.getItemId(item,index);
                    
                    results.push({
                        id: id,
                        name: name,
                        original: item
                    });
                    
                });
                
                return results;
            },
            
            selected_options() {
                let selected = [];
                let values = this.current;
                
                if (!this.multiple) {
                    values = [values];
                }
                
                _.each(values, (item) => {
                    let option = this.getOptionByKey(item);
                    if (option) {
                        selected.push(option);
                    }
                });
                
                return selected;
            }
        },

        mounted() {
            this.updateValue(this.value);
        },

        watch: {
            value(newValue) {
                this.updateValue(newValue);
            }
        },

        methods: {
            
            toggleSearch() {
                this.search_visible = !this.search_visible;
                if (this.search_visible) {
                    if (this.autoclear !== false) {
                        this.search = '';
                    }
                    setTimeout( () => {
                        $('#'+this.search_uid).focus();
                    }, 100);
                }
            },
            
            isSelectedKey(key) {
                return (!this.multiple && (key == this.current)) || (this.multiple && (this.current.indexOf(key) !== -1));
            },
            
            updateValue(newValue) {
                
                if (!this.multiple) {
                    this.current = newValue;
                    return;
                }
                
                if (!newValue) {
                    this.current = [];
                    return;
                }
                
                if (typeof newValue.push !== 'function') {
                    this.current = [newValue];
                } else {
                    this.current = newValue;
                }
            },
            
            getItemName(item, id = null) {
                if (item.attributes) {
                    if (item.attributes.name) {
                        return item.attributes.name;
                    }
                    if (item.attributes.label) {
                        return item.attributes.label;
                    }
                }
                
                if (item.name) {
                    return item.name;
                }
                
                if (item.label) {
                    return item.label;
                }
                
                if (typeof item === 'string') {
                    return item;
                }
                
                return id;
            },
            
            getItemId(item, id = null) {
                if (item.id) {
                    return item.id;
                }
                
                if (item.attributes) {
                    if (item.attributes.id) {
                        return item.attributes.id;
                    }
                }
                
                return id;
            },
            
            getOptionByKey(key) {
                let result = null;
                
                _.each(this.prepared_options, (item, index) => {
                    
                    if (item.id == key) {
                        result = {
                            id: key,
                            name: item.name,
                            original: item
                        };
                        return false;
                    }
                });
                
                return result;
            },

            optionSelected(option) {
                this.hideSearch();
                
                if (!this.multiple) {
                    this.current = option.id;
                } else {
                    if (this.current.indexOf(option.id) === -1) {
                        this.current.push(option.id);
                    }
                }
                
                this.$emit('input', this.current);
            },
            
            hideSearch() {
                if (this.search_visible) {
                    this.toggleSearch();
                }
            },

            optionUnselected(option, $event) {
                $event.stopPropagation();
                
                if (!this.multiple) {
                    return;
                }
                
                let index = this.current.indexOf(option.id);
                if (index === -1) {
                    return;
                }
                
                this.current.splice(index, 1);
                
                this.$emit('input', this.current);
            },

        }
    }
</script>