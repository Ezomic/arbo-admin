<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight, ShieldAlert } from '@lucide/vue';
import { computed } from 'vue';
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { index } from '@/routes/audit-logs';

type AuditLog = {
    id: number;
    user_id: string | null;
    user_name: string | null;
    action: string;
    subject_id: string | null;
    ip_address: string | null;
    created_at: string;
};

const props = defineProps<{
    logs: AuditLog[];
    currentPage: number;
    lastPage: number;
    total: number;
}>();

const actionLabel: Record<string, string> = {
    'medical_case.list_viewed': 'List viewed',
    'medical_case.viewed': 'Case viewed',
    'medical_case.created': 'Case created',
    'medical_case.updated': 'Case updated',
    'medical_case.closed': 'Case closed',
};

const actionVariant = (
    action: string,
): 'default' | 'secondary' | 'destructive' | 'outline' => {
    if (action === 'medical_case.created') {
        return 'default';
    }

    if (action === 'medical_case.closed') {
        return 'secondary';
    }

    if (
        action === 'medical_case.viewed' ||
        action === 'medical_case.list_viewed'
    ) {
        return 'outline';
    }

    return 'default';
};

const hasPrev = computed(() => props.currentPage > 1);
const hasNext = computed(() => props.currentPage < props.lastPage);

const navigate = (page: number) => {
    router.get(index.url({ query: { page } }));
};

const formatDate = (iso: string) =>
    new Intl.DateTimeFormat('nl-NL', {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(new Date(iso));
</script>

<template>
    <Head title="Audit Log" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex items-center gap-3">
            <ShieldAlert class="size-5 text-muted-foreground" />
            <Heading
                title="Medical Record Audit Log"
                description="Every access to medical cases in the Doctors portal — NEN 7513 compliant, tamper-evident"
            />
        </div>

        <div class="text-sm text-muted-foreground">
            {{ total }} entries total
        </div>

        <div class="flex flex-col gap-1 rounded-lg border">
            <div
                v-if="logs.length === 0"
                class="p-6 text-center text-sm text-muted-foreground"
            >
                No audit log entries yet.
            </div>
            <div
                v-for="log in logs"
                :key="log.id"
                class="flex items-center gap-4 border-b px-4 py-3 last:border-0"
            >
                <div class="w-36 shrink-0">
                    <Badge :variant="actionVariant(log.action)">
                        {{ actionLabel[log.action] ?? log.action }}
                    </Badge>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="truncate text-sm font-medium">
                        {{ log.user_name ?? 'Unknown user' }}
                    </div>
                    <div
                        v-if="log.subject_id"
                        class="font-mono text-xs text-muted-foreground"
                    >
                        Case {{ log.subject_id }}
                    </div>
                </div>
                <div class="shrink-0 text-xs text-muted-foreground">
                    {{ log.ip_address }}
                </div>
                <div
                    class="w-36 shrink-0 text-right text-xs text-muted-foreground"
                >
                    {{ formatDate(log.created_at) }}
                </div>
            </div>
        </div>

        <div v-if="lastPage > 1" class="flex items-center justify-between">
            <Button
                variant="outline"
                size="sm"
                :disabled="!hasPrev"
                @click="navigate(currentPage - 1)"
            >
                <ChevronLeft class="mr-1 size-4" />
                Previous
            </Button>
            <span class="text-sm text-muted-foreground"
                >Page {{ currentPage }} of {{ lastPage }}</span
            >
            <Button
                variant="outline"
                size="sm"
                :disabled="!hasNext"
                @click="navigate(currentPage + 1)"
            >
                Next
                <ChevronRight class="ml-1 size-4" />
            </Button>
        </div>
    </div>
</template>
