<template>
    <Breadcrumbs main="Ecommerce" title="Product List" />

    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Individual column searching (text inputs) </h5><span>The searching functionality provided by
                            DataTables is useful for quickly search through the information in the table - however the
                            search is global, and you may wish to present controls that search on specific columns.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive product-table">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th class="sorting_asc" tabindex="0" aria-controls="basic-1" rowspan="1" colspan="1"
                                            aria-sort="ascending" aria-label="Image: activate to sort column descending"
                                            style="width: 113.766px;">Image</th>
                                        <th class="sorting" tabindex="0" aria-controls="basic-1" rowspan="1" colspan="1"
                                            aria-label="Details: activate to sort column ascending"
                                            style="width: 768.172px;">Details</th>
                                        <th class="sorting" tabindex="0" aria-controls="basic-1" rowspan="1" colspan="1"
                                            aria-label="Amount: activate to sort column ascending"
                                            style="width: 137.797px;">Amount</th>
                                        <th class="sorting" tabindex="0" aria-controls="basic-1" rowspan="1" colspan="1"
                                            aria-label="Stock: activate to sort column ascending" style="width: 143.75px;">
                                            Stock</th>
                                        <th class="sorting" tabindex="0" aria-controls="basic-1" rowspan="1" colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 161.25px;">Start date</th>
                                        <th class="sorting" tabindex="0" aria-controls="basic-1" rowspan="1" colspan="1"
                                            aria-label="Action: activate to sort column ascending"
                                            style="width: 243.266px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in productList" :key="product">
                                        <td><img :src="getImgUrl(product.image)" alt=""></td>
                                        <td>
                                            <h6> {{ product.product_name }}</h6><span>{{ product.product_desc }}</span>
                                        </td>
                                        <td>{{ product.amount }}</td>
                                        <td :class="product.stockStatus">{{ product.stock }}</td>
                                        <td>{{ product.start_date }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-xs" type="button"
                                                data-original-title="btn btn-danger btn-xs" title="">Delete</button>
                                            <button class="btn btn-success btn-xs ms-1" type="button"
                                                data-original-title="btn btn-danger btn-xs" title="">Edit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import { productlist } from "../../../data/ecommerce/productList"
export default {
    name: 'productList',
    data() {
        return {
            productList: productlist
        }
    },
    methods: {
        getImgUrl(path) {
            return require("@/assets/images/ecommerce/" + path);
        },
    }
}
</script>

<style lang="scss" scoped>@import "@/assets/scss/utils/variables";
@import "@/assets/scss/components/datatable";</style>
<style scoped>@import "@/assets/css/productlist.css"</style>
