<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';

type Permission = {
    id: string;
    parent_id: string | null;
    app_slug: string;
    name: string;
};

const props = defineProps<{
    permissions: Permission[];
    selectedIds: string[];
    parentId?: string | null;
}>();

const children = props.permissions.filter(
    (permission) => permission.parent_id === (props.parentId ?? null),
);
</script>

<template>
    <ul class="space-y-1" :class="{ 'ml-5 border-l pl-3': parentId }">
        <li v-for="permission in children" :key="permission.id">
            <Label class="flex items-center gap-2 py-1 text-sm font-normal">
                <Checkbox
                    name="permission_ids[]"
                    :value="permission.id"
                    :model-value="selectedIds.includes(permission.id)"
                />
                {{ permission.name }}
            </Label>

            <PermissionTree
                :permissions="permissions"
                :selected-ids="selectedIds"
                :parent-id="permission.id"
            />
        </li>
    </ul>
</template>
