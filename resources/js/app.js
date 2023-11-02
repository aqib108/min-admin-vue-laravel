import {createApp} from 'vue'

import App from './App.vue'
import router from './routes'; // Import your Vue Router configuration
createApp(App)
.use(router)
.mount("#app")