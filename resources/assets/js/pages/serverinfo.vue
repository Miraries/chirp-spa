<template>
    <div class="d-flex justify-content-center mb-5">
        <div class="col-md-8">
            <div v-for="(data, dKey) in allData" class="mb-3">
                <h2>{{ dKey | capitalize}} {{ $t('info') }}</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for="(info, key) in data"><strong>{{ key }}:</strong> {{ info }}</li>
                </ul>
            </div>
        </div>
        <div class="col-md-4 mt-1">
            <div class="mb-3">
                <h2>{{ $t('threads_excel_export') }}</h2>
                <a href="/api/export/threads/xlsx">Download</a>
            </div>
            <div class="mb-3">
                <h2>{{ $t('users_excel_export') }}</h2>
                <a href="/api/export/users/xlsx">Download</a>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        middleware: 'auth',
        data() {
            return {
                host: {},
                client: {},
                software: {},
                uptime: {},
                db: {}
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch() {
                flash(this.$t('fetching_server_info'), 'info');
                axios.get('/api/serverinfo').then(({data}) => {
                    this.host = data.host;
                    this.client = data.client;
                    this.software = data.software;
                    this.uptime = data.uptime;
                    this.db = data.db;
                });
            }
        },
        computed: {
            allData() {
                return {host: this.host, client: this.client, software: this.software, uptime: this.uptime, db: this.db};
            }
        },
        filters: {
            capitalize(val) {
                return val.replace(/^\w/, c => c.toUpperCase());
            }
        }
    }
</script>

<style scoped>

</style>