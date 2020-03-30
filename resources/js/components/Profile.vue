<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Registered at</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $auth.user().name }}</td>
            <td>{{ $auth.user().email }}</td>
            <td>{{ $auth.user().created_at }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "Profile"
    }
</script>

<style scoped>

</style>