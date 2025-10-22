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
    phone: string;
    date_of_birth: Date; // or Date, depending on how you
    gender: string;
    supervisor: string;
    association: string;
    // Add other client properties as needed
}

defineProps<{
    klijent: Client
}>();

const breadcrumbs: BreadcrumbItem[] = [
        {
        title: 'Clients',
        href: clients.index().url,
    },
            {
        title: 'Details',
        href: clients.index().url,
    },
];
</script>

<template>
    <Head title="Client Detail Page" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <header>
            <Link :href="`/clients/${klijent.id}/edit`">edit</Link>
        </header>

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">


            <h2>Detalji klijenta</h2>

             {{ klijent.first_name }} {{ klijent.last_name }} <br>
             {{ klijent.email }} <br>
             {{ klijent.phone }} <br>
                {{ klijent.date_of_birth }} <br>
                {{klijent.gender}} <br>
                {{klijent.supervisor}} <br>
                {{klijent.association}} <br>
                    
        </div>
    </AppLayout>
</template>
