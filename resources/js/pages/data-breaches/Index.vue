<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { AlertTriangle } from '@lucide/vue';
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { create, notify } from '@/routes/data-breaches';

type DataBreach = {
    id: string;
    discovered_at: string;
    description: string;
    data_categories: string[];
    individuals_affected: number | null;
    status: 'open' | 'notified';
    authority_notified_at: string | null;
};

defineProps<{
    breaches: DataBreach[];
}>();

const statusVariant = (
    status: string,
): 'default' | 'secondary' | 'destructive' | 'outline' => {
    if (status === 'notified') {
        return 'secondary';
    }

    return 'destructive';
};

const formatDate = (iso: string) =>
    new Intl.DateTimeFormat('nl-NL', { dateStyle: 'medium' }).format(
        new Date(iso),
    );
</script>

<template>
    <Head title="Data Breaches" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <AlertTriangle class="size-5 text-muted-foreground" />
                <Heading
                    title="Data Breach Register"
                    description="AVG Art. 33 — incidents must be reported to the AP within 72 hours of discovery"
                />
            </div>
            <Button as-child>
                <Link :href="create().url">Report incident</Link>
            </Button>
        </div>

        <div class="flex flex-col gap-1 rounded-lg border">
            <div
                v-if="breaches.length === 0"
                class="p-6 text-center text-sm text-muted-foreground"
            >
                No incidents recorded yet.
            </div>
            <div
                v-for="breach in breaches"
                :key="breach.id"
                class="flex items-start gap-4 border-b px-4 py-4 last:border-0"
            >
                <div class="w-24 shrink-0 pt-0.5">
                    <Badge :variant="statusVariant(breach.status)">
                        {{ breach.status === 'notified' ? 'Notified' : 'Open' }}
                    </Badge>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium">
                        {{ breach.description }}
                    </p>
                    <p class="mt-0.5 text-xs text-muted-foreground">
                        Discovered {{ formatDate(breach.discovered_at) }}
                        <span v-if="breach.individuals_affected !== null">
                            · ~{{ breach.individuals_affected }} individuals
                        </span>
                    </p>
                    <p class="mt-1 text-xs text-muted-foreground">
                        {{ breach.data_categories.join(', ') }}
                    </p>
                </div>
                <div class="shrink-0">
                    <Form
                        v-if="breach.status === 'open'"
                        v-bind="notify.form(breach)"
                        v-slot="{ processing }"
                    >
                        <Button
                            type="submit"
                            size="sm"
                            variant="destructive"
                            :disabled="processing"
                        >
                            Notify AP
                        </Button>
                    </Form>
                    <span v-else class="text-xs text-muted-foreground">
                        Notified
                        {{
                            breach.authority_notified_at
                                ? formatDate(breach.authority_notified_at)
                                : ''
                        }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
