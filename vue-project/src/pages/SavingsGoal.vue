<template>
  <div class="savings-box">
      <div class="form-group">
        <label for="zielbetrag">Zielbetrag (€)</label>
        <input id="zielbetrag" type="number" v-model.number="zielbetrag" min="0" step="0.01" placeholder="z.B. 500.00" />
      </div>

      <div class="form-group">
        <label for="zieldatum">Zieldatum</label>
        <input id="zieldatum" type="date" v-model="zieldatum" />
      </div>

      <button class="primary-btn" :disabled="isLoading" @click="sparzielAnlegen">
        {{ isLoading ? 'In Bearbeitung...' : 'Sparziel anlegen' }}
      </button>

      <p v-if="message" class="success-message">{{ message }}</p>
      <p v-if="error" class="error-message">{{ error }}</p>    
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/api/axios'

const zielbetrag = ref(null)
const zieldatum = ref('')
const isLoading = ref(false)
const message = ref('')
const error = ref('')

async function sparzielAnlegen() {
  message.value = ''
  error.value = ''

  if (!zielbetrag.value || zielbetrag.value <= 0) {
    error.value = 'Bitte einen gültigen Zielbetrag eingeben.'
    return
  }

  if (!zieldatum.value) {
    error.value = 'Bitte ein Zieldatum auswählen.'
    return
  }

  isLoading.value = true

  try {
    const payload = {
      zielbetrag: Number(zielbetrag.value),
      zieldatum: zieldatum.value,
    }

    const response = await api.post('/sparziel/store', payload)
    message.value = 'Sparziel erfolgreich angelegt!'
    console.log('sparzielAnlegen response:', response.data)

    zielbetrag.value = null
    zieldatum.value = ''
  } catch (err) {
    console.error('sparzielAnlegen error', err)
    const errMsg = err.response?.data?.message || err.message || 'Unbekannter Fehler'
    error.value = `Konnte Sparziel nicht anlegen: ${errMsg}`
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
.savings-box {
  background-color: #f9fbff;
  border: 1px solid #d3e0f3;
  border-radius: 14px;
  box-shadow: 0 8px 20px rgba(31, 50, 93, 0.12);
  padding: 18px;
  max-width: 540px;
  margin: 18px auto;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 14px;
}

label {
  color: #1e3a6a;
  font-weight: 600;
}

input {
  padding: 10px 12px;
  border-radius: 8px;
  border: 1px solid #b0c5e6;
  background-color: #fff;
}

button.primary-btn {
  display: inline-flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  padding: 11px 14px;
  border-radius: 10px;
  border: 1px solid #3b82f6;
  background-color: #2563eb;
  color: #fff;
  font-weight: 700;
  cursor: pointer;
  transition: transform 0.1s ease, opacity 0.2s ease;
}

button.primary-btn:hover:not(:disabled) {
  transform: translateY(-1px);
}

button.primary-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  transform: none;
}

.success-message,
.error-message {
  margin-top: 10px;
  padding: 10px;
  border-radius: 8px;
}

.success-message {
  background: #e6f7ea;
  border: 1px solid #7bc38f;
  color: #1f5f30;
}

.error-message {
  background: #ffe9e8;
  border: 1px solid #ea5a55;
  color: #8f1f1b;
}
</style>

