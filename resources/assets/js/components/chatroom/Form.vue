<template>
    <div class="input-group input-append">
        <form action="" class="chat-form" @submit.prevent="submitForm">
            <input class="text" id="text" size="" type="text" name="text" v-model="text">
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">Send</button>
            </span>
        </form>
    </div>
</template>

<script>
    import {api} from "../../config";

    export default {
        data() {
            return {
                text: ''
            }
        },
        methods: {
            // Submit the form, then push the saved message to the parent component
            submitForm() {
                axios.post(api.sendMessage,{
                    text: this.text,
                }).then((res) => {
                    this.$emit('messagesent', res.data.message);
                    this.text = '';
                })
                .catch(err => {
                    console.log(err);
                    let errors = err.response.data.errors;

                    if(errors.text)
                        this.$noty.error(errors.text[0]);

                });
            }
        }
    }
</script>