<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { Pencil, Plus } from '@lucide/vue';
import { ref } from 'vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import PermissionTree from '@/components/PermissionTree.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { store, update } from '@/routes/roles';

type Portal = { slug: string; name: string };
type Permission = { id: string; parent_id: string | null; app_slug: string; name: string };

type Role = {
    id: string;
    app_slug: string;
    name: string;
    description: string | null;
    permission_ids: string[];
};

const props = defineProps<{
    portals: Portal[];
    roles: Role[];
    permissions: Permission[];
}>();

const showCreateDialogFor = ref<string | null>(null);
const editingRole = ref<Role | null>(null);

const rolesFor = (slug: string) => props.roles.filter((role) => role.app_slug === slug);
const permissionsFor = (slug: string) => props.permissions.filter((permission) => permission.app_slug === slug);
</script>

<template>
    <Head title="Roles" />

    <div class="flex flex-col gap-8 p-4">
        <Heading title="Roles" description="Each portal has its own roles and permissions" />

        <section v-for="portal in portals" :key="portal.slug" class="flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <h2 class="font-medium">{{ portal.name }}</h2>
                <Button
                    variant="ghost"
                    size="icon"
                    :aria-label="`Add ${portal.name} role`"
                    @click="showCreateDialogFor = portal.slug"
                >
                    <Plus class="size-4" />
                </Button>
            </div>

            <ul class="flex flex-col gap-2">
                <li
                    v-for="role in rolesFor(portal.slug)"
                    :key="role.id"
                    class="flex items-center justify-between rounded-lg border p-4"
                >
                    <div>
                        <div class="font-medium">{{ role.name }}</div>
                        <div v-if="role.description" class="text-sm text-muted-foreground">
                            {{ role.description }}
                        </div>
                        <div class="mt-1 text-xs text-muted-foreground">
                            {{ role.permission_ids.length }} permission{{ role.permission_ids.length === 1 ? '' : 's' }}
                        </div>
                    </div>
                    <Button variant="ghost" size="icon" aria-label="Edit role" @click="editingRole = role">
                        <Pencil class="size-4" />
                    </Button>
                </li>
                <li v-if="rolesFor(portal.slug).length === 0" class="text-sm text-muted-foreground">
                    No {{ portal.name }} roles yet.
                </li>
            </ul>
        </section>
    </div>

    <Dialog
        :open="showCreateDialogFor !== null"
        @update:open="(open) => { if (!open) showCreateDialogFor = null; }"
    >
        <DialogContent v-if="showCreateDialogFor" class="max-h-[85vh] overflow-y-auto">
            <DialogHeader>
                <DialogTitle>
                    Add {{ portals.find((portal) => portal.slug === showCreateDialogFor)?.name }} role
                </DialogTitle>
            </DialogHeader>
            <Form
                v-bind="store.form()"
                v-slot="{ errors, processing }"
                :reset-on-success="['name', 'description']"
                class="space-y-4"
            >
                <input type="hidden" name="app_slug" :value="showCreateDialogFor" />
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" name="name" required placeholder="e.g. Senior case officer" />
                    <InputError :message="errors.name" />
                </div>
                <div class="grid gap-2">
                    <Label for="description">Description</Label>
                    <Input id="description" name="description" placeholder="Optional" />
                    <InputError :message="errors.description" />
                </div>
                <div class="grid gap-2">
                    <Label>Permissions</Label>
                    <PermissionTree :permissions="permissionsFor(showCreateDialogFor)" :selected-ids="[]" />
                </div>
                <Button type="submit" :disabled="processing">Add role</Button>
            </Form>
        </DialogContent>
    </Dialog>

    <Dialog :open="editingRole !== null" @update:open="(open) => { if (!open) editingRole = null; }">
        <DialogContent v-if="editingRole" class="max-h-[85vh] overflow-y-auto">
            <DialogHeader>
                <DialogTitle>Edit {{ editingRole.name }}</DialogTitle>
            </DialogHeader>
            <Form
                v-bind="update.form({ role: editingRole.id })"
                v-slot="{ errors, processing }"
                class="space-y-4"
            >
                <div class="grid gap-2">
                    <Label for="edit_name">Name</Label>
                    <Input id="edit_name" name="name" required :default-value="editingRole.name" />
                    <InputError :message="errors.name" />
                </div>
                <div class="grid gap-2">
                    <Label for="edit_description">Description</Label>
                    <Input
                        id="edit_description"
                        name="description"
                        :default-value="editingRole.description ?? undefined"
                        placeholder="Optional"
                    />
                    <InputError :message="errors.description" />
                </div>
                <div class="grid gap-2">
                    <Label>Permissions</Label>
                    <PermissionTree
                        :permissions="permissionsFor(editingRole.app_slug)"
                        :selected-ids="editingRole.permission_ids"
                    />
                </div>
                <Button type="submit" :disabled="processing">Save changes</Button>
            </Form>
        </DialogContent>
    </Dialog>
</template>
