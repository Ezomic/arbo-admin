<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { Plus } from '@lucide/vue';
import { ref } from 'vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { edit, store } from '@/routes/contract-types';

type ContractType = {
    id: string;
    name: string;
    description: string | null;
    is_active: boolean;
};

defineProps<{
    contractTypes: ContractType[];
}>();

const showCreateDialog = ref(false);
</script>

<template>
    <Head title="Contract Types" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex items-center justify-between">
            <Heading
                title="Contract Types"
                description="Tenant-wide contract types your case officers can assign when creating a contract"
            />
            <Button variant="ghost" size="icon" aria-label="Add contract type" @click="showCreateDialog = true">
                <Plus class="size-4" />
            </Button>
        </div>

        <ul class="flex flex-col gap-2">
            <li v-for="contractType in contractTypes" :key="contractType.id">
                <Link
                    :href="edit.url(contractType)"
                    class="flex flex-col rounded-lg border p-4 transition-colors hover:bg-muted/50"
                >
                    <div class="font-medium">{{ contractType.name }}</div>
                    <div v-if="contractType.description" class="text-sm text-muted-foreground">
                        {{ contractType.description }}
                    </div>
                    <div class="mt-1 text-xs text-muted-foreground">
                        {{ contractType.is_active ? 'Active' : 'Inactive' }}
                    </div>
                </Link>
            </li>
            <li v-if="contractTypes.length === 0" class="text-sm text-muted-foreground">
                No contract types yet.
            </li>
        </ul>
    </div>

    <Dialog v-model:open="showCreateDialog">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Add contract type</DialogTitle>
            </DialogHeader>
            <Form
                v-bind="store.form()"
                v-slot="{ errors, processing }"
                :reset-on-success="['name', 'description']"
                class="space-y-3"
            >
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" name="name" required placeholder="e.g. Basic verzuimbegeleiding" />
                    <InputError :message="errors.name" />
                </div>
                <div class="grid gap-2">
                    <Label for="description">Description</Label>
                    <Input id="description" name="description" placeholder="Optional" />
                    <InputError :message="errors.description" />
                </div>
                <Button type="submit" :disabled="processing">Add contract type</Button>
            </Form>
        </DialogContent>
    </Dialog>
</template>
