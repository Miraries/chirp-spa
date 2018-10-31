<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link"
                                  v-bind:class="{active: tab === 'profile'}"
                                  @click="tab = 'profile'">{{ $t('profile') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                  v-bind:class="{active: tab === 'threads', disabled: user.threads_count === 0}"
                                  @click="user.threads_count === 0 ? '' : tab = 'threads'">{{ $t('chirps') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                  v-bind:class="{active: tab === 'replies',  disabled: user.replies_count === 0}"
                                  @click="user.replies_count === 0 ? '' : tab = 'replies'">{{ $t('replies') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'messages', params: {id: user.id} }" class="nav-link" v-bind:class="{disabled: user.id === this.$store.state.auth.user.id}"
                                         :event="user.id === this.$store.state.auth.user.id ? '' : 'click'">
                                {{ $t('direct_messages') }}
                            </router-link>
                        </li>
                    </ul>
                </div>
                <profile :data="user" v-if="user.name && tab === 'profile'" class="card-body"></profile>
                <threads v-if="tab === 'threads'" :userId="user.id" class="card-body"></threads>
                <replies v-if="tab === 'replies'" :userId="user.id" class="card-body"></replies>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    import Threads from '../components/chirp/Threads';
    import Replies from '../components/chirp/Replies';
    import Profile from '../components/chirp/Profile';

    export default {
        components: {Threads, Replies, Profile},
        middleware: 'auth',
        data() {
            return {
                user: {
                    id: this.$route.params.id
                },
                tab: 'profile'
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch() {
                flash(this.$t('fetching_profile'), 'info');
                axios.get('/api/profile/' + this.user.id).then(response => {
                    this.user = response.data[0];
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .active {
        background-color: #fff !important;
        border-color: #dee2e6 #dee2e6 #fff !important;
    }

    a {
        cursor: pointer;
        &.disabled {
            cursor: default !important;
        }
    }
</style>