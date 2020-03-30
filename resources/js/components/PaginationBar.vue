<template>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item" :class="{'disabled': pagination.current_page <= 1}">
                <a href="javascript:void(0)" aria-label="Previous" v-on:click.prevent="changePage(pagination.current_page - 1, pagination.per_page)" class="page-link">
                    <span aria-hidden="true">«</span>
                </a>
            </li>
            <li
                v-for="page in pagesNumber()"
                :key="page"
                class="page-item"
                :class="{'active': page == pagination.current_page}"
            ><a href="javascript:void(0)" v-on:click.prevent="changePage(page, pagination.per_page)" class="page-link">{{ page }}</a>
            </li>
            <li class="page-item" :class="{'disabled': pagination.current_page >= pagination.total_pages}">
                <a href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(pagination.current_page + 1,  pagination.per_page)" class="page-link">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "PaginationBar",
        props: {
            pagination: {
                type: Object,
                required: true
            },
            offset: {
                type: Number,
                default: 4
            }
        },
        methods : {
            pagesNumber() {
                // if (!this.pagination.to) {
                //     return [];
                // }
                let from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                let to = from + (this.offset * 2);
                if (to >= this.pagination.total_pages) {
                    to = this.pagination.total_pages;
                }
                let pagesArray = [];
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page);
                }
                return pagesArray;
            },
            previosPage() {
                return this.pagination.current_page - 1
            },
            nextPage() {
                return this.pagination.current_page + 1
            },
            changePage(page, perPage) {
                this.pagination.current_page = page;
                this.$emit('paginate', page, perPage);
            }
        }
    }
</script>

<style scoped>

</style>