<template>
    <div>
        <div class="mt-3 mb-3">
            <router-link :to="{ name:'save-company'}">
                <button type="button" class="btn btn-primary">
                    Add Company
                </button>
            </router-link>
        </div>
        <div v-if="companies.data.length > 0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">company Name</th>
                        <th scope="col">Company Email</th>
                        <th scope="col">Company Logo</th>
                        <th scope="col">Company Site</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(company, index) in companies.data" :key="index">
                        <th scope="row">{{ ++index }}</th>
                        <td>{{ company.name }}</td>
                        <td>{{ company.email }}</td>
                        <td><img :src="company.logo" /></td>
                        <td>{{ company.website ?? "-" }}</td>
                        <td>
                            <button
                                @click="deleteCompany(company.id)"
                                class="btn btn-sm btn-danger"
                            >
                                Delete
                            </button>
                            <router-link :to="{ name:'save-company',params:{id:company.id}}" class="btn btn-primary">
                    Edit
            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Bootstrap5Pagination
                :align="left"
                :data="companies"
                @pagination-change-page="fetchCompanies"
            ></Bootstrap5Pagination>
        </div>

        <div v-else>No Company Found</div>
    </div>
</template>
<script>
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
export default {
    data() {
        return {
            companies: null,
        };
    },
    components: {
        Bootstrap5Pagination,
    },
    created() {
        this.fetchCompanies();
    },
    methods: {
        fetchCompanies(page = 1) {
            axios
                .get(`/api/company?page=${page}`)
                .then((response) => {
                    this.companies = response.data.data;
                    console.log(this.companies.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        deleteCompany(id) {
            if (confirm("Are You Sure Want to Delete!")) {
                axios
                    .delete(`/api/company/${id}`)
                    .then((response) => {
                        alert(response.data.message);
                        var company = this.companies.data;
                        this.companies.data = company.filter(
                            (row) => row.id !== id
                        );
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } else {
                return false;
            }
        },
    },
};
</script>
