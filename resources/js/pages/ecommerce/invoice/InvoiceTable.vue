<template>
<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <td class="item">
                <h6 class="p-2 mb-0">Item Description</h6>
            </td>
            <td class="Hours">
                <h6 class="p-2 mb-0">Hours</h6>
            </td>
            <td class="Rate">
                <h6 class="p-2 mb-0">Rate</h6>
            </td>
            <td class="subtotal">
                <h6 class="p-2 mb-0">Sub-total</h6>
            </td>
        </tr>
        <tr v-for="invoice  in invoices" :key="invoice">
            <td>
                <label>{{ invoice.label }}</label>
                <p class="m-0">{{ invoice.decp }}</p>
            </td>
            <td>
                <p class="itemtext digits">{{invoice.hours }}</p>
            </td>
            <td>
                <p class="itemtext digits">{{ invoice.rate }}</p>
            </td>
            <td>
                <p class="itemtext digits">{{ invoice.subtotal }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="itemtext"></p>
            </td>
            <td>
                <p class="m-0">HST</p>
            </td>
            <td>
                <p class="m-0 digits">13%</p>
            </td>
            <td>
                <p class="m-0 digits">$419.25</p>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td class="Rate">
                <h6 class="mb-0 p-2">Total</h6>
            </td>
            <td class="payment digits">
                <h6 class="mb-0 p-2">$3,644.25</h6>
            </td>
        </tr>
    </tbody>
</table>
</template>

<script>
import {
    invoice
} from "../../../data/ecommerce/invoice"
export default {
    data() {
        return {
            invoices: invoice
        }
    }
}
</script>
