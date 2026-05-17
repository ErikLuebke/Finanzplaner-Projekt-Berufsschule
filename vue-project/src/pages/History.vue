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
      />
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
      <template #item.date="{ item }">
        {{ formatDate(item.date) }}
      </template>

      <template #item.geldwert="{ item }">
        <span :class="item.geldwert > 0 ? 'positive' : item.geldwert < 0 ? 'negative' : ''">
          {{ formatAmount(item.geldwert) }}
        </span>
      </template>

      <template #item.fix="{ item }">
        <span :class="item.fix ? 'positive' : 'negative'">
          {{ item.fix ? 'Ja' : 'Nein' }}
        </span>
      </template>

      <template #item.actions="{ item }">
        <v-btn
          size="small"
          color="#239e9e"
          variant="flat"
          @click="openEditDialog(item)"
        >
          Bearbeiten
        </v-btn>
      </template>
    </v-data-table>
  </v-card>

  <v-dialog v-model="dialog" max-width="500">
    <v-card theme="dark">
      <v-card-title>Kontobewegung bearbeiten</v-card-title>

      <v-card-text v-if="selectedItem">
        <v-text-field
          v-model.number="editForm.geldwert"
          label="Betrag"
          type="number"
          step="0.01"
          variant="outlined"
          class="mb-4"
        />

        <v-switch
          v-model="editForm.fix"
          label="Fixkosten"
          color="#239e9e"
          inset
        />
      </v-card-text>

      <v-card-actions>
        <v-spacer />
        <v-btn variant="text" @click="closeDialog">Abbrechen</v-btn>
        <v-btn color="#239e9e" :loading="saving" @click="saveChanges">
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
const selectedItem = ref(null)

const editForm = ref({
  geldwert: null,
  fix: false,
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
    const response = await api.get('/kontobewegung/history')

    items.value = response.data.map(item => ({
      ...item,
      id: item.id ?? item.kontobewegungid,
      konto_name: item.konto?.name ?? '–',
      kategorie_name: item.kategorie?.bezeichnung ?? '–',
      fix: !!item.fix,
    }))
  } catch (e) {
    error.value = e.response?.data?.message ?? 'Fehler beim Laden der Daten.'
  } finally {
    loading.value = false
  }
}

onMounted(loadData)

const openEditDialog = (item) => {
  selectedItem.value = item
  editForm.value = {
    geldwert: item.geldwert,
    fix: !!item.fix,
  }
  dialog.value = true
}

const closeDialog = () => {
  dialog.value = false
  selectedItem.value = null
  editForm.value = {
    geldwert: null,
    fix: false,
  }
}

const saveChanges = async () => {
  if (!selectedItem.value) return

  saving.value = true
  error.value = null

  try {
    const itemId = selectedItem.value.id ?? selectedItem.value.kontobewegungid

    const payload = {
      konto_id: selectedItem.value.konto_id ?? selectedItem.value.konto?.kontoid,
      kategorie_id: selectedItem.value.kategorie_id ?? selectedItem.value.kategorie?.kategorieid,
      date: selectedItem.value.date,
      geldwert: editForm.value.geldwert,
      fix: editForm.value.fix,
    }

    const response = await api.put(`/kontobewegung/${itemId}/update`, payload)

    const updated = response.data

    const index = items.value.findIndex(item => item.id === selectedItem.value.id)

    if (index !== -1) {
      items.value[index] = {
        ...items.value[index],
        ...updated,
        konto_name: updated.konto?.name ?? items.value[index].konto_name,
        kategorie_name: updated.kategorie?.bezeichnung ?? items.value[index].kategorie_name,
        fix: !!updated.fix,
      }
    }

    closeDialog()
  } catch (e) {
    error.value = e.response?.data?.message ?? 'Fehler beim Speichern der Änderungen.'
  } finally {
    saving.value = false
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
  color: #239e9e;
}

.negative {
  color: #ff6361;
}
</style>