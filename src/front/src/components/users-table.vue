<template>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in $store.state.users.results" :key="user.id">
                <td>{{user.first_name}}</td>
                <td>{{user.last_name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.role}}</td>
                <td>{{user.department}}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: 'users-table',
}
</script>