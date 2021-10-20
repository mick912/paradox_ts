<template>
    <div>
        <modal-window v-if="open" @close="open = false">
            <template v-slot:header>
                <h3>
                    <strong v-if="userLoaded">
                        {{user.first_name}}&nbsp;{{user.last_name}}
                    </strong>
                </h3>
            </template>
            <template v-slot:body>
                <div class="loader">
                    <pulse-loader :loading="loading" color="#9b4dca"></pulse-loader>
                </div>
                <div class="user-info" v-if="userLoaded">
                    <div class="row">
                        <div class="column text-right">Role:</div>
                        <div class="column value">{{user.role}}</div>
                    </div>
                    <div class="row">
                        <div class="column text-right">Department:</div>
                        <div class="column value">{{user.department}}</div>
                    </div>
                    <div class="row">
                        <div class="column text-right">Email:</div>
                        <div class="column value">{{user.email}}</div>
                    </div>
                    <div class="row">
                        <div class="column text-right">Age:</div>
                        <div class="column value">{{user.age}}</div>
                    </div>
                    <div class="row">
                        <div class="column text-right">Address:</div>
                        <div class="column value">
                            <p>{{user.address.area}}, {{user.address.city}}, {{user.address.country}}</p>
                            <p>{{user.address.address}}</p>
                        </div>
                    </div>
                </div>
            </template>
        </modal-window>
    </div>

</template>

<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import ModalWindow from "./modal-window.vue";

export default {
    components: {
        ModalWindow,
        PulseLoader
    },
    name: 'user-info',
    data () {
        return {
            loading: true,
            open: false,
        }
    },
    methods: {
        async show(id) {
            this.open = true;
            this.loading = true;
            await this.$store.dispatch('user/retrieve', {id});
            this.loading = false;
        },
    },
    computed: {
        userLoaded() {
            return Object.keys(this.$store.state.user.user).length > 0;
        },
        user() {
            return this.$store.state.user.user
        }
    }
}
</script>

<style scoped>
    .loader {
        text-align: center;
    }
    .loader > * {
        margin: 150px auto;
    }
    .user-info > * {
        border-bottom: 1px solid #e1e1e1;
        padding: 15px 0;
    }
    .text-right {
        text-align: right;
    }
    .value {
        font-weight: 400;
    }
</style>