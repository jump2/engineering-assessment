<template>
    <div class="container">
        <header class="header-container">
            <a-input-search
                    placeholder="input search text"
                    enter-button
                    size="large"
                    style="width: 500px"
                    @search="handleSearch"
            />
        </header>
        <div class="list-container">
            <a-row :gutter="15">
                <a-col :xs="{ span: 12 }" :lg="{ span: 12 }">
                    <lis v-for="(item, index) in items" :key="index" :item="item"></lis>
                </a-col>
                <a-col :xs="{ span: 12 }" :lg="{ span: 12 }">
                    <mp :positions="locations"></mp>
                </a-col>
            </a-row>
        </div>
    </div>
</template>

<script setup>
    import { reactive } from 'vue'
    import lis from '@/components/list'
    import mp from '@/components/map'
    import { truckFind } from '@/servers/api'
    import {notification} from "ant-design-vue";

    const items = reactive([])
    const locations = reactive([])

    const handleSearch = (val) => {
        truckFind({q: val}).then((resp) => {
            if (resp['error_code'] == 0) {
                items.length = 0;
                locations.length = 0;
                for (let v of resp['data']) {
                    items.push({
                        "applicant": v['Applicant'],
                        "tag": v['FacilityType'],
                        "address": v['Address'],
                        "foodItems": v['FoodItems']
                    })

                    let lat = parseFloat(v['Location']['lat']);
                    let lng = parseFloat(v['Location']['lon']);
                    if (lat > 0) {
                        locations.push({lat: lat, lng: lng})
                    }
                }
            }
        })
    }
</script>

<style scoped>
  .container {
    padding: 0 40px;
  }
  .header-container {
    padding: 24px 0;
  }
  .list-container {
  }
  .search-input >>> .ant-select-selector {
    border-radius: 0;
  }
</style>