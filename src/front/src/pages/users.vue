<template>
    <div class="container users-page">
        <users-table></users-table>
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
import UsersTable from "../components/users-table.vue";
import Pagination from "../components/pagination.vue";

export default {
    components: {
        Pagination,
        UsersTable
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