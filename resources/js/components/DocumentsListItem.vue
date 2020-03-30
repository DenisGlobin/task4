<template>
    <tr>
        <td>{{ id }}</td>
        <td><router-link :to="{ name: 'api.documents.show', params: { id: id } }" class="nav-link">Payload</router-link></td>
        <td>{{ status }}</td>
        <td>{{ owner }}</td>
        <td>{{ createdAt }}</td>
        <td>{{ modifyAt }}</td>
    </tr>
</template>

<script>
    export default {
        name: "DocumentsListItem",
        props: {
            id: {
                type: String
            },
            status: {
                type: String
            },
            owner: {
                type: String
            },
            createdAt: {
                type: String
            },
            modifyAt: {
                type: String
            }
        }
    }
</script>

<style scoped>

</style>