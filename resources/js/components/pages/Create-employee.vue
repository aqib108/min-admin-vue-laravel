<template>
    <div>
        <form>
            <div class="row">
                <div class="col-lg-6">
                    <label for="name">First Name</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="formData.first_name"
                        id="first_name"
                        placeholder="First Name"
                    />
                    <span v-if="errors.first_name" class="text-red-500">{{
                        errors.first_name[0]
                    }}</span>
                </div>
                <div class="col-lg-6">
                    <label for="name">last Name</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="formData.last_name"
                        id="last_name"
                        placeholder="last Name"
                    />
                    <span v-if="errors.last_name" class="text-red-500">{{
                        errors.last_name[0]
                    }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label for="name">phone</label>
                    <input
                        type="phone"
                        class="form-control"
                        id="phone"
                        v-model="formData.phone"
                    />
                    <span v-if="errors.phone" class="text-red-500">{{
                        errors.image[0]
                    }}</span>
                </div>
                <div class="col-lg-6">
                    <label for="inputPassword4">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        placeholder="Email"
                        v-model="formData.email"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label for="name">Company</label>
                    <select
                        class="form-control"
                        name="company_id"
                        v-model="formData.company_id"
                    >
                        <option value="">Choose Company</option>
                        <option
                            v-for="(company, index) in companies"
                            :value="company.id"
                        >
                            {{ company.name }}
                        </option>
                    </select>
                    <span v-if="errors.company_id" class="text-red-500">{{
                        errors.company_id[0]
                    }}</span>
                </div>
            </div>
            <button
                type="button"
                @click="saveEmployee"
                class="btn btn-primary mt-3"
                :disabled="buttonDisabled"
            >
                {{ buttonText }}
            </button>
        </form>
    </div>
</template>
<script>
import axios from "axios";
export default {
    props: ["id"],
    data() {
        return {
            formData: {
                first_name: "",
                last_name: "",
                email: "",
                phone: "",
                company_id: "",
                id: "",
            },
            companies: {},
            errors: {
                first_name: null,
                last_name: null,
                email: null,
                phone: null,
                company_id: null,
            },
            buttonText: "Save",
            buttonDisabled: false,
        };
    },
    created() {
        this.getCompanies();
        if (this.id !== undefined) {
            this.editEmployee();
        }
    },
    methods: {
        async saveEmployee() {
            this.buttonText = "uploading...";
            this.buttonDisabled = true;
            const formData = new FormData();
            formData.append("first_name", this.formData.first_name);
            formData.append("last_name", this.formData.last_name);
            formData.append("email", this.formData.email);
            formData.append("phone", this.formData.phone);
            formData.append("company_id", this.formData.company_id);
            formData.append("id", this.formData.id);
            try {
                const response = await axios.post("/api/employee", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
                this.buttonText = "Save";
                this.buttonDisabled = false;

                alert(response.data.message);
                this.$router.push("/employees");
                // Handle the response as needed
            } catch (error) {
                this.buttonText = "Save";
                this.buttonDisabled = false;

                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    alert("something went wrong");
                }
            }
        },
        async editEmployee() {
            try {
                const response = await axios.get("/api/employee/" + this.id);
                var employee;
                employee = response.data.data;
                this.formData = employee;
            } catch (error) {
                alert("something went wrong");
            }
        },
        async getCompanies() {
            try {
                const response = await axios.get("/api/get-companies");
                var companies;
                companies = response.data.data;
                this.companies = companies;
            } catch (error) {
                alert("something went wrong");
            }
        },
    },
};
</script>
