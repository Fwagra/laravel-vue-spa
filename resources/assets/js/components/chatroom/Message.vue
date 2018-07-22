<template>
    <div class="message-wrapper" :class="isOwner">
        <div class="infos">
            <div class="message rounded">
                {{ message.text }}
            </div>
            <div class="author">{{ message.author }}</div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    export default {
        props: ['message'],

        computed: {
            isOwner: function() {
                return {
                    'own-message': this.message.author === this.user.name
                }
            },
            ...mapState({
                user: state => {
                    return {...state.auth};
                }
            }),
        },
    }
</script>