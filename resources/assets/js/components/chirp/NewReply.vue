<template>
    <form>
        <h4>{{ $t('add_a_reply') }}</h4>
        <div class="form-group">
            <textarea name="body"
                      id="body"
                      class="form-control"
                      placeholder="Say something!"
                      rows="5"
                      required
                      v-model="body"></textarea>
        </div>

        <button type="submit"
                class="btn btn-primary"
                @click.prevent="addReply">{{ $t('post') }}
        </button>
    </form>
</template>

<script>
    export default {
        props: ['threadId'],
        data() {
            return {
                body: ''
            }
        },
        methods: {
            addReply() {
                axios.post('/api/threads/' + this.threadId + '/replies', {body: this.body})
                    .then(({data}) => {
                        flash(this.$t('reply_posted'), 'success');
                        this.$emit('added', this.id);
                        this.body = '';
                        window.events.$emit('increm-reply-count');
                    });
            }
        }
    }
</script>