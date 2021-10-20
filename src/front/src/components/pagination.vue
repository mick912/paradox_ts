<template>
    <ul class="pagination" v-if="totalPages > 1">
        <li class="pagination-previous">
            <a
                href=""
                @click.prevent="changePage(prevPage)"
                v-if="hasPrev()">
                Prev
            </a>
        </li>
        <li v-if="hasFirst()">
            <a href="" @click.prevent="changePage(1)">1</a>
        </li>
        <li v-if="hasFirst()">...</li>
        <li
            :class="{current: current === page}"
            v-for="(page, index) in pages"
            v-bind:key="index">
            <a href="" @click.prevent="changePage(page)">
                {{page}}
            </a>
        </li>
        <li v-if="hasLast()">...</li>
        <li v-if="hasLast()">
            <a href="" @click.prevent="changePage(totalPages)">{{totalPages}}</a>
        </li>
        <li class="pagination-next">
            <a
                href=""
                @click.prevent="changePage(nextPage)"
                v-if="hasNext()"
            >
               Next
            </a>
        </li>
    </ul>
</template>

<script>
export default {
    name: 'Pagination',
    props: {
        current: {
            type: Number,
            default () {
                return 1;
            }
        },
        total: {
            type: Number,
            default () {
                return 0;
            }
        },
        perPage: {
            type: Number,
            default() {
                return 15
            }
        },
        pageRange: {
            type: Number,
            default() {
                return 2
            }
        }
    },
    computed: {
        rangeStart() {
            const start = this.current - this.pageRange;
            return (start > 0) ? start : 1;
        },
        rangeEnd() {
            const end = this.current + this.pageRange;
            return (end < this.totalPages) ? end : this.totalPages;
        },
        pages() {
            let pages = [];

            for (let i = this.rangeStart; i <= this.rangeEnd; i++) {
                pages.push(i)
            }
            return pages;
        },
        totalPages() {
            return Math.ceil(this.total / this.perPage);
        },
        nextPage() {
            return this.current + 1;
        },
        prevPage() {
            return this.current - 1;
        }
    },
    methods: {
        hasFirst() {
            return this.rangeStart !== 1;
        },
        hasLast() {
            return this.rangeEnd !== this.totalPages;
        },
        hasPrev() {
            return this.current > 1;
        },
        hasNext() {
            return this.current < this.totalPages;
        },
        changePage(page) {
            this.$emit('page-change', page, false);
        }
    }
}
</script>

<style scoped>
    .pagination {
        margin-left: 0;
        margin-bottom: 0;
    }
    .pagination:after, .pagination:before {
        display: table;
        content: " ";
    }
    .pagination:after {
        clear: both;
    }
    .pagination li {
        display: inline-block;
        margin-left: 7px;
    }
    a {
        border: 1px solid #e1e1e1;
        border-radius: 4px;
        color: #e1e1e1;
        display: block;
        padding: 5px 15px;
    }
    .current a, a:hover {
        border: 1px solid #9b4dca;
        color: #9b4dca;
    }
</style>