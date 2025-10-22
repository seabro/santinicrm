<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
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

const props = defineProps<{
    klijent: Client;
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

const form = useForm({
    first_name: props.klijent.first_name,
    last_name: props.klijent.last_name,
    email: props.klijent.email,
    phone: props.klijent.phone,
});

const submit = () => {
    form.post(clients.update(props.klijent.id).url, {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Client updated successfully');
        },
        onError: (errors) => {
            console.error('Error updating client:', errors);
        },
    });
};
</script>

<template>
    <Head title="Client Detail Page" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <h2>Editiraj klijenta</h2>
            <form @submit.prevent="submit" :options="{ preserveScroll: true }">
                <div class="flex flex-row gap-4">
                    <div class="mb-4">
                        <Label
                            class="mb-2 block text-sm font-bold text-gray-700"
                            for="first_name"
                        >
                            First Name
                        </Label>
                        <Input
                            class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none"
                            id="first_name"
                            name="first_name"
                            type="text"
                            placeholder="First name"
                            v-model="form.first_name"
                        />
                    </div>
                    <div class="mb-4">
                        <Label
                            class="mb-2 block text-sm font-bold text-gray-700"
                            for="last_name"
                        >
                            Last Name
                        </Label>
                        <Input
                            class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none"
                            id="last_name"
                            name="last_name"
                            type="text"
                            placeholder="Last name"
                            v-model="form.last_name"
                        />
                    </div>
                </div>
                <div class="my-4 w-1/2">
                    <Label
                        class="m-2 block text-sm font-bold text-gray-700"
                        for="email"
                    >
                        Email
                    </Label>
                    <Input
                        class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none"
                        id="email"
                        name="email"
                        type="text"
                        placeholder="Email address"
                        v-model="form.email"
                    />
                </div>

                <div class="my-4">
                    <button
                        type="submit"
                        class="focus:shadow-outline rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700 focus:outline-none"
                    >
                        Save
                    </button>
                </div>
            </form>
            <div
                class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
            >
                {{ klijent.first_name }} {{ klijent.last_name }} <br />
                {{ klijent.email }} <br />
                {{ klijent.phone }} <br />
                {{ klijent.date_of_birth }} <br />
                {{ klijent.gender }} <br />
                {{ klijent.supervisor }} <br />
                {{ klijent.association }} <br />
            </div>
        </div>
    </AppLayout>
</template>
