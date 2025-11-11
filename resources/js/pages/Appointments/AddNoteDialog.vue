<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { useForm } from '@inertiajs/vue3';
//import { useForm } from 'vee-validate';
import appointments from '@/routes/appointments';
import { watch } from 'vue';
type Appointment = {
    id: number;
    date: Date;
    time: string;
    client_id: number;
    note: string;
    // Add other appointment properties as needed
};

const props = defineProps<{
    open: boolean;
    singleAppointment: Appointment;
}>();

const emit = defineEmits(['close']);

//const zabiljeska = props.appointment.note || '';

const form = useForm({
    //note: zabiljeska,
    note: props.singleAppointment.note,
});

const resetForm = () => {
    form.reset();
    form.clearErrors();
};

watch(
    () => props.open,
    (newVal) => {
        if (!newVal) {
            resetForm();
        }
    },
);

watch(
    () => props.singleAppointment.note,
    (newNote) => {
        form.note = newNote;
    },
);

const submit = () => {
    if (!props.singleAppointment) return;
    form.put(appointments.update(props.singleAppointment.id).url, {
        preserveScroll: true,
        onSuccess: () => {
            emit('close');
            resetForm();
        },
    });
};
</script>

<template>
    <Dialog :open="open" @update:open="(value) => !value && $emit('close')">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Add Note</DialogTitle>
            </DialogHeader>

            <div class="grid gap-4 py-4">
                <div class="grid gap-2">
                    <Label for="note">Message</Label>
                    <Textarea id="note" v-model="form.note" placeholder="Enter your note here..." class="min-h-[100px]" />
                    <p v-if="form.errors.note" class="text-sm text-red-500">
                        {{ form.errors.note }}
                    </p>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <Button variant="outline" @click="$emit('close')" :disabled="form.processing"> Cancel </Button>
                <Button @click="submit" :disabled="form.processing">
                    <span v-if="form.processing">Saving...</span>
                    <span v-else>Save Note</span>
                </Button>
            </div>
        </DialogContent>
    </Dialog>
</template>
