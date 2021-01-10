import moment from "moment";

export function formatNumber(number) {
    return number.toLocaleString();
}

export function formatDateTime(date) {
    return date ? moment(date).format("YYYY-MM-DD HH:mm:ss") : "";
}

export function formatDate(date) {
    return moment(date).format("YYYY-MM-DD");
}

export function formatDateTime24(date) {
    return moment(date).format("ddd, DD MMM YYYY hh:mm:ss A");
}

export function formatDateTimePretty(date) {
    return moment(date).format("DD MMM YYYY hh:mm:ss A");
}

export function formatDatePretty(date) {
    return moment(date).format("DD MMM YYYY");
}
