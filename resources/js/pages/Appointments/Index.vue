<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Calendar } from '@/components/ui/calendar';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import type { DateValue } from '@internationalized/date';
import { getLocalTimeZone, today } from '@internationalized/date';
import type { Ref } from 'vue';
import { ref } from 'vue';

const value = ref(today(getLocalTimeZone())) as Ref<DateValue>;
// import the correct clients route or define it if missing
import appointments from '@/routes/appointments';
import clients from '@/routes/clients';

interface Client {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    // Add other client properties as needed
}
interface Appointment {
    id: number;
    date: Date;
    time: string;
    client_id: number;
    // Add other appointment properties as needed
}

defineProps<{
    appointments: Appointment[];
    klijenti: Client[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Appointments',
        href: appointments.index().url,
    },
];
</script>

<template>
    <Head title="Appointments" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <header class="p-8">
            <Link :href="clients.create().url"
                ><Button>Dodaj klijenta</Button></Link
            >
        </header>
        <div
            class="flex flex-row flex-wrap gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Calendar
                v-model="value"
                :weekday-format="'short'"
                class="rounded-md border"
            />
        </div>
    </AppLayout>
</template>
