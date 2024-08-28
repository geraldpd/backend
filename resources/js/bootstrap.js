import axios from "axios";
window.axios = axios;

import Swal from "sweetalert2";
window.Swal = Swal;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const token = localStorage.getItem("authToken");

if (token) {
    window.axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
} else {
    delete window.axios.defaults.headers.common["Authorization"];
}
