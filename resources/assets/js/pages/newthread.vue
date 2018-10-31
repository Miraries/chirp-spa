<template>
    <div class="col-md-8">
        <form @submit.prevent="addThread">
            <h1>{{ $t('new_chirp') }}</h1>
            <div class="form-group">
                <label for="title">{{ $t('title') }}</label>
                <input type="text" name="title" class="form-control" id="title" :placeholder="$t('name_your_chirp')" required v-model="title">
            </div>
            <div class="form-group">
                <label for="body">{{ $t('body') }}</label>
                <textarea name="body"
                          id="body"
                          class="form-control"
                          :placeholder="$t('say_something')"
                          rows="5"
                          required
                          v-model="body"></textarea>
            </div>

            <button type="submit"
                    class="btn btn-primary"
                    >{{ $t('post') }}
            </button>
        </form>
        <div class="mt-3" v-if="title.length > 0">
            <h4 >{{ $t('chirp_preview') }}</h4>
            <thread :data="previewData"></thread>
        </div>
    </div>
</template>

<script>
    import Thread from '../components/chirp/Thread.vue';

    export default {
        middleware: 'auth',
        components: { Thread },
        metaInfo() {
            return {title: this.$t('new_chirp')}
        },

        data() {
            return {
                title: '',
                body: ''
            };
        },

        methods: {
            addThread() {
                window.events.$emit('increm-thread-count');
                axios.post('/api/threads', {title: this.title, body: this.body})
                    .then(({data}) => {
                        this.$router.push('/home');
                        flash(this.$t('chirp_posted'), 'success');
                    });
            }
        },

        computed: {
            previewData() {
                return {
                    body: this.body,
                    title: this.title,
                    created_at: new Date,
                    author: {name: this.$store.state.auth.user.name},
                    replies_count: 0
                }
            }
        }
    }
</script>