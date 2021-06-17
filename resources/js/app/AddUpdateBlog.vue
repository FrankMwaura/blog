<template>
  <div class="container">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
              <h3 class="card-title" v-if="form.id">Update Blog</h3>
              <h3 class="card-title" v-else>Create Blog</h3>
          </div>

        </div>
        <div class="card-body">
          
                                <el-form label-position="top" size="mini" label-width="120px" @submit.prevent="saveUpdateBlog">
                                    <div class="row">
                                        <div class="col-4">
                                            <el-form-item label="Blog Name">
                                            <el-input v-model="form.name" placeholder="Blog Name"></el-input>
                                            <span class="text-danger" v-if="errors['name']">
                                                {{errors['name'][0]}}
                                            </span>
                                            </el-form-item>
                                        </div>
                                        <div class="col-4">
                                            <el-form-item label="Category">
                                                <el-select v-model="form.category_id" placeholder="Select Category" class="w-100">

                                                <el-option v-for="category in categories" :key="category.id" :label="category.name" :value="category.id"></el-option>
                                                
                                                </el-select>
                                                <span class="text-danger" v-if="errors['category_id']">
                                                    {{errors['category_id'][0]}}
                                                </span>
                                            </el-form-item>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <el-form-item label="Image">
                                            <input @change="handleImage" placeholder="Select Image" type="file" />
                                            <img :src="`/uploads/${blog.image}`" alt="" width="100px" height="100px" v-if="form.image" />
                                            <span class="text-danger" v-if="errors['image']">
                                                {{errors['image'][0]}}
                                            </span>
                                            </el-form-item>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="col-8">
                                            <el-form-item label="Small Description">
                                                <el-input type="textarea" v-model="form.small_description" placeholder="Small Description"></el-input>
                                                <span class="text-danger" v-if="errors['small_description']">
                                                    {{errors['small_description'][0]}}
                                                </span>
                                            </el-form-item>
                                            <hr>
                                            
                                            <el-form-item label="Blog Description">
                                                <el-input type="textarea" v-model="form.description" placeholder="Blog Description"></el-input>
                                                <span class="text-danger" v-if="errors['description']">
                                                    {{errors['description'][0]}}
                                                </span>
                                            </el-form-item>

                                            <el-button v-if="form.id" @click.prevent="saveUpdateBlog" type="success" style="float:right" size="mini">
                                                Update Blog
                                            </el-button>
                                            <el-button v-else @click.prevent="saveUpdateBlog" type="success" style="float:right" size="mini">
                                                Create Blog
                                            </el-button>
                                        </div>
                                        <div class="col-2"></div>
                                    </div>
                                </el-form>
        </div>
      </div>
  </div>
</template>

<script>
export default {
    data(){
        return {
            errors: {},
            form:{
                image: '',
                category_id: '',
                name: '',
                small_description: '',
                description: ''
            }
        }
    },
    methods: {
        handleImage(e){
            // console.log(e.target.files[0])
            this.form.image = e.target.files[0]
        },
        categoryList(){
            this.$store.dispatch('categoryListAll')
        },
        saveBlog(formData){
            axios.post('/api/blog', formData)
                .then(res=>{
                    this.$message({
                        message: 'Blog created successfully',
                        type: 'success'
                    })
                    this.$router.push({name: 'BlogList'})
                })
                .catch(err=>{
                    this.errors = err.response.data.errors
                })

        },
        updateBlog(formData){
            axios.post(`/api/blog-update/${this.$route.params.blogId}`,formData)
                .then(res=>{
                    console.log(res.data)
                    this.$message({
                        message: 'Blog updated successfully',
                        type: 'success'
                    })
                    this.$router.push({name: 'BlogList'})
                })
                .catch(err=>{
                    this.errors = err.response.data.errors
                })
        },
        saveUpdateBlog(){
            let formData = new FormData()
            formData.append('category_id', this.form.category_id)
            formData.append('name', this.form.name)
            formData.append('description', this.form.description)
            formData.append('small_description', this.form.small_description)
            formData.append('image', this.form.image)
            if (this.blog.id) {
                this.updateBlog(formData)
            }else{
                this.saveBlog(formData)
            }
        },
        editBlogById(){
            this.$store.dispatch('editBlog', this.$route.params.blogId)
        }
    },
    created(){
        this.categoryList()
        if (this.$route.params.blogId) {
            this.editBlogById()
        }
    },
    computed: {
        categories(){
            return this.$store.getters['categoryList']
        },
        blog(){
            return this.$store.getters['singleBlog']
        }
    },
    watch: {
        blog(){
            this.form = this.blog
        }
    }
}
</script>

<style>

</style>