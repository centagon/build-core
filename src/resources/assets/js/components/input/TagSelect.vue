<template>
    <div>

        <select v-model="selected" v-on:change="onChange">
            <option value="0" disabled>-- select an option--</option>
            <option v-for="option in options" :value="option.id">
                {{ option.name }}
            </option>
        </select>

        <ul>
            <li v-for="option in selected_options">
                {{ option.name }}
                <button v-on:click="remove(option)">x</button>
            </li>
        </ul>

    </div>
</template>

<script>

    export default {

        props: [
            'options',
            'value'
        ],

        mounted: function () {
            this.selected_options = this.value;
        },

        data: function () {
            return {
                options: [],
                selected_options: [],
                selected: null
            }
        },

        methods: {
            onChange: function () {
                const options = this.options;

                for (let i = 0; i < options.length; i++) {
                    let option = options[i];

                    if (option.id == this.selected) {
                        this.selected_options.push(option);
                    }
                }

                this.$emit('input', this.selected_options);
            },

            remove: function (selected) {
                this.selected_options.splice(selected, 1);
            }
        }
    }

</script>