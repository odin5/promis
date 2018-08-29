import ActionTypes from '../ActionTypes.jsx';

import part1 from './reducerParts/part1.jsx';

const initialState = {
  planId: null,
  inGame: false,
  cellDimensions: {width: 0, height: 0},
  gridViewScroll: {top: 0, left: 0},
  plan: {
    rulerTop: {

    },
    rulerLeft: {

    },
  },
  data: {
    lastUpdate: null,
    planSlots: [],
    turns: [], // grid columns
    works: [], // grid rows
    weathers: [],
    teams: [],
  },
};

export default function(state = initialState, action) {
  // let res = false;
  // res = part1(state, action);
  // if(res !== false) return res;

  switch(action.type) {
    case ActionTypes.PLANNING_SAVE_PLAN_ID:
      return {...state, planId: action.payload};
    case ActionTypes.PLANNING_FETCH_PLANNING:
      let { plan, turns, works, weathers, teams, planSlots } = action.payload;
      return {...state, data: { plan, turns, works, weathers, teams, planSlots }};
    default:
      return state;
  }
}