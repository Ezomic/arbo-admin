import Api from './Api'
import ContractTypeController from './ContractTypeController'
import TaskTypeController from './TaskTypeController'
import RoleController from './RoleController'
import Settings from './Settings'

const Controllers = {
    Api: Object.assign(Api, Api),
    ContractTypeController: Object.assign(ContractTypeController, ContractTypeController),
    TaskTypeController: Object.assign(TaskTypeController, TaskTypeController),
    RoleController: Object.assign(RoleController, RoleController),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers