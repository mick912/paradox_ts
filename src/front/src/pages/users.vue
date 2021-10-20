<template>
    <div class="container users-page">
        <div class="loader">
            <pulse-loader :loading="loading" color="#9b4dca"></pulse-loader>
        </div>
        <div class="row">
            <div class="column">
                <h5>Users</h5>
            </div>
            <div class="column column-50">
                <search-input :value="params.q" @input="search"></search-input>
            </div>
        </div>
        <users-table
                :sort="params.sort"
                v-if="!loading && $store.state.users.results.length > 0"
                v-on:sort="orderUsers"
        ></users-table>
        <div class="clearfix">
            <pagination
                    :current="$store.state.users.currentPage"
                    :total="$store.state.users.total"
                    v-on:page-change="getUsers"
                    class="float-right"
            ></pagination>
        </div>
    </div>
</template>

<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import SearchInput from "../components/search-input.vue";

export default {
    components: {
        SearchInput,
        PulseLoader,
        Pagination: () => import("../components/pagination.vue"),
        UsersTable: () => import("../components/users-table.vue")
    },
    name: 'users-page',
    data() {
        return {
            loading: false,
            params: {
                page: 1,
                q: '',
                sort: {
                    field: 'first_name',
                    direction: 'ASC'
                }
            }
        }
    },
    methods: {
        async getUsers(page) {
            this.params.page = page || 1;
            this.loading = true;
            const params = {
                page: this.params.page,
                order: this.params.sort.direction === 'DESC' ? '-' + this.params.sort.field : this.params.sort.field,
                q: this.params.q
            };
            await this.$store.dispatch('users/getList', params);
            this.loading = false;
        },
        async orderUsers({field, direction}) {
            this.params.sort = {field, direction};
            await this.getUsers(1);
        },
        async search(value) {
            this.params.q = value;
            await this.getUsers(1);
        }
    },
    created() {
        this.getUsers();
    }
}
</script>

<style scoped>
    .loader {
        text-align: center;
    }
    .loader > * {
        margin: 400px auto;
    }
    .users-page {
        margin-top: 50px;
    }
</style>