import { axiosGet} from "@/servers/request";

export const truckFind = (data) => {
    return axiosGet("truck/find", data)
}