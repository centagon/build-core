<template>

    <select :options="options" v-model="selected" multiple>
        <option disabled value="0">Select one</option>
    </select>

</template>

<script>

    export default {

        props: [
            'options',
            'value'
        ],

        mounted() {
            let vm = this;

            $(this.$el)
                .val(this.value)
                .select2({
                    data: this.options,
                    tags: true
                })
                .on('change', function () {
                    vm.$emit('input', this.value);
                });
        },

        destroyed() {
            $(this.$el).off().select2('destroy');
        },

        watch: {
            value(value) {
                $(this.$el).select2('val', value);
            },

            options(options) {
                $(this.$el).select2({
                    data: options
                });
            }
        }

    }

</script>
