import {createStore} from 'vuex'

import layout from './modules/layout';
import menu from './modules/menu';
import chat from './modules/chat';
import product from './modules/product';
import todo from './modules/todo';
import contact from './modules/contact';
import jobs from './modules/jobs';
import courses from './modules/courses';
import common from './modules/common';
import tags from './modules/tags';
import bootsrap from "./modules/bootsrap"
import language from "./modules/language"


export default createStore({
  state:{langIcon: '',langLangauge: '',isActive:false},
  getters:{
    langIcon: (state)=>{ return state.langIcon},
    langLangauge:(state)=>{return state.langLangauge}
  },
  mutations: {
      changeLang (state, payload) {
        localStorage.setItem('currentLanguage', payload.id);
        localStorage.setItem('currentLanguageIcon', payload.icon);
        state.langIcon = payload.icon || 'flag-icon-us'
        state.langLangauge = payload.id || 'EN'
      },
      change(state){
        state.isActive = !state.isActive
      }
    },
    actions: {
      setLang ({ commit }, payload) {
        commit('changeLang', payload);  
        
      }
    },
    modules: {
      alert,
      layout,
      chat,
      menu,
      product,
      todo,
    tags,
      jobs,
      courses,language,
      common,contact,bootsrap
    }
});

