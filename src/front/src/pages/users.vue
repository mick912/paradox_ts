<template>
    <div class="container users-page">
        <div class="loader">
            <pulse-loader :loading="loading" color="#9b4dca"></pulse-loader>
        </div>
        <users-table v-if="!loading && $store.state.users.results.length > 0"></users-table>
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

export default {
    components: {
        PulseLoader,
        Pagination: () => import("../components/pagination.vue"),
        UsersTable: () => import("../components/users-table.vue")
    },
    name: 'users-page',
    data() {
        return {
            loading: false,
        }
    },
    methods: {
      async getUsers(page) {
          page = page || 1;
          this.loading = true;
          await this.$store.dispatch('users/getList', {page});
          this.loading = false;
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
</style>