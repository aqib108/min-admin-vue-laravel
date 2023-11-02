import { createWebHistory, createRouter } from 'vue-router';
import Home from './components/pages/Home.vue';
import Employees from './components/pages/Employees.vue';
import Companies from './components/pages/Companies.vue';
import CreateCompany from './components/pages/Create-company.vue';
import CreateEmployee from './components/pages/Create-employee.vue';
const routes = [
  {
    path: '/',
    component: Home,
  },
  {
    path: '/employees',
    component: Employees,
  },
  {
    path: '/companies',
    component: Companies,
  },
  {
    path: '/create-company/:id?',
    name:'save-company',
    component: CreateCompany,
    props:true
  },
  {
    path: '/create-employee/:id?',
    name:'save-employee',
    component: CreateEmployee,
    props:true
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;