<template>
  <div>
    <Breadcrumbs main="app" title="Knowledge Base" />

    <div class="container-fluid knowledgebase-page">
      <div class="row">
        <div class="col-12">
          <div class="knowledgebase-bg">
            <img class="bg-img-cover bg-center " src="../../assets/images/knowledgebase/bg_1.jpg" alt="looginpage" />
          </div>
          <div class="knowledgebase-search">
            <div>
              <h3>How Can I help you?</h3>
              <form class="form-inline" action="#" method="get">
                <div class="form-group w-100">
                  <vue-feather type="search"></vue-feather>
                  <input class="form-control-plaintext w-100" type="text" placeholder="Type question here" title="" />
                </div>
              </form>
            </div>
          </div>
        </div>
        <articlesView />
        <browseArticles />

        <featuredTutorials />
        <latestArticles />

      </div>
    </div>
  </div>
</template>
  
<script>
import { mapState } from 'vuex';
import articlesView from "./articlesView.vue"
import pxcard from '../../components/Pxcard.vue'
import browseArticles from "./browseArticles.vue"
import featuredTutorials from "./featuredTutorials.vue"
import latestArticles from "./latestArticles.vue"
export default {
  components: {
    'px-card': pxcard, articlesView, browseArticles, featuredTutorials, latestArticles
  },
  data() {
    return {};
  },
  computed: {
    ...mapState({
      knowledgebasedata: (state) => state.common.knowledgebasedata,
    }),
  },
};
</script>
  
<style>
.search-form.search-knowledge .form-group {
  position: relative;
}

.search-form.search-knowledge .form-group:after {
  position: absolute;
  content: "\F002";
  font-family: FontAwesome;
  top: 10px;
  left: 30px;
}
</style>