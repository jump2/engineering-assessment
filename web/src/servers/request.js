import { axiosInstance as axios } from "./axios.js"

// get request
export function axiosGet(url, parameter={}) {
    return axios({
        url: url,
        method: 'get',
        params: parameter
    })
}

// post request
export function axiosPost(url,parameter={}) {
    return axios({
        url: url,
        method:'post' ,
        data: parameter
    })
}