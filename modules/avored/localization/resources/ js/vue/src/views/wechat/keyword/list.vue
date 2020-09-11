<template>
  <el-row :gutter="16">
    <el-dialog
      title="添加关键字"
      :visible.sync="centerDialogVisible"
      :close-on-click-modal="false"
      @closed="dialogClose"
      width="30%"
      >
      <keyword-add ref="keyword"></keyword-add>
      <span slot="footer" class="dialog-footer">
        <el-button @click="centerDialogVisible = false">取 消</el-button>
        <el-button type="primary" @click="submit">确 定</el-button>
      </span>
    </el-dialog>
    
    <el-col>
      <el-form :inline="true" class="demo-form-inline">
        <el-form-item>
          <el-input placeholder="关键字"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="centerDialogVisible = true"><i class="el-icon-edit"></i> 添加</el-button>
        </el-form-item>
      </el-form>
    </el-col>

    <el-col>
      <el-table
        :data="tableData"
        border
        style="width: 100%">

        <template slot="empty">
            <div 
              v-loading="loading"
              class="abc"
              element-loading-className="abc"
              element-loading-text="加载中..."
              element-loading-spinner="el-icon-loading"></div>

              <span v-show="empty">
                 暂无数据
              </span>
        </template>

        <el-table-column
          label="关键字"
          class-name="m-col" style="width:30%">
          <template slot-scope="keyword" v-if="keyword.row">
            <el-tag
              v-for="tag in keyword.row.keywords"
              :key="tag.id">
              {{tag.name}}
            </el-tag>
          </template>
        </el-table-column>
        <el-table-column
          prop="content"
          label="内容"
          style="width:35%">
        </el-table-column>
        <el-table-column
          prop="created_at"
          label="创建时间">
        </el-table-column>
        <el-table-column
          prop="address"
          label="操作">

          <template slot-scope="scope">
            <el-button-group>
              <el-button type="primary" size="mini">激活</el-button>
              <el-button type="primary" size="mini" @click="centerDialogVisible = true;edit(scope.row)" icon="el-icon-edit"></el-button>
              <el-button type="danger"  size="mini" @click="del(scope.row)" icon="el-icon-delete"></el-button>
            </el-button-group>
          </template>

        </el-table-column>
      </el-table>
    </el-col>

    <el-col>
      <div style="margin-top:20px;">
        <el-pagination
          layout="total , prev, pager, next"
          :page-sizes="pageSizes"
          :page-size.sync = "pageSize" 
          :current-page.sync = "currentPage" 
          @current-change="goto"
          @size-change="list"
          :total="total">
        </el-pagination>
      </div>
    </el-col>
  </el-row>
</template>

<script>
  import {keyword} from '@/api/wechat'
  const psize =  [15,25,50];

  export default {
    components:{
      "keyword-add" : require('../keyword/add.vue').default
    },
    data() {
      return {
      	pageSizes: psize,
        tableData:[],
        loading: true,
        centerDialogVisible: false,
        global_loading:true,
        pageSize: keyword.conf.pageSize,
        total:0,
        currentPage: keyword.conf.page,
        empty:false
      }
    },
    created:function(){
      this.list();
    },
    methods:{
    	  defaultConfig:function(){
    	  	var $this = this;
    	  	return {
    	  		page : $this.currentPage,
    	  		pageSize : $this.pageSize
    	  	};
    	  },
          dialogClose: function(){
            this.$refs.keyword.clean();
          },
          goto: function(page){
			this.list({'page':page});
          },
          edit: function(row){
            //更新关键字组件,现实当前选中的关键字
            this.$nextTick(_ => {
                if(row){
                  this.$refs.keyword.$data.message = row.content;
                  this.$refs.keyword.$data.dynamicTags = row.keywords.map( e => e.name);
                  this.$refs.keyword.$data.id = row.keyword_id;
                }
            });
          },
          list: function(keyword_conf={}){
            var $this = this;
            var def_conf = $this.defaultConfig();
            keyword_conf = Object.assign({},def_conf,keyword_conf);
            keyword.config(keyword_conf).list().then(function(res){
                $this.loading = false;
                $this.$data.tableData = res.data.data;
                $this.total = res.data.total;
                if($this.$data.tableData.length<=0){
                  $this.empty = true;   
                }else{
                  $this.empty = false;
                }
            });
          },
          del: function(row){
            var $this = this;
            //删除选中的关键字
            this.$confirm('确认删除？').then(_ => {
                var msg = this.$message({iconClass:'el-icon-loading','customClass':'c-loading-msg',message:'删除中...',duration:0});
                keyword.delete(row.keyword_id).then(function(res){
          					if($this.tableData.length<=1){
  	                	$this.goto($this.currentPage-1);
          					}else{
  	                	$this.goto($this.currentPage)
          					}
                    msg.close();
                    $this.$message({message:'删除成功',type:'success'});
                });
            }).catch(function (error) {
              if(error=='cancel'){

              }
            });
          },
          submit: function() {
            var $this = this;
            var data = {
	              keywords: $this.$refs.keyword.$data.dynamicTags,
	              message: $this.$refs.keyword.$data.message,
	              type:'keyword',
	          };
            if($this.$refs.keyword.$data.id){
              data.id = $this.$refs.keyword.$data.id;
              keyword.update(data).then(function(res){
                    $this.$message({message:'编辑成功',type:'success'});
                    $this.centerDialogVisible=false;
                    $this.$refs.keyword.clean();
                    $this.list();
              }).catch(function (error) {
                if(error=='cancel'){

                }
              });
            }else{
              keyword.save(data).then(function(res){
                    $this.$message({message:'添加成功',type:'success'});
                    $this.centerDialogVisible=false;
                    $this.$refs.keyword.clean();
                    $this.list();
              }).catch(function (error) {
                if(error=='cancel'){

                }
              });
            }
          }
    }
  }
</script>

<style>
.m-col .el-tag {
    margin-right: 8px;
}
.abc {
    line-height: initial;
}

.abc .el-loading-mask i , .abc .el-loading-mask .el-loading-text{
    color:#909399;
}

.global_proc_notify .el-loading-mask i , .global_proc_notify .el-loading-mask .el-loading-text{
    color:#909399;
}


/*自定义loading message消息*/
.c-loading-msg {
  color: #909399
}

.c-loading-msg .el-message__content{
  margin-left:10px;
}
</style>