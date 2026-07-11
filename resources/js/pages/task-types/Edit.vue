<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, update } from '@/routes/task-types';

type TaskType = {
    id: string;
    name: string;
    description: string | null;
    is_active: boolean;
};

type Option = {
    value: string;
    label: string;
};

defineProps<{
    taskType: TaskType;
    caseTypeOptions: Option[];
    milestoneOptions: Option[];
    enabledCaseTypes: string[];
    enabledMilestones: string[];
    returnDateOverdueEnabled: boolean;
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
            class="max-w-lg space-y-6"
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

            <fieldset class="grid gap-3">
                <legend class="text-sm font-medium leading-none">Auto-create when case type is</legend>
                <p class="text-muted-foreground text-xs">
                    A task of this type is created automatically in the dossier when an open case matches
                    all the conditions selected across this form. Leave everything unchecked to keep this
                    a manual-only task type.
                </p>
                <div class="grid gap-2">
                    <div
                        v-for="type in caseTypeOptions"
                        :key="type.value"
                        class="flex items-center gap-2"
                    >
                        <Checkbox
                            :id="`case_type_${type.value}`"
                            :name="`case_type_conditions[]`"
                            :value="type.value"
                            :default-checked="enabledCaseTypes.includes(type.value)"
                        />
                        <Label :for="`case_type_${type.value}`" class="font-normal">{{ type.label }}</Label>
                    </div>
                </div>
                <InputError :message="errors['case_type_conditions']" />
            </fieldset>

            <fieldset class="grid gap-3">
                <legend class="text-sm font-medium leading-none">Auto-create when milestone is due</legend>
                <div class="grid gap-2">
                    <div
                        v-for="milestone in milestoneOptions"
                        :key="milestone.value"
                        class="flex items-center gap-2"
                    >
                        <Checkbox
                            :id="`milestone_${milestone.value}`"
                            :name="`milestone_conditions[]`"
                            :value="milestone.value"
                            :default-checked="enabledMilestones.includes(milestone.value)"
                        />
                        <Label :for="`milestone_${milestone.value}`" class="font-normal">{{ milestone.label }}</Label>
                    </div>
                </div>
                <InputError :message="errors['milestone_conditions']" />
            </fieldset>

            <fieldset class="grid gap-3">
                <legend class="text-sm font-medium leading-none">Other conditions</legend>
                <div class="flex items-center gap-2">
                    <Checkbox
                        id="return_date_overdue_condition"
                        name="return_date_overdue_condition"
                        value="1"
                        :default-checked="returnDateOverdueEnabled"
                    />
                    <Label for="return_date_overdue_condition" class="font-normal">Return date overdue</Label>
                </div>
                <InputError :message="errors['return_date_overdue_condition']" />
            </fieldset>

            <div class="flex items-center gap-3">
                <Button type="submit" :disabled="processing">Save changes</Button>
            </div>
        </Form>
    </div>
</template>
