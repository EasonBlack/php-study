<template>
    <div class='content-wrapper'>
        <div-header :title='"Article List"'   :type='"list"'/>
        <div class='list inset'>
            <ul>
                <li>
                    <div class='index font-weight-bold'>ID</div>
                    <div class='name font-weight-bold'>Name</div>
                </li>
                <li v-for="item in list" :key='item.id' 
                @click='articleDetail(item)'
                @mousemove='showDelete(item)' @mouseout='hideDelete(item)'>
                    <div class='index'>
                        {{item.id}}
                    </div>
                    <div class='name'>
                        {{item.name}}
                    </div>
                    <div class='delete'>
                        <button class='btn btn-danger' v-if='item.deletable' @click.prevent.stop='del(item)'>Del</button>
                    </div>    
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import divHeader from './Header.vue';
    export default  {
        components: {divHeader},
        data() {
            return {
                list: [],
                deleteId :null
            }
        },
        created() {
            this.getArticle();
        },
        methods: {
            getArticle() {
                axios.get('http://localhost:7777/article')
                .then(result=>{
                    this.list = result.data.map(o=>Object.assign(o,{deletable: false}));
                })
               
            },
            del(item) {
                axios.delete(`http://localhost:7777/article/${item.id}`)
                .then(o=>{
                    this.getArticle();
                })
            },
            articleDetail(item) {
                this.$router.push(`/list/${item.id}`);
            },
            showDelete(item) {
                item.deletable = true;
            },
            hideDelete(item) {
                item.deletable = false;
            }
        }
    }
</script>

<style lang='scss' scoped>

    ul {
        list-style:none;
        padding: 0;
    }
    li {
        display:flex;
        border-bottom: 1px solid #CCCCCC;	
        div {
            height:50px;
            line-height:50px;
        }	
        .index {
            flex:1;
            text-align: center;
        }
        .name {
            flex:3;
        }
        .delete {
            width:100px;
            text-align: center;
            margin-left: auto;
            
        }
    }
  
    .list {
        flex:1;
        overflow-x:hidden;
        overflow-y:auto;
    }
</style>