<template>
    <div class="tag-select">

        <select v-model="selected" v-on:change="onChange">
            <option value="0" disabled>-- select an option--</option>
            <option v-for="option in options" :value="option.id" v-bind:disabled="isSelected(option)">
                {{ option.name }}
            </option>
        </select>

        <ul class="tag-select__selected">
            <li v-for="option in selected_options">
                <input v-if="name" type="hidden" v-bind:name="name" v-bind:value="option.id"/>
                {{ option.name }}
                <span class="tag-select__selected__remove" v-on:click="remove(option)">x</span>
            </li>
        </ul>
    </div>

</template>

<script>

    export default {

        props: [
            'name',
            'options',
            'value'
        ],

        mounted: function () {

            this.reselectOptions();

        },

        data: function () {
            return {
                selected_options: [],
                selected: null
            };
        },

        watch: {
            options() {
                this.reselectOptions();
            },
            value() {
                this.reselectOptions();
            }
        },

        methods: {

            reselectOptions() {

                this.selected_options = [];

                // Map the values to the id's when we only get an array
                if (this.value.length) {

                    _.each(this.value, (value) => {
                        if (value.id) {
                            this.addSelectedOption(value.id);
                        } else {
                            this.addSelectedOption(value);
                        }
                    });

                }

            },

            addSelectedOption(id) {

                const options = this.options;

                for (let i = 0; i < options.length; i++) {
                    let option = options[i];

                    if (option.id == id) {
                        this.selected_options.push(option);
                    }
                }

            },

            isSelected(check) {
                let selected = false;
                _.each(this.selected_options, (option) => {
                    if (option.id === check.id) {
                        selected = true;
                        return false;
                    }
                });
                return selected;
            },

            onChange: function () {
                if (this.selected) {
                    this.addSelectedOption(this.selected);
                }

                this.$emit('input', this.selected_options);
            },

            remove: function (selected) {
                let index = this.selected_options.indexOf(selected);
                this.selected_options.splice(index, 1);
                this.selected = null;

                this.$emit('input', this.selected_options);
            }
        }
    }

</script>