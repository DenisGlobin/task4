<template>
    <div class="container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Document ID</th>
                <th scope="col">Link</th>
                <th scope="col">Status</th>
                <th scope="col">Owner</th>
                <th scope="col">Created at</th>
                <th scope="col">Modify at</th>
            </tr>
        </thead>
        <tbody>
            <DocumentsListItem
                v-for="(document, index) in documents"
                :id="document.id"
                :key="index"
                :status="document.status"
                :owner="document.owner.name"
                :created-at="document.createdAt"
                :modify-at="document.modifyAt"
            />
        </tbody>
    </table>
    <PaginationBar
        :pagination="pagination"
        @paginate="getDocuments"
        :offset="offset"
    />
    </div>
</template>

<script>
    // import axios from 'axios';
    import route from '../route';
    import DocumentsListItem from "./DocumentsListItem";
    import PaginationBar from './PaginationBar';
    export default {
        name: "DocumentsList",
        components: {DocumentsListItem, PaginationBar,},
        mounted() {
            let page = this.$route.params.page;
            let perPage = this.$route.params.perPage;
            this.getDocuments(page, perPage);
        },
        data() {
            return {
                documents: [],
                pagination: {},
                offset: 4,
            };
        },
        methods: {
            getUrl(id) {
                return route("api.documents.show", {'id':id});
            },
            getDocuments(page = 1, perPage = 10) {
                axios.get(route("api.documents.index", {'page':page,'perPage':perPage}))
                    .then(response => {
                        this.documents = response.data.data.document;
                        this.pagination = response.data.data.pagination;
                });
            }
        }
    }
</script>

<style scoped>

</style>