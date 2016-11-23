<template>
    <div>
        <input v-model="query">
        <ul id="example-1">
            <li v-for="item in rows">
                {{ item.message }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                query: '',
                items: [
                    { message: 'Foo' },
                    { message: 'Bar' },
                    { message: 'Baz' }
                ]
            }
        },

        computed: {
            rows: function () {
                var items = this.items

                if (this.query) {
                    items = this.items.filter(row => {
                        return row.message.toLowerCase().indexOf(this.query) > -1
                    });
                }

                return items
            }
        }
    }
</script>
