<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Form } from '@inertiajs/vue3';
import { Plus } from '@lucide/vue';
import { ref } from 'vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { edit, store } from '@/routes/task-types';

type TaskType = {
    id: string;
    name: string;
    description: string | null;
    is_active: boolean;
};

defineProps<{
    taskTypes: TaskType[];
}>();

const showCreateDialog = ref(false);
</script>

<template>
    <Head title="Task Types" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex items-center justify-between">
            <Heading
                title="Task Types"
                description="Tenant-wide task types your case officers can assign to work items"
            />
            <Button variant="ghost" size="icon" aria-label="Add task type" @click="showCreateDialog = true">
                <Plus class="size-4" />
            </Button>
        </div>

        <ul class="flex flex-col gap-2">
            <li v-for="taskType in taskTypes" :key="taskType.id">
                <Link
                    :href="edit.url(taskType)"
                    class="flex flex-col rounded-lg border p-4 transition-colors hover:bg-muted/50"
                >
                    <div class="font-medium">{{ taskType.name }}</div>
                    <div v-if="taskType.description" class="text-sm text-muted-foreground">
                        {{ taskType.description }}
                    </div>
                    <div class="mt-1 text-xs text-muted-foreground">
                        {{ taskType.is_active ? 'Active' : 'Inactive' }}
                    </div>
                </Link>
            </li>
            <li v-if="taskTypes.length === 0" class="text-sm text-muted-foreground">
                No task types yet.
            </li>
        </ul>
    </div>

    <Dialog v-model:open="showCreateDialog">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Add task type</DialogTitle>
            </DialogHeader>
            <Form
                v-bind="store.form()"
                v-slot="{ errors, processing }"
                :reset-on-success="['name', 'description']"
                class="space-y-3"
            >
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" name="name" required placeholder="e.g. Follow-up call" />
                    <InputError :message="errors.name" />
                </div>
                <div class="grid gap-2">
                    <Label for="description">Description</Label>
                    <Input id="description" name="description" placeholder="Optional" />
                    <InputError :message="errors.description" />
                </div>
                <Button type="submit" :disabled="processing">Add task type</Button>
            </Form>
        </DialogContent>
    </Dialog>
</template>
