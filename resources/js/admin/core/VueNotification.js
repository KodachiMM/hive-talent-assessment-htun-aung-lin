export function success(notification, title = null) {
    return Vue.notify({
        group: "notification",
        type: "success",
        title: title,
        text: notification
    });
}

export function info(notification, title = null) {
    return Vue.notify({
        group: "notification",
        type: "info",
        title: title,
        text: notification
    });
}

export function error(notification, title = null) {
    return Vue.notify({
        group: "notification",
        type: "error",
        title: title,
        text: notification
    });
}

export function warning(notification, title = null) {
    return Vue.notify({
        group: "notification",
        type: "warn",
        title: title,
        text: notification
    });
}
