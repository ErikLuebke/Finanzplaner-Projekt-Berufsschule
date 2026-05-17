import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import History from '../pages/History.vue'
import Expenditure from '../pages/Expenditure.vue'
import SavingsGoal from '../pages/SavingsGoal.vue'
import FixedCosts from '../pages/FixedCosts.vue'
import IncomeCosts from '../pages/IncomeCosts.vue'
import MonthOverview from '../pages/MonthOverview.vue'
import AlertAmount from '../pages/AlertAmount.vue'
import ConnectedAccounts from '../pages/ConnectedAccounts.vue'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/', name: 'home', component: Home, meta: { requiresAuth: true }},
    { path: '/expenditure', name: 'expenditure', component: Expenditure, meta: { requiresAuth: true }},
    { path: '/history', name: 'history', component: History, meta: { requiresAuth: true }},
    { path: '/savings-goal', name: 'savings-goal', component: SavingsGoal, meta: { requiresAuth: true }},
    { path: '/fixed-costs', name: 'fixed-costs', component: FixedCosts, meta: { requiresAuth: true }},
    { path: '/income-costs', name: 'income-costs', component: IncomeCosts, meta: { requiresAuth: true }},
    { path: '/month-overview', name: 'month-overview', component: MonthOverview, meta: { requiresAuth: true }},
    { path: '/alert-amount', name: 'alert-amount', component: AlertAmount, meta: { requiresAuth: true }},
    { path: '/connected-accounts', name: 'connected-accounts', component: ConnectedAccounts, meta: { requiresAuth: true }},
  ], 
})

router.beforeEach((to) => {
  const auth = useAuthStore()
  if (to.meta.requiresAuth && !auth.isLoggedIn) {
    return '/login'
  }
})

export default router