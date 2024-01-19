<template>
    <a-affix :offset-top="24">
        <div id="map" class="map">
        </div>
    </a-affix>
</template>

<script setup>
    import { onMounted, watch, ref } from 'vue'
    import { Loader } from "@googlemaps/js-api-loader"

    const props = defineProps(['positions'])

    const map = ref(null)

    const loader = new Loader({
        apiKey: 'AIzaSyDJW4jsPlNKgv6jFm3B5Edp5ywgdqLWdmc',
        version: 'weekly',
        libraries: ['places']
    })

    let getCenterPosition = positions => {
        let lat=0, lng=0;
        for(let position of positions) {
            lat += position['lat'];
            lng += position['lng'];
        }

        lat /= positions.length;
        lng /= positions.length;

        return { lat: lat, lng: lng }
    }

    watch(props, (value) => {
        google.maps.event.trigger(map.value, 'resize');
        googleMap()
    })

    const googleMap = async () => {
        await loader
            .load()
            .then(google => {
                map.value = new google.maps.Map(document.getElementById('map'), {
                    center: getCenterPosition(props.positions),
                    zoom: 13
                })

                for (let position of props.positions) {
                    new google.maps.Marker({
                        position: position,
                        map: map.value,
                        title: "Hello World!",
                    });
                }
            })
            .catch(error => {
                console.log(error)
            })
            .then(function () {
            })
    }

    onMounted(googleMap)
</script>

<style scoped>
    .map {
        height: 600px;
        width: 100%;
    }
</style>