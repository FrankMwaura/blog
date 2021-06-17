<template>
  <div class="container">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Blog List</h3>
              <router-link :to="{name: 'AddUpdateBlog'}">
                  <el-button type="success">Add New   
                    <i class="el-icon-plus el-icon-right"></i></el-button>
              </router-link>
              <el-button v-if="multipleSelection.length>0" @click="multipleDelete" type="danger" size="small">Bulk Delete   
                                      <i class="el-icon-delete el-icon-right"></i></el-button>
        </div>
        <div class="card-body">
          
                            <el-table
                                ref="multipleTable"
                                :data="blogs.data"
                                style="width: 100%"
                                @selection-change="handleSelectionChange">

                                <el-table-column
                                type="selection"
                                width="55">
                                </el-table-column>

                                <el-table-column
                                property="name"
                                label="Name"
                                width="250">
                                </el-table-column>

                                <el-table-column
                                label="Date"
                                width="200">
                                <template slot-scope="scope">{{ scope.row.created_at | timeFormat }}</template>
                                </el-table-column>

                                <el-table-column
                                label="Actions" fixed="right">
                                  <template slot-scope="scope">
                                    <el-button  @click.prevent="blogDetails(scope.row)" type="primary" icon="el-icon-view" size="mini"></el-button>
                                    <router-link :to="{name: 'editBlog', params: { blogId: scope.row.id }}">
                                    <el-button type="warning" icon="el-icon-edit-outline" size="mini"></el-button>
                                    </router-link>
                                    <el-button @click="deleteBlog(scope.row.id)" type="danger" icon="el-icon-delete-solid" size="mini"></el-button>
                                  </template>
                                </el-table-column>
                            </el-table>
                            <el-pagination
                            class="text-center mt-2 mb-2"
                            background
                            @current-change="handleCurrentChange"
                            :current-page.sync="currentPage"
                            :page-size="blogs.per_page"
                            layout="prev, pager, next"
                            :total="blogs.total">
                            </el-pagination>
        </div>
      </div>
        <!-- blog details -->
        <el-dialog
        :title="blog.name+ '   Details'"
        :visible.sync="centerDialogVisible"
        width="30%"
        center>
        <span>
            <h5 v-if="blog.category">Category Name: {{blog.category.name}}</h5>
            <p v-if="blog.name">Blog Name: {{blog.name}}</p>
            <p>Small Description: {{blog.small_description}}</p>
            <p>Description: {{blog.description}}</p>
            Image: <img  :src="`/uploads/${blog.image}`" width="100px" height="100px"/> <br>
        </span>
        </el-dialog>
        <!-- blog details -->
  </div>
</template>

<script>
export default {
  name: 'BlogList',
    data(){
        return {
            centerDialogVisible: false,
            blog: {},
            currentPage: 1,
            multipleSelection: []
        }
    },
    methods: {
        blogDetails(row){
            this.blog = row
            this.centerDialogVisible = true
        },
        blogList(){
            this.$store.dispatch('blogList', this.currentPage)
        },
        handleCurrentChange(){
            this.$store.dispatch('blogList', this.currentPage)
            // console.log(this.currentPage)
        },
        toggleSelection(rows) {
            if (rows) {
            rows.forEach(row => {
                this.$refs.multipleTable.toggleRowSelection(row);
            });
            } else {
            this.$refs.multipleTable.clearSelection();
            }
        },
        handleSelectionChange(val) {
            this.multipleSelection = val;
        },
        deleteBlog(id){
            this.$store.dispatch('deleteBlog' ,id)
            this.blogList()
            this.$message({
            message: 'Blog deleted successfully',
            type: 'success'
            })
        },
        multipleDelete(){
            // console.log(this.multipleSelection)
            axios.post('/api/multiple-blog-delete', this.multipleSelection)
            .then(res=>{
                this.$message({
                message: 'Blogs deleted successfully',
                type: 'success'
                })
                this.blogList()
            })
        },
    },
    created(){
        this.blogList()
    },
    computed: {
        blogs(){
            return this.$store.getters['blogList']
        }
    }
}
</script>

<style>

</style>
