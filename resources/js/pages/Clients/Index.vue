<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
// import the correct clients route or define it if missing
import clients from '@/routes/clients';

interface Client {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    // Add other client properties as needed
}

defineProps<{
    klijenti: Client[]
}>();

const breadcrumbs: BreadcrumbItem[] = [
        {
        title: 'Clients',
        href: clients.index().url,
    },
];
</script>

<template>
    <Head title="Clients" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <header class="p-8">
            <Link :href="clients.create().url"><Button>Dodaj klijenta</Button></Link>
        </header>
        <div class="flex flex-wrap flex-row gap-4 overflow-x-auto rounded-xl p-4 ">
            <div v-for="klijent in klijenti" :key="klijent.id" class="p-4 border rounded shadow w-96 flex justify-between items-center">
                <div>
                    <h2 class="text-l font-bold mb-2">{{ klijent.first_name }} {{ klijent.last_name }}</h2>
                    <p class="text-sm">{{ klijent.email }}</p>
                </div>
                <Link :href="`/clients/${klijent.id}`"><span class="button rounded px-4 py-2 bg-gray-800">Details</span></Link>
            </div>
        </div>
    </AppLayout>
</template>
