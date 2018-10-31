<template>
    <div class="row mb-3">
        <div class="col-md-8">
            <threads></threads>
        </div>
        <div class="col-md my-5">
            <div v-if="user" class="card align-items-center">
                <profile v-if="user" class="card-body text-center"></profile>
            </div>
            <span v-else>{{ $t('must_register') }}</span>
        </div>
    </div>

</template>

<script>
    import {mapGetters} from 'vuex';
    import Threads from '../components/chirp/Threads.vue';
    import Profile from '../components/chirp/Profile';

    export default {
        components: {Threads, Profile},

        metaInfo() {
            return {title: this.$t('home')}
        },

        computed: mapGetters({
            user: 'auth/user'
        })
    }
</script>
