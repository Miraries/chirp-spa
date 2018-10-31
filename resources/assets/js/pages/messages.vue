<template>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="mb-3">
                <button v-if="inConvo" type="button" class="btn btn-secondary float-right" @click="inConvo=false; messages = []; $router.replace('/dm/')">{{ $t('back') }}
                </button>
                <button v-if="!inConvo" type="button" class="btn btn-primary float-right"
                        @click="$router.push('/dm/create')">{{ $t('new_message') }}
                </button>
                <h4>
                    {{ title }}
                    <router-link v-if="inConvo" :to="{ name: 'profile.user' }">
                        {{ convoUserName }}
                    </router-link>
                </h4>
            </div>
            <div>
                <transition-group name="slide-fade">
                <message v-if="!inConvo" v-for="message in convos" :key="message.id" :data="message"
                         @click.native="convoUserId = friendId(message);inConvo = true; fetchMessages(); ">
                </message>
                </transition-group>
                <transition-group name="slide-fade-reverse">
                <direct-message v-if="inConvo" v-for="(message, key) in messages" :key="key"
                                :data="message"></direct-message>
                </transition-group>
                <h4 v-if="inConvo && messages.length === 0">{{ $t('no_messages') }}</h4>
            </div>
            <new-direct-message v-if="inConvo" :userId="convoUserId" @added="addMessage"></new-direct-message>
        </div>
    </div>
</template>

<script>
    import Message from '../components/chirp/Message.vue';
    import DirectMessage from '../components/chirp/DirectMessage.vue';
    import NewDirectMessage from '../components/chirp/NewDirectMessage.vue';

    export default {
        components: {Message, DirectMessage, NewDirectMessage},
        middleware: 'auth',
        data() {
            return {
                inConvo: false,
                convoUserId: 0,
                convos: [],
                messages: []
            }
        },
        created() {
            if(this.$route.params.id){
                this.inConvo = true;
                this.convoUserId = this.$route.params.id;
                this.fetchMessages();
            }

            this.fetchConvos();
        },
        methods: {
            fetchConvos() {
                flash(this.$t('fetching_conversations'), 'info');
                axios.get('/api/dm').then(response => {
                    this.convos = response.data;
                });
            },
            fetchMessages() {
                flash(this.$t('fetching_direct_messages'), 'info');
                axios.get('/api/dm/' + this.convoUserId).then(response => {
                    this.messages = response.data;
                });
                this.$router.replace('/dm/' + this.convoUserId.toString());
            },
            friendId({from, to}) {
                let id = this.$store.state.auth.user.id;
                return from.id === id ? to.id : from.id;
            },
            friendName({from, to}) {
                let name = this.$store.state.auth.user.name;
                return from.name === name ? to.name : from.name;
            },
            addMessage(body) {
                this.messages.push({
                    body,
                    created_at: new Date,
                    from: {name: this.$store.state.auth.user.name}
                });
            }
        },
        computed: {
            title() {
                return this.inConvo ? this.$t('conversation_with') : this.$t('all_messages');
            },
            convoUserName() {
                if(this.messages.length === 0)
                    return '';
                return this.friendName(this.messages[0]);
            }
        }
    }
</script>

<style scoped>
    .slide-fade-enter-active, .slide-fade-reverse-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active, .slide-fade-reverse-leave-active {
        transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
    {
        transform: translateX(-1rem);
        opacity: 0;
    }
    .slide-fade-reverse-enter, .slide-fade-reverse-leave-to
    {
        transform: translateX(1rem);
        opacity: 0;
    }
</style>