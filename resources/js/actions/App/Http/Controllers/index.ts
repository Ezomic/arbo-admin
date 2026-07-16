import Api from './Api';
import ContractTypeController from './ContractTypeController';
import TaskTypeController from './TaskTypeController';
import RoleController from './RoleController';
import DataBreachController from './DataBreachController';
import NoteTypeController from './NoteTypeController';
import UserController from './UserController';
import AuditLogController from './AuditLogController';
import TenantSettingsController from './TenantSettingsController';
import Settings from './Settings';

const Controllers = {
    Api: Object.assign(Api, Api),
    ContractTypeController: Object.assign(
        ContractTypeController,
        ContractTypeController,
    ),
    TaskTypeController: Object.assign(TaskTypeController, TaskTypeController),
    RoleController: Object.assign(RoleController, RoleController),
    DataBreachController: Object.assign(
        DataBreachController,
        DataBreachController,
    ),
    NoteTypeController: Object.assign(NoteTypeController, NoteTypeController),
    UserController: Object.assign(UserController, UserController),
    AuditLogController: Object.assign(AuditLogController, AuditLogController),
    TenantSettingsController: Object.assign(
        TenantSettingsController,
        TenantSettingsController,
    ),
    Settings: Object.assign(Settings, Settings),
};

export default Controllers;
