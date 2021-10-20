import axios from 'axios'
import appConfig from './config'

const apiConfig = appConfig.api;

let headers = {
    'content-type': 'application/json'
};

export default axios.create({
    baseURL: apiConfig.baseUrl,
    headers: headers
});