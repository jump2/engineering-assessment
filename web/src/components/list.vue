<template>
    <div class="row">
        <h3 class="applicant">{{item.applicant}}</h3>
        <p class="tag" v-if="item.tag">
            <a-tag>{{item.tag}}</a-tag>
        </p>
        <div>
            <b>Address:</b> {{item.address}}
        </div>
        <div>
            <b>Food Items:</b> {{foodItems()}}
        </div>
    </div>
</template>

<script setup>
    const props = defineProps(['item'])

    const foodItems = () => {
        return props.item.foodItems.join(', ')
    }
</script>

<style scoped>
    .row {
        border-bottom: 1px solid #ebebeb;
        padding: 24px;
    }.applicant {
         font-weight: bold;
     }.tag >>> .ant-tag {
          font-weight: bold;
          background-color: #f0f0f0;
          color: #6e7072;
      }
</style>