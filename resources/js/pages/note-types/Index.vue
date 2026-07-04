<script setup lang="ts">
import { Form, Head, useForm } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from '@lucide/vue';
import { ref } from 'vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { destroy, store, update } from '@/routes/note-types';

type Permission = {
    id?: string;
    role: string;
    can_read: boolean;
    can_write: boolean;
    can_update: boolean;
    can_delete: boolean;
};

type NoteType = {
    id: string;
    app_slug: string;
    name: string;
    permissions: Permission[];
};

type Role = {
    id: string;
    app_slug: string;
    name: string;
};

type Portal = {
    slug: string;
    name: string;
};

const props = defineProps<{
    portals: Portal[];
    noteTypes: NoteType[];
    roles: Role[];
}>();

const showCreateDialog = ref(false);
const editingNoteType = ref<NoteType | null>(null);
const createAppSlug = ref('');

function rolesForSlug(slug: string): Role[] {
    return props.roles.filter((r) => r.app_slug === slug);
}

function portalName(slug: string): string {
    return props.portals.find((p) => p.slug === slug)?.name ?? slug;
}

function openCreate(slug: string) {
    createAppSlug.value = slug;
    showCreateDialog.value = true;
}

const deletingNoteType = ref<NoteType | null>(null);

function confirmDelete() {
    if (!deletingNoteType.value) {
        return;
    }

    useForm({}).delete(destroy(deletingNoteType.value.id).url, {
        preserveScroll: true,
        onFinish: () => {
            deletingNoteType.value = null;
        },
    });
}
</script>

