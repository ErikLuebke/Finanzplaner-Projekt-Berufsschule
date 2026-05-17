<template>
  <v-card class="bg text-white" @click="goToHistory" hover>
    <v-card-title>
      <span>Letzte Transaktionen</span>
      <v-spacer />
      <v-icon>mdi-arrow-right</v-icon>
    </v-card-title>
    <v-card-items density="compact" class="mg-3">
      <v-list-item
        v-for="(item, idx) in items"
        :key="idx"
        :title="item.description"
        :subtitle="`${item.date} · ${item.kategorie_name}`"
      >
        <template #append>
          <span :class="item.geldwert > 0 ? 'positive' : item.geldwert < 0 ? 'negative' : ''">
            {{ formatAmount(item.geldwert) }}
          </span>
        </template>
      </v-list-item>
    </v-card-items>
  </v-card>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api/axios'

const router = useRouter()
const items = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    const response = await api.get('/kontobewegung/historyPreview')
    items.value = response.data.map(item => ({
      ...item,
      date: formatDate(item.date),
      kategorie_name: item.kategorie?.bezeichnung ?? '–',
    }))
  } catch (e) {
    error.value = e.response?.data?.message ?? 'Fehler beim Laden der Daten.'
    console.error('Fehler beim Laden:', e)
  } finally {
    loading.value = false
  }
})

const formatAmount = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(value)
}

function goToHistory() {
  router.push({ name: 'history' })
}

const formatDate = (value) => {
  if (!value) return ''
  return new Date(value).toLocaleDateString('de-DE')
}
</script>

<style scoped>
.history-preview {
  cursor: pointer;
  transition: box-shadow 0.2s;
}

.history-preview:hover {
  box-shadow: 0 4px 24px rgba(0,0,0,0.25);
}

.positive { color: #239e9e; }

.negative { color: #ff6361; }

.bg {
  background-color: #142933;
}
</style>
