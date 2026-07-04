import ContractTypeApiController from './ContractTypeApiController'
import NoteTypeApiController from './NoteTypeApiController'

const Api = {
    ContractTypeApiController: Object.assign(ContractTypeApiController, ContractTypeApiController),
    NoteTypeApiController: Object.assign(NoteTypeApiController, NoteTypeApiController),
}

export default Api