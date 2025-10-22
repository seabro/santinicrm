<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clients',
        href: '/clients',
    },
    {
        title: 'Create',
        href: '/clients/create',
    },
];
</script>

<template>
    <Head title="Add Client" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            Dodaj klijenta
            <Form
                action="/clients/store"
                method="post"
                :options="{ preserveScroll: true }"
                #default="{
                    errors,
                    hasErrors,
                    processing,
                    progress,
                    wasSuccessful,
                    recentlySuccessful,
                    setError,
                    clearErrors,
                    resetAndClearErrors,
                    defaults,
                    isDirty,
                    reset,
                    submit,
                }"
            >
                <div v-if="errors.name">
                    {{ errors.name }}
                </div>

                <div v-if="wasSuccessful">User created successfully!</div>

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
                    />
                </div>

                <div class="my-4">
                    <button
                        type="submit"
                        :disabled="processing"
                        class="focus:shadow-outline rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700 focus:outline-none"
                    >
                        {{ processing ? 'Creating...' : 'Save' }}
                    </button>
                </div>
            </Form>
        </div>
    </AppLayout>
</template>
