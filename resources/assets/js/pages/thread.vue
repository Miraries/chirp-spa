<template>
    <div class="col-md-8 mb-5">
        <!--<content-placeholder v-if="!loadedThread" :rows="ThreadRows" class="mb-5"></content-placeholder>-->

        <thread :forcedId="$route.params.id" @deleted="redirect" @loaded="loadedThread = true"></thread>

        <!--<content-placeholder v-for="n in 3" v-if="!loadedReplies" :key="n" :rows="ReplyRows" class="mb-5"></content-placeholder>-->

        <replies :threadId="$route.params.id" @loaded="loadedReplies = true"></replies>
    </div>
</template>

<script>
    import Thread from '../components/chirp/Thread.vue';
    import Replies from '../components/chirp/Replies.vue';
    import ContentPlaceholder from 'vue-content-placeholder';
    import { ThreadRows, ReplyRows } from '../layouts/placeholderRows';

    export default {
        components: { Thread, Replies, ContentPlaceholder },
        data() {
            return {
                loadedThread: false,
                loadedReplies: false,
                ThreadRows,
                ReplyRows
            }
        },
        methods: {
            redirect() {
                this.$router.push('/home')
            }
        }
    }
</script>