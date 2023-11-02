<template>
  <AppLayout></AppLayout>
  <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Application</div>

                <div class="card-body ">
                  <RouterView></RouterView>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import AppLayout from './components/layout/Layout.vue';

export default {
  data() {
    return {
      currentComponent: 'ChildComponent',
    };
  },
  components: {
    AppLayout,
  },
  
};
</script>






