<template>
    <table>
        <thead>
            <tr>
                <th  v-for="(field, key) in fields" :key="key + '-head'">
                    <div @click="sortByField(key)">
                        <span>
                            {{ field.title }}
                        </span>
                        <icon-sort :value="key === sort.field ? sort.direction : null"></icon-sort>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in $store.state.users.results" :key="user.id">
                <td  v-for="(field, key) in fields" :key="key + '-body'">
                    {{user[key]}}
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import IconSort from './icons/sort.vue';

export default {
    name: 'users-table',
    components: {
        IconSort,
    },
    props: {
      sort: {
          type: Object,
          default() {
              return {
                  field: 'first_name',
                  direction: 'ASC'
              }
          }
      }
    },
    data() {
        return {
            fields: {
                first_name: {
                    title: 'First Name'
                },
                last_name: {
                    title: 'Last Name'
                },
                email: {
                    title: 'Email'
                },
                role: {
                    title: 'Role'
                },
                department: {
                    title: 'Department'
                },
            }
        }
    },
    methods: {
        sortByField(field) {
            this.$emit('sort', {
                field: field,
                direction: this.sort.direction === 'ASC' ? 'DESC' : 'ASC',
            });
        },
    }
}
</script>

<style scoped>
    th {
        cursor: pointer;
    }
</style>