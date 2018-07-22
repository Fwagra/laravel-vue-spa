<template>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3">
                <h3>Select your room</h3>
                <ul class="list-group">
                    <li class="list-group-item">Not</li>
                    <li class="list-group-item">implemented</li>
                    <li class="list-group-item">yet</li>
                </ul>
            </div>
            <div class="col-12 col-md-9">
                <div class="panel chatroom rounded  bg-light">
                    <chat-message v-for="message in messages" :message="message"></chat-message>
                    <div class="no-message" v-show="!messages.length">No message yet... Be the first one!</div>
                </div>
                <chat-form ></chat-form>
            </div>
        </div>
    </div>
</template>
<script>
    import Message from './Message.vue';
    import ChatForm from './Form.vue';
    import {api} from "../../config";
    import jwtToken from '../../helpers/jwt-token';
    import Echo from "laravel-echo";

    window.Pusher = require('pusher-js');

    export default {
        components: {
            'chat-message': Message,
            'chat-form': ChatForm
        },
        data() {
            return {
                messages: []
            }
        },
        mounted(){
            // Setup Laravel Echo
            if (jwtToken.getToken()) {
                window.Echo = new Echo({
                    broadcaster: 'pusher',
                    key: Laravel.pusherKey,
                    cluster: Laravel.pusherCluster,
                    encrypted: true,
                    authEndpoint: Laravel.broadcastUrl,
                    auth: {
                        headers: {
                            Authorization: 'Bearer ' + jwtToken.getToken()
                        }
                    }
                });
            }


            // Listen to broadcast channel
            window.Echo.private('chatroom')
            .listen("MessagePosted", (data) => {
                this.messages.push(data.message);
            });
            // Load the 10 last messages
            axios.get(api.listMessages).then(
                (res) => {
                    this.messages = res.data.messages;
                }
            );

        },
        updated() {
            // Automatic scroll of the chat box
            var chatroom = document.querySelector('.chatroom');
            chatroom.scrollTop = chatroom.scrollHeight
        },
        methods: {
//            // Push a newly added message to the current collection
//            addMessage(message) {
//                this.messages.push(message);
//            }
        }
    }
</script>
