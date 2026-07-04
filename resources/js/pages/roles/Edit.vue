<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import PermissionTree from '@/components/PermissionTree.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, update } from '@/routes/roles';

type Permission = { id: string; parent_id: string | null; app_slug: string; name: string };

type Role = {
    id: string;
    app_slug: string;
    name: string;
    description: string | null;
    permission_ids: string[];
};

defineProps<{
    role: Role;
    permissions: Permission[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Roles', href: index() }],
    },
});
</script>

<template>
    <Head :title="`Edit ${role.name}`" />

    <div class="flex flex-col gap-6 p-4">
        <Heading :title="role.name" :description="role.app_slug" />

        <Form
            v-bind="update.form({ role: role.id })"
            v-slot="{ errors, processing }"
            class="max-w-lg space-y-4"
        >
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input id="name" name="name" required :default-value="role.name" />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input id="description" name="description" :default-value="role.description ?? undefined" placeholder="Optional" />
                <InputError :message="errors.description" />
            </div>

            <div class="grid gap-2">
                <Label>Permissions</Label>
                <PermissionTree :permissions="permissions" :selected-ids="role.permission_ids" />
            </div>

            <Button type="submit" :disabled="processing">Save changes</Button>
        </Form>
    </div>
</template>
