<template>
    <div class='content-wrapper'>
        <div-header :title='"Article List"'   :type='"list"'/>
        <div class='list inset'>
            <ul>
                <li>
                    <div class='index font-weight-bold'>ID</div>
                    <div class='name font-weight-bold'>Name</div>
                </li>
                <li v-for="item in list" :key='item.id' @click='articleDetail(item)'>
                    <div class='index'>
                        {{item.id}}
                    </div>
                    <div class='name'>
                        {{item.name}}
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
                list: []
            }
        },
        created() {
            this.getArticle();
        },
        methods: {
            async getArticle() {
                let result = await axios.get('http://localhost:7777/article');
                this.list = result.data;
            },
            articleDetail(item) {
                this.$router.push(`/list/${item.id}`);
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
    }
  
    .list {
        flex:1;
        overflow-x:hidden;
        overflow-y:auto;
    }
</style>