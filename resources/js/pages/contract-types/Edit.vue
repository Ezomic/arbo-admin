<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, update } from '@/routes/contract-types';

type ContractType = {
    id: string;
    name: string;
    description: string | null;
    is_active: boolean;
};

defineProps<{
    contractType: ContractType;
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Contract Types', href: index() }],
    },
});
</script>

<template>
    <Head :title="`Edit ${contractType.name}`" />

    <div class="flex flex-col gap-6 p-4">
        <Heading :title="contractType.name" description="Edit contract type" />

        <Form
            v-bind="update.form({ contractType: contractType.id })"
            v-slot="{ errors, processing }"
            class="max-w-lg space-y-4"
        >
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input id="name" name="name" required :default-value="contractType.name" />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input id="description" name="description" :default-value="contractType.description ?? undefined" placeholder="Optional" />
                <InputError :message="errors.description" />
            </div>

            <div class="flex items-center gap-3">
                <Button type="submit" :disabled="processing">Save changes</Button>
            </div>
        </Form>
    </div>
</template>
