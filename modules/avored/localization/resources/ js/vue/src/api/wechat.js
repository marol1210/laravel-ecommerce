import request from '@/utils/crequest'


const url = "http://localhost:8008/admin";

var keyword =  {
  conf:{
	  pageSize: 15,
	  page:1
  },
  config: function(options=[]){
	  this.conf = Object.assign({},this.conf,options);
	  return this;
  },
  edit:function(id){

  },
  save:function(data){
    return request.post(url+"/keyword", data);
  },
  update:function(data){
    return request.put(url+"/keyword/"+data.id, data);
  },
  list:function(){
	  var params = this.conf;
    return request.get(url+"/keyword",{'params':params});
  },
  delete:function(id){
    return request.delete(url+"/keyword/"+id);
  }
}

export { keyword }