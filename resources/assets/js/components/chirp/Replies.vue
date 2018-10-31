<template>
    <div>
        <h4 v-if="threadId && items.length > 0">{{ $t('replies') }}</h4>
        <h5 v-else-if="threadId">{{ $t('no_replies_yet') }}</h5>

        <content-placeholder v-for="n in 3" v-if="!loaded" :key="n" :rows="ReplyRows" class="mb-5"></content-placeholder>

        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
        <new-reply v-if="user && threadId" :threadId="threadId" @added="fetch"></new-reply>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue'
    import ContentPlaceholder from 'vue-content-placeholder';
    import { ReplyRows } from '../../layouts/placeholderRows.js';

    export default {
        props: ['threadId', 'userId'],
        components: { Reply, NewReply, ContentPlaceholder },

        data() {
            return {
                loaded: false,
                items: [],
                ReplyRows
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch() {
                flash(this.$t('fetching_replies'), 'info');
                axios.get(this.query).then(({data}) => {
                    this.items = data.replies ? data.replies : data;
                    this.loaded = true;
                    this.$emit('loaded');
                });
            },
            remove(index) {
                this.items.splice(index, 1);
            }
        },
        computed: {
            query() {
                return this.userId ? '/api/replies?by=' + this.userId : '/api/threads/' + this.threadId;
            },
            ...mapGetters({
                user: 'auth/user'
            }),
        }
    }
</script>