<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ClipboardList, LayoutGrid, ScrollText, Settings, ShieldCheck, Users } from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { index as auditLogsIndex } from '@/routes/audit-logs';
import { show as tenantSettingsShow } from '@/routes/tenant-settings';
import { index } from '@/routes/contract-types';
import { index as rolesIndex } from '@/routes/roles';
import { index as taskTypesIndex } from '@/routes/task-types';
import { index as usersIndex } from '@/routes/users';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Contract Types',
        href: index(),
        icon: LayoutGrid,
    },
    {
        title: 'Task Types',
        href: taskTypesIndex(),
        icon: ClipboardList,
    },
    {
        title: 'Roles',
        href: rolesIndex(),
        icon: ShieldCheck,
    },
    {
        title: 'Users',
        href: usersIndex(),
        icon: Users,
    },
    {
        title: 'Audit Log',
        href: auditLogsIndex(),
        icon: ScrollText,
    },
    {
        title: 'Tenant Settings',
        href: tenantSettingsShow(),
        icon: Settings,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="index()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
