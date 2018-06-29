<template>
    <div class='header-wrapper noisy'>
        <div class='title-wrapper'>
            <div>{{title}}</div>
            <div class='button-wrapper'>
                <button class='btn btn-primary' @click='newDisplay' v-if='type=="list"'>New</button>
         
                <button class='btn btn-primary' @click='back' v-if='type=="new"'>Back</button>
              
            </div>
        </div>      
    </div>
</template>
<script>
    export default {
        props: ['title', 'type'],
        data() {
            return {
                types: {
                    "new": {
                        title: "Article ",
                    },
                    "list": {
                        title: "Article List",
                    }
                }
            }
        },
        methods: {
            newDisplay() {
                this.$router.push('/list/0')
            },
            back() {
                this.$router.push('/list')
            }
        }
    }
</script>
<style lang='scss' scoped>
    .header-wrapper {
        width:100%;
        height:50px;
        padding: 5px 20px;
        background-color: #A8795A;     
    }
    .title-wrapper {
        display:flex;
        align-items: center;
        font-size:16px;
        font-weight: bold;
        color: white;
    }
    .button-wrapper {
        margin-left: auto;     
    }
</style>
