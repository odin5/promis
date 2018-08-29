import ActionTypes from '../ActionTypes.jsx';
import UrlBuilders from '../resourceUrlBuilders.jsx';
import i18n from '../i18n.jsx';

const fetchInitBase = {
  method: 'GET',
  headers: {
    'Accept': 'application/ld+json'
  },
  cache: 'no-cache',
  redirect: 'follow',
};

export const savePlanId = (planId) => dispatch => {
  dispatch({
    type: ActionTypes.PLANNING_SAVE_PLAN_ID,
    payload: planId
  });
};

export const fetchPlanning = (plan) => dispatch => {
  const url = UrlBuilders.Planning.get(i18n.language, plan);
  fetch(url, fetchInitBase)
    .then(res => res.json())
    .then(data => {
      data.lastUpdate = new Date();
      dispatch({
        type: ActionTypes.PLANNING_FETCH_PLANNING,
        payload: data
      });
    });
};

export const fetchPosts = () => dispatch => {
  fetch('https://jsonplaceholder.typicode.com/posts')
    .then(res => res.json())
    .then(posts =>
      dispatch({
        type: ActionTypes.FETCH_POSTS,
        payload: posts
      })
    );
};

export const createPost = postData => dispatch => {
  fetch('https://jsonplaceholder.typicode.com/posts', {
    method: 'POST',
    headers: {
      'content-type': 'application/json'
    },
    body: JSON.stringify(postData)
  })
    .then(res => res.json())
    .then(post =>
      dispatch({
        type: ActionTypes.NEW_POST,
        payload: post
      })
    );
};