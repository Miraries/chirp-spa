<template>
    <div>
        <div class="form-group form-inline">
            <select class="form-control w-25" v-model="orderby">
                <option value="" disabled selected>{{ $t('sort_by') }}</option>
                <option>{{ $t('date') }}</option>
                <option>{{ $t('popularity') }}</option>
            </select>
            <input type="text" class="form-control w-25 ml-3" :placeholder="$t('filter_by_title')" v-model="titleFilter">
        </div>
        <content-placeholder v-if="items.length === 0" v-for="n in 5" :key="n" :rows="ThreadRows" class="mb-5"></content-placeholder>
        <transition-group name="flip-list" tag="div">
            <div v-for="(thread, index) in items" :key="thread.id">
                <thread v-if="titleFilter.length === 0 || thread.title.toLowerCase().includes(titleFilter.toLowerCase())"
                        :data="thread" @deleted="remove(index)"></thread>
            </div>
        </transition-group>
    </div>
</template>

<script>
    import Thread from './Thread.vue';
    import ContentPlaceholder from 'vue-content-placeholder';
    import { ThreadRows } from '../../layouts/placeholderRows.js';

    export default {
        props: ['userId'],
        components: { Thread, ContentPlaceholder },

        data() {
            return {
                orderby: '',
                items: [],
                titleFilter: '',
                ThreadRows
            }
        },

        created() {
            this.fetch();
            /*window.events.$on('refresh-threads', e => {
                this.fetch();
            })*/
        },

        methods: {
            fetch() {
                flash(this.$t('fetching_chirps'), 'info');
                axios.get('/api/threads' + this.filter).then(response => {
                    this.items = response.data
                });
            },
            remove(index) {
                this.items.splice(index, 1);
            }
        },

        computed: {
            filter() {
                return (this.userId ? '?by=' + this.userId : '?') + (this.orderby === 'Popularity' ? '&popular=1' : '');
            }
        },

        watch: {
            orderby() {
                this.fetch();
            }
        }
    }
</script>

<style scoped>
    .flip-list-move {
        transition: transform 1s;
    }
</style>