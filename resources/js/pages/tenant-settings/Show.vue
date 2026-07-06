<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ShieldCheck } from '@lucide/vue';
import { ref } from 'vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { update } from '@/routes/tenant-settings';

const props = defineProps<{
    require2fa: boolean;
}>();

const enabled = ref(props.require2fa);
</script>

<template>
    <Head title="Tenant Settings" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex items-center gap-3">
            <ShieldCheck class="text-muted-foreground size-5" />
            <Heading
                title="Tenant Settings"
                description="Security and compliance settings for your organisation"
            />
        </div>

        <Form
            v-bind="update.form()"
            v-slot="{ processing }"
            class="flex flex-col gap-6"
        >
            <div class="flex items-center justify-between rounded-lg border p-4">
                <div>
                    <div class="font-medium">Require two-factor authentication</div>
                    <div class="text-muted-foreground text-sm">
                        All users must configure TOTP or a passkey before accessing any portal.
                        Recommended for NEN 7510 compliance.
                    </div>
                </div>
                <Switch
                    v-model:checked="enabled"
                    name="require_2fa"
                    :value="enabled ? '1' : '0'"
                />
                <input type="hidden" name="require_2fa" :value="enabled ? '1' : '0'" />
            </div>

            <div>
                <Button type="submit" :disabled="processing">Save settings</Button>
            </div>
        </Form>
    </div>
</template>
