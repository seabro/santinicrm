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
    date_of_birth: props.klijent.date_of_birth,
    gender: props.klijent.gender,
    supervisor: props.klijent.supervisor,
    association: props.klijent.association,
});

const submit = () => {
    form.put(clients.update(props.klijent.id).url, {
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
                            class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight shadow focus:outline-none"
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
                            class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight shadow focus:outline-none"
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
                        class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight shadow focus:outline-none"
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Email address"
                        v-model="form.email"
                    />
                </div>
                <div class="my-4 w-1/2">
                    <Label
                        class="m-2 block text-sm font-bold text-gray-700"
                        for="date_of_birth"
                    >
                        Date of Birth
                    </Label>
                    <input
                        class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight shadow focus:outline-none"
                        id="date_of_birth"
                        name="date_of_birth"
                        type="date"
                        placeholder="Date of Birth"
                        v-model="form.date_of_birth"
                    />
                </div>
                <div class="my-4 w-1/2">
                    <Label
                        class="m-2 block text-sm font-bold text-gray-700"
                        for="phone"
                    >
                        Phone Number
                    </Label>
                    <Input
                        class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight shadow focus:outline-none"
                        id="phone"
                        name="phone"
                        type="text"
                        placeholder="Phone number"
                        v-model="form.phone"
                    />
                </div>
                <div class="my-4 w-1/2">
                    <Label
                        class="m-2 block text-sm font-bold text-gray-700"
                        for="gender"
                    >
                        Gender
                    </Label>
                    <Input
                        class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight shadow focus:outline-none"
                        id="gender"
                        name="gender"
                        type="text"
                        placeholder="Gender"
                        v-model="form.gender"
                    />
                </div>

                <div class="my-4 w-1/2">
                    <Label
                        class="m-2 block text-sm font-bold text-gray-700"
                        for="supervisor"
                    >
                        Supervisor
                    </Label>
                    <Input
                        class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight shadow focus:outline-none"
                        id="supervisor"
                        name="supervisor"
                        type="text"
                        placeholder="supervisor"
                        v-model="form.supervisor"
                    />
                </div>
                <div class="my-4 w-1/2">
                    <Label
                        class="m-2 block text-sm font-bold text-gray-700"
                        for="association"
                    >
                        Association
                    </Label>
                    <Input
                        class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight shadow focus:outline-none"
                        id="association"
                        name="association"
                        type="text"
                        placeholder="association"
                        v-model="form.association"
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
        </div>
    </AppLayout>
</template>
