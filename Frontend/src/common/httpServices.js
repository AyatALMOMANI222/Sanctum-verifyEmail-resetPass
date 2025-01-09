import axios from "axios";

const axiosInstance = axios.create({
  baseURL: `${process.env.REACT_APP_API_BASE_URL}/api`,
  headers: {
    "Content-Type": "application/json",
    // You can define other headers here if needed, but others like `Accept` are generally not required for simple JSON APIs.
  },
});

// Interceptor for request
axiosInstance.interceptors.request.use(
  (config) => {
    // Custom logic for requests before sending if needed
    return config;
  },
  (error) => Promise.reject(error)
);

// Interceptor for response
axiosInstance.interceptors.response.use(
  (response) => response,
  (error) => Promise.reject(error)
);

const httpServices = {
  get: (url, params) => axiosInstance.get(url, { params }),
  post: (url, data) => axiosInstance.post(url, data),
  put: (url, data) => axiosInstance.put(url, data),
  delete: (url) => axiosInstance.delete(url),
};

export default httpServices;
