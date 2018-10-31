<template>
    <div class="text-center">
        <img :src="user.photo_url" class="rounded-circle profile-photo mr-1">
        <h4 class="font-weight-light mt-3">#{{ user.id }}</h4>
        <h3>{{ user.name }}</h3>
        <hr>
        <a :href="'mailto:'+user.email">{{ user.email }}</a>
        <small class="d-block font-weight-light">{{ $t('joined') }} {{ ago }}</small>
        <hr>
        <h5 class="font-weight-light">{{ $t('chirps') }}: {{ user.threads_count }}</h5>
        <h5 class="font-weight-light">{{ $t('replies') }}: {{ user.replies_count}}</h5>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        props: ['data', 'userId'],
        data() {
            if(this.data)
                return {user: this.data};
            return {
                user: {
                    id: this.$store.state.auth.user.id
                },
            }
        },
        created() {
            if(!this.data)
                this.fetch();
            window.events.$on('decrem-thread-count', e => {
                this.threads_count--;
            });
            window.events.$on('increm-thread-count', e => {
                this.threads_count++;
            });
        },
        computed: {
            ago() {
                return moment(this.user.created_at).calendar();
            }
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

<style scoped>

</style>