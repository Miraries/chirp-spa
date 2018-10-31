<template>
    <div>
        <content-placeholder v-if="!this.title" :rows="ThreadRows" class="mb-5"></content-placeholder>
        <div class="card my-3" v-if="!!this.title" @click="$router.push(path)">
            <div class="card-header">
                <router-link :to="path" style="text-decoration: none">
                    {{ title }}
                </router-link>
                <span class="float-right">
                {{ replies_count }} {{ pluralReplies }}
            </span>
            </div>
            <div class="card-body">
                <span style="white-space: pre-wrap;" class="text-left">{{ body }}</span>
            </div>
            <div class="card-footer">
                <div class="form-inline d-flex justify-content-between">
                    <div class="mb-1 ml-1">
                        <div v-on:click.stop class="d-flex">
                            <img :src="author.photo_url || user.photo_url" class="rounded-circle profile-photo mt-1">
                            <router-link :to="{ name: 'profile.user', params: {id: author.id} }" class="ml-3 mt-2">
                                {{ author.name }}
                            </router-link>
                        </div>
                        <small class="ml-5 mt-5"> {{ ago }}</small>
                    </div>
                    <button v-if="user && (user.id === author.id || user.id === 1)" class="btn btn-danger"
                            @click.stop="deleteThread">
                        {{ $t('delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    import moment from 'moment';
    import ContentPlaceholder from 'vue-content-placeholder';
    import {ThreadRows} from '../../layouts/placeholderRows.js';

    export default {
        props: ['data', 'forcedId'],
        components: {ContentPlaceholder},
        data() {
            if (!this.forcedId)
                return {...this.data, ThreadRows};
            return {
                id: this.forcedId,
                created_at: '',
                title: '',
                body: '',
                replies_count: 0,
                author: {
                    id: 0,
                    name: ''
                },
                ThreadRows
            };
        },
        methods: {
            deleteThread() {
                axios.delete('/api/threads/' + this.id)
                    .then(({data}) => {
                        flash(this.$t('chirp_deleted'), 'warning');
                        this.$emit('deleted', this.id);
                        window.events.$emit('decrem-thread-count');
                    });
            },
            fetch() {
                flash(this.$t('fetching_chirp'), 'info');
                axios.get('/api/threads/' + this.forcedId).then(({data}) => {
                    this.title = data.title;
                    this.created_at = data.created_at;
                    this.body = data.body;
                    this.replies_count = data.replies_count;
                    this.author = data.author;
                    this.$emit('loaded');
                });
            }
        },
        computed: {
            ...mapGetters({
                user: 'auth/user'
            }),
            path() {
                return '/threads/' + this.id
            },
            ago() {
                return moment(this.created_at).fromNow();
            },
            pluralReplies() {
                return this.replies_count === 1 ? this.$t('reply') : this.$t('replies_dative');
            }
        },
        mounted() {
            if (this.forcedId) {
                this.fetch();
                window.events.$on('decrem-reply-count', e => {
                    this.replies_count--;
                });
                window.events.$on('increm-reply-count', e => {
                    this.replies_count++;
                });
            }
        },
        watch: {
            data(oldData, newData) {
                this.title = newData.title;
                this.body = newData.body;
            }
        }
    }
</script>
<style lang="scss" scoped>
    // Copied some styles because of scoping
    .card.my-3 {
        transition: 0.5s;
        cursor: pointer;
        &:hover {
            border-color: #007bff !important;
            color: #007bff !important;
            .card-body {
                transition: 0.5s;
                color: #007bff !important;
            }
            .card-header, .card-footer {
                transition: 0.5s;
                border-color: #007bff !important;
                background-color: transparent !important;
            }
        }
        img {
            width: 32px;
            height: 32px;
        }
    }
</style>