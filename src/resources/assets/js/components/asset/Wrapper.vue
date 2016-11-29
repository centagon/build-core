<template>
	<div class="row">
		<div class="small-12 medium-4 large-3">
			Clicked: {{ $store.state.count }} times.
			<button @click="increment">+</button>
			<button @click="decrement">-</button>
			<asset-sidebar :query="gaaf"></asset-sidebar>
		</div>

		<div class="small-12 medium-8 large-9">
			<asset-canvas></asset-canvas>
		</div>
	</div>
</template>

<script>
	import Sidebar from './Sidebar.vue';
	import Canvas from './Canvas.vue';
	import Store from '../../store/asset/index';

	import { mapGetters, mapActions } from 'vuex';

	export default {
		components: {
			'asset-sidebar': Sidebar,
			'asset-canvas': Canvas
		},

		store: Store,

		data: function () {
            return {
                query: 'test',
                items: [
                    { message: 'Foo' },
                    { message: 'Bar' },
                    { message: 'Baz' }
                ]
            }
        },

        methods: mapActions([
			'increment',
			'decrement'
		]),

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