<template>
    <div class="card border-light mb-3">
        <div class="card-header">
            <img :src="friend.photo_url" class="rounded-circle profile-photo mr-1">
            <strong>{{ friend.name }}</strong>
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

        data() {
            return {
                body: this.data.body,
                created_at: this.data.created_at,
                friend: this.data.to.name === this.$store.state.auth.user.name ? this.data.from : this.data.to
            }
        },
        computed: {
            ago() {
                return moment(this.created_at).fromNow();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .card {
        transition: 0.5s;
        cursor: pointer;
        &:hover {
            border-color: #007bff!important;
            color: #007bff!important;
            .card-body {
                color: #007bff!important;
            }
        }
        img {
            height: 32px;
            width: 32px;
        }
    }
</style>