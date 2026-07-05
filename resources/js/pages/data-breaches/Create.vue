<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { index, store } from '@/routes/data-breaches';

const DATA_CATEGORIES = [
    'NAW-gegevens (naam, adres, woonplaats)',
    'Contactgegevens (e-mail, telefoon)',
    'Financiële gegevens',
    'Burgerservicenummer (BSN)',
    'Gezondheidsgegevens',
    'Arbeidsgegevens',
    'Locatiegegevens',
    'Biometrische gegevens',
    'Bijzondere categorieën (art. 9 AVG)',
];

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Data Breaches', href: index().url }],
    },
});
</script>

<template>
    <Head title="Report Data Breach" />

    <div class="flex flex-col gap-6 p-4">
        <Heading
            title="Report Data Breach"
            description="AVG Art. 33 — complete this form as soon as an incident is discovered"
        />

        <Form
            v-bind="store.form()"
            v-slot="{ errors, processing }"
            class="max-w-2xl space-y-5"
        >
            <div class="grid gap-2">
                <Label for="discovered_at">Date & time discovered</Label>
                <Input
                    id="discovered_at"
                    type="datetime-local"
                    name="discovered_at"
                    required
                />
                <InputError :message="errors.discovered_at" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description of the incident</Label>
                <Textarea
                    id="description"
                    name="description"
                    rows="4"
                    required
                    placeholder="What happened? What data was involved? How was it discovered?"
                />
                <InputError :message="errors.description" />
            </div>

            <fieldset class="grid gap-2">
                <legend class="text-sm leading-none font-medium">
                    Categories of personal data affected
                </legend>
                <div class="mt-2 grid gap-2">
                    <Label
                        v-for="category in DATA_CATEGORIES"
                        :key="category"
                        class="flex cursor-pointer items-center gap-2 font-normal"
                    >
                        <Checkbox name="data_categories[]" :value="category" />
                        {{ category }}
                    </Label>
                </div>
                <InputError :message="errors.data_categories" />
            </fieldset>

            <div class="grid gap-2">
                <Label for="individuals_affected"
                    >Estimated number of individuals affected</Label
                >
                <Input
                    id="individuals_affected"
                    type="number"
                    name="individuals_affected"
                    min="0"
                    placeholder="Leave blank if unknown"
                />
                <InputError :message="errors.individuals_affected" />
            </div>

            <div class="grid gap-2">
                <Label for="measures_taken">Measures taken</Label>
                <Textarea
                    id="measures_taken"
                    name="measures_taken"
                    rows="3"
                    placeholder="What steps have been or will be taken to address the breach?"
                />
                <InputError :message="errors.measures_taken" />
            </div>

            <Button type="submit" :disabled="processing">Log incident</Button>
        </Form>
    </div>
</template>
