<template>
    <div class="container">
        <p>Document ID: {{ document.id }}</p>
        <p>Status: {{ document.status }}</p>
        <p>Payload: {{ document.payload }}</p>
        <p>Created at: {{ document.createdAt }}</p>
        <p>Modify at: {{ document.modifyAt }}</p>
        <p>Owner: {{ document.owner.name }}</p>

        <br>
        <router-link v-if="$gate.allow('update', 'document', $auth.user(), document)" :to="{ name: 'api.documents.edit', params: { id: document.id} }">Edit</router-link>
    </div>
</template>

<script>
    // import axios from 'axios';
    import route from '../route';
    export default {
        name: "DocumentShow",
        data() {
            return {
                document: {
                    id: '',
                    status: 'draft',
                    payload: '',
                    createdAt: '',
                    modifyAt: '',
                    owner: {
                        name: '',
                    },
                },
            };
        },
        mounted() {
            let id = this.$route.params.id;
            this.getDocument(id);
        },
        methods: {
            getDocument(id) {
                axios.get(route("api.documents.show", {'id':id}))
                    .then(response => {
                        this.document = response.data.document;
                    })
                    .catch(response => {
                        console.log(response);
                    });
            }
        }
    }
</script>

<style scoped>

</style>