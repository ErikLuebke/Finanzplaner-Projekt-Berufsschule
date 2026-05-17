<template>
  <v-app class="bg-dark text-white">
    <v-app-bar color="#003f5c" height="120">
      <template v-slot:prepend>
        <v-app-bar-nav-icon
          variant="text"
          @click.stop="drawer = !drawer"
        ></v-app-bar-nav-icon>
      </template>
      <v-app-bar-title class="flex-grow-1 text-center text-h3">
        <RouterLink :to="{ name: 'home' }" style="color: inherit; text-decoration: none;">Freibier Finance</RouterLink>
      </v-app-bar-title>
      <template v-slot:append>
        <v-btn icon @click="logout">
          <v-icon>mdi-logout</v-icon>
        </v-btn>
      </template>
    </v-app-bar>
    <v-navigation-drawer
      v-model="drawer"
      temporary
      class="bg-dark text-white"
    >
      <v-list>
        <v-list-item
          v-for="item in items"
          :key="item.name"
          @click="navigate(item.name)"
        >
          <v-list-item-title>
            {{ item.label }}
          </v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-main>
      <RouterView />
    </v-main>
  </v-app>
</template>

<script setup>
import { ref } from 'vue'
import { RouterView, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const auth = useAuthStore()
const drawer = ref(false)

const items = [
  { label: 'Home', name: 'home' },
  { label: 'Ausgaben', name: 'expenditure' },
  { label: 'Historie', name: 'history' },
  { label: 'Sparziel', name: 'savings-goal' },
  { label: 'Fixkosten', name: 'fixed-costs' },
  { label: 'Ein-/Ausgaben', name: 'income-costs' },
  { label: 'Monatsübersicht', name: 'month-overview' },
  { label: 'Warnbetrag', name: 'alert-amount' },
  { label: 'Verkn. Konten', name: 'connected-accounts' },
]

function navigate(name) {
  drawer.value = false
  router.push({ name })
}

async function logout() {
  await auth.logout()
  router.push('/login')
}
</script>