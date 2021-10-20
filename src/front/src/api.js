import axios from 'axios'
import appConfig from './config'

const apiConfig = appConfig.api;

let headers = {
    'content-type': 'application/json'
};
console.log(apiConfig);

export default axios.create({
    baseURL: apiConfig.baseUrl,
    headers: headers
});