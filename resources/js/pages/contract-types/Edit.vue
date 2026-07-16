<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, update } from '@/routes/contract-types';

type ContractType = {
    id: string;
    name: string;
    description: string | null;
    is_active: boolean;
};

type CaseTypeOption = {
    value: string;
    label: string;
};

defineProps<{
    contractType: ContractType;
    caseTypes: CaseTypeOption[];
    enabledCaseTypes: string[];
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
            class="max-w-lg space-y-6"
        >
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input
                    id="name"
                    name="name"
                    required
                    :default-value="contractType.name"
                />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input
                    id="description"
                    name="description"
                    :default-value="contractType.description ?? undefined"
                    placeholder="Optional"
                />
                <InputError :message="errors.description" />
            </div>

            <fieldset class="grid gap-3">
                <legend class="text-sm leading-none font-medium">
                    Enabled case types
                </legend>
                <p class="text-xs text-muted-foreground">
                    Select which case types can be opened for employers on this
                    contract type. If none are selected, all case types are
                    available.
                </p>
                <div class="grid gap-2">
                    <div
                        v-for="type in caseTypes"
                        :key="type.value"
                        class="flex items-center gap-2"
                    >
                        <Checkbox
                            :id="`case_type_${type.value}`"
                            :name="`case_types[]`"
                            :value="type.value"
                            :default-checked="
                                enabledCaseTypes.includes(type.value)
                            "
                        />
                        <Label
                            :for="`case_type_${type.value}`"
                            class="font-normal"
                            >{{ type.label }}</Label
                        >
                    </div>
                </div>
                <InputError :message="errors['case_types']" />
            </fieldset>

            <div class="flex items-center gap-3">
                <Button type="submit" :disabled="processing"
                    >Save changes</Button
                >
            </div>
        </Form>
    </div>
</template>
