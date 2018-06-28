<template>
    <div class='content-wrapper'>
        <div-header :title='"Article "' :type='"new"' />
        <div class='article'>
            <div class='name mb-4'>
                <template v-if='detail.name'>
                     {{detail.name}}
                </template>
                <input v-if='!detail.name' v-model='newName' class="form-control" placeholder='Name'/>
            </div>
            <div class='content mb-4'>
                <pre v-if='detail.name' v-html="detail.content"></pre>
                <textarea v-if='!detail.content' class="form-control" v-model='newContent' placeholder='Content' />
            </div>
            <div>
                <button class='btn btn-primary' @click='postArticle'>Save</button>
            </div>
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
                id: '',
                newName: '',
                newContent: '',
                detail: {
                    name: '',
                    content: ''
                }
            }
        },
        created() {
            this.id = this.$route.params.id;
            if(this.id) {
                this.getArticleById(this.id);
            } 

        },
        methods: {
            async getArticleById(id) {
                let result = await axios.get(`http://localhost:7777/article/${id}`);
                this.detail = result.data[0];
            },
            postArticle() {
                axios.post(`http://localhost:7777/article`, {name: this.newName, content: this.newContent})
                .then(result=>{
                    console.log(result);
                    this.$router.push('/list');
                })
            }
        }
    }
</script>

<style lang='scss' scoped>
    .article {
        flex:1;
        overflow-x:hidden;
        overflow-y:auto;
        padding: 20px 20px ;
    }
    textarea {
        resize:none;
        height:200px;
    }
</style>