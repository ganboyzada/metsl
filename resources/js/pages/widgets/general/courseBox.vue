<template>
    <div class="col-xxl-3 col-xl-4 col-md-6 box-col-6">
        <div class="row">
            <div class="col-sm-12">
                <div class="card course-box widget-course">
                    <div class="card-body">
                        <div class="course-widget">
                            <div class="course-icon">
                                <svg class="fill-icon">
                                    <use href="@/assets/svg/icon-sprite.svg#course-1"></use>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-0">100+</h4><span class="f-light">Completed Courses</span><router-link
                                    class="btn btn-light f-light" to="/learning/list">View course<span class="ms-2">
                                        <svg class="fill-icon f-light">
                                            <use href="@/assets/svg/icon-sprite.svg#arrowright"></use>
                                        </svg></span></router-link>
                            </div>
                        </div>
                    </div>
                    <ul class="square-group">
                        <li class="square-1 warning"></li>
                        <li class="square-1 primary"></li>
                        <li class="square-2 warning1"></li>
                        <li class="square-3 danger"></li>
                        <li class="square-4 light"></li>
                        <li class="square-5 warning"></li>
                        <li class="square-6 success"></li>
                        <li class="square-7 success"></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card course-box widget-course">
                    <div class="card-body">
                        <div class="course-widget">
                            <div class="course-icon warning">
                                <svg class="fill-icon">
                                    <use href="@/assets/svg/icon-sprite.svg#course-2"></use>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-0">50+</h4><span class="f-light">In Progress Courses</span><router-link
                                    class="btn btn-light f-light" to="/learning/list">View course<span class="ms-2">
                                        <svg class="fill-icon f-light">
                                            <use href="@/assets/svg/icon-sprite.svg#arrowright"></use>
                                        </svg></span></router-link>
                            </div>
                        </div>
                    </div>
                    <ul class="square-group">
                        <li class="square-1 warning"></li>
                        <li class="square-1 primary"></li>
                        <li class="square-2 warning1"></li>
                        <li class="square-3 danger"></li>
                        <li class="square-4 light"></li>
                        <li class="square-5 warning"></li>
                        <li class="square-6 success"></li>
                        <li class="square-7 success"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>