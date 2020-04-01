<template>
    <div class="container">
        <form @submit.prevent="sendData" method="POST">
            <input type="hidden" name="_token" :value="this.$auth.token()">
            <div class="form-group">
                <label for="payload">Payload: </label>
                <textarea class="form-control" id="payload" rows="6" v-model="document.payload"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</template>

<script>
    import route from '../route';
    export default {
        name: "DocumentCreate",
        data() {
            return {
                document: {
                    payload: ''
                },
            };
        },
        methods: {
            sendData() {
                let app = this;
                axios.post(route("api.documents.store"), { payload: app.document.payload })
                    .then(response => {
                        app.$router.push({ name: 'api.documents.index', params: { page: 1, perPage: 10 } });
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