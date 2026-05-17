<template>
  <v-container class="fill-height gradient-bg" fluid>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card elevation="4" rounded="lg" theme="dark">
          <v-card-title class="text-h5 pa-6 pb-2">Anmelden</v-card-title>
          <v-card-subtitle class="px-6 pb-4">Willkommen zurück bei Freibier</v-card-subtitle>

          <v-card-text>
            <v-form ref="form" @submit.prevent="submit">
              <v-text-field
                v-model="email"
                label="E-Mail"
                type="email"
                :rules="[rules.required, rules.email]"
                variant="outlined"
                class="mb-3"
              />
              <v-text-field
                v-model="password"
                label="Passwort"
                :type="showPassword ? 'text' : 'password'"
                :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                @click:append-inner="showPassword = !showPassword"
                :rules="[rules.required]"
                variant="outlined"
              />

              <v-alert v-if="errorMessage" type="error" class="mt-3" density="compact">
                {{ errorMessage }}
              </v-alert>

              <v-btn
                type="submit"
                color="primary"
                size="large"
                block
                class="mt-5"
                :loading="loading"
              >
                Anmelden
              </v-btn>
            </v-form>
          </v-card-text>

          <v-card-actions class="justify-center pb-5">
            <span class="text-body-2 text-medium-emphasis">Noch kein Konto?</span>
            <v-btn variant="text" color="primary" size="small" :to="'/register'">Registrieren</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const auth = useAuthStore()

const form = ref(null)
const email = ref('')
const password = ref('')
const showPassword = ref(false)
const loading = ref(false)
const errorMessage = ref('')

const rules = {
  required: (v) => !!v || 'Pflichtfeld',
  email: (v) => /.+@.+\..+/.test(v) || 'Ungültige E-Mail-Adresse',
}

async function submit() {
  const { valid } = await form.value.validate()
  if (!valid) return

  loading.value = true
  errorMessage.value = ''

  try {
    await auth.login(email.value, password.value)
    router.push('/')
  } catch (e) {
    errorMessage.value = e.response?.data?.message || 'Anmeldung fehlgeschlagen.'
  } finally {
    loading.value = false
  }
}
</script>
