<template>
    <div>
        DIT IS MIJN CANVAS

        Clicked: {{ $store.state.count }} times.
        <ul id="example-1">
            <li v-for="item in rows">
                {{ item.message }}
            </li>
        </ul>
    </div>
</template>

<script>
	import Store from '../../store/asset/index';

    export default{
        data(){
            return{
                msg:'hello vue'
            }
        }
    }
</script>
