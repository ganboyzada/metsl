<template>
    <Breadcrumbs title="Dropzone" main="Bonus UI"/>
    <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h5>Single File Upload</h5>
              </div>
              <div class="card-body">
                <form class="dropzone" id="singleFileUpload" action="/upload.php">
                  <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                    <DropZone :maxFileSize="Number(60000000)" url="http://localhost:8080" :uploadOnDrop="true"  />
                </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h5>Multi File Upload</h5>
              </div>
              <div class="card-body">
                <form class="dropzone dropzone-primary" id="multiFileUpload" action="/upload.php">
                  <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                    <DropZone :maxFileSize="Number(60000000)" url="http://localhost:8080" :uploadOnDrop="true" :multipleUpload="true" :parallelUpload="2" />
                </div>
                </form>
              </div>
            </div>
          </div>
          
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h5>File Type Validation</h5>
              </div>
              <div class="card-body">
                <form class="dropzone dropzone-info" id="fileTypeValidation" action="/upload.php">
                  <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                    <DropZone :maxFileSize="Number(60000000)" url="http://localhost:8080" :uploadOnDrop="true" :multipleUpload="true" :parallelUpload="2" />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
</template>