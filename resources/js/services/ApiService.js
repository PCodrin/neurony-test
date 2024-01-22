import axios from 'axios';

const apiService = axios.create({
  baseURL: '/api',
});

export default apiService;
