<template>
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Upload</div>
                <form>
                <div class="panel-body">
                    <!-- <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading" accept= "video/*"> -->
                <div class="fileinput fileinput-new input-group" data-provides="fileinput" v-if="!uploading">

                        <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i><span class="fileinput-filename"></span>
                        </div>

                        <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select Video File</span><span class="fileinput-exists">Change</span>
                        <input type="file" name="video" id="video" @change="fileInputChange" 
                         accept= "video/*">
                        </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                
                </div>
                </form>
                    <div class="alert alert-danger" v-if="failed">Something Failed Please Try again.
                    
                    </div>
                    
                    <div class="alert alert-default" v-if="failed">
                    
                        <center>
                                <button type="button" class="btn btn-info"
                                onclick="location.reload();" >Try Again :)</button>
                        </center>

                    </div>    
                    

                    <div id="video-form" v-if="uploading && !failed">
                    
                            
                            <div class="alert alert-info" v-if="!uploadingComplete">
                            Your Video will be avaiable at <a href="{{ $root.url }}/videos/{{ uid }}" target="_blank">{{ $root.url }}/videos/{{ uid }}</a>.
                            </div>

                            <div class="alert alert-success" v-if="uploadingComplete">
                            Upload Complete. Your Video is now processing. <a href="/videos">Go to your videos.</a>
                            </div>

                            <div class="progress" v-if="!uploadingComplete">

                                <div class="progress-bar" v-bind:style="{ width: fileProgress + '%' }">



                                </div>


                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input id="title" name="title" type="text" class="form-control" v-model="title">
                            </div>


                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" v-model="description"></textarea>
                            </div>


                            <div class="form-group">
                                <label for="visibility">Visibility</label>
                                <select id="visibility" name="visibility" class="form-control" v-model="visibility">
                                    <option value="private">Private</option>
                                    <!-- <option value="unlisted">Unlisted</option> -->
                                    <option value="public">Public</option>
                                </select>
                            </div>

                            <span class="help-block pull-right">{{ saveStatus }}</span>
                            <button class="btn btn-default" type="submit" @click.prevent="update" >Save changes</button>


                     </div>
 
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {

        data()
        {
            return {

                uid:null,
                uploading: false,
                uploadingComplete: false,
                failed: false,
                title : 'Untitled',
                description : null,
                visibility : 'private',
                saveStatus:null,
                fileProgress:0,
                
            }
        },

        methods: {

            fileInputChange() 
            {
                 this.uploading = true;
                this.failed = false;
                this.file = document.getElementById('video').files[0];
               
                this.store().then(() => {
                    var formData = new FormData();
                    formData.append('video', this.file);
                    formData.append('uid', this.uid);
                    this.$http.post('/upload',formData, 
                    {
                        progress: (e) => {
                            if (e.lengthComputable) {
                                this.updateProgress(e)
                            }
                        }
                    }).then(() => {
                        this.uploadingComplete = true
                    }, () => {
                        this.failed = true
                    });
                }, () => {
                    this.failed = true
                })
            },

            store()
            {
                return this.$http.post('/videos', {

                    title: this.title,
                    description: this.description,
                    visibility: this.visibility,
                    extension: this.file.name.split('.').pop()
                }).then(function (response)
                 {
                     this.uid=response.data.uid;
                });
            },

            update() {
                this.saveStatus = 'Saving changes.';
                return this.$http.put('/videos/' + this.uid, {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility
                }).then(/*if true then*/(response) => {
                    this.saveStatus = 'Changes saved.';
                     //timeout set kiya hai 3 sec ka   
                    setTimeout(() => {
                        this.saveStatus = null
                    }, 3000)
                },/*if false then this*/ () => {
                    this.saveStatus = 'Failed to save changes.';
                });
            },

            updateProgress(e)
            {
                e.percent = (e.loaded / e.total) * 100;
                this.fileProgress = e.percent;
            }
        },
        ready() {
        
            window.onbeforeunload = () => {
                if(this.uploading && !this.uploadingComplete && !this.failed)
                {
                    return 'Are you sure you want to navigate away';
                }
            }

        }
    }
</script>