<template>
    <Head title="Note Types" />

    <div class="flex flex-col gap-8 p-4">
        <Heading
            title="Note Types"
            description="Define note categories per portal and configure which roles can read, write, update, or delete them"
        />

        <div
            v-for="portal in portals"
            :key="portal.slug"
            class="flex flex-col gap-3"
        >
            <div class="flex items-center justify-between">
                <h2 class="font-medium">{{ portal.name }}</h2>
                <Button
                    variant="ghost"
                    size="icon"
                    :aria-label="`Add note type for ${portal.name}`"
                    @click="openCreate(portal.slug)"
                >
                    <Plus class="size-4" />
                </Button>
            </div>

            <ul class="flex flex-col gap-2">
                <li
                    v-for="nt in noteTypes.filter(
                        (n) => n.app_slug === portal.slug,
                    )"
                    :key="nt.id"
                    class="rounded-lg border p-4"
                >
                    <div class="mb-3 flex items-center justify-between">
                        <span class="font-medium">{{ nt.name }}</span>
                        <div class="flex gap-1">
                            <Button
                                variant="ghost"
                                size="icon"
                                :aria-label="`Edit ${nt.name}`"
                                @click="editingNoteType = nt"
                            >
                                <Pencil class="size-4" />
                            </Button>
                            <Button
                                variant="ghost"
                                size="icon"
                                class="text-destructive"
                                :aria-label="`Delete ${nt.name}`"
                                @click="deletingNoteType = nt"
                            >
                                <Trash2 class="size-4" />
                            </Button>
                        </div>
                    </div>

                    <div
                        v-if="nt.permissions.length > 0"
                        class="overflow-x-auto"
                    >
                        <table class="w-full text-xs">
                            <thead>
                                <tr class="text-left text-muted-foreground">
                                    <th class="pr-4 pb-1 font-normal">Role</th>
                                    <th class="pr-3 pb-1 font-normal">Read</th>
                                    <th class="pr-3 pb-1 font-normal">Write</th>
                                    <th class="pr-3 pb-1 font-normal">
                                        Update
                                    </th>
                                    <th class="pb-1 font-normal">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="perm in nt.permissions"
                                    :key="perm.role"
                                >
                                    <td class="py-0.5 pr-4">{{ perm.role }}</td>
                                    <td class="py-0.5 pr-3">
                                        {{ perm.can_read ? '✓' : '—' }}
                                    </td>
                                    <td class="py-0.5 pr-3">
                                        {{ perm.can_write ? '✓' : '—' }}
                                    </td>
                                    <td class="py-0.5 pr-3">
                                        {{ perm.can_update ? '✓' : '—' }}
                                    </td>
                                    <td class="py-0.5">
                                        {{ perm.can_delete ? '✓' : '—' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-else class="text-xs text-muted-foreground">
                        No role permissions configured.
                    </p>
                </li>
                <li
                    v-if="
                        noteTypes.filter((n) => n.app_slug === portal.slug)
                            .length === 0
                    "
                    class="text-sm text-muted-foreground"
                >
                    No note types yet for {{ portal.name }}.
                </li>
            </ul>
        </div>
    </div>

    <!-- Create dialog -->
    <Dialog v-model:open="showCreateDialog">
        <DialogContent class="max-h-[85vh] overflow-y-auto">
            <DialogHeader>
                <DialogTitle
                    >Add note type —
                    {{ portalName(createAppSlug) }}</DialogTitle
                >
            </DialogHeader>
            <Form
                v-bind="store.form()"
                :reset-on-success="['name']"
                v-slot="{ errors, processing }"
                class="space-y-4"
                @success="showCreateDialog = false"
            >
                <input type="hidden" name="app_slug" :value="createAppSlug" />
                <div class="grid gap-2">
                    <Label for="create_name">Name</Label>
                    <Input
                        id="create_name"
                        name="name"
                        required
                        placeholder="e.g. Medisch advies"
                    />
                    <InputError :message="errors.name" />
                </div>

                <div v-if="rolesForSlug(createAppSlug).length > 0">
                    <p class="mb-2 text-sm font-medium">Permissions per role</p>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-muted-foreground">
                                    <th class="pr-4 pb-1 font-normal">Role</th>
                                    <th class="pr-3 pb-1 font-normal">Read</th>
                                    <th class="pr-3 pb-1 font-normal">Write</th>
                                    <th class="pr-3 pb-1 font-normal">
                                        Update
                                    </th>
                                    <th class="pb-1 font-normal">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(role, i) in rolesForSlug(
                                        createAppSlug,
                                    )"
                                    :key="role.id"
                                >
                                    <td class="py-1 pr-4 text-sm">
                                        {{ role.name }}
                                    </td>
                                    <input
                                        type="hidden"
                                        :name="`permissions[${i}][role]`"
                                        :value="role.name"
                                    />
                                    <td class="py-1 pr-3">
                                        <Checkbox
                                            :name="`permissions[${i}][can_read]`"
                                            value="1"
                                        />
                                    </td>
                                    <td class="py-1 pr-3">
                                        <Checkbox
                                            :name="`permissions[${i}][can_write]`"
                                            value="1"
                                        />
                                    </td>
                                    <td class="py-1 pr-3">
                                        <Checkbox
                                            :name="`permissions[${i}][can_update]`"
                                            value="1"
                                        />
                                    </td>
                                    <td class="py-1">
                                        <Checkbox
                                            :name="`permissions[${i}][can_delete]`"
                                            value="1"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <p v-else class="text-sm text-muted-foreground">
                    No roles defined for this portal yet.
                </p>

                <Button type="submit" :disabled="processing"
                    >Add note type</Button
                >
            </Form>
        </DialogContent>
    </Dialog>

    <!-- Edit dialog -->
    <Dialog
        :open="editingNoteType !== null"
        @update:open="
            (open) => {
                if (!open) editingNoteType = null;
            }
        "
    >
        <DialogContent
            v-if="editingNoteType"
            class="max-h-[85vh] overflow-y-auto"
        >
            <DialogHeader>
                <DialogTitle>Edit — {{ editingNoteType.name }}</DialogTitle>
            </DialogHeader>
            <Form
                v-bind="update.form({ noteType: editingNoteType.id })"
                v-slot="{ errors, processing }"
                class="space-y-4"
                @success="editingNoteType = null"
            >
                <div class="grid gap-2">
                    <Label for="edit_name">Name</Label>
                    <Input
                        id="edit_name"
                        name="name"
                        required
                        :default-value="editingNoteType.name"
                    />
                    <InputError :message="errors.name" />
                </div>

                <div v-if="editingNoteType.permissions.length > 0">
                    <p class="mb-2 text-sm font-medium">Permissions per role</p>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-muted-foreground">
                                    <th class="pr-4 pb-1 font-normal">Role</th>
                                    <th class="pr-3 pb-1 font-normal">Read</th>
                                    <th class="pr-3 pb-1 font-normal">Write</th>
                                    <th class="pr-3 pb-1 font-normal">
                                        Update
                                    </th>
                                    <th class="pb-1 font-normal">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(
                                        perm, i
                                    ) in editingNoteType.permissions"
                                    :key="perm.role"
                                >
                                    <td class="py-1 pr-4 text-sm">
                                        {{ perm.role }}
                                    </td>
                                    <input
                                        type="hidden"
                                        :name="`permissions[${i}][role]`"
                                        :value="perm.role"
                                    />
                                    <td class="py-1 pr-3">
                                        <Checkbox
                                            :name="`permissions[${i}][can_read]`"
                                            value="1"
                                            :default-checked="perm.can_read"
                                        />
                                    </td>
                                    <td class="py-1 pr-3">
                                        <Checkbox
                                            :name="`permissions[${i}][can_write]`"
                                            value="1"
                                            :default-checked="perm.can_write"
                                        />
                                    </td>
                                    <td class="py-1 pr-3">
                                        <Checkbox
                                            :name="`permissions[${i}][can_update]`"
                                            value="1"
                                            :default-checked="perm.can_update"
                                        />
                                    </td>
                                    <td class="py-1">
                                        <Checkbox
                                            :name="`permissions[${i}][can_delete]`"
                                            value="1"
                                            :default-checked="perm.can_delete"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <Button type="submit" :disabled="processing"
                    >Save changes</Button
                >
            </Form>
        </DialogContent>
    </Dialog>

    <!-- Delete confirmation dialog -->
    <Dialog
        :open="deletingNoteType !== null"
        @update:open="
            (open) => {
                if (!open) deletingNoteType = null;
            }
        "
    >
        <DialogContent v-if="deletingNoteType">
            <DialogHeader>
                <DialogTitle>Delete note type</DialogTitle>
                <DialogDescription>
                    You are about to delete "{{ deletingNoteType.name }}" ({{
                        portalName(deletingNoteType.app_slug)
                    }}) and its role permissions. This cannot be undone.
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <Button variant="ghost" @click="deletingNoteType = null"
                    >Cancel</Button
                >
                <Button variant="destructive" @click="confirmDelete"
                    >Delete</Button
                >
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
