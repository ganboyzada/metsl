<template>
  <div class="col-sm-12 col-xl-6 xl-100 box-col-12 text-start">
    <div class="card">
      <div class="card-header"><h5>Material Tab With Color</h5></div>
      <div class="card-body">
        <div class="tabbed-card">
            <ul role="tablist" class="pull-right nav nav-tabs border-tab nav-success">
              <li role="presentation" class="nav-item"  v-on:click="changetab('timeline')"  >
                <a :class="{ 'show active': showtab == 'timeline' }" id="top-timeline" data-bs-toggle="tab" role="tab"  aria-controls="timeline" aria-selected="false"  class="nav-link" ><i class="fa fa-home"></i>Home</a>
              </li>
              <li role="presentation" class="nav-item" v-on:click="changetab('about')" >
                <a class="nav-link" :class="{ 'show active': showtab == 'about' }"  id="top-about" data-toggle="tab"  role="tab" aria-controls="about"  aria-selected="false" > <i class="fa fa-user"></i>Profile</a  >
              </li>
              <li  role="presentation" class="nav-item"  v-on:click="changetab('friends')" >
                <a class="nav-link" :class="{ 'show active': showtab == 'friends' }" id="top-friends"  data-toggle="tab" role="tab" aria-controls="friends"  aria-selected="false"  > <i class="fa fa-address-book"></i>Contact</a >
              </li>
            </ul>
          <div class="tab-content" id="top-tabContent">
                              <div class="tab-pane fade" :class="{'show active': showtab == 'timeline' }" id="timeline" role="tabpanel" aria-labelledby="timeline">
                               Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                              </div>
                              <div class="tab-pane fade" :class="{'show active': showtab == 'about' }" id="about" role="tabpanel" aria-labelledby="about">
                                  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                              </div>
                              <div class="tab-pane fade" :class="{'show active': showtab == 'friends' }" id="friends" role="tabpanel" aria-labelledby="friends">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                              </div>
                             
                            </div> 
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    data(){
        return{
            showtab:'timeline',
        }
    },
    methods:{
          changetab(tab) {
        this.showtab = tab;
      }
    }
};
</script>