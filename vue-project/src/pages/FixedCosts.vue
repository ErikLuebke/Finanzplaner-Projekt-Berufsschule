<template>
  <v-card flat class="bg-dark mt-4 mx-5" theme="dark">
    <v-card-title class="d-flex align-center pe-2">
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        density="compact"
        label="Search"
        prepend-inner-icon="mdi-magnify"
        variant="solo-filled"
        flat
        hide-details
        single-line
      ></v-text-field>
    </v-card-title>

    <v-alert v-if="error" type="error" class="ma-4">
      {{ error }}
    </v-alert>

    <v-data-table
      class="bg-dark text-white"
      v-model:search="search"
      :filter-keys="['geldwert', 'kategorie_name', 'konto_name']"
      :headers="header"
      :items="items"
      :loading="loading"
    >
      <template #item.geldwert="{ item }">
        <span :class="item.geldwert > 0 ? 'positive' : item.geldwert < 0 ? 'negative' : ''">
          {{ formatAmount(item.geldwert) }}
        </span>
      </template>

      <template #item.actions="{ item }">
        <v-btn color="red-darken-3" size="small" variant="flat" @click="deleteFixkosten(item.id)">
          Löschen
        </v-btn>
      </template>
    </v-data-table>

    <div class="d-flex justify-end pa-4">
      <v-btn color="primary" @click="dialog = true">
        Neue Fixkosten hinzufügen
      </v-btn>
    </div>
  </v-card>

  <v-dialog v-model="dialog" max-width="500">
    <v-card theme="dark">
      <v-card-title>Neue Fixkosten hinzufügen</v-card-title>

      <v-card-text>
        <v-text-field
          v-model="newFixkosten.date"
          label="Datum"
          type="date"
          variant="outlined"
          class="mb-3"
        ></v-text-field>

        <v-text-field
          v-model.number="newFixkosten.konto_id"
          label="Konto"
          type="number"
          variant="outlined"
          class="mb-3"
        ></v-text-field>

        <v-text-field
          v-model.number="newFixkosten.kategorie_id"
          label="Kategorie"
          type="number"
          variant="outlined"
          class="mb-3"
        ></v-text-field>

        <v-text-field
          v-model.number="newFixkosten.geldwert"
          label="Betrag"
          type="number"
          step="0.01"
          variant="outlined"
          class="mb-3"
        ></v-text-field>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn variant="text" @click="closeDialog">Abbrechen</v-btn>
        <v-btn color="primary" :loading="saving" @click="addFixkosten">
          Speichern
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/api/axios'

const search = ref('')
const items = ref([])
const loading = ref(true)
const saving = ref(false)
const error = ref(null)
const dialog = ref(false)

const newFixkosten = ref({
  date: '',
  konto_id: null,
  kategorie_id: null,
  geldwert: null,
  fix: true,
})

const header = [
  { title: 'Datum', key: 'date', align: 'start' },
  { title: 'Konto', key: 'konto_name' },
  { title: 'Kategorie', key: 'kategorie_name' },
  { title: 'Betrag', key: 'geldwert', align: 'end' },
  { title: 'Fixkosten', key: 'fix', align: 'center' },
  { title: 'Aktionen', key: 'actions', align: 'center', sortable: false },
]

const loadData = async () => {
  loading.value = true
  error.value = null

  try {
    const response = await api.get('/kontobewegung/fixCosts')
    items.value = response.data
      .filter(item => item.fix)
      .map(item => ({
        ...item,        id: item.id ?? item.kontobewegungid,        date: formatDate(item.date),
        konto_name: item.konto?.name ?? '–',
        kategorie_name: item.kategorie?.bezeichnung ?? '–',
        fix: item.fix ? 'Ja' : 'Nein',
      }))
  } catch (e) {
    error.value = e.response?.data?.message ?? 'Fehler beim Laden der Daten.'
  } finally {
    loading.value = false
  }
}

onMounted(loadData)

const addFixkosten = async () => {
  saving.value = true
  error.value = null

  try {
    const response = await api.post('/kontobewegung/fixCostsStore', {
      konto_id: newFixkosten.value.konto_id,
      kategorie_id: newFixkosten.value.kategorie_id,
      date: newFixkosten.value.date,
      geldwert: newFixkosten.value.geldwert,
      fix: newFixkosten.value.fix,
    })

    const item = response.data

    items.value.push({
      ...item,
      date: formatDate(item.date),
      konto_name: item.konto?.name ?? '–',
      kategorie_name: item.kategorie?.bezeichnung ?? '–',
      fix: item.fix ? 'Ja' : 'Nein',
    })

    closeDialog()
  } catch (e) {
    error.value = e.response?.data?.message ?? 'Fehler beim Hinzufügen der Fixkosten.'
  } finally {
    saving.value = false
  }
}

const deleteFixkosten = async (id) => {
  error.value = null

  try {
    await api.delete(`/kontobewegung/${id}/fixCostsDestroy`)
    items.value = items.value.filter(item => item.id !== id)
  } catch (e) {
    error.value = e.response?.data?.message ?? 'Fehler beim Löschen der Fixkosten.'
  }
}

const closeDialog = () => {
  dialog.value = false
  newFixkosten.value = {
    date: '',
    konto_id: null,
    kategorie_id: null,
    geldwert: null,
    fix: true,
  }
}

const formatAmount = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat('de-DE', {
    style: 'currency',
    currency: 'EUR'
  }).format(value)
}

const formatDate = (value) => {
  if (!value) return ''
  return new Date(value).toLocaleDateString('de-DE')
}
</script>

<style scoped>
.positive {
  color: #1e9424;
}

.negative {
  color: #c61d1d;
}
</style>