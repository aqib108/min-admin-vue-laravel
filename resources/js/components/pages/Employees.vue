<template>
    <div>
        <div class="mt-3 mb-3">
            <router-link :to="{ name: 'save-employee' }">
                <button type="button" class="btn btn-primary">
                    Add Employee
                </button>
            </router-link>
        </div>
        <div v-if="employees.data.length > 0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Employee Email</th>
                        <th scope="col">Employee Phone</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(employee, index) in employees.data"
                        :key="index"
                    >
                        <th scope="row">{{ ++index }}</th>
                        <td>{{ employee.full_name }}</td>
                        <td>{{ employee.company.name }}</td>
                        <td>{{ employee.email }}</td>
                        <td>{{ employee.phone ?? "-" }}</td>
                        <td>
                            <button
                                @click="deleteEmployee(employee.id)"
                                class="btn btn-sm btn-danger"
                            >
                                Delete
                            </button>
                            <router-link
                                :to="{
                                    name: 'save-employee',
                                    params: { id: employee.id },
                                }"
                                class="btn btn-primary"
                            >
                                Edit
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Bootstrap5Pagination
                :align="left"
                :data="employees"
                @pagination-change-page="fetchEmployees"
            ></Bootstrap5Pagination>
        </div>

        <div v-else>No Employee Found</div>
    </div>
</template>
<script>
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
export default {
    data() {
        return {
            employees: null,
        };
    },
    components: {
        Bootstrap5Pagination,
    },
    created() {
        this.fetchEmployees();
    },
    methods: {
        fetchEmployees(page = 1) {
            axios
                .get(`/api/employee?page=${page}`)
                .then((response) => {
                    this.employees = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        deleteEmployee(id) {
            if (confirm("Are You Sure Want to Delete!")) {
                axios
                    .delete(`/api/employee/${id}`)
                    .then((response) => {
                        alert(response.data.message);
                        var employees = this.employees.data;
                        this.employees.data = employees.filter(
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
