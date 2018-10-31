<template>
    <div class="input-group my-3">
        <!--<input type="text" class="form-control" placeholder="Write a message">-->
        <textarea class="form-control" rows="2" v-model="body" :placeholder="$t('write_a_message')"></textarea>
        <div class="input-group-append">
            <button class="btn btn-primary" type="button" @click="addReply">{{ $t('send') }}</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['userId'],
        data() {
            return {
                body: ''
            }
        },
        methods: {
            addReply() {
                if(this.body.length === 0){
                    flash('You must enter a message', 'error');
                    return;
                }
                axios.post('/api/dm/' + this.userId, {body: this.body})
                    .then(({data}) => {
                        flash(this.$t('message_sent'), 'success');
                        this.$emit('added', this.body);
                        this.body = '';
                    });
            }
        }
    }
</script>

<style scoped>

</style>