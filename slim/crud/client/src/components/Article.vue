<template>
    <div class='content-wrapper'>
        <div-header :title='"Article Detail"' :type='"new"' />
        <div class='article'>
            <div class='name mb-4'>
                <template v-if='!isEditable'>
                     {{detail.name}}
                </template>
                <input v-if='isEditable' v-model='detail.name' class="form-control" placeholder='Name'/>
            </div>
            <div class='content mb-4'>
                <pre v-if='!isEditable' v-html="detail.content"></pre>
                <textarea v-if='isEditable' class="form-control" v-model='detail.content' placeholder='Content' />
            </div>
            <div>
                <button class='btn btn-primary' @click='saveArticle'  v-if='isEditable'>Save</button>
                <button class='btn btn-primary' @click='showEditable' v-if='!isEditable'>Edit</button>
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
                detail: {
                    id: '',
                    name: '',
                    content: ''
                },
                isEditable: false
            }
        },
        created() {
            this.detail.id = parseInt(this.$route.params.id);
            if(this.detail.id) {
                this.getArticleById(this.detail.id);
            } else {
                this.isEditable = true;
            }

        },
        methods: {
            async getArticleById(id) {
                let result = await axios.get(`http://localhost:7777/article/${id}`);
                let _detail = result.data[0];
                this.detail.name = _detail.name;
                this.detail.content = _detail.content;
            },

            saveArticle() {
                if(this.detail.id) {
                    this.putArticle();
                } else {
                    this.postArticle();
                }
            },

            postArticle() {
                axios.post(`http://localhost:7777/article`, {name: this.detail.name, content: this.detail.content})
                .then(result=>{
                    this.$router.push('/list');
                })
            },

            putArticle() {
                axios.put(`http://localhost:7777/article/${this.id}`, {name: this.detail.name, content: this.detail.content})
                .then(result=>{
                    this.$router.push('/list');
                })
            },

            showEditable() {
                this.isEditable = true;
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