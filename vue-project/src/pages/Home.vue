<template>
    <v-container fluid class="gradient-bg">
        <v-row>
            <ProgressBar />
        </v-row>
        <v-row>
            <v-col cols="5">
                <PieChart />
            </v-col>
            <v-col cols="7">
                <v-row>
                    <v-col cols="12">
                        <HistoryPreview />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <SavingsGoalPreview />
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import SavingsGoalPreview from '../components/SavingsGoalPreview.vue';
import HistoryPreview from '../components/HistoryPreview.vue';
import ProgressBar from '@/components/ProgressBar.vue';
import PieChart from '@/components/PieChart.vue';
</script>