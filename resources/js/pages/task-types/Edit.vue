<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, update } from '@/routes/task-types';

type TaskType = {
    id: string;
    name: string;
    description: string | null;
    is_active: boolean;
};

defineProps<{
    taskType: TaskType;
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Task Types', href: index() }],
    },
});
</script>

<template>
    <Head :title="`Edit ${taskType.name}`" />

    <div class="flex flex-col gap-6 p-4">
        <Heading :title="taskType.name" description="Edit task type" />

        <Form
            v-bind="update.form({ taskType: taskType.id })"
            v-slot="{ errors, processing }"
            class="max-w-lg space-y-4"
        >
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input id="name" name="name" required :default-value="taskType.name" />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input id="description" name="description" :default-value="taskType.description ?? undefined" placeholder="Optional" />
                <InputError :message="errors.description" />
            </div>

            <div class="flex items-center gap-3">
                <Button type="submit" :disabled="processing">Save changes</Button>
            </div>
        </Form>
    </div>
</template>
