<template>
    <div class="card my-3 bg-light">
        <div class="card-body">
            <span>
                {{ body }}
            </span>
        </div>
        <div class="card-footer">
            <div class="form-inline d-flex justify-content-between">
                <span class="mb-0">
                    <img :src="author.photo_url" class="rounded-circle profile-photo mr-1">
                    <router-link :to="{ name: 'profile.user', params: {id: author.id} }">
                                {{ author.name }}
                    </router-link>
                    <small> {{ ago }}</small></span>
                <button v-if="user.id === author.id || user.id === 1" class="btn btn-sm btn-danger mb-0" @click="deleteReply">{{ $t('delete') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import moment from 'moment';

    export default {
        props: ['data'],
        data() {
            return this.data;
        },
        methods: {
            deleteReply() {
                axios.delete('/api/replies/' + this.id)
                    .then(({data}) => {
                        flash('Your reply has been deleted', 'warning');
                        window.events.$emit('decrem-reply-count');
                        this.$emit('deleted', this.data.id);
                    });
            }
        },
        computed: {
            ...mapGetters({
                user: 'auth/user'
            }),
            ago() {
                return moment(this.created_at).fromNow();
            }
        },
    }
</script>

<style lang="scss" scoped>
    .card-body {
        background-color: #fff;
    }
    .card-footer img {
        height: 32px;
        width: 32px;
    }
</style>