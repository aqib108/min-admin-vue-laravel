<template>
  <div>
    <form>
  <div class="row">
    <div class="col-lg-6">
      <label for="name">Name</label>
      <input type="name" class="form-control" v-model="formData.name" id="name" placeholder="Name">
      <span v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</span>
    </div>
    <div class="col-lg-6">
      <label for="inputPassword4">Email</label>
      <input type="email" class="form-control" id="email" placeholder="Email" v-model="formData.email">
      <span v-if="errors.email" class="text-red-500">{{ errors.email[0] }}</span>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <label for="name">Logo</label>
      <input type="file" class="form-control" id="logo" @change="handleFileUpload" accept="image/*" >
      <span v-if="errors.image" class="text-red-500">{{ errors.image[0] }}</span>
    </div>
    <div class="col-lg-6">
      <label for="inputPassword4">website Link</label>
      <input type="url" class="form-control" id="website" placeholder="website link" v-model="formData.website">
    </div>
  </div>
  <div v-if="imageUrl" class="row">
    <img :src="imageUrl" height="100" width="100" >
  </div>
  <button type="button" @click="saveCompany" class="btn btn-primary mt-3" :disabled="buttonDisabled">{{ buttonText }}</button>
</form>
  </div>
</template>
<script>
import axios from 'axios';
export default {
  props: ['id'],
  data() {
    return {
      formData: {
        name: '',
        email: '',
        website:'',
        id:''
      },
      errors:{
        name:null,
        email:null,
        image:null
      },
      buttonText: 'Save',
      buttonDisabled:false,
      selectedFile: null,
      imageUrl:null
    };
  },
  created() {
     if(this.id!==undefined){
        this.editCompany();
     }
  },
  methods: {
   async saveCompany() {
    this.buttonText = 'uploading...';
    this.buttonDisabled = true;
    const formData = new FormData();
    formData.append('name', this.formData.name);
    formData.append('email', this.formData.email);
    formData.append('website', this.formData.website);
    formData.append('image', this.selectedFile);
    formData.append('id', this.formData.id);
    try {
      const response = await axios.post('/api/company', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      this.buttonText = 'Save';
      this.buttonDisabled = false;
 
      alert(response.data.message);
      this.$router.push('/companies');
      // Handle the response as needed
    } catch (error) {
      this.buttonText = 'Save';
      this.buttonDisabled = false;
 
      if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          } else {
           alert('something went wrong');
          }
    }
    },
    handleFileUpload(event) {
      this.selectedFile = event.target.files[0];
      const file = event.target.files[0];
      if (file) {
        this.imageUrl = URL.createObjectURL(file);
      } else {
        this.imageUrl = null;
      }
    },
    async editCompany(){
      try {
      const response = await axios.get('/api/company/'+this.id);
      var company;
      company = response.data.data;
      this.formData = company;
      this.imageUrl = company.logo; 
    } catch (error) {
  
      if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          } else {
           alert('something went wrong');
          }
    }
    }
  },
};
</script>