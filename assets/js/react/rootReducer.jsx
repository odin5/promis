import { combineReducers } from 'redux';
import planningReducer from './planning/reducer.jsx'

export default combineReducers({
  planning: planningReducer,
})