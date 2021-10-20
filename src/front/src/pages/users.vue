<template>
    <div class="container users-page">
        <users-list></users-list>
    </div>
</template>

<script>
import UsersList from "../components/users-list.vue";

export default {
    components: {UsersList},
    name: 'users-page',
    data() {
        return {
            loading: false,
            page: 1,
        }
    },
    methods: {
      async getUsers(page) {
          this.page = page || 1;
          this.loading = true;
          await this.$store.dispatch('users/getList');
          this.loading = false;
      }
    },
    created() {
        this.getUsers();
    }
}
</script>