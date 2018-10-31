<template>
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <h4 class="mb-3">{{ $t('new_message') }}</h4>
            <div class="form-group">
                <select class="form-control" id="selectUser" v-model="selectedUser">
                    <option v-if="users.length > 0" value="" disabled selected>{{ $t('select_user') }}</option>
                    <option v-else value="" disabled selected>{{ $t('loading_users') }}</option>
                    <option v-for="user in users" v-text="user.name"></option>
                </select>
            </div>
            <new-message :userId="selectedUserId" @added="$router.push('/dm/' + selectedUserId);"></new-message>
        </div>
    </div>
</template>

<script>
    import NewMessage from '../components/chirp/NewDirectMessage';

    export default {
        middleware: 'auth',
        components: { NewMessage },
        data() {
            return {
                selectedUser: '',
                users: []
            }
        },
        methods: {
            fetch() {
                flash('Fetching users', 'info');
                axios.get('/api/users').then(({data}) => {
                    this.users = data.filter(x => x.name !== this.$store.state.auth.user.name && x.name !== 'admin');
                });
            }
        },
        created() {
            this.fetch();
        },
        computed: {
            selectedUserId() {
                if(this.users.length > 0)
                    try {
                        return this.users.filter(x => x.name === this.selectedUser)[0].id;
                    } catch(e) {}
                return 0
            }
        }
    }
</script>

<style scoped>

</style>