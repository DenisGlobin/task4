<template>
    <div class="container">
        <form @submit.prevent="sendData" method="POST">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="_token" :value="this.$auth.token()">
            <div class="form-group">
                <label for="payload">Payload: </label>
                <textarea class="form-control" id="payload" rows="6" v-model="document.payload"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <br><hr>
        <form @submit.prevent="publishDocument" method="POST">
            <button type="submit" class="btn btn-success" data-toggle="tooltip"
                data-placement="top" title="Publish this document. You can't edit this document anymore."
            >Publish</button>
        </form>
    </div>
</template>

<script>
    // import axios from 'axios';
    import route from '../route';
    export default {
        name: "DocumentEdit",
        data() {
            return {
                document: {
                    id: '',
                    payload: ''
                },
            };
        },
        mounted() {
            let id = this.$route.params.id;
            this.getDocument(id);
        },
        methods: {
            getDocument(id) {
                axios.get(route("api.documents.show", { 'id': id }))
                    .then(response => {
                        this.document = response.data.document;
                        this.document.payload = JSON.stringify(this.document.payload);
                    })
                    .catch(response => {
                        console.log(response);
                    });
            },
            sendData() {
                let app = this;
                axios.patch(route("api.documents.update", { 'id': app.document.id }), { payload: app.document.payload })
                    .then(response => {
                        app.$router.push({ name: 'api.documents.show', params: { id: app.document.id } });
                    })
                    .catch(response => {
                        console.log(response);
                    });
            },
            publishDocument() {
                let app = this;
                axios.post(route("api.documents.publish", { 'id': app.document.id }))
                    .then(response => {
                        app.$router.push({ name: 'api.documents.show', params: { id: app.document.id } });
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