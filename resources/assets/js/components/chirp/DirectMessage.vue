<template>
    <div class="card border-light mb-3" :class="{alignLeft: isAuth, alignRight: !isAuth}">
        <div class="card-header">
            <img :src="senderName === 'You' ? photo_url : sender.photo_url" class="rounded-circle profile-photo mr-1">
            <strong>{{ senderName }}</strong>
            <span class="float-right">
                {{ ago }}
            </span>
        </div>
        <div class="card-body">
            {{ body }}
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        props: ['data'],

        mounted() {
            this.username = this.$store.state.auth.user.name;
            this.photo_url = this.$store.state.auth.user.photo_url;
        },

        data() {
            return {
                username: '',
                photo_url: '',
                body: this.data.body,
                created_at: this.data.created_at,
                sender: this.data.from
            }
        },
        computed: {
            ago() {
                return moment(this.created_at).calendar();
            },
            senderName() {
                if(this.sender.name === this.username)
                    return 'You';
                else
                    return this.sender.name;
            },
            isAuth() {
                return this.sender.name === this.username;
            }
        }
    }
</script>
<style scoped>
    .alignLeft {
        left: 2rem;
    }
    .alignRight {
        right: 2rem;
    }
    .card-header img {
        height: 32px;
        width: 32px;
    }
</style>