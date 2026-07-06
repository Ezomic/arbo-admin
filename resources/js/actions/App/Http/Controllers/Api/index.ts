import ContractTypeApiController from './ContractTypeApiController'
import NoteTypeApiController from './NoteTypeApiController'
import TaskTypeApiController from './TaskTypeApiController'
import RolePermissionApiController from './RolePermissionApiController'

const Api = {
    ContractTypeApiController: Object.assign(ContractTypeApiController, ContractTypeApiController),
    NoteTypeApiController: Object.assign(NoteTypeApiController, NoteTypeApiController),
    TaskTypeApiController: Object.assign(TaskTypeApiController, TaskTypeApiController),
    RolePermissionApiController: Object.assign(RolePermissionApiController, RolePermissionApiController),
}

export default Api