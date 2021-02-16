<template>
<div>
    <form action="/api/postPicture" class="form-inline" role="form" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Post Title</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter Post Title" v-model="formData.title">
        </div>

        <div class="form-group"> 
            <label for="description">Picture</label>
            <input type="file" name="file" id="file" @change="onFileChange">
            <br>
            <input type="submit" value="Upload" name="submit" class="btn btn-success pull-right">
        </div>
        <input type="hidden" :value="csrf" name="_token">           
    </form>
</div>
</template>
<script>
export default {
    data() {
        return{
            formFields: {
                title: null,
                picture: null
            },
            image: '',
            csrf: document.getElementsByTagName('input').item(name="_token").value,
        };
    },
    methods: {
        onFileChange(e) {
            let file = document.querySelector('input[type=file]').files[0];
            let reader = new FileReader();
            let vm =this;
            //vm.file_name=file;
            reader.addEventListener("load", function () {
                vm.image = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
            vm.file_name=file;
            console.log(vm.file_name);
            console.log(this.image);
        },               
    },
};
</script>
