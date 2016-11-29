<template>
    <div>
        Clicked: {{ $store.state.count }} times.
        <input v-model="query">
        {{ query }}
    </div>
</template>

<script>
	import Store from '../../store/asset/index';

    export default{
        data: function () {
            return {
                query: ''
            }
        }
    }
</script>
